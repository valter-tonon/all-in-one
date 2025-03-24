import React, { useState, useEffect } from 'react';
import { FiPlus, FiSearch, FiFileText, FiDollarSign } from 'react-icons/fi';

interface Venda {
  id: number;
  codigo: string;
  cliente: string;
  data: string;
  status: 'pendente' | 'pago' | 'cancelado';
  total: number;
  itens: number;
}

const Vendas: React.FC = () => {
  const [vendas, setVendas] = useState<Venda[]>([]);
  const [loading, setLoading] = useState<boolean>(true);
  const [searchTerm, setSearchTerm] = useState<string>('');

  useEffect(() => {
    // Simulando carregamento de dados
    const fetchVendas = async () => {
      try {
        // Simulando uma chamada de API
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        // Dados de exemplo
        const vendasData: Venda[] = [
          { id: 1, codigo: 'PED-001', cliente: 'João Silva', data: '2023-11-15', status: 'pago', total: 1299.90, itens: 3 },
          { id: 2, codigo: 'PED-002', cliente: 'Maria Santos', data: '2023-11-14', status: 'pendente', total: 499.90, itens: 1 },
          { id: 3, codigo: 'PED-003', cliente: 'Pedro Oliveira', data: '2023-11-10', status: 'pago', total: 2899.80, itens: 2 },
          { id: 4, codigo: 'PED-004', cliente: 'Ana Costa', data: '2023-11-05', status: 'cancelado', total: 129.90, itens: 1 },
          { id: 5, codigo: 'PED-005', cliente: 'Carlos Souza', data: '2023-11-01', status: 'pago', total: 3499.70, itens: 4 },
        ];
        
        setVendas(vendasData);
      } catch (error) {
        console.error('Erro ao carregar vendas:', error);
      } finally {
        setLoading(false);
      }
    };
    
    fetchVendas();
  }, []);

  const handleSearch = (e: React.ChangeEvent<HTMLInputElement>) => {
    setSearchTerm(e.target.value);
  };

  const filteredVendas = vendas.filter(venda => 
    venda.codigo.toLowerCase().includes(searchTerm.toLowerCase()) ||
    venda.cliente.toLowerCase().includes(searchTerm.toLowerCase())
  );

  const getStatusClass = (status: string): string => {
    switch (status) {
      case 'pago':
        return 'bg-green-100 text-green-800';
      case 'pendente':
        return 'bg-yellow-100 text-yellow-800';
      case 'cancelado':
        return 'bg-red-100 text-red-800';
      default:
        return 'bg-gray-100 text-gray-800';
    }
  };

  const getStatusText = (status: string): string => {
    switch (status) {
      case 'pago':
        return 'Pago';
      case 'pendente':
        return 'Pendente';
      case 'cancelado':
        return 'Cancelado';
      default:
        return status;
    }
  };

  if (loading) {
    return (
      <div className="flex items-center justify-center h-full">
        <div className="w-16 h-16 border-t-4 border-b-4 border-blue-500 rounded-full animate-spin"></div>
      </div>
    );
  }

  // Calcular estatísticas
  const totalVendas = vendas.length;
  const totalPagas = vendas.filter(v => v.status === 'pago').length;
  const totalPendentes = vendas.filter(v => v.status === 'pendente').length;
  const valorTotal = vendas.reduce((acc, venda) => acc + (venda.status !== 'cancelado' ? venda.total : 0), 0);

  return (
    <div>
      <div className="flex items-center justify-between mb-6">
        <h2 className="text-2xl font-semibold text-gray-800">Vendas</h2>
        <button className="flex items-center px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
          <FiPlus className="w-5 h-5 mr-2" />
          Nova Venda
        </button>
      </div>

      {/* Cards de estatísticas */}
      <div className="grid grid-cols-1 gap-6 mb-6 sm:grid-cols-2 lg:grid-cols-4">
        <div className="p-4 bg-white rounded-lg shadow-md">
          <div className="flex items-center">
            <div className="p-3 rounded-full bg-blue-500 text-white">
              <FiFileText className="w-6 h-6" />
            </div>
            <div className="mx-4">
              <h4 className="text-2xl font-semibold text-gray-700">{totalVendas}</h4>
              <div className="text-gray-500">Total de Vendas</div>
            </div>
          </div>
        </div>
        
        <div className="p-4 bg-white rounded-lg shadow-md">
          <div className="flex items-center">
            <div className="p-3 rounded-full bg-green-500 text-white">
              <FiDollarSign className="w-6 h-6" />
            </div>
            <div className="mx-4">
              <h4 className="text-2xl font-semibold text-gray-700">{totalPagas}</h4>
              <div className="text-gray-500">Vendas Pagas</div>
            </div>
          </div>
        </div>
        
        <div className="p-4 bg-white rounded-lg shadow-md">
          <div className="flex items-center">
            <div className="p-3 rounded-full bg-yellow-500 text-white">
              <FiFileText className="w-6 h-6" />
            </div>
            <div className="mx-4">
              <h4 className="text-2xl font-semibold text-gray-700">{totalPendentes}</h4>
              <div className="text-gray-500">Vendas Pendentes</div>
            </div>
          </div>
        </div>
        
        <div className="p-4 bg-white rounded-lg shadow-md">
          <div className="flex items-center">
            <div className="p-3 rounded-full bg-purple-500 text-white">
              <FiDollarSign className="w-6 h-6" />
            </div>
            <div className="mx-4">
              <h4 className="text-2xl font-semibold text-gray-700">
                {valorTotal.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}
              </h4>
              <div className="text-gray-500">Valor Total</div>
            </div>
          </div>
        </div>
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
              placeholder="Buscar vendas..."
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
                  Código
                </th>
                <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Cliente
                </th>
                <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Data
                </th>
                <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Status
                </th>
                <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Itens
                </th>
                <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Total
                </th>
                <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Ações
                </th>
              </tr>
            </thead>
            <tbody className="bg-white divide-y divide-gray-200">
              {filteredVendas.length > 0 ? (
                filteredVendas.map(venda => (
                  <tr key={venda.id}>
                    <td className="px-6 py-4 whitespace-nowrap">
                      <div className="text-sm font-medium text-gray-900">{venda.codigo}</div>
                    </td>
                    <td className="px-6 py-4 whitespace-nowrap">
                      <div className="text-sm text-gray-500">{venda.cliente}</div>
                    </td>
                    <td className="px-6 py-4 whitespace-nowrap">
                      <div className="text-sm text-gray-500">
                        {new Date(venda.data).toLocaleDateString('pt-BR')}
                      </div>
                    </td>
                    <td className="px-6 py-4 whitespace-nowrap">
                      <span className={`px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${getStatusClass(venda.status)}`}>
                        {getStatusText(venda.status)}
                      </span>
                    </td>
                    <td className="px-6 py-4 whitespace-nowrap">
                      <div className="text-sm text-gray-500">{venda.itens}</div>
                    </td>
                    <td className="px-6 py-4 whitespace-nowrap">
                      <div className="text-sm font-medium text-gray-900">
                        {venda.total.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}
                      </div>
                    </td>
                    <td className="px-6 py-4 whitespace-nowrap text-sm font-medium">
                      <button className="text-blue-600 hover:text-blue-900">
                        Ver detalhes
                      </button>
                    </td>
                  </tr>
                ))
              ) : (
                <tr>
                  <td colSpan={7} className="px-6 py-4 text-center text-sm text-gray-500">
                    Nenhuma venda encontrada
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

export default Vendas; 