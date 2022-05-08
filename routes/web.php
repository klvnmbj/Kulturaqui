<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PaisController;
use App\Http\Controllers\UserController;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', [UserController::class, 'login'])->name('dashboard');
});

// + Visitante 
    Route::get('/', function () { return view('welcome'); });
    Route::post('/user/register', [UserController::class, 'register'])->name('user.register');
// - Visitante 

// Dashboard
Route::middleware(['dashboard'])
->group(function () {
    Route::get('/dashboard', function () { return view('dashboard.index'); }); 
    Route::get('/view', function () { return view('kult.index'); })->name('dash.view'); 
});

// + Administrador 

    Route::group(['middleware' => 'administrador'], function(){
        // User
        Route::get('/users', [UserController::class, 'index'])->name('user.index');
        Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/user', [UserController::class, 'store'])->name('user.store');
        Route::get('/user/{user}/edit/status', [UserController::class, 'editStatus']);
        Route::post('/user/{user}/status', [UserController::class, 'updateStatus']);

        // Pais
        Route::get('/pais', [PaisController::class, 'index'])->name('pais.index');
        Route::get('/pais/create', [PaisController::class, 'create'])->name('pais.create');
        Route::post('/pais', [PaisController::class, 'store'])->name('pais.store');
        Route::get('/pais/{pais}/edit', [PaisController::class, 'edit']);
        Route::post('/pais/{pais}', [PaisController::class, 'update']);
        Route::get('/pais/{pais}/view', [PaisController::class, 'show']);
        Route::post('/pais/{pais}/destroy', [PaisController::class, 'destroy']);
    });

// - Administrador 



      