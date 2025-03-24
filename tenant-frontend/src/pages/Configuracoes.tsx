import React, { useState } from 'react';
import { FiSave, FiUser, FiLock, FiMail, FiGlobe, FiCreditCard, FiBell, FiUpload, FiSettings, FiLayout, FiPrinter, FiDollarSign, FiFileText, FiCreditCard as FiInvoice } from 'react-icons/fi';

// Placeholders para imagens
const logoDarkPlaceholder = 'https://via.placeholder.com/150x50?text=Logo+Dark';
const logoLightPlaceholder = 'https://via.placeholder.com/150x50?text=Logo+Light';
const faviconPlaceholder = 'https://via.placeholder.com/32x32?text=Favicon';

const Configuracoes: React.FC = () => {
  // Estado para controlar a aba ativa
  const [activeTab, setActiveTab] = useState('marca');
  
  // Estados para os formulários
  const [brandForm, setBrandForm] = useState({
    titleText: 'WorkDo Dash',
    footerText: '© WorkDo Dash'
  });

  // Estados para as configurações de tema
  const [themeSettings, setThemeSettings] = useState({
    darkMode: false,
    transparentLayout: true,
    rtlLayout: false,
    sidebarSabio: false
  });
  
  // Handler para mudança nos campos do formulário
  const handleBrandFormChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = e.target;
    setBrandForm(prev => ({ ...prev, [name]: value }));
  };

  // Handler para mudança nos toggles
  const handleToggleChange = (setting: keyof typeof themeSettings) => {
    setThemeSettings(prev => ({ ...prev, [setting]: !prev[setting] }));
  };
  
  // Componente para o menu lateral
  const SidebarMenuItem: React.FC<{
    id: string;
    icon: React.ReactNode;
    label: string;
  }> = ({ id, icon, label }) => {
    const isActive = activeTab === id;
    
    return (
      <a 
        href={`#${id}`}
        className={`flex items-center px-4 py-3 rounded-lg mt-1 ${
          isActive 
            ? 'text-white bg-indigo-600' 
            : 'text-gray-700 hover:bg-gray-100'
        }`}
        onClick={(e) => {
          e.preventDefault();
          setActiveTab(id);
        }}
      >
        <div className="mr-3">{icon}</div>
        {label}
      </a>
    );
  };
  
  // Componente para o upload de imagem
  const ImageUploader: React.FC<{
    title: string;
    image: string;
    altText: string;
    darkBg?: boolean;
  }> = ({ title, image, altText, darkBg = false }) => {
    return (
      <div>
        <h3 className="text-lg font-medium mb-4">{title}</h3>
        <div className={`p-4 rounded-lg flex items-center justify-center h-32 ${darkBg ? 'bg-gray-800' : 'bg-gray-100'}`}>
          <img src={image} alt={altText} className="max-h-20" />
        </div>
        <button className="mt-4 w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg flex items-center justify-center">
          <FiUpload className="w-5 h-5 mr-2" />
          Escolha o arquivo aqui
        </button>
      </div>
    );
  };

  // Componente para seleção de cor
  const ColorOption: React.FC<{ color: string }> = ({ color }) => {
    return (
      <div 
        className={`w-10 h-10 rounded-full cursor-pointer`} 
        style={{ backgroundColor: color }}
      ></div>
    );
  };

  // Componente para toggle switch
  const ToggleSwitch: React.FC<{ 
    enabled: boolean; 
    onChange: () => void;
  }> = ({ enabled, onChange }) => {
    return (
      <div 
        onClick={onChange}
        className={`relative inline-flex h-6 w-11 items-center rounded-full transition-colors ${enabled ? 'bg-indigo-600' : 'bg-gray-200'}`}
      >
        <span 
          className={`inline-block h-4 w-4 transform rounded-full bg-white transition-transform ${enabled ? 'translate-x-6' : 'translate-x-1'}`} 
        />
      </div>
    );
  };
  
  return (
    <div className="p-6">
      <div className="flex justify-between items-center mb-6">
        <h1 className="text-2xl font-semibold text-gray-800">Configurações</h1>
      </div>
      
      <div className="grid grid-cols-1 md:grid-cols-4 gap-6">
        {/* Menu lateral */}
        <div className="col-span-1 bg-white rounded-lg shadow">
          <div className="p-4 border-b border-gray-200">
            <h2 className="text-lg font-medium text-gray-800">Configurações</h2>
          </div>
          <nav className="p-2">
            <SidebarMenuItem 
              id="marca" 
              icon={<FiSettings className="w-5 h-5" />} 
              label="Configurações de marca" 
            />
            <SidebarMenuItem 
              id="sistema" 
              icon={<FiGlobe className="w-5 h-5" />} 
              label="Configurações do sistema" 
            />
            <SidebarMenuItem 
              id="empresa" 
              icon={<FiUser className="w-5 h-5" />} 
              label="Configurações da empresa" 
            />
            <SidebarMenuItem 
              id="moeda" 
              icon={<FiDollarSign className="w-5 h-5" />} 
              label="Configurações de moeda" 
            />
            <SidebarMenuItem 
              id="proposta" 
              icon={<FiFileText className="w-5 h-5" />} 
              label="Configurações de proposta" 
            />
            <SidebarMenuItem 
              id="fatura" 
              icon={<FiInvoice className="w-5 h-5" />} 
              label="Configurações de fatura" 
            />
          </nav>
        </div>
        
        {/* Conteúdo principal */}
        <div className="col-span-1 md:col-span-3">
          {/* Configurações de marca */}
          {activeTab === 'marca' && (
            <div className="bg-white rounded-lg shadow mb-6">
              <div className="p-6 border-b border-gray-200">
                <h2 className="text-xl font-semibold text-gray-800">Configurações de marca</h2>
              </div>
              <div className="p-6">
                <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                  <ImageUploader 
                    title="Logotipo Escuro" 
                    image={logoDarkPlaceholder} 
                    altText="Logotipo Escuro" 
                  />
                  <ImageUploader 
                    title="Luz do logotipo" 
                    image={logoLightPlaceholder} 
                    altText="Logotipo Claro" 
                    darkBg={true} 
                  />
                  <ImageUploader 
                    title="Favicon" 
                    image={faviconPlaceholder} 
                    altText="Favicon" 
                  />
                </div>
                
                <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                  <div>
                    <label htmlFor="titleText" className="block text-sm font-medium text-gray-700 mb-2">
                      Texto do título
                    </label>
                    <input
                      type="text"
                      id="titleText"
                      name="titleText"
                      value={brandForm.titleText}
                      onChange={handleBrandFormChange}
                      className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    />
                  </div>
                  
                  <div>
                    <label htmlFor="footerText" className="block text-sm font-medium text-gray-700 mb-2">
                      Texto do rodapé
                    </label>
                    <input
                      type="text"
                      id="footerText"
                      name="footerText"
                      value={brandForm.footerText}
                      onChange={handleBrandFormChange}
                      className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    />
                  </div>
                </div>
                
                <div className="mt-6">
                  <h3 className="text-lg font-medium mb-4">Personalizador de tema</h3>
                  
                  <div className="mb-6">
                    <h4 className="text-md font-medium mb-3">Configurações de cores primárias</h4>
                    <div className="grid grid-cols-6 gap-4">
                      <ColorOption color="#10b981" />
                      <ColorOption color="#84cc16" />
                      <ColorOption color="#6366f1" />
                      <ColorOption color="#2563eb" />
                      <ColorOption color="#db2777" />
                      <ColorOption color="#0ea5e9" />
                      <ColorOption color="#a855f7" />
                      <ColorOption color="#ca8a04" />
                      <ColorOption color="#4b5563" />
                      <ColorOption color="#0d9488" />
                    </div>
                  </div>
                  
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                      <h4 className="text-md font-medium mb-3">Configurações da barra lateral</h4>
                      <div className="space-y-4">
                        <div className="flex items-center justify-between">
                          <span>Layout transparente</span>
                          <ToggleSwitch 
                            enabled={themeSettings.transparentLayout} 
                            onChange={() => handleToggleChange('transparentLayout')} 
                          />
                        </div>
                      </div>
                    </div>
                    
                    <div>
                      <h4 className="text-md font-medium mb-3">Configurações de layout</h4>
                      <div className="space-y-4">
                        <div className="flex items-center justify-between">
                          <span>Layout escuro</span>
                          <ToggleSwitch 
                            enabled={themeSettings.darkMode} 
                            onChange={() => handleToggleChange('darkMode')} 
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                      <h4 className="text-md font-medium mb-3">Habilitar RTL</h4>
                      <div className="space-y-4">
                        <div className="flex items-center justify-between">
                          <span>Layout RTL</span>
                          <ToggleSwitch 
                            enabled={themeSettings.rtlLayout} 
                            onChange={() => handleToggleChange('rtlLayout')} 
                          />
                        </div>
                      </div>
                    </div>
                    
                    <div>
                      <h4 className="text-md font-medium mb-3">Categoria Menu lateral sábio</h4>
                      <div className="space-y-4">
                        <div className="flex items-center justify-between">
                          <span>Categoria Menu lateral sábio</span>
                          <ToggleSwitch 
                            enabled={themeSettings.sidebarSabio} 
                            onChange={() => handleToggleChange('sidebarSabio')} 
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div className="mt-6 flex justify-end">
                  <button className="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded-lg flex items-center">
                    <FiSave className="mr-2" />
                    Salvar alterações
                  </button>
                </div>
              </div>
            </div>
          )}
          
          {/* Configurações do sistema */}
          {activeTab === 'sistema' && (
            <div className="bg-white rounded-lg shadow mb-6">
              <div className="p-6 border-b border-gray-200">
                <h2 className="text-xl font-semibold text-gray-800">Configurações do sistema</h2>
              </div>
              <div className="p-6">
                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div>
                    <h3 className="text-lg font-medium mb-4">Idioma padrão</h3>
                    <select className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                      <option value="en">English</option>
                      <option value="pt">Português</option>
                      <option value="es">Español</option>
                    </select>
                  </div>
                  
                  <div>
                    <h3 className="text-lg font-medium mb-4">Formato de data</h3>
                    <select className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                      <option value="DD-MM-YYYY">DD-MM-YYYY</option>
                      <option value="MM-DD-YYYY">MM-DD-YYYY</option>
                      <option value="YYYY-MM-DD">YYYY-MM-DD</option>
                    </select>
                  </div>
                </div>
                
                <div className="mt-6 flex justify-end">
                  <button className="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded-lg flex items-center">
                    <FiSave className="mr-2" />
                    Salvar alterações
                  </button>
                </div>
              </div>
            </div>
          )}
          
          {/* Outros conteúdos para as outras abas */}
          {activeTab === 'empresa' && (
            <div className="bg-white rounded-lg shadow mb-6">
              <div className="p-6 border-b border-gray-200">
                <h2 className="text-xl font-semibold text-gray-800">Configurações da empresa</h2>
              </div>
              <div className="p-6">
                <p>Configurações da empresa</p>
              </div>
            </div>
          )}
          
          {activeTab === 'moeda' && (
            <div className="bg-white rounded-lg shadow mb-6">
              <div className="p-6 border-b border-gray-200">
                <h2 className="text-xl font-semibold text-gray-800">Configurações de moeda</h2>
              </div>
              <div className="p-6">
                <p>Configurações de moeda</p>
              </div>
            </div>
          )}
          
          {activeTab === 'proposta' && (
            <div className="bg-white rounded-lg shadow mb-6">
              <div className="p-6 border-b border-gray-200">
                <h2 className="text-xl font-semibold text-gray-800">Configurações de proposta</h2>
              </div>
              <div className="p-6">
                <p>Configurações de proposta</p>
              </div>
            </div>
          )}
          
          {activeTab === 'fatura' && (
            <div className="bg-white rounded-lg shadow mb-6">
              <div className="p-6 border-b border-gray-200">
                <h2 className="text-xl font-semibold text-gray-800">Configurações de fatura</h2>
              </div>
              <div className="p-6">
                <p>Configurações de fatura</p>
              </div>
            </div>
          )}
        </div>
      </div>
    </div>
  );
};

export default Configuracoes;