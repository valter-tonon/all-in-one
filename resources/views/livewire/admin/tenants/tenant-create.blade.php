<div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Criar Novo Tenant</h2>
                        <a href="{{ route('admin.tenants') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                            Voltar
                        </a>
                    </div>

                    <!-- Mensagens de Feedback -->
                    @if (session()->has('error'))
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form wire:submit="save" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nome -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                                <input type="text" wire:model="name" id="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Domínio -->
                            <div>
                                <label for="domain" class="block text-sm font-medium text-gray-700">Domínio (opcional)</label>
                                <input type="text" wire:model="domain" id="domain" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                @error('domain') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Banco de Dados -->
                            <div>
                                <label for="database" class="block text-sm font-medium text-gray-700">Banco de Dados</label>
                                <input type="text" wire:model="database" id="database" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <p class="mt-1 text-xs text-gray-500">Use apenas letras, números e underscores.</p>
                                @error('database') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Plano -->
                            <div>
                                <label for="plan" class="block text-sm font-medium text-gray-700">Plano</label>
                                <select wire:model="plan" id="plan" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="basic">Básico</option>
                                    <option value="premium">Premium</option>
                                    <option value="enterprise">Enterprise</option>
                                </select>
                                @error('plan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select wire:model="status" id="status" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="active">Ativo</option>
                                    <option value="inactive">Inativo</option>
                                </select>
                                @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Criar Tenant
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 