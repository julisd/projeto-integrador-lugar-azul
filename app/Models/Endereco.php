<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model\Estabelecimento;


class Endereco extends Model
{
    protected $table = 'enderecos';

    protected $fillable = [
        'cep', 'logradouro', 'numero', 'complemento', 'bairro', 'cidade', 'uf', 'estabelecimento_id',
    ];

    public function estabelecimento()
    {
        return $this->belongsTo(Estabelecimento::class);
    }
}
