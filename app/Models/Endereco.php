<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    protected $fillable = [
        'logradouro',
        'numero',
        'bairro',
        'cidade',
        'unidade_federativa',
        'CEP',
        'complemento',
    ];

    protected $searchableFields = ['*'];


    public function clientes()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function mecanicos() {
        return $this->belongsTo(Mecanico::class);
    }
}
