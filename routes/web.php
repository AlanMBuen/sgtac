<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

    Route::get('/ciudadanos', \App\Livewire\Ciudadano\Index::class)->name('ciudadanos.index');
    Route::get('/ciudadanos/{ciudadano}', \App\Livewire\Ciudadano\Detalles::class)->name('ciudadanos.detalles');

    Route::get('/departamentos', \App\Livewire\Departamento\Index::class)->name('departamentos.index');
    Route::get('/departamentos/{departamento}', \App\Livewire\Departamento\Detalles::class)->name('departamentos.detalles');

require __DIR__.'/auth.php';
