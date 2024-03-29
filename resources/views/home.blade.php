@extends('layouts.app')


@section('titulo')
    Home
@endsection

@section('contenido')
    @if ($posts->count())
        <div class="bg-white p-5 mx-auto w-5/6">
            @foreach ($posts as $post)
            <div class="p-10 mx-auto w-1/2">
                <a href="{{ route('posts.show', ["post" => $post, "user" => $post->user])}}">
                    <img class="mx-auto" src="{{asset('uploads') . '/' . $post->imagen}}" alt="Imagen del post {{$post->titulo}}">
                </a>

                <div class="py-3 w-1/2">
                    <a href="{{route('posts.index', $post->user)}}" class="font-bold hover:bg-blue-500"> {{ $post->user->username }} </a>
                    <p class="text-sm text-gray-500"> {{ $post->created_at->diffForHumans() }} </p>
                </div>
            </div>
                
            @endforeach
        </div>

        <div class="my-10">
            {{ $posts->links() }}
        </div>
    @else
        No hay posts
    @endif
@endsection