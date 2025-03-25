#!/bin/bash

echo "Iniciando o sistema CRM-ERP SaaS Multitenancy em modo produção..."

# Verificar se o Docker está instalado
if ! command -v docker &> /dev/null; then
    echo "Docker não encontrado. Por favor, instale o Docker primeiro."
    exit 1
fi

# Verificar se o Docker Compose está instalado
if ! docker compose version &> /dev/null; then
    echo "Docker Compose não encontrado. Por favor, instale o Docker Compose primeiro."
    exit 1
fi

# Copiar arquivo de ambiente de produção
if [ ! -f .env ]; then
    cp .env.production .env
    echo "Arquivo .env criado a partir de .env.production"
fi

# Construir as imagens
echo "Construindo as imagens Docker..."
docker compose -f docker-compose.prod.yml build

# Iniciar os serviços
echo "Iniciando os serviços..."
docker compose -f docker-compose.prod.yml up -d

# Executar migrações e otimizações
echo "Executando migrações e otimizações..."
docker compose -f docker-compose.prod.yml exec app php artisan migrate --force
docker compose -f docker-compose.prod.yml exec app php artisan config:cache
docker compose -f docker-compose.prod.yml exec app php artisan route:cache
docker compose -f docker-compose.prod.yml exec app php artisan view:cache

echo ""
echo "Sistema CRM-ERP SaaS Multitenancy iniciado em modo produção!"
echo ""
echo "URLs de acesso:"
echo "- Backend (Admin): http://localhost/"
echo "- Frontend (Tenant): http://localhost:3000"
echo "- Grafana (Monitoramento): http://localhost:3001"
echo "  - Usuário: admin"
echo "  - Senha: ${GRAFANA_ADMIN_PASSWORD:-admin}"
echo "- Prometheus: http://localhost:9090"
echo ""
echo "Para parar o sistema, execute: docker compose -f docker-compose.prod.yml down"
echo "" 