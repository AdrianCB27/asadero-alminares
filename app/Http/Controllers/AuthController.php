<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Http\Controllers\TiendaController;

class AuthController extends Controller
{
    /**
     * Muestra la vista del formulario de registro.
     *
     * @return \Illuminate\View\View
     */
    public function registroVista()
    {
        return view('registro');
    }

    /**
     * Procesa la solicitud de registro de un nuevo usuario.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registrarse(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'phone_number' => [
                    'required',
                    'string',
                    'max:20',
                    Rule::unique('users', 'phone_number'),
                ],
            ],
            [
                'phone_number.unique' => 'Ese número de teléfono ya está registrado.',
                'phone_number.required' => 'El teléfono es obligatorio.',
            ]
        );

        $user = User::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
        ]);

        // Inicia sesión al usuario recién registrado
        Auth::login($user);

        return redirect()->route('tienda')->with('success', '¡Registro completado!');
    }

    /**
     * Muestra la vista del formulario de login.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function login()
    {
        // Verifica si el usuario ya ha iniciado sesión
        if (Auth::check()) {
            return (new TiendaController)->index();
        }

        // Si no hay sesión, muestra la vista de login.
        return view('login');
    }

    /**
     * Procesa la solicitud de inicio de sesión.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logged(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
        ]);

        // Normalizar el nombre: convertir a minúsculas y quitar acentos (si fuera necesario)
        $normalizedName = strtolower($request->name);

        // Intenta encontrar al usuario por nombre normalizado y número de teléfono
        // La consulta a la base de datos debe ser con el nombre en minúsculas
        $user = User::whereRaw('LOWER(name) = ?', [$normalizedName])
            ->where('phone_number', $request->phone_number)
            ->first();

        // Si el usuario existe, inicia la sesión manualmente.
        if ($user) {
            Auth::login($user);

            // --- AQUÍ ES DONDE SE COMPRUEBA SI ES ADMIN O NO ---
            if ($user->admin) {
                // El usuario es un administrador (el campo 'admin' es 1),
                // redirige a la vista de admin.
                return redirect()->route('admin.dashboard');
            } else {
                // El usuario no es un administrador (el campo 'admin' es 0),
                // redirige a la vista de la tienda.
                return redirect()->route('tienda');
            }
        }

        // La autenticación falló, redirige de vuelta al login con un error.
        return back()->withErrors(['phone_number' => 'Credenciales no válidas.'])->withInput($request->only('name', 'phone_number'));
    }

    /**
     * Cierra la sesión del usuario.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login')->with('success', '¡Has cerrado sesión correctamente!');
    }
}
