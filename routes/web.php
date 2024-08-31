<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get("/documentos", fn() => Inertia("Documentos"))->name("listagemDocumentos");