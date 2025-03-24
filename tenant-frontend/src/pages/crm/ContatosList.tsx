import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { FiPlus, FiSearch, FiEdit2, FiTrash2, FiMail, FiPhone } from 'react-icons/fi';
import crmService from '../../services/crmService';

const ContatosList: React.FC = () => {
  const [contatos, setContatos] = useState<any[]>([]);
  const [loading, setLoading] = useState<boolean>(true);
  const [error, setError] = useState<string | null>(null);
  const [searchTerm, setSearchTerm] = useState<string>('');
  const [currentPage, setCurrentPage] = useState<number>(1);
  const [totalPages, setTotalPages] = useState<number>(1);
  const [showDeleteModal, setShowDeleteModal] = useState<boolean>(false);
  const [contatoToDelete, setContatoToDelete] = useState<number | null>(null);

  const fetchContatos = async (page = 1, search = '') => {
    try {
      setLoading(true);
      const response = await crmService.getContatos(page, search);
      setContatos(response.data);
      setTotalPages(response.meta.last_page);
      setCurrentPage(response.meta.current_page);
      setError(null);
    } catch (error) {
      console.error('Erro ao carregar contatos:', error);
      setError('Não foi possível carregar os contatos. Tente novamente mais tarde.');
      setContatos([]);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchContatos(currentPage, searchTerm);
  }, [currentPage]);

  const confirmDelete = (id: number) => {
    setContatoToDelete(id);
    setShowDeleteModal(true);
  };

  const handleDelete = async () => {
    if (!contatoToDelete) return;

    try {
      await crmService.deleteContato(contatoToDelete);
      setShowDeleteModal(false);
      setContatoToDelete(null);
      fetchContatos(currentPage, searchTerm);
    } catch (error) {
      console.error('Erro ao excluir contato:', error);
      setError('Não foi possível excluir o contato. Tente novamente mais tarde.');
    }
  };

  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault();
    setCurrentPage(1);
    fetchContatos(1, searchTerm);
  };

  return (
    <div className="container mx-auto px-4 py-6">
      <div className="flex justify-between items-center mb-6">
        <h1 className="text-2xl font-semibold text-gray-800">Contatos</h1>
        <Link 
          to="/crm/contatos/novo" 
          className="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 flex items-center"
        >
          <FiPlus className="mr-2" />
          Novo Contato
        </Link>
      </div>

      {/* Formulário de busca */}
      <div className="bg-white rounded-lg shadow mb-6">
        <form onSubmit={handleSearch} className="p-4 flex items-center">
          <div className="flex-1 mr-4">
            <div className="relative">
              <input
                type="text"
                placeholder="Buscar contatos..."
                className="w-full px-3 py-2 pl-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
              />
              <FiSearch className="absolute left-3 top-3 text-gray-400" />
            </div>
          </div>
          <button
            type="submit"
            className="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300"
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

      {/* Tabela de contatos */}
      <div className="bg-white rounded-lg shadow overflow-hidden">
        {loading ? (
          <div className="p-8 text-center">
            <div className="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-indigo-600 mb-2"></div>
            <p>Carregando contatos...</p>
          </div>
        ) : contatos.length === 0 ? (
          <div className="p-8 text-center text-gray-500">
            <p>Nenhum contato encontrado.</p>
          </div>
        ) : (
          <div className="overflow-x-auto">
            <table className="min-w-full divide-y divide-gray-200">
              <thead className="bg-gray-50">
                <tr>
                  <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Nome
                  </th>
                  <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Cliente
                  </th>
                  <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Cargo
                  </th>
                  <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Contato
                  </th>
                  <th className="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Ações
                  </th>
                </tr>
              </thead>
              <tbody className="bg-white divide-y divide-gray-200">
                {contatos.map((contato) => (
                  <tr key={contato.id} className="hover:bg-gray-50">
                    <td className="px-6 py-4 whitespace-nowrap">
                      <div className="text-sm font-medium text-gray-900">{contato.nome}</div>
                    </td>
                    <td className="px-6 py-4 whitespace-nowrap">
                      <div className="text-sm text-gray-900">{contato.cliente?.nome || '-'}</div>
                    </td>
                    <td className="px-6 py-4 whitespace-nowrap">
                      <div className="text-sm text-gray-500">{contato.cargo || '-'}</div>
                    </td>
                    <td className="px-6 py-4 whitespace-nowrap">
                      <div className="flex flex-col text-sm text-gray-500">
                        {contato.email && (
                          <div className="flex items-center mb-1">
                            <FiMail className="mr-1 text-gray-400" />
                            <span>{contato.email}</span>
                          </div>
                        )}
                        {contato.telefone && (
                          <div className="flex items-center">
                            <FiPhone className="mr-1 text-gray-400" />
                            <span>{contato.telefone}</span>
                          </div>
                        )}
                      </div>
                    </td>
                    <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                      <Link
                        to={`/crm/contatos/${contato.id}/editar`}
                        className="text-indigo-600 hover:text-indigo-900 mr-4"
                      >
                        <FiEdit2 className="inline" /> Editar
                      </Link>
                      <button
                        onClick={() => confirmDelete(contato.id)}
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
        {!loading && contatos.length > 0 && (
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
              Tem certeza que deseja excluir este contato? Esta ação não pode ser desfeita.
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

export default ContatosList;