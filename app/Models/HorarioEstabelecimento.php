<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Endereco;


use Illuminate\Foundation\Auth\User as Authenticatable;

class HorarioEstabelecimento extends Authenticatable  implements CanResetPassword
{
    use  HasFactory, Notifiable;

    protected $table = 'horarios_estabelecimento';
    protected $fillable = ['estabelecimento_id', 'dia_semana', 'abertura', 'fechamento'];

    public function estabelecimento()
    {
        return $this->belongsTo(Estabelecimento::class);
    }
    
}
