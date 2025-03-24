<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Configurações de Multitenancy
    |--------------------------------------------------------------------------
    |
    | Aqui você pode configurar as opções de multitenancy para o sistema.
    |
    */

    // Conexão padrão para o banco de dados do landlord
    'landlord_connection' => 'mysql',
    
    // Prefixo para os bancos de dados dos tenants
    'tenant_db_prefix' => 'tenant_',
    
    // Configurações de identificação do tenant
    'identification' => [
        // Métodos de identificação do tenant (em ordem de prioridade)
        'methods' => [
            'domain', // Identificar pelo domínio
            'header', // Identificar pelo header X-Tenant-ID
        ],
        
        // Nome do header para identificação do tenant
        'header_name' => 'X-Tenant-ID',
        
        // Domínio base para os tenants (ex: tenant.example.com)
        'base_domain' => env('TENANT_BASE_DOMAIN', 'localhost'),
    ],
    
    // Configurações de banco de dados
    'database' => [
        // Usar banco de dados separado para cada tenant
        'separate_databases' => true,
        
        // Configurações de migração
        'migrations' => [
            // Diretório das migrações específicas para tenants
            'path' => database_path('migrations/tenant'),
            
            // Executar migrações automaticamente ao criar um tenant
            'auto_migrate' => true,
        ],
    ],
    
    // Configurações de cache
    'cache' => [
        // Prefixo para as chaves de cache dos tenants
        'prefix' => 'tenant_',
        
        // Limpar cache ao trocar de tenant
        'clear_on_switch' => true,
    ],
    
    // Configurações de armazenamento
    'storage' => [
        // Usar diretórios separados para cada tenant
        'separate_directories' => true,
        
        // Diretório base para os arquivos dos tenants
        'base_path' => storage_path('app/tenants'),
    ],
]; 