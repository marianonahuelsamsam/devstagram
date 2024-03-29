<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{

    // Retornamos la vista del registro de usuarios.
    public function index()
    {
        return view('auth/register');
    }

    // Procesamiento del registro de usuarios.
    public function store(Request $request)
    {
        /* Editamos el username directamente desde el request. De esta forma, la función slug
        nos ayuda a mantener un formato adecuado para nuestro nombre de usuario*/
        $request->request->add(["username" => Str::slug($request->username)]);

        // Validación
        $this->validate($request, [
            'name' => 'required|max:30',
            'username' => 'required|unique:users|min:5|max:30',
            'email' => 'required|unique:users|email|max:50',
            'password' =>'required|confirmed|min:5'
        ]);

        // Creamos el nuevo usuario y lo subimos a la base de datos.
        User::create([
            "name" => $request->name,
            "username" => $request->username,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);

        // Autenticar usuario.
        auth()->attempt($request->only('email', 'password'));


        // Redireccionamos al nuevo usuario a su perfil.
        return redirect()->route('posts.index', auth()->user()->username);

    }


}
