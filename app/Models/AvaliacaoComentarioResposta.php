<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AvaliacaoComentario;


class AvaliacaoComentarioResposta extends Model
{
    protected $table = 'avaliacoes_comentario_respostas';

    protected $fillable = [
        'avaliacao_comentario_id',
        'resposta',
    ];

    public function comentario()
    {
        return $this->belongsTo(AvaliacaoComentario::class, 'avaliacao_comentario_id');
    }
}
