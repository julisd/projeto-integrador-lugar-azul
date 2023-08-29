<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Estabelecimento extends Authenticatable
{
    use  HasFactory, Notifiable;

    protected $table = 'estabelecimentos';
    protected $fillable = [
        'name', 'cnpj', 'email', 'password', 'description', 'category',
    ];
   
}
