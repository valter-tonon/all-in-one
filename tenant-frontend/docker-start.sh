#!/bin/bash

# Script para iniciar o frontend do tenant no Docker

echo "Iniciando o frontend do tenant no Docker..."

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
if [ "$1" == "dev" ]; then
    echo "Iniciando em modo de desenvolvimento..."
    docker-compose up -d tenant-frontend-dev
    echo "Frontend do tenant iniciado em modo de desenvolvimento."
    echo "Acesse: http://localhost/tenant-dev/"
elif [ "$1" == "prod" ]; then
    echo "Iniciando em modo de produção..."
    # Construir a aplicação primeiro
    docker-compose run --rm tenant-frontend-dev npm run build
    # Iniciar o contêiner de produção
    docker-compose up -d tenant-frontend
    echo "Frontend do tenant iniciado em modo de produção."
    echo "Acesse: http://localhost/tenant/"
else
    echo "Uso: ./docker-start.sh [dev|prod]"
    echo "  dev  - Inicia em modo de desenvolvimento com hot-reload"
    echo "  prod - Constrói e inicia em modo de produção"
    exit 1
fi

echo "Concluído!" 