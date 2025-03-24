import React, { useState, useEffect } from 'react';
import { useParams, useNavigate, Link } from 'react-router-dom';
import { FiSave, FiArrowLeft, FiDollarSign, FiUser, FiCalendar, FiFileText } from 'react-icons/fi';
import crmService, { Oportunidade } from '../../services/crmService';

const OportunidadesForm: React.FC = () => {
  const { id } = useParams<{ id: string }>();
  const navigate = useNavigate();
  const isEditMode = !!id;

  const [loading, setLoading] = useState<boolean>(false);
  const [saving, setSaving] = useState<boolean>(false);
  const [error, setError] = useState<string | null>(null);
  const [success, setSuccess] = useState<string | null>(null);
  const [clientes, setClientes] = useState<any[]>([]);
  const [loadingClientes, setLoadingClientes] = useState<boolean>(false);

  // Estado inicial do formulário
  const initialFormState: Oportunidade = {
    titulo: '',
    cliente_id: 0,
    valor: 0,
    status: 'prospeccao',
    data_previsao: '',
    descricao: ''
  };

  const [formData, setFormData] = useState<Oportunidade>(initialFormState);

  // Carregar dados da oportunidade se estiver em modo de edição
  useEffect(() => {
    fetchClientes();
    
    if (isEditMode) {
      fetchOportunidade();
    }
  }, [id]);

  const fetchOportunidade = async () => {
    try {
      setLoading(true);
      const oportunidade = await crmService.getOportunidadeById(Number(id));
      
      // Formatar a data para o formato esperado pelo input date (YYYY-MM-DD)
      if (oportunidade.data_previsao) {
        const date = new Date(oportunidade.data_previsao);
        oportunidade.data_previsao = date.toISOString().split('T')[0];
      }
      
      setFormData(oportunidade);
      setError(null);
    } catch (error) {
      console.error('Erro ao carregar oportunidade:', error);
      setError('Não foi possível carregar os dados da oportunidade. Tente novamente mais tarde.');
    } finally {
      setLoading(false);
    }
  };

  const fetchClientes = async () => {
    try {
      setLoadingClientes(true);
      const response = await crmService.getClientes(1, '', 100); // Buscar todos os clientes para o select
      setClientes(response.data);
    } catch (error) {
      console.error('Erro ao carregar clientes:', error);
    } finally {
      setLoadingClientes(false);
    }
  };

  // Função para lidar com mudanças nos campos do formulário
  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>) => {
    const { name, value } = e.target;
    
    // Converter valores numéricos
    if (name === 'cliente_id') {
      setFormData(prev => ({ ...prev, [name]: parseInt(value) || 0 }));
    } else if (name === 'valor') {
      setFormData(prev => ({ ...prev, [name]: parseFloat(value) || 0 }));
    } else {
      setFormData(prev => ({ ...prev, [name]: value }));
    }
  };

  // Função para enviar o formulário
  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    
    try {
      setSaving(true);
      
      if (isEditMode) {
        await crmService.updateOportunidade(Number(id), formData);
        setSuccess('Oportunidade atualizada com sucesso!');
      } else {
        await crmService.createOportunidade(formData);
        setSuccess('Oportunidade criada com sucesso!');
        setFormData(initialFormState); // Limpar formulário após criar
      }
      
      // Redirecionar após um breve delay para mostrar a mensagem de sucesso
      setTimeout(() => {
        navigate('/crm/oportunidades');
      }, 1500);
      
    } catch (error) {
      console.error('Erro ao salvar oportunidade:', error);
      setError('Não foi possível salvar a oportunidade. Verifique os dados e tente novamente.');
    } finally {
      setSaving(false);
    }
  };

  const formatCurrency = (value: number) => {
    return new Intl.NumberFormat('pt-BR', {
      style: 'currency',
      currency: 'BRL',
      minimumFractionDigits: 2
    }).format(value);
  };

  if (loading) {
    return (
      <div className="container mx-auto px-4 py-6">
        <div className="p-8 text-center">
          <div className="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-indigo-600 mb-2"></div>
          <p>Carregando dados da oportunidade...</p>
        </div>
      </div>
    );
  }

  return (
    <div className="container mx-auto px-4 py-6">
      <div className="flex justify-between items-center mb-6">
        <h1 className="text-2xl font-semibold text-gray-800">
          {isEditMode ? 'Editar Oportunidade' : 'Nova Oportunidade'}
        </h1>
        <Link 
          to="/crm/oportunidades" 
          className="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 flex items-center"
        >
          <FiArrowLeft className="mr-2" />
          Voltar
        </Link>
      </div>

      {/* Mensagens de erro e sucesso */}
      {error && (
        <div className="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
          <p>{error}</p>
        </div>
      )}
      
      {success && (
        <div className="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
          <p>{success}</p>
        </div>
      )}

      {/* Formulário */}
      <div className="bg-white rounded-lg shadow overflow-hidden">
        <form onSubmit={handleSubmit} className="p-6">
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            {/* Informações básicas */}
            <div className="col-span-1 md:col-span-2">
              <h2 className="text-lg font-medium text-gray-800 mb-4 flex items-center">
                <FiFileText className="mr-2" />
                Informações Básicas
              </h2>
            </div>
            
            <div className="col-span-1 md:col-span-2">
              <label htmlFor="titulo" className="block text-sm font-medium text-gray-700 mb-1">
                Título <span className="text-red-500">*</span>
              </label>
              <input
                type="text"
                id="titulo"
                name="titulo"
                required
                value={formData.titulo}
                onChange={handleChange}
                className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
              />
            </div>
            
            <div>
              <label htmlFor="cliente_id" className="block text-sm font-medium text-gray-700 mb-1">
                Cliente <span className="text-red-500">*</span>
              </label>
              <select
                id="cliente_id"
                name="cliente_id"
                required
                value={formData.cliente_id || ''}
                onChange={handleChange}
                className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                disabled={loadingClientes}
              >
                <option value="">Selecione um cliente</option>
                {clientes.map(cliente => (
                  <option key={cliente.id} value={cliente.id}>
                    {cliente.nome} - {cliente.empresa}
                  </option>
                ))}
              </select>
              {loadingClientes && (
                <div className="text-sm text-gray-500 mt-1">Carregando clientes...</div>
              )}
            </div>
            
            <div>
              <label htmlFor="status" className="block text-sm font-medium text-gray-700 mb-1">
                Status <span className="text-red-500">*</span>
              </label>
              <select
                id="status"
                name="status"
                required
                value={formData.status}
                onChange={handleChange}
                className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
              >
                <option value="prospeccao">Prospecção</option>
                <option value="qualificacao">Qualificação</option>
                <option value="proposta">Proposta</option>
                <option value="negociacao">Negociação</option>
                <option value="fechada_ganha">Fechada (Ganha)</option>
                <option value="fechada_perdida">Fechada (Perdida)</option>
              </select>
            </div>
            
            {/* Informações financeiras */}
            <div className="col-span-1 md:col-span-2 mt-4">
              <h2 className="text-lg font-medium text-gray-800 mb-4 flex items-center">
                <FiDollarSign className="mr-2" />
                Informações Financeiras
              </h2>
            </div>
            
            <div>
              <label htmlFor="valor" className="block text-sm font-medium text-gray-700 mb-1">
                Valor <span className="text-red-500">*</span>
              </label>
              <div className="relative">
                <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <span className="text-gray-500">R$</span>
                </div>
                <input
                  type="number"
                  id="valor"
                  name="valor"
                  required
                  min="0"
                  step="0.01"
                  value={formData.valor}
                  onChange={handleChange}
                  className="w-full pl-10 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                />
              </div>
              {formData.valor > 0 && (
                <div className="text-sm text-gray-500 mt-1">
                  {formatCurrency(formData.valor)}
                </div>
              )}
            </div>
            
            <div>
              <label htmlFor="data_previsao" className="block text-sm font-medium text-gray-700 mb-1">
                Data de Previsão de Fechamento
              </label>
              <input
                type="date"
                id="data_previsao"
                name="data_previsao"
                value={formData.data_previsao || ''}
                onChange={handleChange}
                className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
              />
            </div>
            
            {/* Descrição */}
            <div className="col-span-1 md:col-span-2 mt-4">
              <label htmlFor="descricao" className="block text-sm font-medium text-gray-700 mb-1">
                Descrição
              </label>
              <textarea
                id="descricao"
                name="descricao"
                rows={4}
                value={formData.descricao || ''}
                onChange={handleChange}
                className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                placeholder="Descreva os detalhes desta oportunidade..."
              ></textarea>
            </div>
          </div>
          
          <div className="mt-8 flex justify-end">
            <button
              type="button"
              onClick={() => navigate('/crm/oportunidades')}
              className="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 mr-4"
            >
              Cancelar
            </button>
            <button
              type="submit"
              disabled={saving}
              className={`px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 flex items-center ${saving ? 'opacity-70 cursor-not-allowed' : ''}`}
            >
              {saving ? (
                <>
                  <div className="animate-spin rounded-full h-4 w-4 border-t-2 border-b-2 border-white mr-2"></div>
                  Salvando...
                </>
              ) : (
                <>
                  <FiSave className="mr-2" />
                  Salvar
                </>
              )}
            </button>
          </div>
        </form>
      </div>
    </div>
  );
};

export default OportunidadesForm; 