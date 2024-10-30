<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    protected $fillable = [
        'medicamento',
        'dosis',
        'id_consulta'
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class, 'id_consulta', 'consulta_id');
    }
}