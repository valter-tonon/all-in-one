<?php

use App\Interfaces\Http\Controllers\StockController;
use App\Interfaces\Http\Controllers\TenantController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Rotas públicas
Route::get('/', function () {
    return response()->json([
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
            ],
            [
                'path' => '/api/stocks/low-stock',
                'methods' => ['GET'],
                'description' => 'Listar itens com estoque baixo'
            ],
            [
                'path' => '/api/stocks/out-of-stock',
                'methods' => ['GET'],
                'description' => 'Listar itens sem estoque'
            ]
        ]
    ]);
});

// Rotas de autenticação
Route::prefix('auth')->group(function () {
    Route::post('/login', function (Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->is_admin ? 'admin' : 'user',
                ]
            ]);
        }

        return response()->json([
            'message' => 'Credenciais inválidas'
        ], 401);
    });

    Route::middleware('auth:sanctum')->get('/check', function (Request $request) {
        return response()->json([
            'user' => $request->user()
        ]);
    });
});

// Rotas de Tenant (Admin)
Route::prefix('tenants')->group(function () {
    Route::get('/', [TenantController::class, 'index']);
    Route::get('/search', [TenantController::class, 'search']);
    Route::get('/{id}', [TenantController::class, 'show']);
    Route::post('/', [TenantController::class, 'store']);
    Route::put('/{id}', [TenantController::class, 'update']);
    Route::delete('/{id}', [TenantController::class, 'destroy']);
});

// Rotas de Estoque (Tenant)
Route::middleware('tenant')->prefix('stocks')->group(function () {
    Route::get('/', [StockController::class, 'index']);
    Route::get('/search', [StockController::class, 'search']);
    Route::get('/low-stock', [StockController::class, 'lowStock']);
    Route::get('/out-of-stock', [StockController::class, 'outOfStock']);
    Route::get('/{id}', [StockController::class, 'show']);
    Route::post('/', [StockController::class, 'store']);
    Route::put('/{id}', [StockController::class, 'update']);
    Route::delete('/{id}', [StockController::class, 'destroy']);
});

// Rotas do módulo CRM
Route::prefix('crm')->group(function () {
    // Rotas de Clientes
    Route::prefix('clientes')->group(function () {
        Route::get('/', function (Request $request) {
            // Simulação de dados para desenvolvimento
            return response()->json([
                'data' => [
                    [
                        'id' => 1,
                        'nome' => 'Empresa ABC',
                        'email' => 'contato@empresaabc.com',
                        'telefone' => '(11) 3333-4444',
                        'empresa' => 'Empresa ABC Ltda',
                        'cargo' => 'Gerente',
                        'endereco' => 'Rua das Flores, 123',
                        'cidade' => 'São Paulo',
                        'estado' => 'SP',
                        'cep' => '01234-567',
                        'pais' => 'Brasil',
                        'observacoes' => 'Cliente desde 2020',
                        'status' => 'ativo'
                    ],
                    [
                        'id' => 2,
                        'nome' => 'Empresa XYZ',
                        'email' => 'contato@empresaxyz.com',
                        'telefone' => '(11) 5555-6666',
                        'empresa' => 'Empresa XYZ S.A.',
                        'cargo' => 'Diretor',
                        'endereco' => 'Av. Paulista, 1000',
                        'cidade' => 'São Paulo',
                        'estado' => 'SP',
                        'cep' => '01310-100',
                        'pais' => 'Brasil',
                        'observacoes' => 'Cliente VIP',
                        'status' => 'ativo'
                    ]
                ],
                'total' => 2
            ]);
        });
        
        Route::get('/{id}', function (Request $request, $id) {
            // Simulação de dados para desenvolvimento
            $clientes = [
                1 => [
                    'id' => 1,
                    'nome' => 'Empresa ABC',
                    'email' => 'contato@empresaabc.com',
                    'telefone' => '(11) 3333-4444',
                    'empresa' => 'Empresa ABC Ltda',
                    'cargo' => 'Gerente',
                    'endereco' => 'Rua das Flores, 123',
                    'cidade' => 'São Paulo',
                    'estado' => 'SP',
                    'cep' => '01234-567',
                    'pais' => 'Brasil',
                    'observacoes' => 'Cliente desde 2020',
                    'status' => 'ativo'
                ],
                2 => [
                    'id' => 2,
                    'nome' => 'Empresa XYZ',
                    'email' => 'contato@empresaxyz.com',
                    'telefone' => '(11) 5555-6666',
                    'empresa' => 'Empresa XYZ S.A.',
                    'cargo' => 'Diretor',
                    'endereco' => 'Av. Paulista, 1000',
                    'cidade' => 'São Paulo',
                    'estado' => 'SP',
                    'cep' => '01310-100',
                    'pais' => 'Brasil',
                    'observacoes' => 'Cliente VIP',
                    'status' => 'ativo'
                ]
            ];
            
            if (isset($clientes[$id])) {
                return response()->json($clientes[$id]);
            }
            
            return response()->json(['message' => 'Cliente não encontrado'], 404);
        });
        
        Route::post('/', function (Request $request) {
            // Simulação de criação
            return response()->json([
                'id' => 3,
                'nome' => $request->nome,
                'email' => $request->email,
                'telefone' => $request->telefone,
                'empresa' => $request->empresa,
                'cargo' => $request->cargo,
                'endereco' => $request->endereco,
                'cidade' => $request->cidade,
                'estado' => $request->estado,
                'cep' => $request->cep,
                'pais' => $request->pais,
                'observacoes' => $request->observacoes,
                'status' => $request->status
            ], 201);
        });
        
        Route::put('/{id}', function (Request $request, $id) {
            // Simulação de atualização
            return response()->json([
                'id' => $id,
                'nome' => $request->nome,
                'email' => $request->email,
                'telefone' => $request->telefone,
                'empresa' => $request->empresa,
                'cargo' => $request->cargo,
                'endereco' => $request->endereco,
                'cidade' => $request->cidade,
                'estado' => $request->estado,
                'cep' => $request->cep,
                'pais' => $request->pais,
                'observacoes' => $request->observacoes,
                'status' => $request->status
            ]);
        });
        
        Route::delete('/{id}', function (Request $request, $id) {
            // Simulação de exclusão
            return response()->json(['message' => 'Cliente excluído com sucesso']);
        });
    });
    
    // Rotas de Contatos
    Route::prefix('contatos')->group(function () {
        Route::get('/', function (Request $request) {
            // Simulação de dados para desenvolvimento
            return response()->json([
                'data' => [
                    [
                        'id' => 1,
                        'nome' => 'João Silva',
                        'email' => 'joao@empresaabc.com',
                        'telefone' => '(11) 98765-4321',
                        'cargo' => 'Gerente de Compras',
                        'cliente_id' => 1,
                        'departamento' => 'Compras',
                        'observacoes' => 'Contato principal'
                    ],
                    [
                        'id' => 2,
                        'nome' => 'Maria Souza',
                        'email' => 'maria@empresaxyz.com',
                        'telefone' => '(11) 91234-5678',
                        'cargo' => 'Diretora Financeira',
                        'cliente_id' => 2,
                        'departamento' => 'Financeiro',
                        'observacoes' => 'Contato para assuntos financeiros'
                    ]
                ],
                'total' => 2,
                'meta' => [
                    'current_page' => 1,
                    'last_page' => 1
                ]
            ]);
        });
        
        Route::get('/{id}', function (Request $request, $id) {
            // Simulação de dados para desenvolvimento
            $contatos = [
                1 => [
                    'id' => 1,
                    'nome' => 'João Silva',
                    'email' => 'joao@empresaabc.com',
                    'telefone' => '(11) 98765-4321',
                    'cargo' => 'Gerente de Compras',
                    'cliente_id' => 1,
                    'departamento' => 'Compras',
                    'observacoes' => 'Contato principal'
                ],
                2 => [
                    'id' => 2,
                    'nome' => 'Maria Souza',
                    'email' => 'maria@empresaxyz.com',
                    'telefone' => '(11) 91234-5678',
                    'cargo' => 'Diretora Financeira',
                    'cliente_id' => 2,
                    'departamento' => 'Financeiro',
                    'observacoes' => 'Contato para assuntos financeiros'
                ]
            ];
            
            if (isset($contatos[$id])) {
                return response()->json($contatos[$id]);
            }
            
            return response()->json(['message' => 'Contato não encontrado'], 404);
        });
        
        Route::post('/', function (Request $request) {
            // Simulação de criação
            return response()->json([
                'id' => 3,
                'nome' => $request->nome,
                'email' => $request->email,
                'telefone' => $request->telefone,
                'cargo' => $request->cargo,
                'cliente_id' => $request->cliente_id,
                'departamento' => $request->departamento,
                'observacoes' => $request->observacoes
            ], 201);
        });
        
        Route::put('/{id}', function (Request $request, $id) {
            // Simulação de atualização
            return response()->json([
                'id' => $id,
                'nome' => $request->nome,
                'email' => $request->email,
                'telefone' => $request->telefone,
                'cargo' => $request->cargo,
                'cliente_id' => $request->cliente_id,
                'departamento' => $request->departamento,
                'observacoes' => $request->observacoes
            ]);
        });
        
        Route::delete('/{id}', function (Request $request, $id) {
            // Simulação de exclusão
            return response()->json(['message' => 'Contato excluído com sucesso']);
        });
    });
    
    // Rotas de Oportunidades
    Route::prefix('oportunidades')->group(function () {
        Route::get('/', function (Request $request) {
            // Simulação de dados para desenvolvimento
            return response()->json([
                'data' => [
                    [
                        'id' => 1,
                        'titulo' => 'Projeto de Implementação ERP',
                        'cliente_id' => 1,
                        'valor' => 50000.00,
                        'status' => 'em_andamento',
                        'data_previsao' => '2025-06-30',
                        'descricao' => 'Implementação de sistema ERP completo'
                    ],
                    [
                        'id' => 2,
                        'titulo' => 'Consultoria Estratégica',
                        'cliente_id' => 2,
                        'valor' => 25000.00,
                        'status' => 'negociacao',
                        'data_previsao' => '2025-04-15',
                        'descricao' => 'Consultoria para planejamento estratégico'
                    ]
                ],
                'total' => 2,
                'meta' => [
                    'current_page' => 1,
                    'last_page' => 1
                ]
            ]);
        });
        
        Route::get('/{id}', function (Request $request, $id) {
            // Simulação de dados para desenvolvimento
            $oportunidades = [
                1 => [
                    'id' => 1,
                    'titulo' => 'Projeto de Implementação ERP',
                    'cliente_id' => 1,
                    'valor' => 50000.00,
                    'status' => 'em_andamento',
                    'data_previsao' => '2025-06-30',
                    'descricao' => 'Implementação de sistema ERP completo'
                ],
                2 => [
                    'id' => 2,
                    'titulo' => 'Consultoria Estratégica',
                    'cliente_id' => 2,
                    'valor' => 25000.00,
                    'status' => 'negociacao',
                    'data_previsao' => '2025-04-15',
                    'descricao' => 'Consultoria para planejamento estratégico'
                ]
            ];
            
            if (isset($oportunidades[$id])) {
                return response()->json($oportunidades[$id]);
            }
            
            return response()->json(['message' => 'Oportunidade não encontrada'], 404);
        });
        
        Route::post('/', function (Request $request) {
            // Simulação de criação
            return response()->json([
                'id' => 3,
                'titulo' => $request->titulo,
                'cliente_id' => $request->cliente_id,
                'valor' => $request->valor,
                'status' => $request->status,
                'data_previsao' => $request->data_previsao,
                'descricao' => $request->descricao
            ], 201);
        });
        
        Route::put('/{id}', function (Request $request, $id) {
            // Simulação de atualização
            return response()->json([
                'id' => $id,
                'titulo' => $request->titulo,
                'cliente_id' => $request->cliente_id,
                'valor' => $request->valor,
                'status' => $request->status,
                'data_previsao' => $request->data_previsao,
                'descricao' => $request->descricao
            ]);
        });
        
        Route::delete('/{id}', function (Request $request, $id) {
            // Simulação de exclusão
            return response()->json(['message' => 'Oportunidade excluída com sucesso']);
        });
    });
    
    // Rotas de Atividades
    Route::prefix('atividades')->group(function () {
        Route::get('/', function (Request $request) {
            // Simulação de dados para desenvolvimento
            return response()->json([
                'data' => [
                    [
                        'id' => 1,
                        'titulo' => 'Reunião de Kickoff',
                        'tipo' => 'reuniao',
                        'data' => '2025-03-15',
                        'hora' => '14:00',
                        'cliente_id' => 1,
                        'contato_id' => 1,
                        'oportunidade_id' => 1,
                        'descricao' => 'Reunião inicial para definição do projeto',
                        'status' => 'agendada'
                    ],
                    [
                        'id' => 2,
                        'titulo' => 'Apresentação de Proposta',
                        'tipo' => 'apresentacao',
                        'data' => '2025-03-20',
                        'hora' => '10:00',
                        'cliente_id' => 2,
                        'contato_id' => 2,
                        'oportunidade_id' => 2,
                        'descricao' => 'Apresentação da proposta de consultoria',
                        'status' => 'agendada'
                    ]
                ],
                'total' => 2,
                'meta' => [
                    'current_page' => 1,
                    'last_page' => 1
                ]
            ]);
        });
        
        Route::get('/{id}', function (Request $request, $id) {
            // Simulação de dados para desenvolvimento
            $atividades = [
                1 => [
                    'id' => 1,
                    'titulo' => 'Reunião de Kickoff',
                    'tipo' => 'reuniao',
                    'data' => '2025-03-15',
                    'hora' => '14:00',
                    'cliente_id' => 1,
                    'contato_id' => 1,
                    'oportunidade_id' => 1,
                    'descricao' => 'Reunião inicial para definição do projeto',
                    'status' => 'agendada'
                ],
                2 => [
                    'id' => 2,
                    'titulo' => 'Apresentação de Proposta',
                    'tipo' => 'apresentacao',
                    'data' => '2025-03-20',
                    'hora' => '10:00',
                    'cliente_id' => 2,
                    'contato_id' => 2,
                    'oportunidade_id' => 2,
                    'descricao' => 'Apresentação da proposta de consultoria',
                    'status' => 'agendada'
                ]
            ];
            
            if (isset($atividades[$id])) {
                return response()->json($atividades[$id]);
            }
            
            return response()->json(['message' => 'Atividade não encontrada'], 404);
        });
        
        Route::post('/', function (Request $request) {
            // Simulação de criação
            return response()->json([
                'id' => 3,
                'titulo' => $request->titulo,
                'tipo' => $request->tipo,
                'data' => $request->data,
                'hora' => $request->hora,
                'cliente_id' => $request->cliente_id,
                'contato_id' => $request->contato_id,
                'oportunidade_id' => $request->oportunidade_id,
                'descricao' => $request->descricao,
                'status' => $request->status
            ], 201);
        });
        
        Route::put('/{id}', function (Request $request, $id) {
            // Simulação de atualização
            return response()->json([
                'id' => $id,
                'titulo' => $request->titulo,
                'tipo' => $request->tipo,
                'data' => $request->data,
                'hora' => $request->hora,
                'cliente_id' => $request->cliente_id,
                'contato_id' => $request->contato_id,
                'oportunidade_id' => $request->oportunidade_id,
                'descricao' => $request->descricao,
                'status' => $request->status
            ]);
        });
        
        Route::delete('/{id}', function (Request $request, $id) {
            // Simulação de exclusão
            return response()->json(['message' => 'Atividade excluída com sucesso']);
        });
    });
    
    // Rota para o dashboard do CRM
    Route::get('/dashboard', function (Request $request) {
        // Simulação de dados para o dashboard
        return response()->json([
            'clientes_total' => 2,
            'oportunidades_total' => 2,
            'oportunidades_valor_total' => 75000.00,
            'atividades_pendentes' => 2,
            'oportunidades_por_status' => [
                'negociacao' => 1,
                'em_andamento' => 1,
                'ganhas' => 0,
                'perdidas' => 0
            ],
            'atividades_proximas' => [
                [
                    'id' => 1,
                    'titulo' => 'Reunião de Kickoff',
                    'data' => '2025-03-15',
                    'cliente' => 'Empresa ABC'
                ],
                [
                    'id' => 2,
                    'titulo' => 'Apresentação de Proposta',
                    'data' => '2025-03-20',
                    'cliente' => 'Empresa XYZ'
                ]
            ]
        ]);
    });
});

// Rotas do módulo de Produtos
Route::prefix('produtos')->group(function () {
    Route::get('/', function (Request $request) {
        // Simulação de dados para desenvolvimento
        return response()->json([
            'data' => [
                [
                    'id' => 1,
                    'nome' => 'Notebook Dell Inspiron',
                    'sku' => 'DELL-INSP-15',
                    'preco' => 3599.90,
                    'estoque' => 15,
                    'estoqueMinimo' => 5,
                    'categoria' => 'Eletrônicos',
                    'status' => 'ativo',
                    'descricao' => 'Notebook Dell Inspiron 15 polegadas, 8GB RAM, 256GB SSD',
                    'unidade' => 'un',
                    'peso' => 2.2,
                    'dimensoes' => [
                        'altura' => 2.5,
                        'largura' => 38,
                        'comprimento' => 26
                    ]
                ],
                [
                    'id' => 2,
                    'nome' => 'Monitor LG UltraWide',
                    'sku' => 'LG-UW-29',
                    'preco' => 1899.90,
                    'estoque' => 8,
                    'estoqueMinimo' => 3,
                    'categoria' => 'Periféricos',
                    'status' => 'ativo',
                    'descricao' => 'Monitor LG UltraWide 29 polegadas, resolução 2560x1080',
                    'unidade' => 'un',
                    'peso' => 5.2,
                    'dimensoes' => [
                        'altura' => 20,
                        'largura' => 70,
                        'comprimento' => 30
                    ]
                ],
                [
                    'id' => 3,
                    'nome' => 'Teclado Mecânico Redragon',
                    'sku' => 'RD-MECH-K552',
                    'preco' => 299.90,
                    'estoque' => 2,
                    'estoqueMinimo' => 5,
                    'categoria' => 'Periféricos',
                    'status' => 'ativo',
                    'descricao' => 'Teclado mecânico Redragon K552 RGB',
                    'unidade' => 'un',
                    'peso' => 0.9,
                    'dimensoes' => [
                        'altura' => 3,
                        'largura' => 35,
                        'comprimento' => 12
                    ]
                ],
                [
                    'id' => 4,
                    'nome' => 'Mouse Logitech G Pro',
                    'sku' => 'LOG-GPRO',
                    'preco' => 399.90,
                    'estoque' => 0,
                    'estoqueMinimo' => 5,
                    'categoria' => 'Periféricos',
                    'status' => 'ativo',
                    'descricao' => 'Mouse gamer Logitech G Pro Wireless',
                    'unidade' => 'un',
                    'peso' => 0.08,
                    'dimensoes' => [
                        'altura' => 4,
                        'largura' => 6,
                        'comprimento' => 12
                    ]
                ]
            ],
            'meta' => [
                'current_page' => 1,
                'from' => 1,
                'last_page' => 1,
                'per_page' => 10,
                'to' => 4,
                'total' => 4
            ]
        ]);
    });
    
    Route::get('/low-stock', function (Request $request) {
        // Simulação de dados para desenvolvimento
        return response()->json([
            'data' => [
                [
                    'id' => 3,
                    'nome' => 'Teclado Mecânico Redragon',
                    'sku' => 'RD-MECH-K552',
                    'preco' => 299.90,
                    'estoque' => 2,
                    'estoqueMinimo' => 5,
                    'categoria' => 'Periféricos',
                    'status' => 'ativo'
                ]
            ],
            'meta' => [
                'current_page' => 1,
                'from' => 1,
                'last_page' => 1,
                'per_page' => 10,
                'to' => 1,
                'total' => 1
            ]
        ]);
    });
    
    Route::get('/out-of-stock', function (Request $request) {
        // Simulação de dados para desenvolvimento
        return response()->json([
            'data' => [
                [
                    'id' => 4,
                    'nome' => 'Mouse Logitech G Pro',
                    'sku' => 'LOG-GPRO',
                    'preco' => 399.90,
                    'estoque' => 0,
                    'estoqueMinimo' => 5,
                    'categoria' => 'Periféricos',
                    'status' => 'ativo'
                ]
            ],
            'meta' => [
                'current_page' => 1,
                'from' => 1,
                'last_page' => 1,
                'per_page' => 10,
                'to' => 1,
                'total' => 1
            ]
        ]);
    });
    
    Route::get('/categorias', function (Request $request) {
        // Simulação de dados para desenvolvimento
        return response()->json([
            'data' => [
                'Eletrônicos',
                'Periféricos',
                'Móveis',
                'Acessórios',
                'Outros'
            ],
            'meta' => [
                'total' => 5
            ]
        ]);
    });
    
    Route::get('/{id}', function (Request $request, $id) {
        // Simulação de dados para desenvolvimento
        $produtos = [
            1 => [
                'id' => 1,
                'nome' => 'Notebook Dell Inspiron',
                'sku' => 'DELL-INSP-15',
                'preco' => 3599.90,
                'estoque' => 15,
                'estoqueMinimo' => 5,
                'categoria' => 'Eletrônicos',
                'status' => 'ativo',
                'descricao' => 'Notebook Dell Inspiron 15 polegadas, 8GB RAM, 256GB SSD',
                'unidade' => 'un',
                'peso' => 2.2,
                'dimensoes' => [
                    'altura' => 2.5,
                    'largura' => 38,
                    'comprimento' => 26
                ]
            ],
            2 => [
                'id' => 2,
                'nome' => 'Monitor LG UltraWide',
                'sku' => 'LG-UW-29',
                'preco' => 1899.90,
                'estoque' => 8,
                'estoqueMinimo' => 3,
                'categoria' => 'Periféricos',
                'status' => 'ativo',
                'descricao' => 'Monitor LG UltraWide 29 polegadas, resolução 2560x1080',
                'unidade' => 'un',
                'peso' => 5.2,
                'dimensoes' => [
                    'altura' => 20,
                    'largura' => 70,
                    'comprimento' => 30
                ]
            ],
            3 => [
                'id' => 3,
                'nome' => 'Teclado Mecânico Redragon',
                'sku' => 'RD-MECH-K552',
                'preco' => 299.90,
                'estoque' => 2,
                'estoqueMinimo' => 5,
                'categoria' => 'Periféricos',
                'status' => 'ativo',
                'descricao' => 'Teclado mecânico Redragon K552 RGB',
                'unidade' => 'un',
                'peso' => 0.9,
                'dimensoes' => [
                    'altura' => 3,
                    'largura' => 35,
                    'comprimento' => 12
                ]
            ],
            4 => [
                'id' => 4,
                'nome' => 'Mouse Logitech G Pro',
                'sku' => 'LOG-GPRO',
                'preco' => 399.90,
                'estoque' => 0,
                'estoqueMinimo' => 5,
                'categoria' => 'Periféricos',
                'status' => 'ativo',
                'descricao' => 'Mouse gamer Logitech G Pro Wireless',
                'unidade' => 'un',
                'peso' => 0.08,
                'dimensoes' => [
                    'altura' => 4,
                    'largura' => 6,
                    'comprimento' => 12
                ]
            ]
        ];
        
        if (isset($produtos[$id])) {
            return response()->json($produtos[$id]);
        }
        
        return response()->json(['message' => 'Produto não encontrado'], 404);
    });
    
    Route::post('/', function (Request $request) {
        // Simulação de criação
        return response()->json([
            'id' => 5,
            'nome' => $request->nome,
            'sku' => $request->sku,
            'preco' => $request->preco,
            'estoque' => $request->estoque,
            'estoqueMinimo' => $request->estoqueMinimo,
            'categoria' => $request->categoria,
            'status' => $request->status,
            'descricao' => $request->descricao,
            'unidade' => $request->unidade,
            'peso' => $request->peso,
            'dimensoes' => $request->dimensoes
        ], 201);
    });
    
    Route::put('/{id}', function (Request $request, $id) {
        // Simulação de atualização
        return response()->json([
            'id' => $id,
            'nome' => $request->nome,
            'sku' => $request->sku,
            'preco' => $request->preco,
            'estoque' => $request->estoque,
            'estoqueMinimo' => $request->estoqueMinimo,
            'categoria' => $request->categoria,
            'status' => $request->status,
            'descricao' => $request->descricao,
            'unidade' => $request->unidade,
            'peso' => $request->peso,
            'dimensoes' => $request->dimensoes
        ]);
    });
    
    Route::delete('/{id}', function (Request $request, $id) {
        // Simulação de exclusão
        return response()->json(['message' => 'Produto excluído com sucesso']);
    });
}); 