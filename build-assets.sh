#!/bin/bash

# Instalar Node.js e npm
echo "Instalando Node.js e npm..."
apt-get update
apt-get install -y nodejs npm

# Instalar dependências
echo "Instalando dependências do Node..."
npm install

# Compilar assets
echo "Compilando assets..."
npm run build

echo "Assets compilados com sucesso!" 