import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { FiPlus, FiSearch, FiEdit2, FiTrash2, FiDollarSign, FiCalendar } from 'react-icons/fi';
import crmService from '../../services/crmService';

const OportunidadesList: React.FC = () => {
  const [oportunidades, setOportunidades] = useState<any[]>([]);
  const [loading, setLoading] = useState<boolean>(true);
  const [error, setError] = useState<string | null>(null);
  const [searchTerm, setSearchTerm] = useState<string>('');
  const [statusFilter, setStatusFilter] = useState<string>('');
  const [currentPage, setCurrentPage] = useState<number>(1);
  const [totalPages, setTotalPages] = useState<number>(1);
  const [showDeleteModal, setShowDeleteModal] = useState<boolean>(false);
  const [oportunidadeToDelete, setOportunidadeToDelete] = useState<number | null>(null);

  const fetchOportunidades = async (page = 1, search = '', status = '') => {
    try {
      setLoading(true);
      const params: any = { page, search, per_page: 10 };
      if (status) params.status = status;
      
      const response = await crmService.getOportunidades(page, search);
      setOportunidades(response.data);
      setTotalPages(response.meta.last_page);
      setCurrentPage(response.meta.current_page);
      setError(null);
    } catch (error) {
      console.error('Erro ao carregar oportunidades:', error);
      setError('Não foi possível carregar as oportunidades. Tente novamente mais tarde.');
      setOportunidades([]);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchOportunidades(currentPage, searchTerm, statusFilter);
  }, [currentPage, statusFilter]);

  const confirmDelete = (id: number) => {
    setOportunidadeToDelete(id);
    setShowDeleteModal(true);
  };

  const handleDelete = async () => {
    if (!oportunidadeToDelete) return;

    try {
      await crmService.deleteOportunidade(oportunidadeToDelete);
      setShowDeleteModal(false);
      setOportunidadeToDelete(null);
      fetchOportunidades(currentPage, searchTerm, statusFilter);
    } catch (error) {
      console.error('Erro ao excluir oportunidade:', error);
      setError('Não foi possível excluir a oportunidade. Tente novamente mais tarde.');
    }
  };

  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault();
    setCurrentPage(1);
    fetchOportunidades(1, searchTerm, statusFilter);
  };

  const handleStatusChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
    setStatusFilter(e.target.value);
    setCurrentPage(1);
  };

  const formatCurrency = (value: number) => {
    return new Intl.NumberFormat('pt-BR', {
      style: 'currency',
      currency: 'BRL'
    }).format(value);
  };

  const renderStatus = (status: string) => {
    let bgColor = '';
    let textColor = '';
    let label = '';

    switch (status) {
      case 'prospeccao':
        bgColor = 'bg-blue-100';
        textColor = 'text-blue-800';
        label = 'Prospecção';
        break;
      case 'qualificacao':
        bgColor = 'bg-purple-100';
        textColor = 'text-purple-800';
        label = 'Qualificação';
        break;
      case 'proposta':
        bgColor = 'bg-yellow-100';
        textColor = 'text-yellow-800';
        label = 'Proposta';
        break;
      case 'negociacao':
        bgColor = 'bg-orange-100';
        textColor = 'text-orange-800';
        label = 'Negociação';
        break;
      case 'fechada_ganha':
        bgColor = 'bg-green-100';
        textColor = 'text-green-800';
        label = 'Fechada (Ganha)';
        break;
      case 'fechada_perdida':
        bgColor = 'bg-red-100';
        textColor = 'text-red-800';
        label = 'Fechada (Perdida)';
        break;
      default:
        bgColor = 'bg-gray-100';
        textColor = 'text-gray-800';
        label = status;
    }

    return (
      <span className={`px-2 py-1 rounded-full text-xs font-medium ${bgColor} ${textColor}`}>
        {label}
      </span>
    );
  };

  return (
    <div className="container mx-auto px-4 py-6">
      <div className="flex justify-between items-center mb-6">
        <h1 className="text-2xl font-semibold text-gray-800">Oportunidades</h1>
        <Link 
          to="/crm/oportunidades/novo" 
          className="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 flex items-center"
        >
          <FiPlus className="mr-2" />
          Nova Oportunidade
        </Link>
      </div>

      {/* Formulário de busca e filtros */}
      <div className="bg-white rounded-lg shadow mb-6">
        <form onSubmit={handleSearch} className="p-4 flex flex-col md:flex-row items-center gap-4">
          <div className="flex-1 w-full">
            <div className="relative">
              <input
                type="text"
                placeholder="Buscar oportunidades..."
                className="w-full px-3 py-2 pl-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
              />
              <FiSearch className="absolute left-3 top-3 text-gray-400" />
            </div>
          </div>
          
          <div className="w-full md:w-48">
            <select
              className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
              value={statusFilter}
              onChange={handleStatusChange}
            >
              <option value="">Todos os status</option>
              <option value="prospeccao">Prospecção</option>
              <option value="qualificacao">Qualificação</option>
              <option value="proposta">Proposta</option>
              <option value="negociacao">Negociação</option>
              <option value="fechada_ganha">Fechada (Ganha)</option>
              <option value="fechada_perdida">Fechada (Perdida)</option>
            </select>
          </div>
          
          <button
            type="submit"
            className="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 w-full md:w-auto"
          >
            Buscar
          </button>
        </form>
      </div>

      {/* Mensagem de erro */}
      {error && (
        <div className="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
          <p>{error}</p>
        </div>
      )}

      {/* Tabela de oportunidades */}
      <div className="bg-white rounded-lg shadow overflow-hidden">
        {loading ? (
          <div className="p-8 text-center">
            <div className="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-indigo-600 mb-2"></div>
            <p>Carregando oportunidades...</p>
          </div>
        ) : oportunidades.length === 0 ? (
          <div className="p-8 text-center text-gray-500">
            <p>Nenhuma oportunidade encontrada.</p>
          </div>
        ) : (
          <div className="overflow-x-auto">
            <table className="min-w-full divide-y divide-gray-200">
              <thead className="bg-gray-50">
                <tr>
                  <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Título
                  </th>
                  <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Cliente
                  </th>
                  <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Valor
                  </th>
                  <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Status
                  </th>
                  <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Previsão
                  </th>
                  <th className="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Ações
                  </th>
                </tr>
              </thead>
              <tbody className="bg-white divide-y divide-gray-200">
                {oportunidades.map((oportunidade) => (
                  <tr key={oportunidade.id} className="hover:bg-gray-50">
                    <td className="px-6 py-4 whitespace-nowrap">
                      <div className="text-sm font-medium text-gray-900">{oportunidade.titulo}</div>
                    </td>
                    <td className="px-6 py-4 whitespace-nowrap">
                      <div className="text-sm text-gray-900">{oportunidade.cliente?.nome || '-'}</div>
                      <div className="text-xs text-gray-500">{oportunidade.cliente?.empresa || ''}</div>
                    </td>
                    <td className="px-6 py-4 whitespace-nowrap">
                      <div className="text-sm text-gray-900 font-medium">
                        <span className="flex items-center">
                          <FiDollarSign className="mr-1 text-green-500" />
                          {formatCurrency(oportunidade.valor)}
                        </span>
                      </div>
                    </td>
                    <td className="px-6 py-4 whitespace-nowrap">
                      {renderStatus(oportunidade.status)}
                    </td>
                    <td className="px-6 py-4 whitespace-nowrap">
                      {oportunidade.data_previsao ? (
                        <div className="text-sm text-gray-500 flex items-center">
                          <FiCalendar className="mr-1" />
                          {new Date(oportunidade.data_previsao).toLocaleDateString('pt-BR')}
                        </div>
                      ) : (
                        <span className="text-sm text-gray-400">-</span>
                      )}
                    </td>
                    <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                      <Link
                        to={`/crm/oportunidades/${oportunidade.id}/editar`}
                        className="text-indigo-600 hover:text-indigo-900 mr-4"
                      >
                        <FiEdit2 className="inline" /> Editar
                      </Link>
                      <button
                        onClick={() => confirmDelete(oportunidade.id)}
                        className="text-red-600 hover:text-red-900"
                      >
                        <FiTrash2 className="inline" /> Excluir
                      </button>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        )}

        {/* Paginação */}
        {!loading && oportunidades.length > 0 && (
          <div className="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
            <div className="text-sm text-gray-700">
              Mostrando página <span className="font-medium">{currentPage}</span> de{' '}
              <span className="font-medium">{totalPages}</span>
            </div>
            <div className="flex space-x-2">
              <button
                onClick={() => setCurrentPage((prev) => Math.max(prev - 1, 1))}
                disabled={currentPage === 1}
                className={`px-3 py-1 rounded-md ${
                  currentPage === 1
                    ? 'bg-gray-100 text-gray-400 cursor-not-allowed'
                    : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                }`}
              >
                Anterior
              </button>
              <button
                onClick={() => setCurrentPage((prev) => Math.min(prev + 1, totalPages))}
                disabled={currentPage === totalPages}
                className={`px-3 py-1 rounded-md ${
                  currentPage === totalPages
                    ? 'bg-gray-100 text-gray-400 cursor-not-allowed'
                    : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                }`}
              >
                Próxima
              </button>
            </div>
          </div>
        )}
      </div>

      {/* Modal de confirmação de exclusão */}
      {showDeleteModal && (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
          <div className="bg-white rounded-lg p-6 max-w-md w-full">
            <h3 className="text-lg font-medium text-gray-900 mb-4">Confirmar exclusão</h3>
            <p className="text-gray-500 mb-6">
              Tem certeza que deseja excluir esta oportunidade? Esta ação não pode ser desfeita.
            </p>
            <div className="flex justify-end space-x-3">
              <button
                onClick={() => setShowDeleteModal(false)}
                className="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300"
              >
                Cancelar
              </button>
              <button
                onClick={handleDelete}
                className="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700"
              >
                Excluir
              </button>
            </div>
          </div>
        </div>
      )}
    </div>
  );
};

export default OportunidadesList;