<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{

    // Procesamiento del guardado del like. En los parámetros recibimos el post al que va dirigido.
    public function store(Request $request, Post $post) 
    {
        // Utilizamos la relación entre los modelos "post" y "like" para generar el nuevo like.
        $post->likes()->create([
            'user_id' => auth()->user()->id
        ]);

        return back();
    }

    // Eliminación del like.
    public function destroy(Request $request, Post $post) 
    {   
        /* Usaremos la relación entre los modelos "user" y "likes" para ubicar el like. A través de la función
        "where" buscamos la coincidencia del campo"post_id" con el pasado a través del request para eliminarlo
        (delete) */
        
        $request->user()->likes()->where('post_id', $post->id)->delete();

        return back();
    }
}
