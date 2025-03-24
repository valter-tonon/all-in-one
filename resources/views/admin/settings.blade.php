<x-layouts.admin>
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6">Configurações do Sistema</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-50 p-4 rounded-lg">
                <h2 class="text-lg font-semibold mb-4">Configurações Gerais</h2>
                
                <div class="space-y-4">
                    <div>
                        <label for="site_name" class="block text-sm font-medium text-gray-700 mb-1">Nome do Site</label>
                        <input type="text" id="site_name" name="site_name" value="CRM-ERP All-in-One" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    
                    <div>
                        <label for="admin_email" class="block text-sm font-medium text-gray-700 mb-1">Email do Administrador</label>
                        <input type="email" id="admin_email" name="admin_email" value="admin@example.com" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    
                    <div>
                        <label for="timezone" class="block text-sm font-medium text-gray-700 mb-1">Fuso Horário</label>
                        <select id="timezone" name="timezone" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="America/Sao_Paulo" selected>America/Sao_Paulo</option>
                            <option value="America/New_York">America/New_York</option>
                            <option value="Europe/London">Europe/London</option>
                            <option value="Asia/Tokyo">Asia/Tokyo</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg">
                <h2 class="text-lg font-semibold mb-4">Configurações de Email</h2>
                
                <div class="space-y-4">
                    <div>
                        <label for="mail_driver" class="block text-sm font-medium text-gray-700 mb-1">Driver de Email</label>
                        <select id="mail_driver" name="mail_driver" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="smtp" selected>SMTP</option>
                            <option value="sendmail">Sendmail</option>
                            <option value="mailgun">Mailgun</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="mail_host" class="block text-sm font-medium text-gray-700 mb-1">Host SMTP</label>
                        <input type="text" id="mail_host" name="mail_host" value="smtp.mailtrap.io" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    
                    <div>
                        <label for="mail_port" class="block text-sm font-medium text-gray-700 mb-1">Porta SMTP</label>
                        <input type="text" id="mail_port" name="mail_port" value="2525" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-6">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Salvar Configurações
            </button>
        </div>
    </div>
</x-layouts.admin> 