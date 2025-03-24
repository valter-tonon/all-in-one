import React, { useState } from 'react';
import { Outlet, Link, useLocation } from 'react-router-dom';
import { 
  FiMenu, FiX, FiHome, FiUsers, FiPackage, FiShoppingCart, 
  FiDollarSign, FiBarChart2, FiSettings, FiPhoneCall, 
  FiMessageSquare, FiTarget, FiUserPlus, FiList
} from 'react-icons/fi';
import authService from '../services/authService';

const Layout: React.FC = () => {
  const [sidebarOpen, setSidebarOpen] = useState<boolean>(false);
  const [crmSubmenuOpen, setCrmSubmenuOpen] = useState<boolean>(false);
  const location = useLocation();
  const user = authService.getCurrentUser();

  const isActive = (path: string): string => {
    return location.pathname === path ? 'bg-indigo-700 text-white' : 'text-gray-300 hover:bg-indigo-700 hover:text-white';
  };

  const handleLogout = () => {
    authService.logout();
  };

  return (
    <div className="flex h-screen bg-gray-100">
      {/* Sidebar para dispositivos móveis */}
      <div className={`fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden ${sidebarOpen ? 'block' : 'hidden'}`} 
           onClick={() => setSidebarOpen(false)}></div>

      {/* Sidebar */}
      <div className={`fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-indigo-800 lg:translate-x-0 lg:static lg:inset-0 ${sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'}`}>
        <div className="flex items-center justify-between px-6 py-4">
          <div className="text-xl font-semibold text-white">CRM-ERP SaaS</div>
          <button onClick={() => setSidebarOpen(false)} className="text-white lg:hidden">
            <FiX className="w-6 h-6" />
          </button>
        </div>
        <nav className="mt-10">
          <Link to="/" className={`flex items-center px-6 py-2 mt-1 ${isActive('/')}`}>
            <FiHome className="w-5 h-5" />
            <span className="mx-3">Dashboard</span>
          </Link>
          
          {/* Módulo CRM com submenu */}
          <div className="mt-1">
            <button 
              onClick={() => setCrmSubmenuOpen(!crmSubmenuOpen)}
              className="flex items-center w-full px-6 py-2 text-gray-300 hover:bg-indigo-700 hover:text-white"
            >
              <FiUsers className="w-5 h-5" />
              <span className="mx-3">CRM</span>
              <svg 
                className={`w-4 h-4 ml-auto transition-transform duration-200 ${crmSubmenuOpen ? 'transform rotate-180' : ''}`} 
                fill="none" 
                viewBox="0 0 24 24" 
                stroke="currentColor"
              >
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            
            {/* Submenu do CRM */}
            <div className={`pl-4 mt-1 ${crmSubmenuOpen ? 'block' : 'hidden'}`}>
              <Link to="/crm/clientes" className={`flex items-center px-6 py-2 ${isActive('/crm/clientes')}`}>
                <FiUserPlus className="w-4 h-4" />
                <span className="mx-3 text-sm">Clientes</span>
              </Link>
              <Link to="/crm/contatos" className={`flex items-center px-6 py-2 ${isActive('/crm/contatos')}`}>
                <FiPhoneCall className="w-4 h-4" />
                <span className="mx-3 text-sm">Contatos</span>
              </Link>
              <Link to="/crm/oportunidades" className={`flex items-center px-6 py-2 ${isActive('/crm/oportunidades')}`}>
                <FiTarget className="w-4 h-4" />
                <span className="mx-3 text-sm">Oportunidades</span>
              </Link>
              <Link to="/crm/atividades" className={`flex items-center px-6 py-2 ${isActive('/crm/atividades')}`}>
                <FiList className="w-4 h-4" />
                <span className="mx-3 text-sm">Atividades</span>
              </Link>
            </div>
          </div>
          
          <Link to="/produtos" className={`flex items-center px-6 py-2 mt-1 ${isActive('/produtos')}`}>
            <FiPackage className="w-5 h-5" />
            <span className="mx-3">Produtos</span>
          </Link>
          <Link to="/vendas" className={`flex items-center px-6 py-2 mt-1 ${isActive('/vendas')}`}>
            <FiShoppingCart className="w-5 h-5" />
            <span className="mx-3">Vendas</span>
          </Link>
          <Link to="/financeiro" className={`flex items-center px-6 py-2 mt-1 ${isActive('/financeiro')}`}>
            <FiDollarSign className="w-5 h-5" />
            <span className="mx-3">Financeiro</span>
          </Link>
          <Link to="/relatorios" className={`flex items-center px-6 py-2 mt-1 ${isActive('/relatorios')}`}>
            <FiBarChart2 className="w-5 h-5" />
            <span className="mx-3">Relatórios</span>
          </Link>
          <Link to="/configuracoes" className={`flex items-center px-6 py-2 mt-1 ${isActive('/configuracoes')}`}>
            <FiSettings className="w-5 h-5" />
            <span className="mx-3">Configurações</span>
          </Link>
        </nav>
      </div>

      <div className="flex flex-col flex-1 overflow-hidden">
        {/* Header */}
        <header className="flex items-center justify-between px-6 py-4 bg-white border-b-2 border-gray-200">
          <div className="flex items-center">
            <button onClick={() => setSidebarOpen(true)} className="text-gray-500 focus:outline-none lg:hidden">
              <FiMenu className="w-6 h-6" />
            </button>
          </div>
          <div className="flex items-center">
            <div className="relative">
              <div className="flex items-center text-gray-500">
                <div className="w-8 h-8 overflow-hidden rounded-full">
                  <img src={`https://ui-avatars.com/api/?name=${user?.name || 'Usuário'}&background=6366F1&color=fff`} alt="Avatar" className="object-cover w-full h-full" />
                </div>
                <span className="mx-2 font-medium">{user?.name || 'Usuário'}</span>
                <button 
                  onClick={handleLogout}
                  className="ml-2 text-sm text-gray-500 hover:text-indigo-600"
                >
                  Sair
                </button>
              </div>
            </div>
          </div>
        </header>

        {/* Conteúdo principal */}
        <main className="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
          <div className="container px-6 py-8 mx-auto">
            <Outlet />
          </div>
        </main>
      </div>
    </div>
  );
};

export default Layout; 