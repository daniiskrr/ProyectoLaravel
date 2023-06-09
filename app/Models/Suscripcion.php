<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Suscripcion extends Model
{
    use HasFactory;

    protected $table = 'suscripcion';

    protected $fillable = [
        'id',
        'nombre_suscripcion',
        'precio_suscripcion',
        'duracion'
    ];

}
