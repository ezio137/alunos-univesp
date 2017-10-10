<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Curso extends Model
{
    protected $fillable = [
        'polo_id',
        'nome',
        'codigo_curso',
    ];

    public function polo()
    {
        return $this->belongsTo(Polo::class);
    }

    public function alunos()
    {
        return $this->hasMany(Aluno::class);
    }

}
