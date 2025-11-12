<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Docente extends Model
{
    use HasFactory;

    protected $table = "docentes";

    protected $fillable = [
        'uuid',
        'nombre',
        'apellidop',
        'apellidom',
        'direccion',
        'email',
        'telefono',
        'descriptor',
        'sincronizado',
        'user_id',
        'plantel_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->uuid) {
                $model->uuid = Str::uuid()->toString();
            }
        });
    }
}
