<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Mostrar la cesta del usuario autenticado
     */
    public function viewCart()
    {
        $cartItems = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return view('cart.view', ['cartItems' => $cartItems]);
    }

    /**
     * Añadir producto a la cesta
     */
    public function addToCart(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($productId);

        // Si ya existe en la cesta, actualizamos la cantidad
        $cartItem = CartItem::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            $cartItem = CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => $request->quantity,
            ]);
        }

        return response()->json(['message' => 'Producto añadido a la cesta', 'cart' => $cartItem]);
    }

    /**
     * Eliminar producto de la cesta
     */
    public function removeFromCart($productId)
    {
        $cartItem = CartItem::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if (!$cartItem) {
            return response()->json(['message' => 'Producto no encontrado en la cesta'], 404);
        }

        $cartItem->delete();

        return redirect()->route('cart.view')->with('success', 'Producto eliminado de la cesta');
    }

    /**
     * Confirmar compra (checkout)
     */
    public function checkout(Request $request)
    {
        $userId = Auth::id();
        $cartItems = CartItem::with('product')->where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'La cesta está vacía'], 400);
        }

        DB::beginTransaction();

        try {
            // Crear pedido
            $order = Order::create([
                'user_id' => $userId,
                'phone_number' => Auth::user()->phone_number,
                'total' => 0,
            ]);

            $total = 0;

            foreach ($cartItems as $item) {
                $subtotal = $item->quantity * $item->product->price;
                $total += $subtotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->product->price,
                ]);

                // Reducir stock del producto
                $item->product->decrement('stock', $item->quantity);
            }

            // Actualizar total del pedido
            $order->update(['total' => $total]);

            // Vaciar cesta
            CartItem::where('user_id', $userId)->delete();

            DB::commit();

            return response()->json(['message' => 'Pedido creado con éxito', 'order' => $order]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al procesar el pedido', 'error' => $e->getMessage()], 500);
        }
    }
}
