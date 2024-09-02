<?php

use App\Http\Controllers\OrcamentosController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect("/orcamentos/listagem"));

Route::get("/orcamentos/criar", fn() => Inertia("CriarOrcamentos"))->name("criarOrcamentos");
Route::get("/orcamentos/editar/{id}", fn() => Inertia("CriarOrcamentos"))->name("criarOrcamentos");
Route::get("/orcamentos/listagem", fn() => Inertia("ListarOrcamentos"))->name("listarOrcamentos");
Route::post("/orcamentos/getDadosFiltrados", [OrcamentosController::class, "index"]);
Route::resource("/orcamentos", OrcamentosController::class);