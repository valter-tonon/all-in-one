#!/bin/bash

# Script para parar o ambiente de desenvolvimento combinado

# Cores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${YELLOW}Parando ambiente de desenvolvimento combinado...${NC}"

# Parar os containers
docker-compose -f docker-compose-dev.yml down

# Verificar status
if [ $? -eq 0 ]; then
  echo -e "${GREEN}Ambiente de desenvolvimento parado com sucesso!${NC}"
else
  echo -e "${RED}Erro ao parar o ambiente de desenvolvimento.${NC}"
  exit 1
fi

exit 0 