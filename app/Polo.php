<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Polo extends Model
{
    protected $fillable = [
        'nome',
        'codigo_polo',
    ];
}
