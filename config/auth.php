<?php

return [

'defaults' => [
    'guard' => 'web',
    'passwords' => 'pessoa_usuarias',
],
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],

    'admin' => [
        'driver' => 'session',
        'provider' => 'admins',
    ],

    'estabelecimento' => [
        'driver' => 'session',
        'provider' => 'estabelecimentos',
    ],

    'pessoa_usuaria' => [
        'driver' => 'session',
        'provider' => 'pessoas',
    ],
],

'providers' => [

    'admins' => [
        'driver' => 'eloquent',
        'model' => App\Models\Admin::class,
    ],

    'estabelecimentos' => [
        'driver' => 'eloquent',
        'model' => App\Models\Estabelecimento::class,
    ],

    'pessoas' => [
        'driver' => 'eloquent',
        'model' => App\Models\PessoaUsuaria::class,
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
