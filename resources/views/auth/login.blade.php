@extends('layouts.app')

@section('titulo')
    Inicia Sesión en Devstagram
@endsection

@section('contenido')
    <div class="md:flex md:justify-center md:gap-10 md:items-center">

        <div class="md:w-6/12 p-5">
            <img src="{{"img/login.jpg"}}" alt="Imagen Login">
        </div>

        <div class="md:w-4/12 bg-white p-5 rounded-lg shadow-xl ">
            <form action="{{route('login')}}" method="POST">
                @csrf

                @if (session('mensaje'))
                    <p class=" bg-red-500 text-white my-2 text-sm p-2 rounded-lg text-center">{{session('mensaje')}}</p>
                @endif

                <div class="mb-5">
                    <label for="email" class="mb-2 mt-2 block uppercase text-gray-500 font-bold">Email</label>
                    <input type="email" name="email" id="email" placeholder="Tu Email de Registro" class="border p-3 w-full rounded-lg" value="{{old('email')}} @error('name') border-red-500 @enderror" ">

                    @error('email')
                        <p class=" bg-red-500 text-white my-2 text-sm p-2 rounded-lg text-center">{{$message}}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="password" class="mb-2 mt-2 block uppercase text-gray-500 font-bold">Password</label>
                    <input type="password" name="password" id="password" placeholder="Tu Password de Registro" class="border p-3 w-full rounded-lg">

                    @error('password')
                        <p class=" bg-red-500 text-white my-2 text-sm p-2 rounded-lg text-center">{{$message}}</p>
                    @enderror
                </div>

                <div>
                    <input type="checkbox" name="remember" id="remember" <label for="remember">
                    <label class="mb-2 text-gray-500" for="remember">Mantener mi sesión abierta</label>
                </div>

                <input type="submit" value="Iniciar Sesión" class="bg-sky-600 hover:bg-sky-700 transition-colors
                cursor-pointer uppercase font-bold w-full mt-4 p-3 text-white rounded-lg">

            </form>
        </div>


    </div>
@endsection
