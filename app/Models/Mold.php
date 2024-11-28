<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mold extends Model
{
    use HasFactory;
    protected $fillable = [
        'code_mold',
        'name_mold',
        'width',
        'height',
        'status',
    ];
}
