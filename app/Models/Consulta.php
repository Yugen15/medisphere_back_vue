<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consulta extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'fecha', 'estado', 'diagnostico', 'id_cita'
    ];

    public function cita()
    {
        return $this->belongsTo(Cita::class, 'id_cita');
    }

    public function paciente()
    {
        // Aquí utilizamos la relación cita para acceder al paciente
        return $this->cita->belongsTo(Paciente::class, 'paciente_id');
    }

    public function doctor()
    {
        // Aquí utilizamos la relación cita para acceder al médico
        return $this->cita->belongsTo(Medico::class, 'doctor_id');
    }
}
