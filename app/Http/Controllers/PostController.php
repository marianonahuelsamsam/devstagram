<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function __construct()
    {   
        // Proteger la ruta de usuarios no autenticados.
        $this->middleware('auth')->except('show', 'index');
    }

    public function index(User $user)
    {
        // Guardar en la variable los posts asociados al id del usuario recibido por medio de la ruta.
        // paginate() dividirá en grupos de 5 los post y creará automaticamente los enlaces de paginación.
        $posts = Post::where('user_id', $user->id)->latest()->paginate(5);

        // Enviamos a la vista el usuario y la variable de post con la paginación.
        return view('dashboard', [
            "user" => $user,
            "posts" => $posts
        ]);
    }

    // Retornamos la vista del formulario de creación de posts.
    public function create() 
    {
        return view('posts.create');
    }

    // Procesamiento de la subida de publicaciones.
    public function store(Request $request) 
    {  
        // Validamos la existencia de los campos.
        $this->validate($request, [
            "titulo" => "required|max:250",
            "descripcion" => "required",
            "imagen" => "required"
        ]);

        // Post::create([
        //     "titulo" => $request->titulo,
        //     "descripcion" => $request->descripcion,
        //     "imagen" => $request->imagen,
        //     "user_id" => auth()->user()->id
        // ]);

        // Otra forma

        // $post = new Post;
        // $post->titulo = $request->titulo;
        // $post->descripcion = $request->descripcion;
        // $post->imagen = $request->imagen;
        // $post->user_id = auth()->user()->id;

        // $post->save();
        
        // Guardamos el post utilizando la relacion entre los modelos "user" y "post".
        $request->user()->posts()->create([
            "titulo" => $request->titulo,
            "descripcion" => $request->descripcion,
            "imagen" => $request->imagen,
            "user_id" => auth()->user()->id
        ]);

        // Redireccionamos al perfil del usuario autenticado.
        return redirect()->route("posts.index", auth()->user()->username);
    }

    // Abrir publicaciones.
    public function show( User $user, Post $post ) 
    {
        return view('posts.show', [
            "post" => $post,
            "user" => $user
        ]);
    }

    // Eliminar publicaciones.
    public function destroy(Post $post) 
    {
        // Utilizamos un policy para confirmar que el usuario que está intentando eliminar la publicación es el mismo
        // que la creó.
        $this->authorize('delete', $post);

        // Eliminamos el post de la base de datos.
        $post->delete();

        // Ubicamos la imagen del post para eliminarla del servidor.
        $image_path = public_path('uploads/' . $post->imagen);

        // Si la imagen existe, la eliminamos del servidor.
        if (File::exists($image_path)) {
            unlink($image_path);
        }

        // Redirigimos al usuario a su perfil.
        return redirect()->route('posts.index', auth()->user()->username);
    }
}
