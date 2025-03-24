<?php

header('Content-Type: application/json');

// Simular uma resposta da API
$response = [
    'status' => 'success',
    'message' => 'API do CRM-ERP SaaS Multitenancy',
    'version' => '1.0.0',
    'endpoints' => [
        [
            'path' => '/api/tenants',
            'methods' => ['GET', 'POST'],
            'description' => 'Gerenciamento de tenants'
        ],
        [
            'path' => '/api/tenants/{id}',
            'methods' => ['GET', 'PUT', 'DELETE'],
            'description' => 'Operações em um tenant específico'
        ],
        [
            'path' => '/api/stocks',
            'methods' => ['GET', 'POST'],
            'description' => 'Gerenciamento de estoque'
        ],
        [
            'path' => '/api/stocks/{id}',
            'methods' => ['GET', 'PUT', 'DELETE'],
            'description' => 'Operações em um item de estoque específico'
        ]
    ]
];

echo json_encode($response, JSON_PRETTY_PRINT); 