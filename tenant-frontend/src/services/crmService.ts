import api from './api';

// Interfaces para o módulo CRM
export interface Cliente {
  id?: number;
  nome: string;
  email: string;
  telefone: string;
  empresa: string;
  cargo?: string;
  endereco?: string;
  cidade?: string;
  estado?: string;
  cep?: string;
  pais?: string;
  observacoes?: string;
  status: string;
}

export interface ClienteParams {
  page?: number;
  search?: string;
  status?: string;
  per_page?: number;
}

export interface Contato {
  id?: number;
  nome: string;
  email: string;
  telefone: string;
  cargo?: string;
  cliente_id: number;
  departamento?: string;
  observacoes?: string;
}

export interface Oportunidade {
  id?: number;
  titulo: string;
  cliente_id: number;
  valor: number;
  status: string;
  data_previsao?: string;
  descricao?: string;
}

export interface Atividade {
  id?: number;
  titulo: string;
  tipo: string;
  data: string;
  hora?: string;
  cliente_id?: number;
  contato_id?: number;
  oportunidade_id?: number;
  descricao?: string;
  status: string;
}

// Serviço para o módulo CRM
const crmService = {
  // Clientes
  async getClientes(pageOrParams: number | ClienteParams = 1, search = '', perPage = 10): Promise<{ data: Cliente[], total: number }> {
    let params;
    
    if (typeof pageOrParams === 'object') {
      params = pageOrParams;
    } else {
      params = {
        page: pageOrParams,
        search,
        per_page: perPage
      };
    }
    
    const response = await api.get('/crm/clientes', { params });
    return response.data;
  },

  async getClienteById(id: number): Promise<Cliente> {
    const response = await api.get(`/crm/clientes/${id}`);
    return response.data;
  },

  async createCliente(cliente: Cliente): Promise<Cliente> {
    const response = await api.post('/crm/clientes', cliente);
    return response.data;
  },

  async updateCliente(id: number, cliente: Cliente): Promise<Cliente> {
    const response = await api.put(`/crm/clientes/${id}`, cliente);
    return response.data;
  },

  async deleteCliente(id: number): Promise<void> {
    await api.delete(`/crm/clientes/${id}`);
  },

  // Contatos
  async getContatos(page = 1, search = '', perPage = 10): Promise<{ 
    data: Contato[], 
    total: number,
    meta: {
      current_page: number,
      last_page: number
    } 
  }> {
    const response = await api.get('/crm/contatos', {
      params: { page, search, per_page: perPage }
    });
    return response.data;
  },

  async getContatoById(id: number): Promise<Contato> {
    const response = await api.get(`/crm/contatos/${id}`);
    return response.data;
  },

  async createContato(contato: Contato): Promise<Contato> {
    const response = await api.post('/crm/contatos', contato);
    return response.data;
  },

  async updateContato(id: number, contato: Contato): Promise<Contato> {
    const response = await api.put(`/crm/contatos/${id}`, contato);
    return response.data;
  },

  async deleteContato(id: number): Promise<void> {
    await api.delete(`/crm/contatos/${id}`);
  },

  // Oportunidades
  async getOportunidades(page = 1, search = '', perPage = 10): Promise<{ 
    data: Oportunidade[], 
    total: number,
    meta: {
      current_page: number,
      last_page: number
    } 
  }> {
    const response = await api.get('/crm/oportunidades', {
      params: { page, search, per_page: perPage }
    });
    return response.data;
  },

  async getOportunidadeById(id: number): Promise<Oportunidade> {
    const response = await api.get(`/crm/oportunidades/${id}`);
    return response.data;
  },

  async createOportunidade(oportunidade: Oportunidade): Promise<Oportunidade> {
    const response = await api.post('/crm/oportunidades', oportunidade);
    return response.data;
  },

  async updateOportunidade(id: number, oportunidade: Oportunidade): Promise<Oportunidade> {
    const response = await api.put(`/crm/oportunidades/${id}`, oportunidade);
    return response.data;
  },

  async deleteOportunidade(id: number): Promise<void> {
    await api.delete(`/crm/oportunidades/${id}`);
  },

  // Atividades
  async getAtividades(page = 1, search = '', perPage = 10): Promise<{ 
    data: Atividade[], 
    total: number,
    meta: {
      current_page: number,
      last_page: number
    } 
  }> {
    const response = await api.get('/crm/atividades', {
      params: { page, search, per_page: perPage }
    });
    return response.data;
  },

  async getAtividadeById(id: number): Promise<Atividade> {
    const response = await api.get(`/crm/atividades/${id}`);
    return response.data;
  },

  async createAtividade(atividade: Atividade): Promise<Atividade> {
    const response = await api.post('/crm/atividades', atividade);
    return response.data;
  },

  async updateAtividade(id: number, atividade: Atividade): Promise<Atividade> {
    const response = await api.put(`/crm/atividades/${id}`, atividade);
    return response.data;
  },

  async deleteAtividade(id: number): Promise<void> {
    await api.delete(`/crm/atividades/${id}`);
  },

  // Dashboard CRM
  async getDashboardData(): Promise<any> {
    const response = await api.get('/crm/dashboard');
    return response.data;
  }
};

export default crmService; 