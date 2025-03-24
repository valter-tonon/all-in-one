<div>
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6">Configurações do Sistema</h1>
        
        @if (session()->has('message'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('message') }}</p>
            </div>
        @endif
        
        <form wire:submit.prevent="saveSettings">
            <!-- Abas de Configuração -->
            <div x-data="{ activeTab: 'general' }">
                <div class="border-b border-gray-200 mb-6">
                    <nav class="-mb-px flex space-x-8">
                        <button type="button" 
                                @click="activeTab = 'general'" 
                                :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'general', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'general' }"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Geral
                        </button>
                        <button type="button" 
                                @click="activeTab = 'email'" 
                                :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'email', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'email' }"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Email
                        </button>
                        <button type="button" 
                                @click="activeTab = 'security'" 
                                :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'security', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'security' }"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Segurança
                        </button>
                    </nav>
                </div>
                
                <!-- Configurações Gerais -->
                <div x-show="activeTab === 'general'" class="space-y-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h2 class="text-lg font-semibold mb-4">Configurações Gerais</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="site_name" class="block text-sm font-medium text-gray-700 mb-1">Nome do Site</label>
                                <input type="text" id="site_name" wire:model="generalSettings.site_name" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                @error('generalSettings.site_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label for="admin_email" class="block text-sm font-medium text-gray-700 mb-1">Email do Administrador</label>
                                <input type="email" id="admin_email" wire:model="generalSettings.admin_email" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                @error('generalSettings.admin_email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label for="timezone" class="block text-sm font-medium text-gray-700 mb-1">Fuso Horário</label>
                                <select id="timezone" wire:model="generalSettings.timezone" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="America/Sao_Paulo">America/Sao_Paulo</option>
                                    <option value="America/New_York">America/New_York</option>
                                    <option value="Europe/London">Europe/London</option>
                                    <option value="Asia/Tokyo">Asia/Tokyo</option>
                                </select>
                                @error('generalSettings.timezone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Configurações de Email -->
                <div x-show="activeTab === 'email'" class="space-y-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h2 class="text-lg font-semibold mb-4">Configurações de Email</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="mail_driver" class="block text-sm font-medium text-gray-700 mb-1">Driver de Email</label>
                                <select id="mail_driver" wire:model="emailSettings.mail_driver" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="smtp">SMTP</option>
                                    <option value="sendmail">Sendmail</option>
                                    <option value="mailgun">Mailgun</option>
                                </select>
                                @error('emailSettings.mail_driver') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label for="mail_host" class="block text-sm font-medium text-gray-700 mb-1">Host SMTP</label>
                                <input type="text" id="mail_host" wire:model="emailSettings.mail_host" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                @error('emailSettings.mail_host') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label for="mail_port" class="block text-sm font-medium text-gray-700 mb-1">Porta SMTP</label>
                                <input type="text" id="mail_port" wire:model="emailSettings.mail_port" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                @error('emailSettings.mail_port') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label for="mail_username" class="block text-sm font-medium text-gray-700 mb-1">Usuário SMTP</label>
                                <input type="text" id="mail_username" wire:model="emailSettings.mail_username" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                @error('emailSettings.mail_username') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label for="mail_password" class="block text-sm font-medium text-gray-700 mb-1">Senha SMTP</label>
                                <input type="password" id="mail_password" wire:model="emailSettings.mail_password" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                @error('emailSettings.mail_password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label for="mail_encryption" class="block text-sm font-medium text-gray-700 mb-1">Criptografia</label>
                                <select id="mail_encryption" wire:model="emailSettings.mail_encryption" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="tls">TLS</option>
                                    <option value="ssl">SSL</option>
                                    <option value="">Nenhuma</option>
                                </select>
                                @error('emailSettings.mail_encryption') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label for="mail_from_address" class="block text-sm font-medium text-gray-700 mb-1">Endereço de Email (From)</label>
                                <input type="email" id="mail_from_address" wire:model="emailSettings.mail_from_address" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                @error('emailSettings.mail_from_address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label for="mail_from_name" class="block text-sm font-medium text-gray-700 mb-1">Nome do Remetente</label>
                                <input type="text" id="mail_from_name" wire:model="emailSettings.mail_from_name" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                @error('emailSettings.mail_from_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Configurações de Segurança -->
                <div x-show="activeTab === 'security'" class="space-y-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h2 class="text-lg font-semibold mb-4">Configurações de Segurança</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="login_attempts" class="block text-sm font-medium text-gray-700 mb-1">Tentativas de Login</label>
                                <input type="number" id="login_attempts" wire:model="securitySettings.login_attempts" min="1" max="10"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <p class="text-xs text-gray-500 mt-1">Número máximo de tentativas de login antes do bloqueio</p>
                                @error('securitySettings.login_attempts') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label for="lockout_time" class="block text-sm font-medium text-gray-700 mb-1">Tempo de Bloqueio (minutos)</label>
                                <input type="number" id="lockout_time" wire:model="securitySettings.lockout_time" min="1"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <p class="text-xs text-gray-500 mt-1">Tempo de bloqueio após exceder o número máximo de tentativas</p>
                                @error('securitySettings.lockout_time') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label for="password_expiry_days" class="block text-sm font-medium text-gray-700 mb-1">Expiração de Senha (dias)</label>
                                <input type="number" id="password_expiry_days" wire:model="securitySettings.password_expiry_days" min="0"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <p class="text-xs text-gray-500 mt-1">Número de dias até que a senha expire (0 = nunca expira)</p>
                                @error('securitySettings.password_expiry_days') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="flex items-center">
                                <input type="checkbox" id="require_2fa" wire:model="securitySettings.require_2fa" 
                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="require_2fa" class="ml-2 block text-sm text-gray-700">Exigir Autenticação de Dois Fatores</label>
                                @error('securitySettings.require_2fa') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-6">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Salvar Configurações
                </button>
            </div>
        </form>
    </div>
</div> 