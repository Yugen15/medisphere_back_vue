<?php

namespace App\Models;

use App\Models\Medico;
use App\Models\Paciente;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cita extends Model
{
    use HasFactory;
    protected $table = 'citas';
    protected $fillable = ['title', 'date', 'estado', 'paciente_id', 'doctor_id'];

     /**
     * Definir la relación de la cita con el paciente.
     * Una cita pertenece a un paciente.
     */
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    /**
     * Definir la relación de la cita con el doctor.
     * Una cita pertenece a un doctor.
     */
    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }
}
