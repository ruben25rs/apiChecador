<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    protected $table = "asistencias";

    protected $fillable = [
        'tipo',
        'foto_url',
        'sincronizado',
        'user_id',
    ];
}
