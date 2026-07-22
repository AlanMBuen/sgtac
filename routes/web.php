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

require __DIR__.'/auth.php';
