<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    public function __construct()
    {   
        // Proteger la ruta de usuarios no autenticados.
        $this->middleware('auth');
    }

    public function index(Request $request, User $user) 
    {

        return view('perfil/editar-perfil', [
            'user' => $user
        ]);
    }

    public function store(Request $request) 
    {

        /* Editamos el username directamente desde el request. De esta forma, la función slug
        nos ayuda a mantener un formato adecuado para nuestro nombre de usuario*/
        $request->request->add(["username" => Str::slug($request->username)]);

        // Validamos el username, ya que es obligatorio.
        $this->validate($request, [
            "username" => ["required", "unique:users,username,".auth()->user()->id, "min:3", "max:30", "not_in:twitter,editar-perfil,devstagram"]

        ]); 

        // La imagen no es obligatoria, entonces ejecutamos las siguientes líneas solo en caso de que exista una.
        if ($request->imagen) {

            // Asociamos la imagen a una variable.
            $imagen = $request->file('imagen');

            // Juntamos un uniq id más la extensión de la imagen para generar un nombre.
            $nombreImagen = Str::uuid() . "." . $imagen->extension();
            
            // Generamos una nueva variable para guardar la imagen y editarla con Intervention Image.
            $imagenServidor = Image::make($imagen);
            $imagenServidor->fit(1000, 1000);

            // Generamos una url para guardar las imagenes en el servidor.
            $imagenPath = public_path('perfiles') . "/" . $nombreImagen;

            // Guardamos la imagen en el servidor.
            $imagenServidor->save($imagenPath);
        }


        // Guardar cambios
        $usuario = User::find(auth()->user()->id); 

        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? '';

        $usuario->save();

        /* Al momento de redireccionar, es importante que notemos que lo hacemos enviando el username que se 
        encuentra en la función de autenticación para evitar errores si fue editado. */
        return redirect()->route('posts.index', $usuario->username);
    }
}




