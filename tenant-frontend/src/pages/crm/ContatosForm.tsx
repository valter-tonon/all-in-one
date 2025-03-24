import React, { useState, useEffect } from 'react';
import { useParams, useNavigate, Link } from 'react-router-dom';
import { FiSave, FiArrowLeft, FiUser, FiMail, FiPhone, FiBriefcase } from 'react-icons/fi';
import crmService, { Contato } from '../../services/crmService';

const ContatosForm: React.FC = () => {
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
  const initialFormState: Contato = {
    nome: '',
    email: '',
    telefone: '',
    cargo: '',
    cliente_id: 0,
    departamento: '',
    observacoes: ''
  };

  const [formData, setFormData] = useState<Contato>(initialFormState);

  // Carregar dados do contato se estiver em modo de edição
  useEffect(() => {
    fetchClientes();
    
    if (isEditMode) {
      fetchContato();
    }
  }, [id]);

  const fetchContato = async () => {
    try {
      setLoading(true);
      const contato = await crmService.getContatoById(Number(id));
      setFormData(contato);
      setError(null);
    } catch (error) {
      console.error('Erro ao carregar contato:', error);
      setError('Não foi possível carregar os dados do contato. Tente novamente mais tarde.');
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
    
    // Converter cliente_id para número quando for selecionado
    if (name === 'cliente_id') {
      setFormData(prev => ({ ...prev, [name]: parseInt(value) || 0 }));
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
        await crmService.updateContato(Number(id), formData);
        setSuccess('Contato atualizado com sucesso!');
      } else {
        await crmService.createContato(formData);
        setSuccess('Contato criado com sucesso!');
        setFormData(initialFormState); // Limpar formulário após criar
      }
      
      // Redirecionar após um breve delay para mostrar a mensagem de sucesso
      setTimeout(() => {
        navigate('/crm/contatos');
      }, 1500);
      
    } catch (error) {
      console.error('Erro ao salvar contato:', error);
      setError('Não foi possível salvar o contato. Verifique os dados e tente novamente.');
    } finally {
      setSaving(false);
    }
  };

  if (loading) {
    return (
      <div className="container mx-auto px-4 py-6">
        <div className="p-8 text-center">
          <div className="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-indigo-600 mb-2"></div>
          <p>Carregando dados do contato...</p>
        </div>
      </div>
    );
  }

  return (
    <div className="container mx-auto px-4 py-6">
      <div className="flex justify-between items-center mb-6">
        <h1 className="text-2xl font-semibold text-gray-800">
          {isEditMode ? 'Editar Contato' : 'Novo Contato'}
        </h1>
        <Link 
          to="/crm/contatos" 
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
                <FiUser className="mr-2" />
                Informações Básicas
              </h2>
            </div>
            
            <div>
              <label htmlFor="nome" className="block text-sm font-medium text-gray-700 mb-1">
                Nome <span className="text-red-500">*</span>
              </label>
              <input
                type="text"
                id="nome"
                name="nome"
                required
                value={formData.nome}
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
            
            {/* Informações profissionais */}
            <div className="col-span-1 md:col-span-2 mt-4">
              <h2 className="text-lg font-medium text-gray-800 mb-4 flex items-center">
                <FiBriefcase className="mr-2" />
                Informações Profissionais
              </h2>
            </div>
            
            <div>
              <label htmlFor="cargo" className="block text-sm font-medium text-gray-700 mb-1">
                Cargo
              </label>
              <input
                type="text"
                id="cargo"
                name="cargo"
                value={formData.cargo || ''}
                onChange={handleChange}
                className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
              />
            </div>
            
            <div>
              <label htmlFor="departamento" className="block text-sm font-medium text-gray-700 mb-1">
                Departamento
              </label>
              <input
                type="text"
                id="departamento"
                name="departamento"
                value={formData.departamento || ''}
                onChange={handleChange}
                className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
              />
            </div>
            
            {/* Informações de contato */}
            <div className="col-span-1 md:col-span-2 mt-4">
              <h2 className="text-lg font-medium text-gray-800 mb-4 flex items-center">
                <FiMail className="mr-2" />
                Informações de Contato
              </h2>
            </div>
            
            <div>
              <label htmlFor="email" className="block text-sm font-medium text-gray-700 mb-1">
                Email <span className="text-red-500">*</span>
              </label>
              <input
                type="email"
                id="email"
                name="email"
                required
                value={formData.email}
                onChange={handleChange}
                className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
              />
            </div>
            
            <div>
              <label htmlFor="telefone" className="block text-sm font-medium text-gray-700 mb-1">
                Telefone <span className="text-red-500">*</span>
              </label>
              <input
                type="tel"
                id="telefone"
                name="telefone"
                required
                value={formData.telefone}
                onChange={handleChange}
                className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
              />
            </div>
            
            {/* Observações */}
            <div className="col-span-1 md:col-span-2 mt-4">
              <label htmlFor="observacoes" className="block text-sm font-medium text-gray-700 mb-1">
                Observações
              </label>
              <textarea
                id="observacoes"
                name="observacoes"
                rows={4}
                value={formData.observacoes || ''}
                onChange={handleChange}
                className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
              ></textarea>
            </div>
          </div>
          
          <div className="mt-8 flex justify-end">
            <button
              type="button"
              onClick={() => navigate('/crm/contatos')}
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

export default ContatosForm; 