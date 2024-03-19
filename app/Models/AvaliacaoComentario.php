<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AvaliacaoComentarioResposta;
use App\Models\PessoaUsuaria;
use App\Models\Estabelecimento;



class AvaliacaoComentario extends Model
{   
    protected $table = 'avaliacoes_comentarios';
    
    protected $fillable = [
        'usuario_id',
        'estabelecimento_id',
        'avaliacao',
        'comentario'
    ];

    // Relacionamento com o modelo de Usuário
    public function usuario()
    {
        return $this->belongsTo(PessoaUsuaria::class, 'usuario_id');
    }

    // Relacionamento com o modelo de Estabelecimento
    public function estabelecimento()
    {
        return $this->belongsTo(Estabelecimento::class, 'estabelecimento_id');
    }

    // Relacionamento com respostas
    public function respostas()
    {
        return $this->hasMany(AvaliacaoComentarioResposta::class, 'avaliacao_comentario_id');
    }
}
