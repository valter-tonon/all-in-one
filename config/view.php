<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Caminhos de Visualização
    |--------------------------------------------------------------------------
    |
    | A maioria dos sistemas de templates em PHP carrega templates de disco. Aqui você pode
    | listar todos os caminhos que devem ser verificados quando as visualizações são carregadas.
    | O caminho padrão é a pasta "resources/views" dentro da aplicação.
    |
    */

    'paths' => [
        resource_path('views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Caminho de Compilação de Visualizações
    |--------------------------------------------------------------------------
    |
    | Muitos sistemas de templates compilam as visualizações em tempo de execução para melhorar
    | o desempenho. Aqui você pode especificar um caminho onde os arquivos de visualização compilados
    | devem ser armazenados. Este é o caminho padrão para o Laravel.
    |
    */

    'compiled' => env(
        'VIEW_COMPILED_PATH',
        realpath(storage_path('framework/views'))
    ),

]; 