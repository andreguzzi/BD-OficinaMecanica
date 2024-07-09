<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peca extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'valor'
    ];

    public function ordemServico() {
        return $this->hasMany(OrdemServico::class);
    }
    
}
