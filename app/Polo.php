<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Polo extends Model
{
    protected $fillable = [
        'nome',
        'codigo_polo',
    ];

    public function cursos()
    {
        return $this->hasMany(Curso::class);
    }

    public function getCursoComputacaoAttribute()
    {
	    return $this->cursos->filter(function($curso) {
		    return str_contains($curso->nome, 'Compu');
	    })->first();
    }

}
