<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiaSemanaController extends Controller
{
        public function actualizar(Request $request)
    {
        $request->validate([
            'dia' => 'required|string'
        ]);

        DB::table('dia_semana_actual')->truncate(); // limpia la tabla (solo 1 fila)
        DB::table('dia_semana_actual')->insert([
            'dia' => $request->dia,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json(['success' => true]);
    }

    public function obtener()
    {
        $dia = DB::table('dia_semana_actual')->first();
        return response()->json($dia);
    }
}
