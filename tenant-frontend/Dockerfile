# Estágio de build
FROM node:16-alpine as build

# Definir diretório de trabalho
WORKDIR /app

# Copiar arquivos de configuração
COPY package.json package-lock.json* ./

# Instalar dependências
RUN npm ci

# Copiar código fonte
COPY . .

# Construir aplicação
RUN npm run build

# Estágio de produção
FROM nginx:alpine

# Copiar configuração do nginx
COPY nginx/nginx.conf /etc/nginx/conf.d/default.conf

# Copiar build da aplicação para o diretório do nginx
COPY --from=build /app/build /usr/share/nginx/html

# Expor porta 80
EXPOSE 80

# Comando para iniciar o nginx
CMD ["nginx", "-g", "daemon off;"] 