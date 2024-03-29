<?php

use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImagenesController;
use App\Http\Controllers\LikeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home
Route::get('/', HomeController::class)->name('home');

// Registro, creación de cuentas.
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

// Login.
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);

// Cerrar sesión.
Route::post('/logout', [LogoutController::class, 'store'])->name('logout');

// Edición del perfil.
Route::get('/editar-perfil', [PerfilController::class, 'index'])->name('perfil.index');
Route::post('/editar-perfil', [PerfilController::class, 'store'])->name('perfil.store');

// Muro del usuario asociado al username.
Route::get('/{user:username}', [PostController::class, 'index'])->name('posts.index');

// Manejo de posts:

// Formulario para creación de posts.
Route::get('/post/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/post', [PostController::class, 'store'])->name('posts.store');

// Manejo de imagenes subidas en las publicaciones.
Route::post('/imagenes', [ImagenesController::class, 'store'])->name('imagenes.store');

// Mostrar posts,
Route::get('/{user:username}/post/{post}', [PostController::class, 'show'])->name('posts.show');

// Guardar comentarios,
Route::post('/{user:username}/post/{post}', [ComentarioController::class, 'store'])->name('comentarios.store');
Route::delete('/{user:username}/post/{post}/{comentario}', [ComentarioController::class, 'destroy'])->name('comentarios.destroy');

// Eliminar publicaciones.
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

// Likes
Route::post('posts/{post}/likes', [LikeController::class, 'store'])->name('posts.likes.store');
Route::delete('posts/{post}/likes', [LikeController::class, 'destroy'])->name('posts.likes.destroy');

// Función de seguidores.
Route::post('/{user:username}/follow', [FollowerController::class, 'store'])->name('users.follow');
Route::delete('/{user:username}/unfollow', [FollowerController::class, 'destroy'])->name('users.unfollow');