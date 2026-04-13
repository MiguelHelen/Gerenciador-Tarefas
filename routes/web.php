<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rotas públicas
Route::get('/', function () {
    return view('welcome');
});

// Rotas de autenticação (geradas pelo Laravel)
Auth::routes();

// Rotas protegidas por autenticação
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // Rotas de tarefas
    Route::resource('tasks', TaskController::class);
    
    // Rota adicional para alternar status
    Route::patch('tasks/{task}/toggle-status', [TaskController::class, 'toggleStatus'])
         ->name('tasks.toggle-status');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
