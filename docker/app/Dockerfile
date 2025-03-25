FROM php:8.2-fpm

# Argumentos definidos em docker-compose.yml
ARG user=www-data
ARG uid=1000

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    gnupg

# Instalar Node.js e npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest

# Limpar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensões PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Obter Composer mais recente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Criar usuário e definir permissões
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Criar diretório do sistema
RUN mkdir -p /var/www
WORKDIR /var/www

# Criar script de entrada
RUN echo "#!/bin/bash\n\
# Garantir que o arquivo hot exista e tenha permissões\n\
rm -rf /var/www/public/hot\n\
touch /var/www/public/hot\n\
chmod 777 /var/www/public/hot\n\
\n\
# Instalar dependências do npm se ainda não existirem\n\
if [ ! -d \"/var/www/node_modules\" ]; then\n\
    cd /var/www && npm install\n\
fi\n\
\n\
# Iniciar o servidor Vite em segundo plano\n\
cd /var/www && npm run dev &\n\
\n\
# Iniciar o PHP-FPM em primeiro plano\n\
php-fpm" > /usr/local/bin/entrypoint.sh && \
    chmod +x /usr/local/bin/entrypoint.sh

# Definir usuário padrão
USER $user

# Expor porta 9000 e 5173 (Vite)
EXPOSE 9000 5173

# Executar script de entrada
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"] 