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

    Route::get('/puestos', \App\Livewire\Puesto\Index::class)->name('puestos.index');
    Route::get('/puestos/{puesto}', \App\Livewire\Puesto\Detalles::class)->name('puesto.detalles');

    Route::get('/empleados', \App\Livewire\Empleado\Index::class)->name('empleados.index');
    Route::get('/empleados/{empleado}', \App\Livewire\Empleado\Detalles::class)->name('empleados.detalles');

    Route::get('/contratos', \App\Livewire\Contrato\Index::class)->name('contratos.index');
    Route::get('/contratos/{contrato}', \App\Livewire\Contrato\Detalles::class)->name('contratos.detalles');

    Route::get('/tipotramites', \App\Livewire\TipoTramite\Index::class)->name('tipotramites.index');
    Route::get('/tipotramites/{tipotramite}', \App\Livewire\TipoTramite\Detalles::class)->name('tipotramites.detalles');

require __DIR__.'/auth.php';
