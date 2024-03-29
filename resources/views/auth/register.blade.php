@extends('layouts.app')

@section('titulo')
    Registrate en Devstagram
@endsection

@section('contenido')
    <div class="md:flex md:justify-center md:gap-10 md:items-center">

        <div class="md:w-6/12 p-5">
            <img src="{{"img/registrar.jpg"}}" alt="">
        </div>

        <div class="md:w-4/12 bg-white p-5 rounded-lg shadow-xl ">
            <form action="{{route('register')}}" method="POST">
                @csrf

                <div class="mb-5">
                    <label for="name" class="mb-2 mt-2 block uppercase text-gray-500 font-bold">Nombre</label>
                    <input type="text" name="name" id="name" placeholder="Tu Nombre" class="border p-3 w-full rounded-lg @error('name') border-red-500 @enderror" value="{{old('name')}}">

                    @error('name')
                        <p class=" bg-red-500 text-white my-2 text-sm p-2 rounded-lg text-center">{{$message}}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="username" class="mb-2 mt-2 block uppercase text-gray-500 font-bold">Nombre de Usuario</label>
                    <input type="text" name="username" id="username" placeholder="Tu Nombre de Usuario" class="border p-3 w-full rounded-lg" @error('name') border-red-500 @enderror" value="{{old('username')}}">

                    @error('username')
                        <p class=" bg-red-500 text-white my-2 text-sm p-2 rounded-lg text-center">{{$message}}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="email" class="mb-2 mt-2 block uppercase text-gray-500 font-bold">Email</label>
                    <input type="email" name="email" id="email" placeholder="Tu Email de Registro" class="border p-3 w-full rounded-lg" @error('name') border-red-500 @enderror" value="{{old('email')}}">

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

                <div class="mb-5">
                    <label for="password_confirmation" class="mb-2 mt-2 block uppercase text-gray-500 font-bold">Repetí tu Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Repetí tu Password" class="border p-3 w-full rounded-lg">
                </div>

                <input type="submit" value="Crear Cuenta" class="bg-sky-600 hover:bg-sky-700 transition-colors
                cursor-pointer uppercase font-bold w-full mt-4 p-3 text-white rounded-lg">

            </form>
        </div>


    </div>
@endsection
