<?php

return [

    'defaults' => [],


    'guards' => [
        'pessoa_usuaria' => [
            'driver' => 'session',
            'provider' => 'pessoa_usuarias',
        ],
        'estabelecimento' => [
            'driver' => 'session',
            'provider' => 'estabelecimentos',
        ],
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
    ],

    'providers' => [
        'pessoa_usuarias' => [
            'driver' => 'eloquent',
            'model' => App\Models\PessoaUsuaria::class, // Definindo o modelo correspondente para PessoaUsuaria
        ],
        'estabelecimentos' => [
            'driver' => 'eloquent',
            'model' => App\Models\Estabelecimento::class, // Definindo o modelo correspondente para Estabelecimento
        ],
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
    ],

    'passwords' => [
        'pessoa_usuarias' => [
            'provider' => 'pessoa_usuarias',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'estabelecimentos' => [
            'provider' => 'estabelecimentos',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],


    'reset' => [
        'pessoa_usuarias' => [
            'provider' => 'pessoa_usuarias',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'estabelecimentos' => [
            'provider' => 'estabelecimentos',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Here you may define the amount of seconds before a password confirmation
    | times out and the user is prompted to re-enter their password via the
    | confirmation screen. By default, the timeout lasts for three hours.
    |
    */

    'password_timeout' => 10800,

];
