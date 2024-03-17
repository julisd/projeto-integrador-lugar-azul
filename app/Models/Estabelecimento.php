<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Endereco;


use Illuminate\Foundation\Auth\User as Authenticatable;

class Estabelecimento extends Authenticatable  implements CanResetPassword
{
    use  HasFactory, Notifiable;

    protected $table = 'estabelecimentos';
    protected $fillable = [
        'name', 'image', 'cnpj', 'email', 'telephone', 'password', 'description', 'category', 'status',  'autism_characteristics'
    ];

    public function endereco()
    {
        return $this->hasOne(Endereco::class, 'estabelecimento_id');
    }

    public function horarios()
    {
        return $this->hasMany(HorarioEstabelecimento::class);
    }
    
}
