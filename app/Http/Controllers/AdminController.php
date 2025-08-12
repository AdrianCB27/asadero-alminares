<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        // Aquí puedes agregar la lógica para el dashboard del administrador
        // Por ejemplo, podrías obtener estadísticas, listas de usuarios, etc.
        $setting = Setting::first(); // Obtiene la primera configuración, asumiendo que solo hay una fila

        return view('admin.dashboard', ["user" => $user, "setting" => $setting]);
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
    public function clientes()
    {
        $user = auth()->user();
        // Aquí puedes agregar la lógica para mostrar los clientes
        // Por ejemplo, podrías obtener una lista de usuarios registrados
        $clientes = User::where('admin', false)->get(); // Obtiene todos los usuarios que no son administradores

        return view('admin.clientes', ["user" => $user, "clientes" => $clientes]); // Asegúrate de que la vista admin.clientes exista
    }
    public function productos()
    {
        $user = auth()->user();

        $productos = Product::all();
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
        $producto->save();

        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }
    public function deleteProductos(Request $request)
    {
        try {
            Product::query()->delete();
            return response()->json(['message' => 'Se han eliminado todos los productos correctamente.'], 200);
        } catch (\Throwable $e) {
            Log::error($e);
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
