<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Medico extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido',
        'id_especialidad'
    ];

    public function especialidade(): BelongsTo
    {
        return $this->belongsTo(Especialidade::class, 'id_especialidad');
    }
}