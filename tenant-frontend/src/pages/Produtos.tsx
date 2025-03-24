import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { FiEdit, FiTrash2, FiPlus, FiSearch, FiAlertCircle } from 'react-icons/fi';
import produtoService, { Produto, ProdutoParams } from '../services/produtoService';
import { PageHeader } from '../components/PageHeader';

const Produtos: React.FC = () => {
  const navigate = useNavigate();
  const [produtos, setProdutos] = useState<Produto[]>([]);
  const [loading, setLoading] = useState<boolean>(true);
  const [searchTerm, setSearchTerm] = useState<string>('');
  const [currentPage, setCurrentPage] = useState<number>(1);
  const [totalPages, setTotalPages] = useState<number>(1);
  const [error, setError] = useState<string | null>(null);
  const [lowStockCount, setLowStockCount] = useState<number>(0);
  const [outOfStockCount, setOutOfStockCount] = useState<number>(0);
  const [deleteModalOpen, setDeleteModalOpen] = useState<boolean>(false);
  const [produtoToDelete, setProdutoToDelete] = useState<Produto | null>(null);

  useEffect(() => {
    fetchProdutos();
    fetchStockAlerts();
  }, [currentPage]);

  const fetchProdutos = async () => {
    try {
      setLoading(true);
      setError(null);
      
      const params: ProdutoParams = {
        page: currentPage,
        search: searchTerm
      };
      
      const response = await produtoService.getProdutos(params);
      setProdutos(response.data || []);
      
      if (response.meta) {
        setTotalPages(response.meta.last_page || 1);
      } else {
        setTotalPages(1);
      }
    } catch (error) {
      console.error('Erro ao carregar produtos:', error);
      setError('Não foi possível carregar os produtos. Tente novamente mais tarde.');
      setProdutos([]);
    } finally {
      setLoading(false);
    }
  };

  const fetchStockAlerts = async () => {
    try {
      const lowStockResponse = await produtoService.getLowStockProdutos();
      setLowStockCount(lowStockResponse.meta?.total || 0);
      
      const outOfStockResponse = await produtoService.getOutOfStockProdutos();
      setOutOfStockCount(outOfStockResponse.meta?.total || 0);
    } catch (error) {
      console.error('Erro ao carregar alertas de estoque:', error);
    }
  };

  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault();
    setCurrentPage(1);
    fetchProdutos();
  };

  const handlePageChange = (page: number) => {
    setCurrentPage(page);
  };

  const handleDeleteClick = (produto: Produto) => {
    setProdutoToDelete(produto);
    setDeleteModalOpen(true);
  };

  const confirmDelete = async () => {
    if (!produtoToDelete) return;
    
    try {
      await produtoService.deleteProduto(produtoToDelete.id);
      setProdutos(produtos.filter(p => p.id !== produtoToDelete.id));
      setDeleteModalOpen(false);
      setProdutoToDelete(null);
    } catch (error) {
      console.error('Erro ao excluir produto:', error);
      setError('Não foi possível excluir o produto. Tente novamente mais tarde.');
    }
  };

  const getStockStatusClass = (produto: Produto) => {
    if (produto.estoque <= 0) {
      return 'bg-red-100 text-red-800';
    } else if (produto.estoque <= produto.estoqueMinimo) {
      return 'bg-yellow-100 text-yellow-800';
    } else {
      return 'bg-green-100 text-green-800';
    }
  };

  const getStockStatusText = (produto: Produto) => {
    if (produto.estoque <= 0) {
      return 'Sem estoque';
    } else if (produto.estoque <= produto.estoqueMinimo) {
      return 'Estoque baixo';
    } else {
      return 'Em estoque';
    }
  };

  return (
    <div>
      <PageHeader 
        title="Produtos" 
      />
      
      <div className="mb-6">
        <div className="flex flex-col md:flex-row md:items-center md:justify-between">
          <div className="mb-4 md:mb-0">
            <button
              onClick={() => navigate('/produtos/novo')}
              className="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 flex items-center"
            >
              <FiPlus className="mr-2" />
              Novo Produto
            </button>
          </div>
          
          <form onSubmit={handleSearch} className="flex">
            <div className="relative">
              <input
                type="text"
                placeholder="Buscar produtos..."
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
                className="px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 w-full"
              />
            </div>
            <button
              type="submit"
              className="px-4 py-2 bg-gray-100 text-gray-700 border border-gray-300 border-l-0 rounded-r-md hover:bg-gray-200 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            >
              <FiSearch />
            </button>
          </form>
        </div>
      </div>
      
      {(lowStockCount > 0 || outOfStockCount > 0) && (
        <div className="mb-6">
          <div className="flex flex-col md:flex-row gap-4">
            {lowStockCount > 0 && (
              <div className="p-4 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 flex items-center">
                <FiAlertCircle className="mr-2 text-yellow-500" />
                <span>
                  <strong>{lowStockCount}</strong> produtos com estoque baixo
                </span>
              </div>
            )}
            
            {outOfStockCount > 0 && (
              <div className="p-4 bg-red-50 border-l-4 border-red-400 text-red-700 flex items-center">
                <FiAlertCircle className="mr-2 text-red-500" />
                <span>
                  <strong>{outOfStockCount}</strong> produtos sem estoque
                </span>
              </div>
            )}
          </div>
        </div>
      )}
      
      {error && (
        <div className="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
          <div className="flex">
            <div className="flex-shrink-0">
              <FiAlertCircle className="w-5 h-5 text-red-500" />
            </div>
            <div className="ml-3">
              <p>{error}</p>
            </div>
          </div>
        </div>
      )}
      
      {loading ? (
        <div className="flex items-center justify-center h-64">
          <div className="w-16 h-16 border-t-4 border-b-4 border-blue-500 rounded-full animate-spin"></div>
        </div>
      ) : (
        <>
          {produtos.length > 0 ? (
            <div className="overflow-x-auto">
              <table className="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
                <thead className="bg-gray-50">
                  <tr>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Nome
                    </th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      SKU
                    </th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Preço
                    </th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Estoque
                    </th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Categoria
                    </th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Status
                    </th>
                    <th className="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Ações
                    </th>
                  </tr>
                </thead>
                <tbody className="divide-y divide-gray-200">
                  {produtos.map((produto) => (
                    <tr key={produto.id} className="hover:bg-gray-50">
                      <td className="px-6 py-4 whitespace-nowrap">
                        <div className="text-sm font-medium text-gray-900">{produto.nome}</div>
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap">
                        <div className="text-sm text-gray-500">{produto.sku}</div>
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap">
                        <div className="text-sm text-gray-900">
                          {produto.preco.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}
                        </div>
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap">
                        <span className={`px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${getStockStatusClass(produto)}`}>
                          {produto.estoque} un - {getStockStatusText(produto)}
                        </span>
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap">
                        <div className="text-sm text-gray-500">{produto.categoria}</div>
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap">
                        <span className={`px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${
                          produto.status === 'ativo' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'
                        }`}>
                          {produto.status === 'ativo' ? 'Ativo' : 'Inativo'}
                        </span>
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button
                          onClick={() => navigate(`/produtos/editar/${produto.id}`)}
                          className="text-blue-600 hover:text-blue-900 mr-3"
                        >
                          <FiEdit className="w-5 h-5" />
                        </button>
                        <button
                          onClick={() => handleDeleteClick(produto)}
                          className="text-red-600 hover:text-red-900"
                        >
                          <FiTrash2 className="w-5 h-5" />
                        </button>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          ) : (
            <div className="bg-white p-6 text-center rounded-lg border border-gray-200">
              <p className="text-gray-500">Nenhum produto encontrado</p>
            </div>
          )}
          
          {totalPages > 1 && (
            <div className="flex justify-center mt-6">
              <nav className="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                <button
                  onClick={() => handlePageChange(currentPage - 1)}
                  disabled={currentPage === 1}
                  className={`relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium ${
                    currentPage === 1 ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 hover:bg-gray-50'
                  }`}
                >
                  <span className="sr-only">Anterior</span>
                  &laquo;
                </button>
                
                {[...Array(totalPages)].map((_, i) => (
                  <button
                    key={i}
                    onClick={() => handlePageChange(i + 1)}
                    className={`relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium ${
                      currentPage === i + 1 ? 'z-10 bg-blue-50 border-blue-500 text-blue-600' : 'text-gray-500 hover:bg-gray-50'
                    }`}
                  >
                    {i + 1}
                  </button>
                ))}
                
                <button
                  onClick={() => handlePageChange(currentPage + 1)}
                  disabled={currentPage === totalPages}
                  className={`relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium ${
                    currentPage === totalPages ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 hover:bg-gray-50'
                  }`}
                >
                  <span className="sr-only">Próxima</span>
                  &raquo;
                </button>
              </nav>
            </div>
          )}
        </>
      )}
      
      {deleteModalOpen && produtoToDelete && (
        <div className="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
          <div className="bg-white rounded-lg p-6 max-w-md w-full">
            <h3 className="text-lg font-medium text-gray-900 mb-4">Confirmar exclusão</h3>
            <p className="text-gray-500 mb-6">
              Tem certeza que deseja excluir o produto <strong>{produtoToDelete.nome}</strong>? Esta ação não pode ser desfeita.
            </p>
            <div className="flex justify-end space-x-3">
              <button
                onClick={() => setDeleteModalOpen(false)}
                className="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
              >
                Cancelar
              </button>
              <button
                onClick={confirmDelete}
                className="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
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

export default Produtos; 