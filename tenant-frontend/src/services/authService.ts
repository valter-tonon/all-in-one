import api from './api';

interface LoginCredentials {
  email: string;
  password: string;
}

interface AuthResponse {
  token: string;
  user: {
    id: number;
    name: string;
    email: string;
    role: string;
  };
}

const authService = {
  // Função para realizar login
  async login(credentials: LoginCredentials): Promise<AuthResponse> {
    try {
      const response = await api.post<AuthResponse>('/auth/login', credentials);
      
      // Armazenar token e informações do usuário no localStorage
      localStorage.setItem('token', response.data.token);
      localStorage.setItem('user', JSON.stringify(response.data.user));
      
      return response.data;
    } catch (error) {
      throw error;
    }
  },

  // Função para realizar logout
  logout(): void {
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    window.location.href = '/login';
  },

  // Função para verificar se o usuário está autenticado
  isAuthenticated(): boolean {
    const token = localStorage.getItem('token');
    return !!token;
  },

  // Função para obter o usuário atual
  getCurrentUser(): any {
    const user = localStorage.getItem('user');
    return user ? JSON.parse(user) : null;
  },

  // Função para verificar se o token ainda é válido
  async checkTokenValidity(): Promise<boolean> {
    try {
      await api.get('/auth/check');
      return true;
    } catch (error) {
      this.logout();
      return false;
    }
  }
};

export default authService; 