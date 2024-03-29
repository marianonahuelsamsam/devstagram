<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImagenesController extends Controller
{   
    // Procesamiento de la subida de la imagen
    public function store(Request $request) 
    {

        // Asociamos la imagen a una variable.
        $imagen = $request->file('file');

        // Juntamos un uniq id más la extensión de la imagen para generar un nombre.
        $nombreImagen = Str::uuid() . "." . $imagen->extension();

        // Generamos una nueva variable para guardar la imagen y editarla con Intervention Image.
        $imagenServidor = Image::make($imagen);
        $imagenServidor->fit(1000, 1000);

        // Generamos una url para guardar las imagenes en el servidor.
        $imagenPath = public_path('uploads') . "/" . $nombreImagen;

        // Guardamos la imagen en el servidor.
        $imagenServidor->save($imagenPath);

        // Generamos una respuesta con el nombre de la imagen para poder conectar a Drop Zone.
        return response()->json(['imagen' => $nombreImagen]);
    }
}
