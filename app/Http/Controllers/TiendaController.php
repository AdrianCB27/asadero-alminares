<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class TiendaController extends Controller
{
    public function index(){
        $user = auth()->user();
        $setting=Setting::first();
        $mensaje=Mensaje::firstOrCreate(['texto' => 'Encargos de 18:30 a 11:30 y venta de 13:00 a 15:00. De lunes a viernes excepto festivos.']);
        $productos=Product::all();
        return view('tienda.index',["user"=>$user,"setting"=>$setting,"productos"=>$productos, "mensaje"=>$mensaje]); // Asegúrate de que la vista tienda.index exista

    }
}
