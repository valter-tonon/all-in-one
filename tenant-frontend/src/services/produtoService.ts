import api from './api';

export interface Produto {
  id?: number;
  nome: string;
  sku: string;
  preco: number;
  estoque: number;
  estoqueMinimo: number;
  categoria: string;
  status: string;
  descricao?: string;
  imagem?: string;
  fornecedor_id?: number;
  unidade?: string;
  peso?: number;
  dimensoes?: {
    altura: number;
    largura: number;
    comprimento: number;
  };
}

export interface ProdutoParams {
  page?: number;
  perPage?: number;
  search?: string;
  categoria?: string;
  status?: string;
  orderBy?: string;
  order?: 'asc' | 'desc';
}

export interface ApiResponse<T> {
  data: T;
  meta?: {
    current_page: number;
    from: number;
    last_page: number;
    path: string;
    per_page: number;
    to: number;
    total: number;
  };
  links?: {
    first: string;
    last: string;
    prev: string | null;
    next: string | null;
  };
}

const produtoService = {
  // Listar produtos
  getProdutos: async (params: ProdutoParams = {}): Promise<ApiResponse<Produto[]>> => {
    try {
      const response = await api.get('/produtos', { params });
      return response.data;
    } catch (error) {
      console.error('Erro ao buscar produtos:', error);
      throw error;
    }
  },

  // Obter produto por ID
  getProdutoById: async (id: number): Promise<Produto> => {
    try {
      const response = await api.get(`/produtos/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Erro ao buscar produto ${id}:`, error);
      throw error;
    }
  },

  // Criar produto
  createProduto: async (produto: Produto): Promise<Produto> => {
    try {
      const response = await api.post('/produtos', produto);
      return response.data;
    } catch (error) {
      console.error('Erro ao criar produto:', error);
      throw error;
    }
  },

  // Atualizar produto
  updateProduto: async (id: number, produto: Produto): Promise<Produto> => {
    try {
      const response = await api.put(`/produtos/${id}`, produto);
      return response.data;
    } catch (error) {
      console.error(`Erro ao atualizar produto ${id}:`, error);
      throw error;
    }
  },

  // Excluir produto
  deleteProduto: async (id: number | undefined): Promise<void> => {
    if (!id) {
      throw new Error('ID do produto não fornecido');
    }
    
    try {
      const response = await api.delete(`/produtos/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Erro ao excluir produto ${id}:`, error);
      throw error;
    }
  },

  // Obter produtos com estoque baixo
  getLowStockProdutos: async (): Promise<ApiResponse<Produto[]>> => {
    try {
      const response = await api.get('/produtos/low-stock');
      return response.data;
    } catch (error) {
      console.error('Erro ao buscar produtos com estoque baixo:', error);
      throw error;
    }
  },

  // Obter produtos sem estoque
  getOutOfStockProdutos: async (): Promise<ApiResponse<Produto[]>> => {
    try {
      const response = await api.get('/produtos/out-of-stock');
      return response.data;
    } catch (error) {
      console.error('Erro ao buscar produtos sem estoque:', error);
      throw error;
    }
  },

  // Obter categorias de produtos
  getCategorias: async (): Promise<ApiResponse<string[]>> => {
    try {
      const response = await api.get('/produtos/categorias');
      return response.data;
    } catch (error) {
      console.error('Erro ao buscar categorias:', error);
      throw error;
    }
  }
};

export default produtoService; 