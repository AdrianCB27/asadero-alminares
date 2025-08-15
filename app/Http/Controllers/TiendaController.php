<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class TiendaController extends Controller
{
    public function index(){
        $user = auth()->user();
        $setting=Setting::first();
        $productos=Product::all(); // Asegúrate de que tienes un modelo Product y que la tabla está configurada correctamente
        return view('tienda.index',["user"=>$user,"setting"=>$setting,"productos"=>$productos]); // Asegúrate de que la vista tienda.index exista

    }
}
