<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoServico extends Model
{
    use HasFactory;

    protected $fillable = [
        'conserto',
        'revisao',
        'mecanico_id',
        'cliente_veiculo_id'
    ];

    public function mecanico() {
        return $this->belongsTo(Mecanico::class);
    }

    public function clienteVeiculo() {
        return $this->belongsTo(ClienteVeiculo::class);
    }
}
