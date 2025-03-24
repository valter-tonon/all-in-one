# Frontend do Tenant - CRM-ERP SaaS Multitenancy

Este é o frontend para os tenants (clientes) do sistema CRM-ERP SaaS Multitenancy. Desenvolvido com React e TypeScript, oferece uma interface moderna e responsiva para gerenciar clientes, produtos, vendas, finanças e relatórios.

## Tecnologias Utilizadas

- React 18
- TypeScript
- React Router DOM
- Tailwind CSS
- Chart.js / React-Chartjs-2
- React Icons
- Axios

## Requisitos

- Node.js 14+
- npm ou yarn
- Docker e Docker Compose (para execução em contêineres)

## Instalação

### Método 1: Instalação Local

1. Clone o repositório
2. Instale as dependências:

```bash
cd tenant-frontend
npm install
```

### Método 2: Usando Docker

Não é necessário instalar dependências localmente se estiver usando Docker. Veja a seção Docker abaixo.

## Executando o Projeto

### Método 1: Desenvolvimento Local

Para iniciar o servidor de desenvolvimento localmente:

```bash
npm start
```

O aplicativo estará disponível em [http://localhost:3000](http://localhost:3000).

### Método 2: Usando Docker

Veja a seção Docker abaixo para instruções detalhadas.

## Build para Produção

Para criar uma versão otimizada para produção:

```bash
npm run build
```

## Estrutura do Projeto

```
tenant-frontend/
├── public/                # Arquivos públicos
├── src/                   # Código fonte
│   ├── components/        # Componentes reutilizáveis
│   ├── pages/             # Páginas da aplicação
│   ├── services/          # Serviços e APIs
│   ├── types/             # Definições de tipos TypeScript
│   ├── utils/             # Funções utilitárias
│   ├── App.tsx            # Componente principal
│   └── index.tsx          # Ponto de entrada
├── package.json           # Dependências e scripts
└── tsconfig.json          # Configuração do TypeScript
```

## Funcionalidades

- **Dashboard**: Visão geral com gráficos e estatísticas
- **Clientes**: Gerenciamento completo de clientes
- **Produtos**: Controle de estoque e produtos
- **Vendas**: Registro e acompanhamento de vendas
- **Financeiro**: Controle financeiro
- **Relatórios**: Relatórios e análises
- **Configurações**: Configurações do sistema

## Integração com Backend

O frontend se comunica com o backend Laravel através de APIs RESTful, utilizando autenticação via tokens JWT.

## Docker

O projeto está configurado para ser executado em contêineres Docker, tanto em ambiente de desenvolvimento quanto em produção.

### Pré-requisitos

- Docker
- Docker Compose

### Executando com Docker

Temos um script que facilita a execução do frontend no Docker:

```bash
# Para executar em modo de desenvolvimento (com hot-reload)
./docker-start.sh dev

# Para executar em modo de produção
./docker-start.sh prod
```

### Acessando a Aplicação

- **Modo de Desenvolvimento**: Acesse [http://localhost/tenant-dev/](http://localhost/tenant-dev/)
- **Modo de Produção**: Acesse [http://localhost/tenant/](http://localhost/tenant/)

### Configuração Manual com Docker Compose

Se preferir configurar manualmente, você pode usar os seguintes comandos:

```bash
# Modo de desenvolvimento
docker-compose up -d tenant-frontend-dev

# Modo de produção (build + execução)
docker-compose run --rm tenant-frontend-dev npm run build
docker-compose up -d tenant-frontend
```

### Estrutura Docker

- **tenant-frontend**: Contêiner de produção usando Nginx para servir a aplicação compilada
- **tenant-frontend-dev**: Contêiner de desenvolvimento com Node.js e hot-reload

## Licença

Este projeto é parte do sistema CRM-ERP SaaS Multitenancy e está sob a licença MIT.