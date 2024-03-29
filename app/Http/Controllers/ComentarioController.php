<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    // Subida de comentarios
    public function store(Request $request, User $user, Post $post) 
    {

        // Validamos que el comentario exista.
        $this->validate($request, [
            "comentario" => 'required|max:500'
        ]);

        // Guardamos el comentario asociando al autor y el post al que va dirigido a través del id.
        Comentario::create([
            "user_id" => auth()->user()->id,
            "post_id" => $post->id,
            "comentario" => $request->comentario
        ]);

        // Retornamos y mensaje
        return back()->with('mensaje', 'Comentario agregado correctamente');

    }

    // Eliminación del comentario
    public function destroy (User $user, Post $post, Comentario $comentario) 
    {
        /* Utilizamos el policy para comprobar si el usuario que está queriendo eliminar el comentario
        es el autor*/

        $this->authorize('delete', $comentario);

        // Eliminamos el comentario de la base de datos.
        $comentario->delete();

        return back()->with('mensaje', 'Comentario eliminado');
    }
}
