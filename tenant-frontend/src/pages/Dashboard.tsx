import React, { useState, useEffect } from 'react';
import { FiUsers, FiShoppingCart, FiDollarSign, FiPackage, FiAlertCircle } from 'react-icons/fi';
import { Chart as ChartJS, CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip, Legend, BarElement } from 'chart.js';
import { Line, Bar } from 'react-chartjs-2';

// Registrar componentes do Chart.js
ChartJS.register(CategoryScale, LinearScale, PointElement, LineElement, BarElement, Title, Tooltip, Legend);

interface StatCardProps {
  title: string;
  value: string | number;
  icon: React.ReactNode;
  color: string;
}

const StatCard: React.FC<StatCardProps> = ({ title, value, icon, color }) => (
  <div className="flex items-center p-6 bg-white rounded-lg shadow-md">
    <div className={`p-3 rounded-full ${color} text-white`}>
      {icon}
    </div>
    <div className="mx-4">
      <h4 className="text-2xl font-semibold text-gray-700">{value}</h4>
      <div className="text-gray-500">{title}</div>
    </div>
  </div>
);

// Componente de gráfico de barras simples
const BarChart: React.FC<{ data: number[], labels: string[], title: string }> = ({ data, labels, title }) => {
  const maxValue = Math.max(...data) * 1.2;
  
  return (
    <div className="p-4 bg-white rounded-lg shadow-md">
      <h3 className="mb-4 text-lg font-semibold text-gray-700">{title}</h3>
      <div className="space-y-2">
        {data.map((value, index) => (
          <div key={index} className="flex items-center">
            <span className="w-20 text-xs text-gray-600">{labels[index]}</span>
            <div className="flex-1 ml-2">
              <div className="w-full bg-gray-200 rounded-full h-2.5">
                <div 
                  className="bg-blue-600 h-2.5 rounded-full" 
                  style={{ width: `${(value / maxValue) * 100}%` }}
                ></div>
              </div>
            </div>
            <span className="ml-2 text-xs font-medium text-gray-600">
              {value.toLocaleString('pt-BR')}
            </span>
          </div>
        ))}
      </div>
    </div>
  );
};

// Componente de gráfico de linha simples
const LineChart: React.FC<{ data: number[], labels: string[], title: string }> = ({ data, labels, title }) => {
  const maxValue = Math.max(...data) * 1.2;
  const points = data.map((value, index) => ({
    x: (index / (data.length - 1)) * 100,
    y: 100 - ((value / maxValue) * 100)
  }));
  
  // Criar o path para o SVG
  const pathData = points.map((point, index) => 
    (index === 0 ? 'M ' : 'L ') + point.x + ' ' + point.y
  ).join(' ');
  
  return (
    <div className="p-4 bg-white rounded-lg shadow-md">
      <h3 className="mb-4 text-lg font-semibold text-gray-700">{title}</h3>
      <div className="relative h-40">
        <svg className="w-full h-full overflow-visible">
          <path
            d={pathData}
            fill="none"
            stroke="#3b82f6"
            strokeWidth="2"
          />
          {points.map((point, index) => (
            <circle
              key={index}
              cx={point.x + '%'}
              cy={point.y + '%'}
              r="3"
              fill="#3b82f6"
            />
          ))}
        </svg>
        
        {/* Eixo X com labels */}
        <div className="absolute bottom-0 left-0 right-0 flex justify-between text-xs text-gray-500">
          {labels.map((label, index) => (
            <div key={index} style={{ left: `${(index / (labels.length - 1)) * 100}%` }} className="absolute transform -translate-x-1/2">
              {label}
            </div>
          ))}
        </div>
      </div>
    </div>
  );
};

const Dashboard: React.FC = () => {
  const [loading, setLoading] = useState<boolean>(true);
  const [stats, setStats] = useState({
    clientes: 0,
    produtos: 0,
    vendas: 0,
    receita: 0
  });
  
  const [vendasMensais, setVendasMensais] = useState<number[]>([]);
  const [produtosMaisVendidos, setProdutosMaisVendidos] = useState<{ nome: string, quantidade: number }[]>([]);
  
  useEffect(() => {
    // Simulando carregamento de dados
    const fetchData = async () => {
      try {
        // Simulando uma chamada de API
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        // Dados de exemplo
        setStats({
          clientes: 156,
          produtos: 89,
          vendas: 432,
          receita: 128750.90
        });
        
        setVendasMensais([12500, 15800, 14200, 18900, 21500, 19800]);
        
        setProdutosMaisVendidos([
          { nome: 'Notebook Pro', quantidade: 45 },
          { nome: 'Smartphone X', quantidade: 38 },
          { nome: 'Monitor 27"', quantidade: 29 },
          { nome: 'Teclado Mecânico', quantidade: 24 },
          { nome: 'Mouse Gamer', quantidade: 18 }
        ]);
      } catch (error) {
        console.error('Erro ao carregar dados do dashboard:', error);
      } finally {
        setLoading(false);
      }
    };
    
    fetchData();
  }, []);

  if (loading) {
    return (
      <div className="flex items-center justify-center h-full">
        <div className="w-16 h-16 border-t-4 border-b-4 border-blue-500 rounded-full animate-spin"></div>
      </div>
    );
  }

  return (
    <div>
      <h2 className="text-2xl font-semibold text-gray-800">Dashboard</h2>
      
      {/* Cards de estatísticas */}
      <div className="grid grid-cols-1 gap-6 mt-6 sm:grid-cols-2 lg:grid-cols-4">
        <StatCard 
          title="Clientes" 
          value={stats.clientes} 
          icon={<FiUsers className="w-6 h-6" />} 
          color="bg-blue-500" 
        />
        <StatCard 
          title="Vendas" 
          value={stats.vendas} 
          icon={<FiShoppingCart className="w-6 h-6" />} 
          color="bg-green-500" 
        />
        <StatCard 
          title="Receita" 
          value={stats.receita.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })} 
          icon={<FiDollarSign className="w-6 h-6" />} 
          color="bg-yellow-500" 
        />
        <StatCard 
          title="Produtos" 
          value={stats.produtos} 
          icon={<FiPackage className="w-6 h-6" />} 
          color="bg-purple-500" 
        />
      </div>

      {/* Gráficos */}
      <div className="grid grid-cols-1 gap-6 mt-8 lg:grid-cols-2">
        <LineChart 
          data={vendasMensais} 
          labels={['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun']} 
          title="Vendas Mensais (R$)"
        />
        
        <BarChart 
          data={produtosMaisVendidos.map(p => p.quantidade)} 
          labels={produtosMaisVendidos.map(p => p.nome)} 
          title="Produtos Mais Vendidos"
        />
      </div>

      {/* Alertas */}
      <div className="p-6 mt-8 bg-white rounded-lg shadow-md">
        <h3 className="text-lg font-semibold text-gray-700">Alertas Recentes</h3>
        <div className="mt-4">
          <div className="flex items-center p-4 bg-red-100 rounded-lg">
            <FiAlertCircle className="w-6 h-6 text-red-500" />
            <span className="ml-3 text-red-700">Estoque baixo para o produto "Notebook Dell XPS"</span>
          </div>
          <div className="flex items-center p-4 mt-2 bg-yellow-100 rounded-lg">
            <FiAlertCircle className="w-6 h-6 text-yellow-500" />
            <span className="ml-3 text-yellow-700">Fatura #1234 vence em 3 dias</span>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Dashboard; 