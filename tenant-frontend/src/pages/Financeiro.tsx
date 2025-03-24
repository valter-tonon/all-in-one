import React, { useState, useEffect } from 'react';
import { FiDollarSign, FiArrowUp, FiArrowDown, FiCalendar, FiFilter, FiDownload, FiPlusCircle } from 'react-icons/fi';

// Tipos
interface Transacao {
  id: number;
  descricao: string;
  valor: number;
  data: string;
  tipo: 'receita' | 'despesa';
  categoria: string;
  status: 'pendente' | 'pago' | 'atrasado';
}

interface Categoria {
  id: number;
  nome: string;
  tipo: 'receita' | 'despesa';
}

// Componente de card de resumo
const ResumoCard: React.FC<{ titulo: string; valor: number; icone: React.ReactNode; corIcone: string }> = ({ 
  titulo, valor, icone, corIcone 
}) => (
  <div className="p-6 bg-white rounded-lg shadow-md">
    <div className="flex items-center">
      <div className={`p-3 rounded-full ${corIcone}`}>
        {icone}
      </div>
      <div className="mx-4">
        <h4 className="text-2xl font-semibold text-gray-700">
          {valor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}
        </h4>
        <div className="text-gray-500">{titulo}</div>
      </div>
    </div>
  </div>
);

// Componente de tabela de transações
const TabelaTransacoes: React.FC<{ 
  transacoes: Transacao[]; 
  onDelete: (id: number) => void;
  onEdit: (transacao: Transacao) => void;
}> = ({ transacoes, onDelete, onEdit }) => {
  return (
    <div className="overflow-x-auto">
      <table className="min-w-full bg-white rounded-lg shadow-md">
        <thead>
          <tr className="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
            <th className="py-3 px-6 text-left">Descrição</th>
            <th className="py-3 px-6 text-left">Categoria</th>
            <th className="py-3 px-6 text-left">Data</th>
            <th className="py-3 px-6 text-right">Valor</th>
            <th className="py-3 px-6 text-center">Status</th>
            <th className="py-3 px-6 text-center">Ações</th>
          </tr>
        </thead>
        <tbody className="text-gray-600 text-sm">
          {transacoes.map((transacao) => (
            <tr key={transacao.id} className="border-b border-gray-200 hover:bg-gray-50">
              <td className="py-3 px-6 text-left whitespace-nowrap">
                {transacao.descricao}
              </td>
              <td className="py-3 px-6 text-left">{transacao.categoria}</td>
              <td className="py-3 px-6 text-left">{transacao.data}</td>
              <td className={`py-3 px-6 text-right ${transacao.tipo === 'receita' ? 'text-green-600' : 'text-red-600'}`}>
                {transacao.tipo === 'receita' ? '+' : '-'}
                {transacao.valor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}
              </td>
              <td className="py-3 px-6 text-center">
                <span className={`px-2 py-1 rounded-full text-xs ${
                  transacao.status === 'pago' 
                    ? 'bg-green-100 text-green-800' 
                    : transacao.status === 'pendente'
                      ? 'bg-yellow-100 text-yellow-800'
                      : 'bg-red-100 text-red-800'
                }`}>
                  {transacao.status === 'pago' 
                    ? 'Pago' 
                    : transacao.status === 'pendente'
                      ? 'Pendente'
                      : 'Atrasado'}
                </span>
              </td>
              <td className="py-3 px-6 text-center">
                <div className="flex item-center justify-center">
                  <button 
                    onClick={() => onEdit(transacao)}
                    className="w-4 mr-2 transform hover:text-blue-500 hover:scale-110"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                  </button>
                  <button 
                    onClick={() => onDelete(transacao.id)}
                    className="w-4 mr-2 transform hover:text-red-500 hover:scale-110"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                  </button>
                </div>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

// Componente de formulário de transação
const FormularioTransacao: React.FC<{
  transacao: Transacao | null;
  categorias: Categoria[];
  onSave: (transacao: Omit<Transacao, 'id'>) => void;
  onCancel: () => void;
}> = ({ transacao, categorias, onSave, onCancel }) => {
  const [form, setForm] = useState({
    descricao: transacao?.descricao || '',
    valor: transacao?.valor || 0,
    data: transacao?.data || new Date().toISOString().split('T')[0],
    tipo: transacao?.tipo || 'receita',
    categoria: transacao?.categoria || '',
    status: transacao?.status || 'pendente'
  });

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>) => {
    const { name, value } = e.target;
    setForm(prev => ({ ...prev, [name]: value }));
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    onSave({
      descricao: form.descricao,
      valor: Number(form.valor),
      data: form.data,
      tipo: form.tipo as 'receita' | 'despesa',
      categoria: form.categoria,
      status: form.status as 'pendente' | 'pago' | 'atrasado'
    });
  };

  return (
    <div className="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
      <div className="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
        <h3 className="text-lg font-semibold mb-4">
          {transacao ? 'Editar Transação' : 'Nova Transação'}
        </h3>
        <form onSubmit={handleSubmit}>
          <div className="mb-4">
            <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="tipo">
              Tipo
            </label>
            <select
              id="tipo"
              name="tipo"
              value={form.tipo}
              onChange={handleChange}
              className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            >
              <option value="receita">Receita</option>
              <option value="despesa">Despesa</option>
            </select>
          </div>
          <div className="mb-4">
            <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="descricao">
              Descrição
            </label>
            <input
              id="descricao"
              name="descricao"
              type="text"
              value={form.descricao}
              onChange={handleChange}
              className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required
            />
          </div>
          <div className="mb-4">
            <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="valor">
              Valor
            </label>
            <input
              id="valor"
              name="valor"
              type="number"
              step="0.01"
              value={form.valor}
              onChange={handleChange}
              className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required
            />
          </div>
          <div className="mb-4">
            <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="data">
              Data
            </label>
            <input
              id="data"
              name="data"
              type="date"
              value={form.data}
              onChange={handleChange}
              className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required
            />
          </div>
          <div className="mb-4">
            <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="categoria">
              Categoria
            </label>
            <select
              id="categoria"
              name="categoria"
              value={form.categoria}
              onChange={handleChange}
              className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required
            >
              <option value="">Selecione uma categoria</option>
              {categorias
                .filter(cat => cat.tipo === form.tipo)
                .map(cat => (
                  <option key={cat.id} value={cat.nome}>
                    {cat.nome}
                  </option>
                ))}
            </select>
          </div>
          <div className="mb-4">
            <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="status">
              Status
            </label>
            <select
              id="status"
              name="status"
              value={form.status}
              onChange={handleChange}
              className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            >
              <option value="pendente">Pendente</option>
              <option value="pago">Pago</option>
              <option value="atrasado">Atrasado</option>
            </select>
          </div>
          <div className="flex items-center justify-between">
            <button
              type="button"
              onClick={onCancel}
              className="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
            >
              Cancelar
            </button>
            <button
              type="submit"
              className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
            >
              Salvar
            </button>
          </div>
        </form>
      </div>
    </div>
  );
};

// Página principal de Financeiro
const Financeiro: React.FC = () => {
  const [transacoes, setTransacoes] = useState<Transacao[]>([]);
  const [categorias, setCategorias] = useState<Categoria[]>([]);
  const [filtroTipo, setFiltroTipo] = useState<'todos' | 'receita' | 'despesa'>('todos');
  const [filtroStatus, setFiltroStatus] = useState<'todos' | 'pendente' | 'pago' | 'atrasado'>('todos');
  const [transacaoAtual, setTransacaoAtual] = useState<Transacao | null>(null);
  const [mostrarFormulario, setMostrarFormulario] = useState(false);
  const [loading, setLoading] = useState(true);

  // Estatísticas financeiras
  const [resumo, setResumo] = useState({
    totalReceitas: 0,
    totalDespesas: 0,
    saldo: 0
  });

  useEffect(() => {
    // Simulando carregamento de dados
    const fetchData = async () => {
      try {
        // Simulando uma chamada de API
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        // Dados de exemplo - categorias
        const categoriasExemplo: Categoria[] = [
          { id: 1, nome: 'Vendas', tipo: 'receita' },
          { id: 2, nome: 'Serviços', tipo: 'receita' },
          { id: 3, nome: 'Investimentos', tipo: 'receita' },
          { id: 4, nome: 'Outros', tipo: 'receita' },
          { id: 5, nome: 'Fornecedores', tipo: 'despesa' },
          { id: 6, nome: 'Salários', tipo: 'despesa' },
          { id: 7, nome: 'Aluguel', tipo: 'despesa' },
          { id: 8, nome: 'Impostos', tipo: 'despesa' },
          { id: 9, nome: 'Utilidades', tipo: 'despesa' },
          { id: 10, nome: 'Marketing', tipo: 'despesa' },
        ];
        
        // Dados de exemplo - transações
        const transacoesExemplo: Transacao[] = [
          { 
            id: 1, 
            descricao: 'Venda de produtos', 
            valor: 5000, 
            data: '2023-06-15', 
            tipo: 'receita', 
            categoria: 'Vendas',
            status: 'pago'
          },
          { 
            id: 2, 
            descricao: 'Consultoria', 
            valor: 2500, 
            data: '2023-06-20', 
            tipo: 'receita', 
            categoria: 'Serviços',
            status: 'pago'
          },
          { 
            id: 3, 
            descricao: 'Pagamento de fornecedor', 
            valor: 1800, 
            data: '2023-06-10', 
            tipo: 'despesa', 
            categoria: 'Fornecedores',
            status: 'pago'
          },
          { 
            id: 4, 
            descricao: 'Aluguel do escritório', 
            valor: 3000, 
            data: '2023-07-05', 
            tipo: 'despesa', 
            categoria: 'Aluguel',
            status: 'pendente'
          },
          { 
            id: 5, 
            descricao: 'Impostos trimestrais', 
            valor: 4200, 
            data: '2023-06-30', 
            tipo: 'despesa', 
            categoria: 'Impostos',
            status: 'atrasado'
          },
          { 
            id: 6, 
            descricao: 'Contrato de serviço mensal', 
            valor: 3500, 
            data: '2023-07-10', 
            tipo: 'receita', 
            categoria: 'Serviços',
            status: 'pendente'
          },
        ];
        
        setCategorias(categoriasExemplo);
        setTransacoes(transacoesExemplo);
        
        // Calcular resumo
        const totalReceitas = transacoesExemplo
          .filter(t => t.tipo === 'receita')
          .reduce((sum, t) => sum + t.valor, 0);
          
        const totalDespesas = transacoesExemplo
          .filter(t => t.tipo === 'despesa')
          .reduce((sum, t) => sum + t.valor, 0);
          
        setResumo({
          totalReceitas,
          totalDespesas,
          saldo: totalReceitas - totalDespesas
        });
      } catch (error) {
        console.error('Erro ao carregar dados financeiros:', error);
      } finally {
        setLoading(false);
      }
    };
    
    fetchData();
  }, []);

  // Filtrar transações
  const transacoesFiltradas = transacoes.filter(t => {
    if (filtroTipo !== 'todos' && t.tipo !== filtroTipo) return false;
    if (filtroStatus !== 'todos' && t.status !== filtroStatus) return false;
    return true;
  });

  // Manipuladores de eventos
  const handleDelete = (id: number) => {
    setTransacoes(prev => prev.filter(t => t.id !== id));
    // Aqui você faria uma chamada à API para excluir a transação
  };

  const handleEdit = (transacao: Transacao) => {
    setTransacaoAtual(transacao);
    setMostrarFormulario(true);
  };

  const handleSave = (transacao: Omit<Transacao, 'id'>) => {
    if (transacaoAtual) {
      // Editar transação existente
      setTransacoes(prev => 
        prev.map(t => t.id === transacaoAtual.id ? { ...transacao, id: transacaoAtual.id } : t)
      );
    } else {
      // Adicionar nova transação
      const novaTransacao = {
        ...transacao,
        id: Math.max(0, ...transacoes.map(t => t.id)) + 1
      };
      setTransacoes(prev => [...prev, novaTransacao]);
    }
    
    // Recalcular resumo
    const novasTransacoes = transacaoAtual 
      ? transacoes.map(t => t.id === transacaoAtual.id ? { ...transacao, id: transacaoAtual.id } : t)
      : [...transacoes, { ...transacao, id: Math.max(0, ...transacoes.map(t => t.id)) + 1 }];
      
    const totalReceitas = novasTransacoes
      .filter(t => t.tipo === 'receita')
      .reduce((sum, t) => sum + t.valor, 0);
      
    const totalDespesas = novasTransacoes
      .filter(t => t.tipo === 'despesa')
      .reduce((sum, t) => sum + t.valor, 0);
      
    setResumo({
      totalReceitas,
      totalDespesas,
      saldo: totalReceitas - totalDespesas
    });
    
    setTransacaoAtual(null);
    setMostrarFormulario(false);
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
      <h2 className="text-2xl font-semibold text-gray-800">Gestão Financeira</h2>
      
      {/* Cards de resumo */}
      <div className="grid grid-cols-1 gap-6 mt-6 sm:grid-cols-3">
        <ResumoCard 
          titulo="Receitas" 
          valor={resumo.totalReceitas} 
          icone={<FiArrowUp className="w-6 h-6 text-white" />} 
          corIcone="bg-green-500" 
        />
        <ResumoCard 
          titulo="Despesas" 
          valor={resumo.totalDespesas} 
          icone={<FiArrowDown className="w-6 h-6 text-white" />} 
          corIcone="bg-red-500" 
        />
        <ResumoCard 
          titulo="Saldo" 
          valor={resumo.saldo} 
          icone={<FiDollarSign className="w-6 h-6 text-white" />} 
          corIcone={resumo.saldo >= 0 ? "bg-blue-500" : "bg-orange-500"} 
        />
      </div>
      
      {/* Filtros e ações */}
      <div className="flex flex-wrap items-center justify-between mt-8 mb-4">
        <div className="flex flex-wrap items-center space-x-4">
          <div className="flex items-center">
            <FiFilter className="mr-2 text-gray-600" />
            <select
              value={filtroTipo}
              onChange={(e) => setFiltroTipo(e.target.value as any)}
              className="p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              <option value="todos">Todos os tipos</option>
              <option value="receita">Receitas</option>
              <option value="despesa">Despesas</option>
            </select>
          </div>
          <div className="flex items-center mt-2 sm:mt-0">
            <FiCalendar className="mr-2 text-gray-600" />
            <select
              value={filtroStatus}
              onChange={(e) => setFiltroStatus(e.target.value as any)}
              className="p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              <option value="todos">Todos os status</option>
              <option value="pendente">Pendentes</option>
              <option value="pago">Pagos</option>
              <option value="atrasado">Atrasados</option>
            </select>
          </div>
        </div>
        <div className="flex space-x-2 mt-4 sm:mt-0">
          <button 
            onClick={() => {
              setTransacaoAtual(null);
              setMostrarFormulario(true);
            }}
            className="flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
          >
            <FiPlusCircle className="mr-2" />
            Nova Transação
          </button>
          <button className="flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
            <FiDownload className="mr-2" />
            Exportar
          </button>
        </div>
      </div>
      
      {/* Tabela de transações */}
      <div className="mt-4 bg-white rounded-lg shadow-md overflow-hidden">
        <TabelaTransacoes 
          transacoes={transacoesFiltradas} 
          onDelete={handleDelete}
          onEdit={handleEdit}
        />
      </div>
      
      {/* Formulário de transação (modal) */}
      {mostrarFormulario && (
        <FormularioTransacao 
          transacao={transacaoAtual}
          categorias={categorias}
          onSave={handleSave}
          onCancel={() => {
            setTransacaoAtual(null);
            setMostrarFormulario(false);
          }}
        />
      )}
    </div>
  );
};

export default Financeiro; 