<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdemServico extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_servico_id',
        'status',
        'dataEmissao',
        'dataEntrega',
        'descricao',
        'valor_total',
        'peca_id'
    ];

    public function tipoServico() {
        return $this->belongsTo(TipoServico::class);
    }

    public function peca() {
        return $this->belongsTo(Peca::class);
    }
}
