<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'CPF',
        'CNPJ',
        'tipo_pessoa',
        'razao_social',
        'endereco_id'
    ];

    protected $searchableFields = ['*'];

    public function endereco()
    {
        return $this->belongsTo(Endereco::class);
    }
}
