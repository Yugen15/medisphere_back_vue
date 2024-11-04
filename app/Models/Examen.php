<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Examen extends Model
{
    use SoftDeletes;

    protected $table = 'examenes';

    protected $fillable = [
        'tipo',
        'resultado',
        'id_consulta'
    ];

    protected $dates = ['deleted_at'];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class, 'id_consulta');
    }
}
