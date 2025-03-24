import React, { useState, useEffect } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { Form, Input, Button, Card, Select, DatePicker, message, Spin } from 'antd';
import { SaveOutlined, ArrowLeftOutlined } from '@ant-design/icons';
import api from '../../services/api';
import { PageHeader } from '../../components/PageHeader';
import moment from 'moment';

const { Option } = Select;
const { TextArea } = Input;
const { RangePicker } = DatePicker;

// Usando Record para satisfazer a restrição do useParams
type ParamTypes = Record<string, string | undefined>;

const AtividadesForm: React.FC = () => {
  const [form] = Form.useForm();
  const { id } = useParams<ParamTypes>();
  const navigate = useNavigate();
  const [loading, setLoading] = useState<boolean>(false);
  const [clientes, setClientes] = useState<any[]>([]);
  const [contatos, setContatos] = useState<any[]>([]);
  const [oportunidades, setOportunidades] = useState<any[]>([]);
  const [clienteSelecionado, setClienteSelecionado] = useState<number | null>(null);
  const [submitting, setSubmitting] = useState<boolean>(false);

  const isEdicao = !!id;

  useEffect(() => {
    fetchClientes();
    fetchOportunidades();
    
    if (isEdicao) {
      fetchAtividade();
    }
  }, [id]);

  useEffect(() => {
    if (clienteSelecionado) {
      fetchContatosPorCliente(clienteSelecionado);
    } else {
      setContatos([]);
    }
  }, [clienteSelecionado]);

  const fetchClientes = async () => {
    try {
      // Quando a API estiver pronta, descomentar a linha abaixo
      // const response = await api.get('/api/clientes');
      // setClientes(response.data);
      
      // Dados de exemplo para evitar erros enquanto a API não está pronta
      setClientes([
        { id: 1, nome: 'Empresa ABC' },
        { id: 2, nome: 'Empresa XYZ' }
      ]);
    } catch (error) {
      console.error('Erro ao buscar clientes:', error);
      message.error('Não foi possível carregar a lista de clientes');
    }
  };

  const fetchContatosPorCliente = async (clienteId: number) => {
    try {
      // Quando a API estiver pronta, descomentar a linha abaixo
      // const response = await api.get(`/api/clientes/${clienteId}/contatos`);
      // setContatos(response.data);
      
      // Dados de exemplo para evitar erros enquanto a API não está pronta
      setContatos([
        { id: 1, nome: 'João Silva', cliente_id: 1 },
        { id: 2, nome: 'Maria Oliveira', cliente_id: 1 },
        { id: 3, nome: 'Carlos Santos', cliente_id: 2 }
      ].filter(contato => contato.cliente_id === clienteId));
    } catch (error) {
      console.error('Erro ao buscar contatos:', error);
      message.error('Não foi possível carregar a lista de contatos');
    }
  };

  const fetchOportunidades = async () => {
    try {
      // Quando a API estiver pronta, descomentar a linha abaixo
      // const response = await api.get('/api/oportunidades');
      // setOportunidades(response.data);
      
      // Dados de exemplo para evitar erros enquanto a API não está pronta
      setOportunidades([
        { id: 1, titulo: 'Venda de Software', cliente_id: 1 },
        { id: 2, titulo: 'Implementação de Sistema', cliente_id: 2 }
      ]);
    } catch (error) {
      console.error('Erro ao buscar oportunidades:', error);
      message.error('Não foi possível carregar a lista de oportunidades');
    }
  };

  const fetchAtividade = async () => {
    try {
      setLoading(true);
      // Quando a API estiver pronta, descomentar a linha abaixo
      // const response = await api.get(`/api/atividades/${id}`);
      // const atividade = response.data;
      
      // Dados de exemplo para evitar erros enquanto a API não está pronta
      const atividade = {
        id: 1,
        titulo: 'Ligação de acompanhamento',
        tipo: 'Ligação',
        status: 'Pendente',
        data_inicio: '2023-03-15T10:00:00',
        data_fim: '2023-03-15T10:30:00',
        cliente_id: 1,
        contato_id: 1,
        oportunidade_id: 1,
        descricao: 'Ligar para verificar interesse no produto'
      };
      
      setClienteSelecionado(atividade.cliente_id);
      
      form.setFieldsValue({
        ...atividade,
        periodo: [
          moment(atividade.data_inicio),
          moment(atividade.data_fim)
        ]
      });
      
      setLoading(false);
    } catch (error) {
      console.error('Erro ao buscar atividade:', error);
      message.error('Não foi possível carregar os dados da atividade');
      setLoading(false);
      navigate('/crm/atividades');
    }
  };

  const handleSubmit = async (values: any) => {
    try {
      setSubmitting(true);
      
      const dadosAtividade = {
        ...values,
        data_inicio: values.periodo[0].format(),
        data_fim: values.periodo[1].format(),
      };
      
      delete dadosAtividade.periodo;
      
      if (isEdicao) {
        // Quando a API estiver pronta, descomentar a linha abaixo
        // await api.put(`/api/atividades/${id}`, dadosAtividade);
        message.success('Atividade atualizada com sucesso');
      } else {
        // Quando a API estiver pronta, descomentar a linha abaixo
        // await api.post('/api/atividades', dadosAtividade);
        message.success('Atividade criada com sucesso');
      }
      
      navigate('/crm/atividades');
    } catch (error) {
      console.error('Erro ao salvar atividade:', error);
      message.error('Não foi possível salvar a atividade');
    } finally {
      setSubmitting(false);
    }
  };

  const handleClienteChange = (value: number) => {
    setClienteSelecionado(value);
    form.setFieldsValue({ contato_id: undefined, oportunidade_id: undefined });
  };

  return (
    <div>
      <PageHeader
        title={isEdicao ? 'Editar Atividade' : 'Nova Atividade'}
        subtitle={isEdicao ? 'Atualize os dados da atividade' : 'Cadastre uma nova atividade'}
        onBack={() => navigate('/crm/atividades')}
        backIcon={<ArrowLeftOutlined />}
      />

      <Card>
        {loading ? (
          <div style={{ textAlign: 'center', padding: '50px' }}>
            <Spin size="large" />
          </div>
        ) : (
          <Form
            form={form}
            layout="vertical"
            onFinish={handleSubmit}
            initialValues={{
              status: 'Pendente',
              tipo: 'Ligação'
            }}
          >
            <Form.Item
              name="titulo"
              label="Título"
              rules={[{ required: true, message: 'Por favor, informe o título da atividade' }]}
            >
              <Input placeholder="Título da atividade" />
            </Form.Item>

            <Form.Item
              name="tipo"
              label="Tipo"
              rules={[{ required: true, message: 'Por favor, selecione o tipo da atividade' }]}
            >
              <Select placeholder="Selecione o tipo">
                <Option value="Ligação">Ligação</Option>
                <Option value="Reunião">Reunião</Option>
                <Option value="E-mail">E-mail</Option>
                <Option value="Visita">Visita</Option>
                <Option value="Outro">Outro</Option>
              </Select>
            </Form.Item>

            <Form.Item
              name="status"
              label="Status"
              rules={[{ required: true, message: 'Por favor, selecione o status da atividade' }]}
            >
              <Select placeholder="Selecione o status">
                <Option value="Pendente">Pendente</Option>
                <Option value="Em andamento">Em andamento</Option>
                <Option value="Concluída">Concluída</Option>
                <Option value="Cancelada">Cancelada</Option>
                <Option value="Atrasada">Atrasada</Option>
              </Select>
            </Form.Item>

            <Form.Item
              name="periodo"
              label="Período"
              rules={[{ required: true, message: 'Por favor, informe o período da atividade' }]}
            >
              <RangePicker
                showTime
                format="DD/MM/YYYY HH:mm"
                placeholder={['Data/hora início', 'Data/hora fim']}
                style={{ width: '100%' }}
              />
            </Form.Item>

            <Form.Item
              name="cliente_id"
              label="Cliente"
              rules={[{ required: true, message: 'Por favor, selecione o cliente' }]}
            >
              <Select 
                placeholder="Selecione o cliente"
                onChange={handleClienteChange}
              >
                {clientes.map(cliente => (
                  <Option key={cliente.id} value={cliente.id}>{cliente.nome}</Option>
                ))}
              </Select>
            </Form.Item>

            <Form.Item
              name="contato_id"
              label="Contato"
              rules={[{ required: true, message: 'Por favor, selecione o contato' }]}
            >
              <Select 
                placeholder="Selecione o contato"
                disabled={!clienteSelecionado}
              >
                {contatos.map(contato => (
                  <Option key={contato.id} value={contato.id}>{contato.nome}</Option>
                ))}
              </Select>
            </Form.Item>

            <Form.Item
              name="oportunidade_id"
              label="Oportunidade"
            >
              <Select 
                placeholder="Selecione a oportunidade (opcional)"
                allowClear
              >
                {oportunidades
                  .filter(op => !clienteSelecionado || op.cliente_id === clienteSelecionado)
                  .map(oportunidade => (
                    <Option key={oportunidade.id} value={oportunidade.id}>{oportunidade.titulo}</Option>
                  ))
                }
              </Select>
            </Form.Item>

            <Form.Item
              name="descricao"
              label="Descrição"
              rules={[{ required: true, message: 'Por favor, informe a descrição da atividade' }]}
            >
              <TextArea rows={4} placeholder="Descreva os detalhes da atividade" />
            </Form.Item>

            <Form.Item>
              <Button
                type="primary"
                htmlType="submit"
                icon={<SaveOutlined />}
                loading={submitting}
              >
                {isEdicao ? 'Atualizar' : 'Salvar'}
              </Button>
            </Form.Item>
          </Form>
        )}
      </Card>
    </div>
  );
};

export default AtividadesForm; 