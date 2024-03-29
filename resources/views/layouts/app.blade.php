<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @stack('style')

        <title>Laravel @yield('titulo')</title>

        @vite('resources/css/app.css')
        @livewireStyles
    </head>

    <body class="bg-gray-100">
        <header class="p-5 border-b bg-white shadow">
            <div class="container mx-auto flex justify-between items-center">
                <a href="{{route('home')}}" class="text-3xl font-black">Devstagram</a>


                @auth()

                    <nav class="flex gap-4 items-center " >

                        <a class="flex items-center gap-2 bg-white border p-2 text-gray-600 rounded
                            text-sm uppercase font-bold cursor-pointer"
                            href="{{route('posts.create')}}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Crear
                        </a>

                        <a href="{{route('posts.index', auth()->user()->username)}}">
                            <p class="font-bold text-gray-600 text-sm">Hola <span class="text-blue-500">{{auth()->user()->username}}</span></p>
                        </a>

                        <form action="{{route('logout')}}" method="POST">
                            @csrf

                            <button type="submit" class="font-bold uppercase text-gray-600 text-sm" ">
                                Cerrar Sesión
                            </button>
                        </form>

                    </nav>
                @endauth

                @guest()
                    <nav class=" flex gap-4 " >
                        <a class="font-bold uppercase text-gray-600 text-sm" href="{{ route('login') }}">Login</a>
                        <a class="font-bold uppercase text-gray-600 text-sm" href="{{route('register')}}">Crear Cuenta</a>
                    </nav>
                @endguest


            </div>

        </header>

        <main class="container mx-auto mt-10">
            <h2 class="font-black text-center text-3xl mb-10">
                @yield('titulo')
            </h2>

            @yield('contenido')
        </main>

        <footer class="text-center p-5 mt-5 text-gray-500 font-bold uppercase">
            Devstagram - Todos los derechos reservados {{ now()->year }}
        </footer>
        @livewireScripts
    </body>

</html>
