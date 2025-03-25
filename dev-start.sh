#!/bin/bash

# Script para iniciar o ambiente de desenvolvimento combinado (backend + frontend)

# Cores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${GREEN}Iniciando ambiente de desenvolvimento combinado...${NC}"

# Verificar se o frontend existe
if [ ! -d "../tenant-frontend-repo" ]; then
  echo -e "${RED}Erro: Diretório do frontend não encontrado em ../tenant-frontend-repo${NC}"
  echo -e "${YELLOW}Certifique-se de que o repositório frontend está clonado no diretório pai com o nome 'tenant-frontend-repo'${NC}"
  exit 1
fi

# Verificar se o docker está instalado
if ! command -v docker &> /dev/null; then
  echo -e "${RED}Erro: Docker não está instalado ou não está no PATH${NC}"
  exit 1
fi

# Verificar se o docker-compose está instalado
if ! command -v docker-compose &> /dev/null; then
  echo -e "${RED}Erro: Docker Compose não está instalado ou não está no PATH${NC}"
  exit 1
fi

# Iniciar os containers
echo -e "${GREEN}Iniciando containers com docker-compose...${NC}"
docker-compose -f docker-compose-dev.yml up -d

# Verificar status
if [ $? -eq 0 ]; then
  echo -e "${GREEN}Ambiente de desenvolvimento iniciado com sucesso!${NC}"
  echo -e "${GREEN}Backend: http://localhost${NC}"
  echo -e "${GREEN}Frontend: http://localhost:3000${NC}"
else
  echo -e "${RED}Erro ao iniciar o ambiente de desenvolvimento.${NC}"
  exit 1
fi

# Mostrar logs em tempo real (opcional)
read -p "Deseja ver os logs em tempo real? (s/n): " ver_logs
if [[ $ver_logs == "s" || $ver_logs == "S" ]]; then
  docker-compose -f docker-compose-dev.yml logs -f
fi

exit 0 