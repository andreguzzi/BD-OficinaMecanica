<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mecanico extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'especialidade',
        'endereco_id',
    ];

    public function endereco() {
        return $this->belongsTo(Endereco::class);
    }

}
