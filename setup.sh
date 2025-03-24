#!/bin/bash

# Cores para saída
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${YELLOW}Iniciando configuração do CRM-ERP SaaS Multitenancy...${NC}"

# Verificar se o Docker está instalado
if ! command -v docker &> /dev/null; then
    echo -e "${RED}Docker não encontrado. Por favor, instale o Docker antes de continuar.${NC}"
    exit 1
fi

# Verificar se o Docker Compose está instalado
if ! command -v docker compose &> /dev/null; then
    echo -e "${RED}Docker Compose não encontrado. Por favor, instale o Docker Compose antes de continuar.${NC}"
    exit 1
fi

# Criar arquivo .env se não existir
if [ ! -f .env ]; then
    echo -e "${YELLOW}Criando arquivo .env a partir do .env.example...${NC}"
    cp .env.example .env
    echo -e "${GREEN}Arquivo .env criado com sucesso!${NC}"
else
    echo -e "${YELLOW}Arquivo .env já existe. Pulando...${NC}"
fi

# Iniciar containers Docker
echo -e "${YELLOW}Iniciando containers Docker...${NC}"
docker compose up -d
echo -e "${GREEN}Containers iniciados com sucesso!${NC}"

# Verificar status dos containers
echo -e "${YELLOW}Verificando status dos containers...${NC}"
docker compose ps

# Instalar dependências do Composer
echo -e "${YELLOW}Instalando dependências do Composer...${NC}"
docker compose exec app composer install
echo -e "${GREEN}Dependências instaladas com sucesso!${NC}"

# Gerar chave da aplicação
echo -e "${YELLOW}Gerando chave da aplicação...${NC}"
docker compose exec app php artisan key:generate
echo -e "${GREEN}Chave gerada com sucesso!${NC}"

# Executar migrações
echo -e "${YELLOW}Executando migrações do banco de dados...${NC}"
docker compose exec app php artisan migrate --seed
echo -e "${GREEN}Migrações executadas com sucesso!${NC}"

# Configurar permissões
echo -e "${YELLOW}Configurando permissões...${NC}"
docker compose exec app chmod -R 777 storage bootstrap/cache
echo -e "${GREEN}Permissões configuradas com sucesso!${NC}"

# Criar link simbólico para storage
echo -e "${YELLOW}Criando link simbólico para storage...${NC}"
docker compose exec app php artisan storage:link
echo -e "${GREEN}Link simbólico criado com sucesso!${NC}"

echo -e "${GREEN}Configuração concluída com sucesso!${NC}"
echo -e "${YELLOW}Acesse a aplicação em:${NC}"
echo -e "${GREEN}Admin: http://localhost${NC}"
echo -e "${GREEN}API: http://localhost/api${NC}" 