<?php

return [

'defaults' => [
    'guard' => 'web',
    'passwords' => 'pessoa_usuarias',
],


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
        'model' => App\Models\PessoaUsuaria::class,
    ],
    'estabelecimentos' => [
        'driver' => 'eloquent',
        'model' => App\Models\Estabelecimento::class,
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
    'admins' => [
        'provider' => 'admins',
        'table' => 'password_reset_tokens',
        'expire' => 60,
        'throttle' => 60,
    ],
],

'password_timeout' => 10800,

];
