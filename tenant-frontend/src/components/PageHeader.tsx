import React, { ReactNode } from 'react';
import { Typography, Button, Space } from 'antd';
import { ArrowLeftOutlined } from '@ant-design/icons';

const { Title, Text } = Typography;

interface PageHeaderProps {
  title: string;
  subtitle?: string;
  extra?: ReactNode;
  onBack?: () => void;
  backIcon?: ReactNode;
}

export const PageHeader: React.FC<PageHeaderProps> = ({
  title,
  subtitle,
  extra,
  onBack,
  backIcon = <ArrowLeftOutlined />
}) => {
  return (
    <div style={{ 
      marginBottom: 24,
      display: 'flex',
      justifyContent: 'space-between',
      alignItems: 'center'
    }}>
      <div>
        <Space align="center">
          {onBack && (
            <Button 
              type="text" 
              icon={backIcon} 
              onClick={onBack}
              style={{ marginRight: 8 }}
            />
          )}
          <div>
            <Title level={4} style={{ margin: 0 }}>{title}</Title>
            {subtitle && <Text type="secondary">{subtitle}</Text>}
          </div>
        </Space>
      </div>
      {extra && <div>{extra}</div>}
    </div>
  );
};

export default PageHeader; 