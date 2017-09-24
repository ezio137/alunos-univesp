<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Aluno extends Model
{
    protected $fillable = [
        'curso_id',
        'nome',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}
