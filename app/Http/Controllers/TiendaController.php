<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TiendaController extends Controller
{
    public function index(){
        $user = auth()->user();
        return view('tienda.index',["user"=>$user]); // Asegúrate de que la vista tienda.index exista

    }
}
