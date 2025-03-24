import React, { useState, useEffect } from 'react';
import { FiPlus, FiEdit2, FiTrash2, FiSearch } from 'react-icons/fi';

interface Cliente {
  id: number;
  nome: string;
  email: string;
  telefone: string;
  empresa: string;
  status: 'ativo' | 'inativo';
  ultimaCompra: string;
}

const Clientes: React.FC = () => {
  const [clientes, setClientes] = useState<Cliente[]>([]);
  const [loading, setLoading] = useState<boolean>(true);
  const [searchTerm, setSearchTerm] = useState<string>('');

  useEffect(() => {
    // Simulando carregamento de dados
    const fetchClientes = async () => {
      try {
        // Simulando uma chamada de API
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        // Dados de exemplo
        const clientesData: Cliente[] = [
          { id: 1, nome: 'João Silva', email: 'joao@empresa.com', telefone: '(11) 98765-4321', empresa: 'Empresa A', status: 'ativo', ultimaCompra: '2023-11-15' },
          { id: 2, nome: 'Maria Santos', email: 'maria@empresa.com', telefone: '(11) 91234-5678', empresa: 'Empresa B', status: 'ativo', ultimaCompra: '2023-11-10' },
          { id: 3, nome: 'Pedro Oliveira', email: 'pedro@empresa.com', telefone: '(11) 99876-5432', empresa: 'Empresa C', status: 'inativo', ultimaCompra: '2023-10-25' },
          { id: 4, nome: 'Ana Costa', email: 'ana@empresa.com', telefone: '(11) 95678-1234', empresa: 'Empresa D', status: 'ativo', ultimaCompra: '2023-11-05' },
          { id: 5, nome: 'Carlos Souza', email: 'carlos@empresa.com', telefone: '(11) 92345-6789', empresa: 'Empresa E', status: 'inativo', ultimaCompra: '2023-09-30' },
        ];
        
        setClientes(clientesData);
      } catch (error) {
        console.error('Erro ao carregar clientes:', error);
      } finally {
        setLoading(false);
      }
    };
    
    fetchClientes();
  }, []);

  const handleSearch = (e: React.ChangeEvent<HTMLInputElement>) => {
    setSearchTerm(e.target.value);
  };

  const filteredClientes = clientes.filter(cliente => 
    cliente.nome.toLowerCase().includes(searchTerm.toLowerCase()) ||
    cliente.email.toLowerCase().includes(searchTerm.toLowerCase()) ||
    cliente.empresa.toLowerCase().includes(searchTerm.toLowerCase())
  );

  const handleDelete = (id: number) => {
    if (window.confirm('Tem certeza que deseja excluir este cliente?')) {
      setClientes(clientes.filter(cliente => cliente.id !== id));
    }
  };

  if (loading) {
    return (
      <div className="flex items-center justify-center h-full">
        <div className="w-16 h-16 border-t-4 border-b-4 border-blue-500 rounded-full animate-spin"></div>
      </div>
    );
  }

  return (
    <div>
      <div className="flex items-center justify-between mb-6">
        <h2 className="text-2xl font-semibold text-gray-800">Clientes</h2>
        <button className="flex items-center px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
          <FiPlus className="w-5 h-5 mr-2" />
          Novo Cliente
        </button>
      </div>
      
      <div className="p-6 bg-white rounded-lg shadow-md">
        <div className="flex items-center mb-4">
          <div className="relative flex-1">
            <div className="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
              <FiSearch className="w-5 h-5 text-gray-400" />
            </div>
            <input
              type="text"
              className="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
              placeholder="Buscar clientes..."
              value={searchTerm}
              onChange={handleSearch}
            />
          </div>
        </div>
        
        <div className="overflow-x-auto">
          <table className="min-w-full divide-y divide-gray-200">
            <thead className="bg-gray-50">
              <tr>
                <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Nome
                </th>
                <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Email
                </th>
                <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Telefone
                </th>
                <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Empresa
                </th>
                <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Status
                </th>
                <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Última Compra
                </th>
                <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Ações
                </th>
              </tr>
            </thead>
            <tbody className="bg-white divide-y divide-gray-200">
              {filteredClientes.length > 0 ? (
                filteredClientes.map(cliente => (
                  <tr key={cliente.id}>
                    <td className="px-6 py-4 whitespace-nowrap">
                      <div className="text-sm font-medium text-gray-900">{cliente.nome}</div>
                    </td>
                    <td className="px-6 py-4 whitespace-nowrap">
                      <div className="text-sm text-gray-500">{cliente.email}</div>
                    </td>
                    <td className="px-6 py-4 whitespace-nowrap">
                      <div className="text-sm text-gray-500">{cliente.telefone}</div>
                    </td>
                    <td className="px-6 py-4 whitespace-nowrap">
                      <div className="text-sm text-gray-500">{cliente.empresa}</div>
                    </td>
                    <td className="px-6 py-4 whitespace-nowrap">
                      <span className={`px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${
                        cliente.status === 'ativo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                      }`}>
                        {cliente.status === 'ativo' ? 'Ativo' : 'Inativo'}
                      </span>
                    </td>
                    <td className="px-6 py-4 whitespace-nowrap">
                      <div className="text-sm text-gray-500">
                        {new Date(cliente.ultimaCompra).toLocaleDateString('pt-BR')}
                      </div>
                    </td>
                    <td className="px-6 py-4 whitespace-nowrap text-sm font-medium">
                      <button className="text-blue-600 hover:text-blue-900 mr-3">
                        <FiEdit2 className="w-5 h-5" />
                      </button>
                      <button 
                        className="text-red-600 hover:text-red-900"
                        onClick={() => handleDelete(cliente.id)}
                      >
                        <FiTrash2 className="w-5 h-5" />
                      </button>
                    </td>
                  </tr>
                ))
              ) : (
                <tr>
                  <td colSpan={7} className="px-6 py-4 text-center text-sm text-gray-500">
                    Nenhum cliente encontrado
                  </td>
                </tr>
              )}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );
};

export default Clientes;