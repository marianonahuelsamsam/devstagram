@extends('layouts.app')

@section('titulo')
    Crear una nueva publicación
@endsection

@push('style')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endpush

@section('contenido')

    @vite('resources/js/app.js')

    <div class="md:flex md:items-center">
        <div class="md:w-1/2 px-10">
            <form id="dropzone" action="/imagenes" method="POST" class="dropzone border-dashed border-8 w-full h-96 rounded flex flex-col
            justify-center items-center">

            @csrf

            </form>
        </div>

        <div class="md:w-1/2 p-10 bg-white rounded-lg shadow-xl mt-10 md:mt-0">
            <form action="{{route('posts.store')}}" method="POST">
                @csrf

                <div class="mb-5">
                    <label for="titulo" class="mb-2 mt-2 block uppercase text-gray-500 font-bold">Título</label>
                    <input type="text" name="titulo" id="titulo" placeholder="Título de la publicación" class="border p-3 w-full rounded-lg @error('titulo') border-red-500 @enderror" value="{{old('titulo')}}">

                    @error('titulo')
                        <p class=" bg-red-500 text-white my-2 text-sm p-2 rounded-lg text-center">{{$message}}</p>
                    @enderror
                </div> <!-- Fin de campo -->

                <div class="mb-5">
                    <label for="descripcion" class="mb-2 mt-2 block uppercase text-gray-500 font-bold">Descripción</label>
                    <textarea name="descripcion" id="descripcion" placeholder="Descripcion de la publicación" class="border p-3 w-full rounded-lg @error('titulo') border-red-500 @enderror" value="{{old('titulo')}}"> </textarea>

                    @error('descripcion')
                        <p class=" bg-red-500 text-white my-2 text-sm p-2 rounded-lg text-center">{{$message}}</p>
                    @enderror
                </div> <!-- Fin de campo -->

                <div class="mb-5">
                    <input name="imagen" type="hidden" value="{{old('imagen')}}">
                    @error('imagen')
                        <p class=" bg-red-500 text-white my-2 text-sm p-2 rounded-lg text-center">{{$message}}</p>
                    @enderror
                </div>

                <input type="submit" value="Crear Publicación" class="bg-sky-600 hover:bg-sky-700 transition-colors
                cursor-pointer uppercase font-bold w-full mt-4 p-3 text-white rounded-lg">
            </form>
        </div>
    </div>
@endsection
