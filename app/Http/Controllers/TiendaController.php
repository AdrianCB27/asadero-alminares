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
        $mensaje=Mensaje::first();
        $productos=Product::all()->sortBy('name');
        return view('tienda.index',["user"=>$user,"setting"=>$setting,"productos"=>$productos, "mensaje"=>$mensaje]); // Asegúrate de que la vista tienda.index exista

    }
}
