<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EspecialidadeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\RecetaController;
use App\Http\Controllers\ExameneController;

// Rutas abiertas (sin autenticación)

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::resource('users', UserController::class)->except(['create', 'edit']); //crud para usuarios

//Para el reporte de paciente
Route::get('paciente/reporte/{id}', [PacienteController::class, 'generateReport'])->name('paciente.reporte');

//Para el reporte de receta por paciente y por fecha
Route::get('receta/reporte/{id}', [RecetaController::class, 'generateReport'])->name('receta.reporte');



// Rutas protegidas (requieren autenticación)
Route::group(['middleware' => 'auth:sanctum'], function () {

    // Logout de la API
    Route::post('/logout', [AuthController::class, 'logout']);

    // Api de especialidades
    Route::resource('especialidades', EspecialidadeController::class)->except(['create', 'edit']); // Solo API, no necesitamos 'create' y 'edit'
    Route::get('/especialidad/select', [EspecialidadeController::class, 'select']); //selet para las espeialidades

    // Api de pacentes
    Route::resource('pacientes', PacienteController::class);
    Route::get('/paciente/select', [PacienteController::class, 'select']);
    Route::put('/paciente/update/{id}', [PacienteController::class, 'update']);
    Route::delete('/paciente/delete/{id}', [PacienteController::class, 'delete']);

    

    // Api de médicos
    Route::get('/medico/select', [MedicoController::class, 'select']);
    Route::post('/medico/store', [MedicoController::class, 'store']);
    Route::put('/medico/update/{id}', [MedicoController::class, 'update']);
    Route::delete('/medico/delete/{id}', [MedicoController::class, 'delete']);
    Route::get('/medico/find/{id}', [MedicoController::class, 'find']);

    // Api citas
    Route::get('/cita/select', [CitaController::class, 'select']);
    Route::get('citas', [CitaController::class, 'index']);
    Route::post('citas/create', [CitaController::class, 'store']);
    Route::put('citas/update/{id}', [CitaController::class, 'update']);
    Route::delete('citas/delete/{id}', [CitaController::class, 'delete']);
    Route::get('/citas/find/{id}', [CitaController::class, 'find']);


    // Api 
    Route::get('consultas', [ConsultaController::class, 'index']);
    Route::get('consulta/select', [ConsultaController::class, 'select']);
    Route::post('consultas/create', [ConsultaController::class, 'store']);
    Route::put('consultas/update/{id}', [ConsultaController::class, 'update']);
    Route::delete('consultas/delete/{id}', [ConsultaController::class, 'delete']);
    Route::get('consultas/find/{id}', [ConsultaController::class, 'find']);


    // Api receta
    Route::get('/consultas/{consultaId}/recetas', [RecetaController::class, 'getByConsulta']);
    Route::post('/recetas', [RecetaController::class, 'store']);
    Route::put('/recetas/{id}', [RecetaController::class, 'update']);
    Route::delete('/recetas/{id}', [RecetaController::class, 'destroy']);

    // Api examenes
    Route::get('/consultas/{consultaId}/examenes', [ExameneController::class, 'index']);
    Route::post('/examenes', [ExameneController::class, 'store']);
    Route::put('/examenes/{id}', [ExameneController::class, 'update']);
    Route::delete('/examenes/{id}', [ExameneController::class, 'destroy']);
});
