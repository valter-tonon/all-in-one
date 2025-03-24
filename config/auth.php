<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Autenticação - Defaults
    |--------------------------------------------------------------------------
    |
    | Esta opção controla o guard de autenticação "padrão" e as opções de redefinição de senha
    | para sua aplicação. Você pode alterar esses padrões conforme necessário,
    | mas eles são um bom começo para a maioria das aplicações.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Guards de Autenticação
    |--------------------------------------------------------------------------
    |
    | Em seguida, você pode definir cada guard de autenticação para sua aplicação.
    | Claro, uma ótima configuração padrão foi definida para você
    | aqui, que usa armazenamento de sessão e o modelo de usuário Eloquent.
    |
    | Todos os drivers de autenticação têm um provedor de usuário. Isso define como os
    | usuários são realmente recuperados do seu banco de dados ou outro armazenamento.
    | Eloquent é o ORM mais popular do Laravel, então vamos usá-lo aqui.
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
            'hash' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Provedores de Usuário
    |--------------------------------------------------------------------------
    |
    | Todos os drivers de autenticação têm um provedor de usuário. Isso define como os
    | usuários são realmente recuperados do seu banco de dados ou outro armazenamento.
    | Eloquent é o ORM mais popular do Laravel, então vamos usá-lo aqui.
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Redefinição de Senha
    |--------------------------------------------------------------------------
    |
    | Você pode especificar várias configurações de redefinição de senha se tiver mais
    | de uma tabela de usuário ou modelo em sua aplicação e deseja ter
    | configurações de redefinição de senha separadas com base nos tipos de usuário específicos.
    |
    | O tempo de expiração é o número de minutos que cada token de redefinição será
    | considerado válido. Esta configuração de segurança permite que os tokens expirem.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Tempo Limite de Redefinição de Senha
    |--------------------------------------------------------------------------
    |
    | Aqui você pode definir o número de segundos antes que um token de redefinição de senha
    | seja considerado expirado. Se você não definir um tempo limite, o padrão será
    | considerado como o valor definido para a opção de expiração.
    |
    */

    'password_timeout' => 10800,

]; 