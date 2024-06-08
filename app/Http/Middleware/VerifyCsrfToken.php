<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'pessoa/register',
        'pessoa/login',
        'pessoa/logout',
        'pessoa/usuario/editar',
        'pessoa/password/confirm',
        'pessoa/password/reset',
        'estabelecimento/register',
        'estabelecimento/login',
        'estabelecimento/logout',
        'estabelecimento/usuario/editar',
        'estabelecimento/password/reset',
        'admin/register',
        'admin/login',
        'admin/logout',
        'admin/editar',
        '/avaliar-estabelecimento',
        '/responder-avaliacao',
        '/upload/',

    ];
    
}
