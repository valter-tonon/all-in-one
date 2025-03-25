#!/bin/bash

# Garantir que o diretório hot exista e tenha permissões
mkdir -p /var/www/public/hot
chmod 777 /var/www/public/hot

# Instalar dependências do npm se ainda não existirem
if [ ! -d "/var/www/node_modules" ]; then
    cd /var/www && npm install
fi

# Iniciar o servidor Vite em segundo plano
cd /var/www && npm run dev &

# Iniciar o PHP-FPM em primeiro plano
php-fpm 