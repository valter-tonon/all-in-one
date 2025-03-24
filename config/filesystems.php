<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Disco de Sistema de Arquivos Padrão
    |--------------------------------------------------------------------------
    |
    | Aqui você pode especificar o disco de sistema de arquivos padrão que deve ser usado
    | pelo framework. O disco "local" e o disco "s3" são fornecidos
    | pronto para uso. Basta armazenar seus arquivos localmente ou no S3.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Discos de Sistema de Arquivos
    |--------------------------------------------------------------------------
    |
    | Aqui você pode configurar quantos discos de sistema de arquivos desejar, e pode até
    | configurar vários discos do mesmo driver. Os valores padrão foram
    | configurados para cada driver como um exemplo das opções necessárias.
    |
    | Drivers suportados: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

        'tenant' => [
            'driver' => 'local',
            'root' => storage_path('app/tenants'),
            'throw' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Links Simbólicos
    |--------------------------------------------------------------------------
    |
    | Aqui você pode configurar os links simbólicos que serão criados quando o
    | comando `storage:link` Artisan é executado. Os links de array configurados
    | serão criados para você quando este comando Artisan for executado.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

]; 