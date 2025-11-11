<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;

    protected $table = "docentes";

    protected $fillable = [
        'nombre',
        'apellidop',
        'apellidom',
        'direccion',
        'email',
        'telefono',
        'descriptor',
        'user_id',
        'plantel_id',
    ];
}
