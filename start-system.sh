#!/bin/bash

# Script para iniciar todo o sistema CRM-ERP SaaS Multitenancy

echo "Iniciando o sistema CRM-ERP SaaS Multitenancy..."

# Verificar se o Docker está instalado
if ! command -v docker &> /dev/null; then
    echo "Docker não encontrado. Por favor, instale o Docker primeiro."
    exit 1
fi

# Verificar se o Docker Compose está instalado
if ! command -v docker-compose &> /dev/null; then
    echo "Docker Compose não encontrado. Por favor, instale o Docker Compose primeiro."
    exit 1
fi

# Determinar o modo de execução
MODE=${1:-"dev"}

if [ "$MODE" != "dev" ] && [ "$MODE" != "prod" ]; then
    echo "Modo inválido. Use 'dev' ou 'prod'."
    echo "Uso: ./start-system.sh [dev|prod]"
    exit 1
fi

echo "Iniciando o sistema em modo $MODE..."

# Iniciar os serviços principais
echo "Iniciando o backend e banco de dados..."
docker-compose up -d app db nginx

# Aguardar o backend iniciar
echo "Aguardando o backend iniciar..."
sleep 10

# Iniciar o frontend do tenant
echo "Iniciando o frontend do tenant..."
if [ "$MODE" == "dev" ]; then
    # Modo de desenvolvimento
    docker-compose up -d tenant-frontend-dev
    FRONTEND_URL="http://localhost/tenant-dev/"
else
    # Modo de produção
    # Construir a aplicação primeiro
    echo "Construindo o frontend para produção..."
    docker-compose run --rm tenant-frontend-dev npm run build
    # Iniciar o contêiner de produção
    docker-compose up -d tenant-frontend
    FRONTEND_URL="http://localhost/tenant/"
fi

echo ""
echo "Sistema CRM-ERP SaaS Multitenancy iniciado com sucesso!"
echo ""
echo "URLs de acesso:"
echo "- Backend (Admin): http://localhost/"
echo "- Frontend (Tenant): $FRONTEND_URL"
echo ""
echo "Para parar o sistema, execute: docker-compose down"
echo "" 