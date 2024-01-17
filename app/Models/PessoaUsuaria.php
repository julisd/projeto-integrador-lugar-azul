<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class PessoaUsuaria extends Authenticatable
{

    use HasFactory;
    use Notifiable;

    protected $table = 'pessoa_usuaria';
    protected $fillable = ['name', 'email', 'password', 'birthdate', 'autism_characteristics'];

    public function avaliacoesComentarios()
    {
        return $this->hasMany(AvaliacaoComentario::class, 'usuario_id');
    }
}
