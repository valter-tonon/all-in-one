import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { Table, Button, Card, Input, Space, Popconfirm, message, Tag, Tooltip } from 'antd';
import { SearchOutlined, PlusOutlined, EditOutlined, DeleteOutlined } from '@ant-design/icons';
import crmService, { Atividade } from '../../services/crmService';
import { PageHeader } from '../../components/PageHeader';

const AtividadesList: React.FC = () => {
  const [atividades, setAtividades] = useState<Atividade[]>([]);
  const [loading, setLoading] = useState<boolean>(true);
  const [searchText, setSearchText] = useState<string>('');
  const [currentPage, setCurrentPage] = useState<number>(1);
  const [totalPages, setTotalPages] = useState<number>(1);

  useEffect(() => {
    fetchAtividades();
  }, [currentPage]);

  const fetchAtividades = async () => {
    try {
      setLoading(true);
      const response = await crmService.getAtividades(currentPage, searchText);
      setAtividades(response.data);
      setTotalPages(response.meta.last_page);
      message.success('Atividades carregadas com sucesso!');
    } catch (error) {
      console.error('Erro ao carregar atividades:', error);
      message.error('Erro ao carregar atividades. Tente novamente mais tarde.');
    } finally {
      setLoading(false);
    }
  };

  const handleDelete = async (id: number) => {
    try {
      // Quando a API estiver pronta, descomentar a linha abaixo
      // await api.delete(`/api/atividades/${id}`);
      setAtividades(atividades.filter(atividade => atividade.id !== id));
      message.success('Atividade excluída com sucesso');
    } catch (error) {
      console.error('Erro ao excluir atividade:', error);
      message.error('Não foi possível excluir a atividade');
    }
  };

  const handleSearch = (value: string) => {
    setSearchText(value);
  };

  const filteredAtividades = atividades.filter(
    atividade =>
      atividade.titulo.toLowerCase().includes(searchText.toLowerCase()) ||
      atividade.tipo.toLowerCase().includes(searchText.toLowerCase()) ||
      atividade.status.toLowerCase().includes(searchText.toLowerCase())
  );

  const columns = [
    {
      title: 'Título',
      dataIndex: 'titulo',
      key: 'titulo',
      render: (text: string, record: any) => (
        <Link to={`/crm/atividades/${record.id}`}>{text}</Link>
      ),
    },
    {
      title: 'Tipo',
      dataIndex: 'tipo',
      key: 'tipo',
    },
    {
      title: 'Status',
      dataIndex: 'status',
      key: 'status',
      render: (status: string) => {
        let color = 'blue';
        if (status === 'Concluída') color = 'green';
        if (status === 'Cancelada') color = 'red';
        return (
          <Tag color={color}>
            {status}
          </Tag>
        );
      },
    },
    {
      title: 'Data',
      dataIndex: 'data',
      key: 'data',
      render: (data: string) => new Date(data).toLocaleDateString(),
    },
    {
      title: 'Cliente',
      key: 'cliente',
      render: (record: any) => record.cliente_id ? `Cliente #${record.cliente_id}` : '-',
    },
    {
      title: 'Contato',
      key: 'contato',
      render: (record: any) => record.contato_id ? `Contato #${record.contato_id}` : '-',
    },
    {
      title: 'Ações',
      key: 'acoes',
      render: (_: any, record: any) => (
        <Space size="middle">
          <Tooltip title="Editar">
            <Link to={`/crm/atividades/editar/${record.id}`}>
              <Button type="primary" icon={<EditOutlined />} size="small" />
            </Link>
          </Tooltip>
          <Tooltip title="Excluir">
            <Popconfirm
              title="Tem certeza que deseja excluir esta atividade?"
              onConfirm={() => handleDelete(record.id)}
              okText="Sim"
              cancelText="Não"
            >
              <Button danger icon={<DeleteOutlined />} size="small" />
            </Popconfirm>
          </Tooltip>
        </Space>
      ),
    },
  ];

  return (
    <div>
      <PageHeader
        title="Atividades"
        subtitle="Gerencie as atividades relacionadas a clientes e oportunidades"
        extra={
          <Link to="/crm/atividades/novo">
            <Button type="primary" icon={<PlusOutlined />}>
              Nova Atividade
            </Button>
          </Link>
        }
      />

      <Card>
        <Space style={{ marginBottom: 16 }}>
          <Input
            placeholder="Buscar atividades"
            prefix={<SearchOutlined />}
            onChange={(e: React.ChangeEvent<HTMLInputElement>) => handleSearch(e.target.value)}
            style={{ width: 300 }}
          />
        </Space>

        <Table
          columns={columns}
          dataSource={filteredAtividades}
          rowKey="id"
          loading={loading}
          pagination={{ pageSize: 10 }}
        />
      </Card>
    </div>
  );
};

export default AtividadesList; 