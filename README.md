# CRM-ERP SaaS Multitenancy

Sistema SaaS "all-in-one" CRM e ERP baseado em Laravel com multitenancy, seguindo as melhores práticas de TDD (Test-Driven Development), Clean Architecture e princípios SOLID.

## Características

- **Multitenancy**: Cada tenant (empresa/cliente) tem dados isolados em bancos de dados separados.
- **Dashboards**:
  1. **Dashboard Admin**: Gerencia todos os tenants (usando Laravel Blade + Livewire).
  2. **Dashboard Cliente**: Interface por tenant (frontend React com Tailwind CSS).
- **Modularidade**: Módulos CRM (gestão de clientes) e ERP (estoque, vendas) separados.
- **Arquitetura Limpa**: Separação em camadas (Domain, Application, Infrastructure, Interfaces).
- **Princípios SOLID**: Código organizado seguindo os princípios de design SOLID.
- **TDD**: Desenvolvimento orientado por testes com PHPUnit.
- **Frontend Moderno**: Interface do tenant desenvolvida com React, TypeScript e Tailwind CSS.
- **Docker**: Ambiente completo configurado com Docker para fácil implantação.

## Requisitos

- PHP 8.2+
- MySQL 8.0+
- Composer
- Node.js 16+ (para desenvolvimento do frontend)
- Docker e Docker Compose

## Instalação e Execução Rápida

O projeto inclui um script para iniciar todo o sistema (backend e frontend) com Docker:

```bash
# Clone o repositório
git clone https://github.com/seu-usuario/crm-erp.git
cd crm-erp

# Inicie o sistema em modo de desenvolvimento
./start-system.sh dev

# Ou em modo de produção
./start-system.sh prod
```

Após a inicialização, acesse:
- **Dashboard Admin**: http://localhost/
- **Dashboard Tenant (Dev)**: http://localhost/tenant-dev/
- **Dashboard Tenant (Prod)**: http://localhost/tenant/

## Instalação Manual

1. Clone o repositório:
   ```bash
   git clone https://github.com/seu-usuario/crm-erp.git
   cd crm-erp
   ```

2. Execute o script de configuração:
   ```bash
   ./setup.sh
   ```
   
   Ou configure manualmente:
   ```bash
   cp .env.example .env
   docker compose up -d
   ```

3. Acesse a aplicação:
   - Admin: http://localhost
   - API: http://localhost/api

## Configuração do Ambiente Passo a Passo

### 1. Verificação dos Containers Docker

Após executar `docker compose up -d`, verifique se todos os containers estão rodando corretamente:

```bash
docker compose ps
```

Você deve ver os seguintes containers em execução:
- `app` - Backend Laravel
- `db` - Banco de dados MySQL
- `nginx` - Servidor web
- `tenant-frontend` ou `tenant-frontend-dev` - Frontend React

### 2. Configuração do Arquivo .env

Copie o arquivo de exemplo e edite conforme necessário:

```bash
cp .env.example .env
```

As configurações padrão já estão preparadas para o ambiente Docker, com:
- `DB_HOST=db` (nome do serviço MySQL no docker-compose)
- `DB_DATABASE=landlord` (banco de dados principal)
- `DB_USERNAME=root` e `DB_PASSWORD=root` (credenciais padrão)

### 3. Verificação da Aplicação

Acesse a aplicação nos seguintes endereços:
- Dashboard Admin: http://localhost
- API: http://localhost/api
- Frontend Tenant (Dev): http://localhost/tenant-dev/
- Frontend Tenant (Prod): http://localhost/tenant/

### 4. Comandos Personalizados

O sistema inclui comandos personalizados para facilitar o desenvolvimento:

#### Gerenciamento de Tenants

```bash
# Criar um novo tenant
docker compose exec app php artisan tenant:create [nome] [domínio] --plan=[plano]

# Listar todos os tenants
docker compose exec app php artisan tenant:list

# Listar apenas tenants ativos
docker compose exec app php artisan tenant:list --active

# Listar apenas tenants inativos
docker compose exec app php artisan tenant:list --inactive
```

#### Gerenciamento de Estoque

```bash
# Listar todos os produtos
docker compose exec app php artisan stock:manage list

# Adicionar um novo produto
docker compose exec app php artisan stock:manage add --name="Produto" --quantity=10 --price=99.90 --category="Categoria"

# Atualizar um produto existente
docker compose exec app php artisan stock:manage update --id=1 --quantity=20

# Remover um produto
docker compose exec app php artisan stock:manage remove --id=1

# Listar produtos com estoque baixo
docker compose exec app php artisan stock:manage low-stock

# Listar produtos sem estoque
docker compose exec app php artisan stock:manage out-of-stock
```

### 5. Frontend do Tenant

O frontend do tenant é uma aplicação React separada localizada no diretório `tenant-frontend/`. Ele oferece uma interface moderna e responsiva para os tenants gerenciarem seus negócios.

#### Funcionalidades do Frontend

- **Dashboard**: Visão geral com gráficos e estatísticas
- **Clientes**: Gerenciamento completo de clientes
- **Produtos**: Controle de estoque e produtos
- **Vendas**: Registro e acompanhamento de vendas
- **Financeiro**: Controle financeiro com receitas e despesas
- **Relatórios**: Relatórios e análises detalhadas
- **Configurações**: Configurações do sistema

#### Executando o Frontend Separadamente

Se desejar executar apenas o frontend do tenant:

```bash
# Modo de desenvolvimento
cd tenant-frontend
npm install
npm start

# Ou usando Docker
cd tenant-frontend
./docker-start.sh dev  # Desenvolvimento
./docker-start.sh prod # Produção
```

### 6. Estado Atual do Projeto

O projeto está atualmente em fase de desenvolvimento inicial. A estrutura básica foi criada seguindo os princípios de Clean Architecture, com as seguintes camadas:

- **Domain**: Entidades e regras de negócio
  - Entities: `Tenant`, `Stock`
  - Exceptions: `TenantNotFoundException`, `StockNotFoundException`
  - Repositories (interfaces): `TenantRepositoryInterface`, `StockRepositoryInterface`

- **Application**: Casos de uso e lógica de aplicação
  - Services: `TenantService`, `StockService`
  - DTOs: `TenantDTO`, `StockDTO`

- **Infrastructure**: Implementações concretas
  - Repositories: `EloquentTenantRepository`, `EloquentStockRepository`

- **Interfaces**: Controladores e recursos
  - Controllers: `TenantController`, `StockController`
  - Resources: `TenantResource`, `StockResource`
  - Views: Dashboard do admin com Livewire

O ambiente Docker está configurado e pronto para desenvolvimento, com:
- Container PHP (app)
- Container MySQL (db)
- Container Nginx (nginx)
- Container Frontend (tenant-frontend ou tenant-frontend-dev)

### 7. Comandos Úteis para Desenvolvimento

```bash
# Acessar o shell do container backend
docker compose exec app bash

# Acessar o shell do container frontend
docker compose exec tenant-frontend-dev sh

# Acessar o MySQL
docker compose exec db mysql -uroot -proot

# Ver logs da aplicação
docker compose logs -f app

# Ver logs do frontend
docker compose logs -f tenant-frontend-dev
```

### 8. Solução de Problemas

Se encontrar problemas durante a configuração:

1. **Permissões de Arquivos**: Ajuste as permissões se necessário:
   ```bash
   docker compose exec app chmod -R 777 storage bootstrap/cache
   ```

2. **Problemas de Conexão com o Banco de Dados**: Verifique se o container do MySQL está rodando:
   ```bash
   docker compose logs db
   ```

3. **Erros de Migração**: Redefina o banco de dados se necessário:
   ```bash
   docker compose exec app php artisan migrate:fresh
   ```

4. **Problemas com o Frontend**: Verifique os logs do frontend:
   ```bash
   docker compose logs tenant-frontend-dev
   ```

## Estrutura do Projeto

```
crm-erp/
├── app/
│   ├── Domain/
│   │   ├── Entities/ (Tenant.php, Stock.php)
│   │   └── Exceptions/ (TenantNotFoundException.php)
│   ├── Application/
│   │   ├── Services/ (TenantService.php, StockService.php)
│   │   └── DTOs/ (TenantDTO.php, StockDTO.php)
│   ├── Infrastructure/
│   │   ├── Repositories/ (TenantRepository.php, StockRepository.php)
│   │   └── Persistence/ (EloquentTenantRepository.php)
│   ├── Interfaces/
│   │   ├── Http/
│   │   │   ├── Controllers/ (TenantController.php, StockController.php)
│   │   │   └── Resources/ (StockResource.php)
│   │   └── Web/ (views/admin/dashboard.blade.php)
│   ├── Console/
│   │   └── Commands/ (TenantCreate.php, TenantList.php, StockManage.php)
├── tenant-frontend/
│   ├── src/
│   │   ├── components/ (Layout.tsx, etc.)
│   │   ├── pages/ (Dashboard.tsx, Clientes.tsx, etc.)
│   │   └── App.tsx
│   ├── public/
│   ├── Dockerfile
│   └── docker-compose.yml
├── tests/
│   ├── Unit/ (TenantServiceTest.php)
│   ├── Feature/ (TenantControllerTest.php)
├── docker/
│   ├── app/ (Dockerfile for PHP)
│   ├── nginx/ (nginx.conf)
├── docker-compose.yml
├── start-system.sh
```

## API Endpoints

### Tenants (Admin)
- `GET /api/tenants` - Listar todos os tenants
- `GET /api/tenants/{id}` - Obter um tenant específico
- `POST /api/tenants` - Criar um novo tenant
- `PUT /api/tenants/{id}` - Atualizar um tenant
- `DELETE /api/tenants/{id}` - Excluir um tenant

### Estoque (Tenant)
- `GET /api/stocks` - Listar todos os itens de estoque
- `GET /api/stocks/{id}` - Obter um item específico
- `POST /api/stocks` - Criar um novo item
- `PUT /api/stocks/{id}` - Atualizar um item
- `DELETE /api/stocks/{id}` - Excluir um item
- `GET /api/stocks/low-stock` - Listar itens com estoque baixo
- `GET /api/stocks/out-of-stock` - Listar itens sem estoque

## Licença

Este projeto está licenciado sob a licença MIT. 