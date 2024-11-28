<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produccion extends Model
{
    use HasFactory;
    protected $table = 'produccion'; 

    protected $fillable = [
        'cod_produccion',
        'cod_order',
        'merma',
        'espacio_usado',
        'imagen',
        'status',
    ];
}
