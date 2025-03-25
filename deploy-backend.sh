#!/bin/bash

# Script para deploy do backend para a VM Oracle via SSH
# Uso: ./deploy-backend.sh [usuario] [host]

# Verificar se os parâmetros foram passados
if [ $# -lt 2 ]; then
  echo "Uso: $0 [usuario] [host]"
  echo "Exemplo: $0 ubuntu 192.168.1.100"
  exit 1
fi

SSH_USER=$1
VM_HOST=$2

echo "Iniciando deploy para $SSH_USER@$VM_HOST..."

# Adicionar host ao known_hosts se não existir
ssh-keyscan $VM_HOST >> ~/.ssh/known_hosts 2>/dev/null

# Executar comandos de deploy via SSH
ssh $SSH_USER@$VM_HOST << 'ENDSSH'
  echo "Conectado à VM Oracle. Iniciando processo de deploy..."
  
  # Navegar para o diretório da aplicação
  cd /caminho/para/aplicacao
  
  # Atualizar código do repositório
  echo "Atualizando código do repositório..."
  git pull origin main
  
  # Instalar dependências
  echo "Instalando dependências via Composer..."
  composer install --no-interaction --prefer-dist --optimize-autoloader
  
  # Aplicar migrações
  echo "Aplicando migrações..."
  php artisan migrate --force
  
  # Limpar e recriar caches
  echo "Limpando e recriando caches..."
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  
  # Reiniciar serviços
  echo "Reiniciando serviços..."
  sudo systemctl restart nginx
  sudo systemctl restart php8.1-fpm
  
  echo "Deploy concluído com sucesso!"
ENDSSH

echo "Script de deploy finalizado." 