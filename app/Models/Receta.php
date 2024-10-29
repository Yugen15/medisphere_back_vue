<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receta extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'recetas'; // Nombre de la tabla en la base de datos

    // Campos que se pueden asignar en masa
    protected $fillable = [
        'medicamento',
        'dosis',
        'id_consulta',
    ];

    // Campos que Laravel tratará como timestamps
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
