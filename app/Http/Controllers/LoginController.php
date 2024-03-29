<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    // Retornamos la vista.
    public function index(Request $request) 
    {

        return view('auth.login', [
            "email" => $request->email
        ]);

    }

    // Procesamiento del login.
    public function store(Request $request) 
    {
        // Validamos que se ingresen el email y contraseña.
        $this->validate($request, [
            "email" => "required|email",
            "password" => "required"
        ]);

        /* Intentamos autenticar con las credenciales ingresadas por el usuario. En caso
        de no ser posible, retrocedemos con un mensaje de error a través de una sesión */
        if(!auth()->attempt($request->only('email', 'password'), $request->remember)) {
            return back()->with('mensaje', 'Email o Contraseña incorrectas.');
        }

        // Si la autenticación fue exitosa, redirigimos al usuario a su perfil.
        return redirect()->route('posts.index', auth()->user()->username);
    }
}
