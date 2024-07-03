<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaoObra extends Model
{
    use HasFactory;

    protected $fillable = [
        'horas',
        'custo'
    ];
}
