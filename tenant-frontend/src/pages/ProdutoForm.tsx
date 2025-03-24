import React, { useState, useEffect } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { FiSave, FiArrowLeft, FiAlertCircle } from 'react-icons/fi';
import produtoService, { Produto } from '../services/produtoService';
import { PageHeader } from '../components/PageHeader';

const ProdutoForm: React.FC = () => {
  const { id } = useParams<{ id: string }>();
  const navigate = useNavigate();
  const isEditMode = !!id;
  
  const [loading, setLoading] = useState<boolean>(false);
  const [saving, setSaving] = useState<boolean>(false);
  const [error, setError] = useState<string | null>(null);
  const [categorias, setCategorias] = useState<string[]>([]);
  
  const [produto, setProduto] = useState<Produto>({
    nome: '',
    sku: '',
    preco: 0,
    estoque: 0,
    estoqueMinimo: 0,
    categoria: '',
    status: 'ativo',
    descricao: '',
    unidade: 'un',
    peso: 0,
    dimensoes: {
      altura: 0,
      largura: 0,
      comprimento: 0
    }
  });
  
  useEffect(() => {
    const fetchCategorias = async () => {
      try {
        const response = await produtoService.getCategorias();
        setCategorias(response.data);
      } catch (error) {
        console.error('Erro ao carregar categorias:', error);
      }
    };
    
    fetchCategorias();
    
    if (isEditMode) {
      fetchProduto();
    }
  }, [id, isEditMode]);
  
  const fetchProduto = async () => {
    try {
      setLoading(true);
      setError(null);
      
      const response = await produtoService.getProdutoById(Number(id));
      setProduto(response);
    } catch (error) {
      console.error('Erro ao carregar produto:', error);
      setError('Não foi possível carregar os dados do produto. Tente novamente mais tarde.');
    } finally {
      setLoading(false);
    }
  };
  
  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>) => {
    const { name, value } = e.target;
    
    if (name.includes('.')) {
      const [parent, child] = name.split('.');
      setProduto(prev => ({
        ...prev,
        [parent]: {
          ...(prev[parent as keyof Produto] as Record<string, any>),
          [child]: value
        }
      }));
    } else {
      setProduto(prev => ({
        ...prev,
        [name]: name === 'preco' || name === 'estoque' || name === 'estoqueMinimo' || name === 'peso' 
          ? Number(value) 
          : value
      }));
    }
  };
  
  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    
    try {
      setSaving(true);
      setError(null);
      
      if (isEditMode) {
        await produtoService.updateProduto(Number(id), produto);
      } else {
        await produtoService.createProduto(produto);
      }
      
      navigate('/produtos');
    } catch (error) {
      console.error('Erro ao salvar produto:', error);
      setError('Não foi possível salvar o produto. Verifique os dados e tente novamente.');
    } finally {
      setSaving(false);
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
      <PageHeader 
        title={isEditMode ? `Editar Produto: ${produto.nome}` : 'Novo Produto'} 
        onBack={() => navigate('/produtos')}
      />
      
      <div className="p-6 bg-white rounded-lg shadow-md">
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
        
        <form onSubmit={handleSubmit}>
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
              <label htmlFor="nome" className="block text-sm font-medium text-gray-700 mb-1">
                Nome do Produto <span className="text-red-500">*</span>
              </label>
              <input
                type="text"
                id="nome"
                name="nome"
                value={produto.nome}
                onChange={handleChange}
                required
                className="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
              />
            </div>
            
            <div>
              <label htmlFor="sku" className="block text-sm font-medium text-gray-700 mb-1">
                SKU <span className="text-red-500">*</span>
              </label>
              <input
                type="text"
                id="sku"
                name="sku"
                value={produto.sku}
                onChange={handleChange}
                required
                className="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
              />
            </div>
            
            <div>
              <label htmlFor="preco" className="block text-sm font-medium text-gray-700 mb-1">
                Preço (R$) <span className="text-red-500">*</span>
              </label>
              <input
                type="number"
                id="preco"
                name="preco"
                value={produto.preco}
                onChange={handleChange}
                required
                min="0"
                step="0.01"
                className="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
              />
            </div>
            
            <div>
              <label htmlFor="categoria" className="block text-sm font-medium text-gray-700 mb-1">
                Categoria <span className="text-red-500">*</span>
              </label>
              <select
                id="categoria"
                name="categoria"
                value={produto.categoria}
                onChange={handleChange}
                required
                className="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
              >
                <option value="">Selecione uma categoria</option>
                {categorias.map((categoria, index) => (
                  <option key={index} value={categoria}>
                    {categoria}
                  </option>
                ))}
                {categorias.length === 0 && (
                  <>
                    <option value="Eletrônicos">Eletrônicos</option>
                    <option value="Periféricos">Periféricos</option>
                    <option value="Móveis">Móveis</option>
                    <option value="Acessórios">Acessórios</option>
                    <option value="Outros">Outros</option>
                  </>
                )}
              </select>
            </div>
            
            <div>
              <label htmlFor="estoque" className="block text-sm font-medium text-gray-700 mb-1">
                Estoque Atual <span className="text-red-500">*</span>
              </label>
              <input
                type="number"
                id="estoque"
                name="estoque"
                value={produto.estoque}
                onChange={handleChange}
                required
                min="0"
                className="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
              />
            </div>
            
            <div>
              <label htmlFor="estoqueMinimo" className="block text-sm font-medium text-gray-700 mb-1">
                Estoque Mínimo <span className="text-red-500">*</span>
              </label>
              <input
                type="number"
                id="estoqueMinimo"
                name="estoqueMinimo"
                value={produto.estoqueMinimo}
                onChange={handleChange}
                required
                min="0"
                className="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
              />
            </div>
            
            <div>
              <label htmlFor="status" className="block text-sm font-medium text-gray-700 mb-1">
                Status <span className="text-red-500">*</span>
              </label>
              <select
                id="status"
                name="status"
                value={produto.status}
                onChange={handleChange}
                required
                className="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
              >
                <option value="ativo">Ativo</option>
                <option value="inativo">Inativo</option>
              </select>
            </div>
            
            <div>
              <label htmlFor="unidade" className="block text-sm font-medium text-gray-700 mb-1">
                Unidade de Medida
              </label>
              <select
                id="unidade"
                name="unidade"
                value={produto.unidade}
                onChange={handleChange}
                className="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
              >
                <option value="un">Unidade (un)</option>
                <option value="kg">Quilograma (kg)</option>
                <option value="g">Grama (g)</option>
                <option value="l">Litro (l)</option>
                <option value="ml">Mililitro (ml)</option>
                <option value="m">Metro (m)</option>
                <option value="cm">Centímetro (cm)</option>
                <option value="m²">Metro Quadrado (m²)</option>
                <option value="m³">Metro Cúbico (m³)</option>
              </select>
            </div>
          </div>
          
          <div className="mb-6">
            <label htmlFor="descricao" className="block text-sm font-medium text-gray-700 mb-1">
              Descrição
            </label>
            <textarea
              id="descricao"
              name="descricao"
              value={produto.descricao}
              onChange={handleChange}
              rows={4}
              className="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            ></textarea>
          </div>
          
          <div className="mb-6">
            <h3 className="text-lg font-medium text-gray-700 mb-3">Dimensões e Peso</h3>
            <div className="grid grid-cols-1 md:grid-cols-4 gap-4">
              <div>
                <label htmlFor="peso" className="block text-sm font-medium text-gray-700 mb-1">
                  Peso (kg)
                </label>
                <input
                  type="number"
                  id="peso"
                  name="peso"
                  value={produto.peso}
                  onChange={handleChange}
                  min="0"
                  step="0.01"
                  className="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                />
              </div>
              
              <div>
                <label htmlFor="dimensoes.altura" className="block text-sm font-medium text-gray-700 mb-1">
                  Altura (cm)
                </label>
                <input
                  type="number"
                  id="dimensoes.altura"
                  name="dimensoes.altura"
                  value={produto.dimensoes?.altura}
                  onChange={handleChange}
                  min="0"
                  step="0.1"
                  className="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                />
              </div>
              
              <div>
                <label htmlFor="dimensoes.largura" className="block text-sm font-medium text-gray-700 mb-1">
                  Largura (cm)
                </label>
                <input
                  type="number"
                  id="dimensoes.largura"
                  name="dimensoes.largura"
                  value={produto.dimensoes?.largura}
                  onChange={handleChange}
                  min="0"
                  step="0.1"
                  className="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                />
              </div>
              
              <div>
                <label htmlFor="dimensoes.comprimento" className="block text-sm font-medium text-gray-700 mb-1">
                  Comprimento (cm)
                </label>
                <input
                  type="number"
                  id="dimensoes.comprimento"
                  name="dimensoes.comprimento"
                  value={produto.dimensoes?.comprimento}
                  onChange={handleChange}
                  min="0"
                  step="0.1"
                  className="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                />
              </div>
            </div>
          </div>
          
          <div className="flex justify-end space-x-3">
            <button
              type="button"
              onClick={() => navigate('/produtos')}
              className="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
              <FiArrowLeft className="w-5 h-5 mr-2 inline" />
              Cancelar
            </button>
            <button
              type="submit"
              disabled={saving}
              className="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex items-center"
            >
              <FiSave className="w-5 h-5 mr-2" />
              {saving ? 'Salvando...' : 'Salvar Produto'}
            </button>
          </div>
        </form>
      </div>
    </div>
  );
};

export default ProdutoForm; 