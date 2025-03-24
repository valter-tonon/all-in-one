import React, { useState, useEffect } from 'react';
import { Routes, Route } from 'react-router-dom';
import Dashboard from './pages/Dashboard';
import Produtos from './pages/Produtos';
import ProdutoForm from './pages/ProdutoForm';
import Vendas from './pages/Vendas';
import Financeiro from './pages/Financeiro';
import Relatorios from './pages/Relatorios';
import Configuracoes from './pages/Configuracoes';
import Layout from './components/Layout';
import Login from './pages/Login';
import NotFound from './pages/NotFound';
import authService from './services/authService';

// Importações do módulo CRM
import ClientesList from './pages/crm/ClientesList';
import ClientesForm from './pages/crm/ClientesForm';
import ContatosList from './pages/crm/ContatosList';
import ContatosForm from './pages/crm/ContatosForm';
import OportunidadesList from './pages/crm/OportunidadesList';
import OportunidadesForm from './pages/crm/OportunidadesForm';
import AtividadesList from './pages/crm/AtividadesList';
import AtividadesForm from './pages/crm/AtividadesForm';

const App: React.FC = () => {
  // Estado para autenticação
  const [isAuthenticated, setIsAuthenticated] = useState<boolean>(false);
  const [isLoading, setIsLoading] = useState<boolean>(true);

  useEffect(() => {
    // Verificar se o usuário está autenticado ao carregar a aplicação
    const checkAuth = async () => {
      const isAuth = authService.isAuthenticated();
      setIsAuthenticated(isAuth);
      
      if (isAuth) {
        try {
          // Verificar se o token ainda é válido
          await authService.checkTokenValidity();
        } catch (error) {
          setIsAuthenticated(false);
        }
      }
      
      setIsLoading(false);
    };
    
    checkAuth();
  }, []);

  const handleLogin = () => {
    setIsAuthenticated(true);
  };

  if (isLoading) {
    return <div className="flex items-center justify-center h-screen">Carregando...</div>;
  }

  if (!isAuthenticated) {
    return <Login onLogin={handleLogin} />;
  }

  return (
    <Routes>
      <Route path="/" element={<Layout />}>
        <Route index element={<Dashboard />} />
        
        {/* Rotas do módulo CRM */}
        <Route path="crm">
          <Route path="clientes" element={<ClientesList />} />
          <Route path="clientes/novo" element={<ClientesForm />} />
          <Route path="clientes/:id" element={<ClientesForm />} />
          
          <Route path="contatos" element={<ContatosList />} />
          <Route path="contatos/novo" element={<ContatosForm />} />
          <Route path="contatos/:id" element={<ContatosForm />} />
          
          <Route path="oportunidades" element={<OportunidadesList />} />
          <Route path="oportunidades/novo" element={<OportunidadesForm />} />
          <Route path="oportunidades/:id" element={<OportunidadesForm />} />
          
          <Route path="atividades" element={<AtividadesList />} />
          <Route path="atividades/novo" element={<AtividadesForm />} />
          <Route path="atividades/:id" element={<AtividadesForm />} />
        </Route>
        
        {/* Rotas do módulo de Produtos */}
        <Route path="produtos" element={<Produtos />} />
        <Route path="produtos/novo" element={<ProdutoForm />} />
        <Route path="produtos/editar/:id" element={<ProdutoForm />} />
        
        <Route path="vendas" element={<Vendas />} />
        <Route path="financeiro" element={<Financeiro />} />
        <Route path="relatorios" element={<Relatorios />} />
        <Route path="configuracoes" element={<Configuracoes />} />
        <Route path="*" element={<NotFound />} />
      </Route>
    </Routes>
  );
}

export default App; 