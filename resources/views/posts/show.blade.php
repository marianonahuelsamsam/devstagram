@extends('layouts.app')

@section('titulo')
    {{ $post->titulo }}
@endsection

{{-- Contenido de la pagina - Foto, likes, comentarios --}}
@section('contenido')
    <div class="container mx-auto flex">

        {{-- Contenido de la seccion izquierda de la web (tamaño grande) foto, likes y boton de eliminar--}}
        <div class="md:w-1/2">

            {{-- Imagen  --}}
            <img src="{{ asset('uploads' . '/' . $post->imagen) }}" alt="Imagen del post {{ $post->titulo }}">

            {{-- Likes --}}
            <div class="p-2 flex items-center gap-2">
                
                <livewire:like-post :post="$post" />
                
        
            </div> 

            {{-- Fecha, hora y nombre de usuario--}}
            <div class="px-2">
                <p class="font-bold"> {{ $post->user->username }} </p>
                <p class="text-sm text-gray-500"> {{ $post->created_at->diffForHumans() }} </p>
            </div>

            {{-- Boton de eliminar Post--}}
            @auth                
                @if ($post->user->username === auth()->user()->username)
                    <form method="POST" action="{{ route('posts.destroy', $post) }}">
                        @method('DELETE')
                        @csrf
                        <input type="submit" value="Eliminar Publicación" class="bg-red-500 hover:bg-red-600 p-2 rounded 
                        text-white font-bold mt-4 cursor-pointer">
                    </form>
                @endif
            @endauth
        </div>{{-- Fin de la sección izquierda --}}


        {{-- Sección derecha de la vista del post (En tamaño grande) Comentarios.--}}
        <div class="md:w-1/2 p-5">
            <div class="shadow bg-white p-5 mb-5">
                <p class="text-center font-bold text-xl">Comentarios</p>

                {{-- Esta sección se utilizar para mostrar un mensaje de comentario agregado con exito --}}
                @if (session('mensaje'))
                    <div class="bg-green-500 p-2 rounded-lg mb-5 text-white text-center uppercase font-bold">
                        {{ session('mensaje') }}
                    </div>
                @endif
                
                {{-- Verificamos la autenticación de comentarios para habilitar la caja --}}
                @auth()                  
                    <div class="my-10">
                        <form action="{{route('comentarios.store', ["post" => $post, "user" => $user])}}" method="POST">
                            @csrf                        
                            <label for="comentario" class="mb-2 mt-2 block uppercase text-gray-500 font-bold">Agrega un comentario</label>
                            <textarea name="comentario" id="comentario" placeholder="Agrega un comentario" class="border p-3 w-full rounded-lg @error('titulo') border-red-500 @enderror"></textarea>
        
                            @error('comentario')
                                <p class=" bg-red-500 text-white my-2 text-sm p-2 rounded-lg text-center">{{$message}}</p>
                            @enderror

                            <input type="submit" value="enviar comentario" class="bg-sky-600 hover:bg-sky-700 transition-colors
                            cursor-pointer uppercase font-bold w-full mt-4 p-3 text-white rounded-lg">
                        </form>
                    </div> <!-- Fin de campo -->
                @endauth
                
                {{-- Muestra los comentarios del post --}}
                <div class="shadow mb-5 bg-white p-5 max-h-95 overflow-y-scroll mt-10 ">

                    @if ($post->comentarios->count()) 
                        @foreach ($post->comentarios as $comentario)

                            <div class="p-5 border-gray-300 border-b {{ $loop->last ? 'border-b-0' : '' }}">

                                {{--Perfil del autor del comentario--}}
                                <a class="font-bold" href="{{ route('posts.index', $comentario->user)}}">
                                    {{ $comentario->user->username }}
                                </a>

                                {{-- Comentario --}}
                                <p> {{$comentario->comentario}} </p>

                                <div class="flex aling-center gap-4">
                                    {{-- fecha --}}
                                    <p class="text-sm text-gray-500"> {{ $comentario->created_at->diffForHumans() }} </p>

                                    {{-- Botón de eliminar comentario --}}

                                    @if ($comentario->user->username === auth()->user()->username)
                                    
                                        <form method="POST" action="{{route('comentarios.destroy', ["post" => $post, "user" => $user->username, "comentario" => $comentario])}}">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" value="Eliminar comentario" class="text-sm text-red-500 cursor-pointer hover:bg-red-300">
                                        </form>
                                    @endif
                                </div>

                                

                            </div>
                        @endforeach
                    @else
                        <p class="p-10 text-center">No hay comentarios</p>
                    @endif

                </div>

            </div>
        </div> {{-- Fin comentarios --}}
        
    </div>    

@endsection



