<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use SoftDeletes;

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
