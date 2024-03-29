@extends('layouts.app')

@section('titulo')
    Edita tu perfil
@endsection

@section('contenido')

    <div class="md:flex md:justify-center">
        <div class="md:w-1/2 bg-white shadow p-10">

            <form method="POST" action="{{ route('perfil.store') }}" enctype="multipart/form-data" class="p-3">  

                @csrf

                <div>
                    <label for="username" class="mb-2 block uppercase text-gray-500 font-bold"> Username </label>
    
                    <input type="text" name="username" id="username" placeholder="Nuevo Username" value="{{auth()->user()->username}}"
                        class="border p-3 w-full rounded-lg"
                    >

                    @error('username')
                        <p class=" bg-red-500 text-white my-2 text-sm p-2 rounded-lg text-center">{{$message}}</p>
                    @enderror
                </div>

                <div class="mt-3">
                    <label for="imagen" class="mb-2 block uppercase text-gray-500 font-bold"> Imagen del Perfil </label>
    
                    <input type="file" name="imagen" id="imagen" accept=".jpg, .png, .jpeg" class="border p-3 w-full rounded-lg">
                </div>
                
                <input type="submit" value="Guardar Cambios" class="bg-sky-600 hover:bg-sky-700 transition-colors
                cursor-pointer uppercase font-bold w-full mt-4 p-3 text-white rounded-lg">

    
            </form>
    
        </div>
    </div>


@endsection 