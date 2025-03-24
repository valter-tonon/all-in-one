import React, { useState, useEffect } from 'react';
import { FiDownload, FiFilter, FiCalendar, FiBarChart2, FiPieChart, FiTrendingUp, FiDollarSign } from 'react-icons/fi';

// Tipos
interface DadosVendas {
  periodo: string;
  valor: number;
}

interface DadosProduto {
  nome: string;
  quantidade: number;
  valor: number;
}

interface DadosCliente {
  nome: string;
  compras: number;
  valor: number;
}

// Componente de gráfico de barras simples
const GraficoBarras: React.FC<{ dados: { label: string; valor: number }[]; titulo: string; corBarra?: string }> = ({ 
  dados, titulo, corBarra = 'bg-blue-500' 
}) => {
  const maxValor = Math.max(...dados.map(d => d.valor)) * 1.2 || 1;
  
  return (
    <div className="p-6 bg-white rounded-lg shadow-md">
      <h3 className="text-lg font-semibold text-gray-700 mb-4">{titulo}</h3>
      <div className="space-y-3">
        {dados.map((item, index) => (
          <div key={index} className="flex items-center">
            <span className="w-24 text-xs text-gray-600 truncate">{item.label}</span>
            <div className="flex-1 ml-2">
              <div className="w-full bg-gray-200 rounded-full h-2.5">
                <div 
                  className={`${corBarra} h-2.5 rounded-full`} 
                  style={{ width: `${(item.valor / maxValor) * 100}%` }}
                ></div>
              </div>
            </div>
            <span className="ml-2 text-xs font-medium text-gray-600 w-16 text-right">
              {item.valor.toLocaleString('pt-BR')}
            </span>
          </div>
        ))}
      </div>
    </div>
  );
};

// Componente de gráfico de linha simples
const GraficoLinha: React.FC<{ dados: { label: string; valor: number }[]; titulo: string }> = ({ 
  dados, titulo 
}) => {
  const maxValor = Math.max(...dados.map(d => d.valor)) * 1.2 || 1;
  const pontos = dados.map((item, index) => ({
    x: (index / (dados.length - 1 || 1)) * 100,
    y: 100 - ((item.valor / maxValor) * 100)
  }));
  
  // Criar o path para o SVG
  const pathData = pontos.map((ponto, index) => 
    (index === 0 ? 'M ' : 'L ') + ponto.x + ' ' + ponto.y
  ).join(' ');
  
  return (
    <div className="p-6 bg-white rounded-lg shadow-md">
      <h3 className="text-lg font-semibold text-gray-700 mb-4">{titulo}</h3>
      <div className="relative h-48">
        <svg className="w-full h-full overflow-visible">
          <path
            d={pathData}
            fill="none"
            stroke="#3b82f6"
            strokeWidth="2"
          />
          {pontos.map((ponto, index) => (
            <circle
              key={index}
              cx={ponto.x + '%'}
              cy={ponto.y + '%'}
              r="3"
              fill="#3b82f6"
            />
          ))}
        </svg>
        
        {/* Eixo X com labels */}
        <div className="absolute bottom-0 left-0 right-0 flex justify-between text-xs text-gray-500">
          {dados.map((item, index) => (
            <div key={index} style={{ left: `${(index / (dados.length - 1 || 1)) * 100}%` }} className="absolute transform -translate-x-1/2">
              {item.label}
            </div>
          ))}
        </div>
      </div>
    </div>
  );
};

// Componente de gráfico de pizza simples
const GraficoPizza: React.FC<{ dados: { label: string; valor: number; cor: string }[]; titulo: string }> = ({ 
  dados, titulo 
}) => {
  const total = dados.reduce((sum, item) => sum + item.valor, 0);
  let anguloAtual = 0;
  
  return (
    <div className="p-6 bg-white rounded-lg shadow-md">
      <h3 className="text-lg font-semibold text-gray-700 mb-4">{titulo}</h3>
      <div className="flex items-center justify-center">
        <div className="relative w-48 h-48">
          <svg viewBox="0 0 100 100" className="w-full h-full">
            {dados.map((item, index) => {
              const percentual = item.valor / total;
              const angulo = percentual * 360;
              
              // Calcular pontos do arco
              const x1 = 50 + 40 * Math.cos((anguloAtual * Math.PI) / 180);
              const y1 = 50 + 40 * Math.sin((anguloAtual * Math.PI) / 180);
              
              anguloAtual += angulo;
              
              const x2 = 50 + 40 * Math.cos((anguloAtual * Math.PI) / 180);
              const y2 = 50 + 40 * Math.sin((anguloAtual * Math.PI) / 180);
              
              // Determinar se o arco é maior que 180 graus
              const largeArcFlag = angulo > 180 ? 1 : 0;
              
              // Criar o path para o SVG
              const path = `M 50 50 L ${x1} ${y1} A 40 40 0 ${largeArcFlag} 1 ${x2} ${y2} Z`;
              
              return (
                <path
                  key={index}
                  d={path}
                  fill={item.cor}
                  stroke="#fff"
                  strokeWidth="1"
                />
              );
            })}
          </svg>
        </div>
        
        <div className="ml-6 space-y-2">
          {dados.map((item, index) => (
            <div key={index} className="flex items-center">
              <div className="w-3 h-3 mr-2" style={{ backgroundColor: item.cor }}></div>
              <span className="text-xs text-gray-600">{item.label} ({((item.valor / total) * 100).toFixed(1)}%)</span>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
};

// Componente de tabela de dados
const TabelaDados: React.FC<{ 
  dados: any[]; 
  colunas: { chave: string; titulo: string; formato?: (valor: any) => string }[];
  titulo: string;
}> = ({ dados, colunas, titulo }) => {
  return (
    <div className="bg-white rounded-lg shadow-md overflow-hidden">
      <div className="p-4 border-b">
        <h3 className="text-lg font-semibold text-gray-700">{titulo}</h3>
      </div>
      <div className="overflow-x-auto">
        <table className="min-w-full">
          <thead>
            <tr className="bg-gray-100 text-gray-600 uppercase text-xs leading-normal">
              {colunas.map((coluna, index) => (
                <th key={index} className="py-3 px-6 text-left">
                  {coluna.titulo}
                </th>
              ))}
            </tr>
          </thead>
          <tbody className="text-gray-600 text-sm">
            {dados.map((item, rowIndex) => (
              <tr key={rowIndex} className="border-b border-gray-200 hover:bg-gray-50">
                {colunas.map((coluna, colIndex) => (
                  <td key={colIndex} className="py-3 px-6 text-left">
                    {coluna.formato ? coluna.formato(item[coluna.chave]) : item[coluna.chave]}
                  </td>
                ))}
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </div>
  );
};

// Componente de card de estatística
const CardEstatistica: React.FC<{ 
  titulo: string; 
  valor: string | number; 
  descricao?: string;
  icone: React.ReactNode;
  corIcone: string;
}> = ({ titulo, valor, descricao, icone, corIcone }) => (
  <div className="p-6 bg-white rounded-lg shadow-md">
    <div className="flex items-center">
      <div className={`p-3 rounded-full ${corIcone}`}>
        {icone}
      </div>
      <div className="mx-4">
        <h4 className="text-2xl font-semibold text-gray-700">{valor}</h4>
        <div className="text-gray-500">{titulo}</div>
        {descricao && <div className="text-xs text-gray-400 mt-1">{descricao}</div>}
      </div>
    </div>
  </div>
);

// Página principal de Relatórios
const Relatorios: React.FC = () => {
  const [periodoSelecionado, setPeriodoSelecionado] = useState<'7dias' | '30dias' | '90dias' | '12meses'>('30dias');
  const [tipoRelatorio, setTipoRelatorio] = useState<'vendas' | 'produtos' | 'clientes'>('vendas');
  const [loading, setLoading] = useState(true);
  
  // Estados para os dados
  const [dadosVendas, setDadosVendas] = useState<DadosVendas[]>([]);
  const [dadosProdutos, setDadosProdutos] = useState<DadosProduto[]>([]);
  const [dadosClientes, setDadosClientes] = useState<DadosCliente[]>([]);
  
  // Estatísticas gerais
  const [estatisticas, setEstatisticas] = useState({
    totalVendas: 0,
    ticketMedio: 0,
    taxaConversao: 0,
    crescimento: 0
  });

  useEffect(() => {
    // Simulando carregamento de dados
    const fetchData = async () => {
      setLoading(true);
      try {
        // Simulando uma chamada de API
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        // Dados de exemplo para vendas
        let vendasExemplo: DadosVendas[] = [];
        if (periodoSelecionado === '7dias') {
          vendasExemplo = [
            { periodo: 'Seg', valor: 1200 },
            { periodo: 'Ter', valor: 1800 },
            { periodo: 'Qua', valor: 1500 },
            { periodo: 'Qui', valor: 2200 },
            { periodo: 'Sex', valor: 2800 },
            { periodo: 'Sáb', valor: 1900 },
            { periodo: 'Dom', valor: 1100 }
          ];
        } else if (periodoSelecionado === '30dias') {
          vendasExemplo = Array.from({ length: 4 }, (_, i) => ({
            periodo: `Semana ${i + 1}`,
            valor: Math.floor(Math.random() * 10000) + 5000
          }));
        } else if (periodoSelecionado === '90dias') {
          vendasExemplo = Array.from({ length: 3 }, (_, i) => ({
            periodo: `Mês ${i + 1}`,
            valor: Math.floor(Math.random() * 30000) + 15000
          }));
        } else {
          vendasExemplo = [
            { periodo: 'Jan', valor: 25000 },
            { periodo: 'Fev', valor: 28000 },
            { periodo: 'Mar', valor: 32000 },
            { periodo: 'Abr', valor: 30000 },
            { periodo: 'Mai', valor: 35000 },
            { periodo: 'Jun', valor: 42000 },
            { periodo: 'Jul', valor: 38000 },
            { periodo: 'Ago', valor: 40000 },
            { periodo: 'Set', valor: 45000 },
            { periodo: 'Out', valor: 48000 },
            { periodo: 'Nov', valor: 52000 },
            { periodo: 'Dez', valor: 60000 }
          ];
        }
        
        // Dados de exemplo para produtos
        const produtosExemplo: DadosProduto[] = [
          { nome: 'Notebook Pro', quantidade: 45, valor: 135000 },
          { nome: 'Smartphone X', quantidade: 78, valor: 117000 },
          { nome: 'Monitor 27"', quantidade: 36, valor: 43200 },
          { nome: 'Teclado Mecânico', quantidade: 52, valor: 15600 },
          { nome: 'Mouse Gamer', quantidade: 64, valor: 12800 },
          { nome: 'Headset Wireless', quantidade: 29, valor: 14500 },
          { nome: 'Tablet 10"', quantidade: 22, valor: 33000 },
          { nome: 'Câmera DSLR', quantidade: 18, valor: 54000 },
          { nome: 'Impressora Laser', quantidade: 15, valor: 22500 },
          { nome: 'SSD 1TB', quantidade: 41, valor: 20500 }
        ];
        
        // Dados de exemplo para clientes
        const clientesExemplo: DadosCliente[] = [
          { nome: 'Empresa ABC Ltda', compras: 12, valor: 48000 },
          { nome: 'Comércio XYZ', compras: 8, valor: 32000 },
          { nome: 'Indústria 123', compras: 15, valor: 75000 },
          { nome: 'Distribuidora Fast', compras: 6, valor: 18000 },
          { nome: 'Supermercado Big', compras: 10, valor: 40000 },
          { nome: 'Farmácia Saúde', compras: 5, valor: 15000 },
          { nome: 'Escola Futuro', compras: 3, valor: 9000 },
          { nome: 'Hospital Central', compras: 7, valor: 35000 },
          { nome: 'Restaurante Gourmet', compras: 4, valor: 12000 },
          { nome: 'Construtora Sólida', compras: 9, valor: 54000 }
        ];
        
        // Estatísticas gerais
        const estatisticasExemplo = {
          totalVendas: vendasExemplo.reduce((sum, item) => sum + item.valor, 0),
          ticketMedio: Math.floor(vendasExemplo.reduce((sum, item) => sum + item.valor, 0) / 
                      produtosExemplo.reduce((sum, item) => sum + item.quantidade, 0)),
          taxaConversao: 28.5,
          crescimento: 15.7
        };
        
        setDadosVendas(vendasExemplo);
        setDadosProdutos(produtosExemplo);
        setDadosClientes(clientesExemplo);
        setEstatisticas(estatisticasExemplo);
      } catch (error) {
        console.error('Erro ao carregar dados dos relatórios:', error);
      } finally {
        setLoading(false);
      }
    };
    
    fetchData();
  }, [periodoSelecionado]);

  // Preparar dados para os gráficos
  const dadosGraficoVendas = dadosVendas.map(item => ({
    label: item.periodo,
    valor: item.valor
  }));
  
  const dadosGraficoProdutos = dadosProdutos
    .sort((a, b) => b.valor - a.valor)
    .slice(0, 5)
    .map(item => ({
      label: item.nome,
      valor: item.valor
    }));
  
  const dadosGraficoClientes = dadosClientes
    .sort((a, b) => b.valor - a.valor)
    .slice(0, 5)
    .map(item => ({
      label: item.nome,
      valor: item.valor
    }));
  
  const dadosGraficoPizza = [
    { label: 'Notebooks', valor: 135000, cor: '#3b82f6' },
    { label: 'Smartphones', valor: 117000, cor: '#10b981' },
    { label: 'Monitores', valor: 43200, cor: '#f59e0b' },
    { label: 'Acessórios', valor: 28400, cor: '#ef4444' },
    { label: 'Outros', valor: 130000, cor: '#8b5cf6' }
  ];

  if (loading) {
    return (
      <div className="flex items-center justify-center h-full">
        <div className="w-16 h-16 border-t-4 border-b-4 border-blue-500 rounded-full animate-spin"></div>
      </div>
    );
  }

  return (
    <div>
      <h2 className="text-2xl font-semibold text-gray-800">Relatórios</h2>
      
      {/* Filtros e seleção de período */}
      <div className="flex flex-wrap items-center justify-between mt-6 mb-8">
        <div className="flex flex-wrap items-center space-x-4">
          <div className="flex items-center">
            <FiBarChart2 className="mr-2 text-gray-600" />
            <select
              value={tipoRelatorio}
              onChange={(e) => setTipoRelatorio(e.target.value as any)}
              className="p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              <option value="vendas">Relatório de Vendas</option>
              <option value="produtos">Relatório de Produtos</option>
              <option value="clientes">Relatório de Clientes</option>
            </select>
          </div>
          <div className="flex items-center mt-2 sm:mt-0">
            <FiCalendar className="mr-2 text-gray-600" />
            <select
              value={periodoSelecionado}
              onChange={(e) => setPeriodoSelecionado(e.target.value as any)}
              className="p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              <option value="7dias">Últimos 7 dias</option>
              <option value="30dias">Últimos 30 dias</option>
              <option value="90dias">Últimos 90 dias</option>
              <option value="12meses">Últimos 12 meses</option>
            </select>
          </div>
        </div>
        <button className="flex items-center px-4 py-2 mt-4 sm:mt-0 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
          <FiDownload className="mr-2" />
          Exportar Relatório
        </button>
      </div>
      
      {/* Cards de estatísticas */}
      <div className="grid grid-cols-1 gap-6 mb-8 sm:grid-cols-2 lg:grid-cols-4">
        <CardEstatistica 
          titulo="Total de Vendas" 
          valor={estatisticas.totalVendas.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })} 
          icone={<FiBarChart2 className="w-6 h-6 text-white" />} 
          corIcone="bg-blue-500" 
        />
        <CardEstatistica 
          titulo="Ticket Médio" 
          valor={estatisticas.ticketMedio.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })} 
          icone={<FiDollarSign className="w-6 h-6 text-white" />} 
          corIcone="bg-green-500" 
        />
        <CardEstatistica 
          titulo="Taxa de Conversão" 
          valor={`${estatisticas.taxaConversao}%`} 
          descricao="Visitas que resultaram em vendas"
          icone={<FiPieChart className="w-6 h-6 text-white" />} 
          corIcone="bg-yellow-500" 
        />
        <CardEstatistica 
          titulo="Crescimento" 
          valor={`${estatisticas.crescimento}%`} 
          descricao="Em relação ao período anterior"
          icone={<FiTrendingUp className="w-6 h-6 text-white" />} 
          corIcone="bg-purple-500" 
        />
      </div>
      
      {/* Conteúdo específico para cada tipo de relatório */}
      {tipoRelatorio === 'vendas' && (
        <>
          <div className="grid grid-cols-1 gap-6 mb-8 lg:grid-cols-2">
            <GraficoLinha 
              dados={dadosGraficoVendas} 
              titulo={`Vendas por ${periodoSelecionado === '7dias' ? 'Dia' : 
                periodoSelecionado === '30dias' ? 'Semana' : 
                periodoSelecionado === '90dias' ? 'Mês' : 'Mês'}`} 
            />
            <GraficoPizza 
              dados={dadosGraficoPizza} 
              titulo="Vendas por Categoria" 
            />
          </div>
          
          <TabelaDados 
            dados={dadosVendas} 
            colunas={[
              { chave: 'periodo', titulo: 'Período' },
              { 
                chave: 'valor', 
                titulo: 'Valor', 
                formato: (valor) => valor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }) 
              }
            ]}
            titulo="Detalhamento de Vendas por Período"
          />
        </>
      )}
      
      {tipoRelatorio === 'produtos' && (
        <>
          <div className="grid grid-cols-1 gap-6 mb-8 lg:grid-cols-2">
            <GraficoBarras 
              dados={dadosGraficoProdutos} 
              titulo="Produtos Mais Vendidos (por valor)" 
              corBarra="bg-green-500"
            />
            <GraficoBarras 
              dados={dadosProdutos.sort((a, b) => b.quantidade - a.quantidade).slice(0, 5).map(item => ({
                label: item.nome,
                valor: item.quantidade
              }))} 
              titulo="Produtos Mais Vendidos (por quantidade)" 
              corBarra="bg-blue-500"
            />
          </div>
          
          <TabelaDados 
            dados={dadosProdutos} 
            colunas={[
              { chave: 'nome', titulo: 'Produto' },
              { chave: 'quantidade', titulo: 'Quantidade' },
              { 
                chave: 'valor', 
                titulo: 'Valor Total', 
                formato: (valor) => valor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }) 
              }
            ]}
            titulo="Detalhamento de Vendas por Produto"
          />
        </>
      )}
      
      {tipoRelatorio === 'clientes' && (
        <>
          <div className="grid grid-cols-1 gap-6 mb-8 lg:grid-cols-2">
            <GraficoBarras 
              dados={dadosGraficoClientes} 
              titulo="Clientes com Maior Valor em Compras" 
              corBarra="bg-purple-500"
            />
            <GraficoBarras 
              dados={dadosClientes.sort((a, b) => b.compras - a.compras).slice(0, 5).map(item => ({
                label: item.nome,
                valor: item.compras
              }))} 
              titulo="Clientes com Maior Número de Compras" 
              corBarra="bg-yellow-500"
            />
          </div>
          
          <TabelaDados 
            dados={dadosClientes} 
            colunas={[
              { chave: 'nome', titulo: 'Cliente' },
              { chave: 'compras', titulo: 'Número de Compras' },
              { 
                chave: 'valor', 
                titulo: 'Valor Total', 
                formato: (valor) => valor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }) 
              }
            ]}
            titulo="Detalhamento de Compras por Cliente"
          />
        </>
      )}
    </div>
  );
};

export default Relatorios; 