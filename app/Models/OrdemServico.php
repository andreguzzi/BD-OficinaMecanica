<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdemServico extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'dataEmissao',
        'dataEntrega',
        'descricao',
        'valor_total',
        'cliente_id',
        'veiculo_id',
        'mecanico_id'
    ];

    public function servico() {
        return $this->belongsTo(TipoServico::class);
    }

    public function peca() {
        return $this->BelongsToMany(Peca::class);
    }

    public function veiculo() {
        return $this->belongsTo(Veiculo::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    public function mecanico()
    {
        return $this->belongsTo(Mecanico::class);
    }
}
