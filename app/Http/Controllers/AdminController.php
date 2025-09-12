<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        // Aquí puedes agregar la lógica para el dashboard del administrador
        // Por ejemplo, podrías obtener estadísticas, listas de usuarios, etc.
        $setting = Setting::first(); // Obtiene la primera configuración, asumiendo que solo hay una fila
        $mensaje = Mensaje::first(); // Obtiene el primer mensaje, asumiendo que solo hay una fila
        $productos = Product::all();
        $diaSemana = \Illuminate\Support\Facades\DB::table('dia_semana_actual')->first();   


        return view('admin.dashboard', ["user" => $user, "setting" => $setting, "mensaje" => $mensaje, "productos" => $productos,"diaSemana"=>$diaSemana]);
    }
    public function cambiarTienda(Request $request)
    {
        // El JavaScript envía un JSON con `mostrar_tienda: true/false`
        // Usamos `input()` para obtener el valor del JSON
        $mostrarTienda = $request->input('mostrar_tienda');

        // Busca el primer registro de configuración o lo crea si no existe
        $setting = Setting::firstOrCreate([]);

        // Actualiza el campo de la base de datos con el valor booleano
        $setting->mostrar_tienda = (bool) $mostrarTienda;
        $setting->save();

        // En lugar de redirigir, devolvemos una respuesta JSON
        return response()->json([
            'success' => true,
            'message' => 'El estado de la tienda ha sido actualizado.'
        ]);
    }
    public function clientes(Request $request)
    {
        $user = auth()->user();

        // Obtiene el valor del campo 'search' del formulario, si existe
        $search = $request->input('search');


        // Construye la consulta para filtrar los clientes
        $clientes = User::where('admin', false)
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('phone_number', 'like', "%{$search}%");
            })
            ->get();

        return view('admin.clientes', [
            "user" => $user,
            "clientes" => $clientes
        ]);
    }
    public function eliminarCliente($id)
    {
        try {
            $cliente = User::findOrFail($id);
            $cliente->delete();
            return redirect()->route('clientes.index')->with('success', 'Cliente eliminado exitosamente.');
        } catch (\Exception $e) {
            Log::error("Error al eliminar cliente: " . $e->getMessage());
            return redirect()->route('clientes.index')->with('error', 'No se pudo eliminar el cliente.');
        }
    }
    public function productos()
    {
        $user = auth()->user();

        $productos = Product::all()->sortBy('name');
        return view('admin.productos', ["user" => $user, "productos" => $productos]);
    }
    public function storeProducto(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);
        $producto = new Product();
        $producto->name = $request->input('name');
        $producto->price = $request->input('price');
        $producto->stock = $request->input('stock');
        $producto->stock_maximo = $request->input('stock');
        $producto->save();

        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }
    public function deleteProductos(Request $request)
    {
        try {
            Product::query()->delete();
            Order::query()->delete();
            return response()->json(['message' => 'Se han eliminado todos los productos correctamente.'], 200);
        } catch (\Throwable $e) {
            Log::error($e);
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    public function deleteProducto($id)
    {
        try {
            $producto = Product::findOrFail($id);
            $producto->delete();
            return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
        } catch (\Exception $e) {
            Log::error("Error al eliminar producto: " . $e->getMessage());
            return redirect()->route('productos.index')->with('error', 'No se pudo eliminar el producto.');
        }
    }
    public function cambiarMensaje(Request $request)
    {
        $request->validate([
            'mensaje' => 'required|string|max:255',
        ]);

        $nuevoTexto = $request->input('mensaje');

        // Reemplaza los saltos de línea con <br>
        $nuevoTextoConSaltos = str_replace(array("\r\n", "\r", "\n"), '<br>', $nuevoTexto);

        // Busca el primer registro de mensaje o lo crea si no existe
        $mensaje = Mensaje::first();

        // Actualiza el campo de la base de datos con el nuevo texto
        $mensaje->texto = $nuevoTextoConSaltos;
        $mensaje->save();

        return redirect()->route('admin.dashboard')->with('success', 'El mensaje ha sido actualizado.');
    }
    public function pedidos(Request $request)
    {
        $user = auth()->user();
        $search = $request->input('search');

        $query = Order::where('completed', false);

        if ($search) {
            $query->whereHas('user', function ($subQuery) use ($search) {
                $subQuery->where('name', 'like', "%{$search}%");
            });
        }

        $orders = $query->get();

        return view('admin.pedidos', ["user" => $user, "orders" => $orders]);
    }
    public function pedidosCompletados(Request $request)
    {
        $user = auth()->user();
        $search = $request->input('search');

        $query = Order::where('completed', true);

        if ($search) {
            $query->whereHas('user', function ($subQuery) use ($search) {
                $subQuery->where('name', 'like', "%{$search}%");
            });
        }

        $orders = $query->get();

        return view('admin.pedidosCompletados', ["user" => $user, "orders" => $orders]);
    }
    public function marcarPedidoCompletado($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->completed = true;
            $order->save();
            return redirect()->route('pedidos.index')->with('success', 'Pedido marcado como completado.');
        } catch (\Exception $e) {
            Log::error("Error al marcar pedido como completado: " . $e->getMessage());
            return redirect()->route('pedidos.index')->with('error', 'No se pudo marcar el pedido como completado.');
        }
    }
}
