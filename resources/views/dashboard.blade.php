@extends('layouts.app')

@section('contenido')

    <div class="flex justify-center"> {{-- Div principal --}}

        {{-- Datos deñ perfil --}}
        <div class="flex flex-col items-center w-full md:w-8/12 lg:w-6/12 md:flex-row md:gap-4">

            <div class="w-6/12 pb-4">
                <img  class="rounded-full object-cover" src="{{ $user->imagen ? asset('perfiles') . '/' . $user->imagen : asset('img/usuario.svg') }}" alt="Imagen Usuario">
            </div>

            <div class="md:w-8/12 lg:w-6/12">

                <div class="flex items-center gap-2">
                    <p class="mb-3 text-2xl text-gray-700" >{{$user->username}}</p>

                    @auth
                        @if ($user->id === auth()->user()->id)
                            <a href="{{ route('perfil.index') }}" class="text-gray-500 cursor-pointer hover:text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 
                                    1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </a>
                        @endif
                    @endauth

                </div>



                <p class="mb-3 text-sm font-bold text-gray-800"> 
                    {{$user->followers->count()}} <span class="font-normal"> @choice('Seguidor|Seguidores', $user->followers->count()) </span> 
                </p>

                <p class="mb-3 text-sm font-bold text-gray-800"> 
                    {{$user->following->count()}} <span class="font-normal"> Siguiendo  </span>  
                </p>

                <p class="mb-3 text-sm font-bold text-gray-800"> 
                    {{ $user->posts()->count() }} <span class="font-normal"> Publicaciones </span> 
                </p>

                {{-- Botones de seguir y dejar de seguir (solo se muestran a usuarios autenticados) --}}
                @auth()
                
                    {{-- Evitar seguirse a si mismo--}}
                    @if ($user->id !== auth()->user()->id) 

                        {{-- Comprobamos si el usuario del perfil mostrado en pantalla es seguido por el usuario
                        autenticado para mostrar el correspondiente formulario.
                        Si el método "siguiendo" del modelo User retorna false significa que no estamos siguiendo
                        al usuario, entonces solo mostramos el botón de seguir". Caso contrario, "dejar de seguir"--}}
                        @if (!$user->siguiendo(auth()->user())) 
    
                            <form method="POST" action="{{ route('users.follow', $user) }}">
                                @csrf
                                <input type="submit" class="bg-blue-600 text-white uppercase rounded-lg px-3 py-1 
                                text-xs font-bold cursor-pointer" value="seguir">
                            </form>
                            
                        @else
                            <form method="POST" action="{{ route('users.unfollow', $user); }}">
                                @csrf
                                @method('DELETE')
                                <input type="submit" class="bg-red-600 text-white uppercase rounded-lg px-3 py-1 
                                text-xs font-bold cursor-pointer" value="Dejar de seguir">
                            </form>
                                
                        @endif

                    @endif
                @endauth
                {{-- Botones de seguir y dejar de seguir --}}
            </div>

        </div>

    </div>

    {{-- Listado de publicaciones con sus respectivas miniaturas --}}
    <section class="container mx-auto mt-10">

        <h2 class="my-10 text-4xl font-black text-center">Publicaciones</h2>

        @if ($posts->count())

            <div class="grid grid-cols-2 gap-5 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4">
                @foreach ($posts as $post)
                    <a href="{{ route('posts.show', ["post" => $post, "user" => $user])}}">
                        <img src="{{asset('uploads') . '/' . $post->imagen}}" alt="Imagen del post {{$post->titulo}}">
                    </a>
                @endforeach
            </div>

            <div class="my-10">
                {{ $posts->links() }}
            </div>
        @else
            <p class="text-sm font-bold text-center text-gray-600 uppercase">Este usuario no tiene publicaciones.</p>
        @endif

    </section>

@endsection
