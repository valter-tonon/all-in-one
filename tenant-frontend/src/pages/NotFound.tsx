import React from 'react';
import { Link } from 'react-router-dom';
import { FiAlertTriangle } from 'react-icons/fi';

const NotFound: React.FC = () => {
  return (
    <div className="flex flex-col items-center justify-center h-full">
      <FiAlertTriangle className="w-16 h-16 text-yellow-500" />
      <h1 className="mt-4 text-2xl font-bold text-gray-800">Página não encontrada</h1>
      <p className="mt-2 text-gray-600">A página que você está procurando não existe ou foi removida.</p>
      <Link to="/" className="px-4 py-2 mt-6 text-white bg-blue-600 rounded-md hover:bg-blue-700">
        Voltar para o Dashboard
      </Link>
    </div>
  );
};

export default NotFound; 