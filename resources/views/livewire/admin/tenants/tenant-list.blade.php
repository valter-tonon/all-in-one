<div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Gerenciamento de Tenants</h2>
                        <a href="{{ route('admin.tenants.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Novo Tenant
                        </a>
                    </div>

                    <!-- Mensagens de Feedback -->
                    @if (session()->has('message'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                            {{ session('message') }}
                        </div>
                    @endif

                    @if (session()->has('error'))
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Filtros -->
                    <div class="mb-6 flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <input wire:model.live="searchTerm" type="text" placeholder="Buscar por nome ou domínio..." 
                                class="w-full px-4 py-2 border rounded-md">
                        </div>
                        <div class="w-full md:w-48">
                            <select wire:model.live="statusFilter" class="w-full px-4 py-2 border rounded-md">
                                <option value="">Todos os status</option>
                                <option value="active">Ativos</option>
                                <option value="inactive">Inativos</option>
                            </select>
                        </div>
                    </div>

                    <!-- Tabela de Tenants -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">ID</th>
                                    <th class="py-3 px-6 text-left">Nome</th>
                                    <th class="py-3 px-6 text-left">Domínio</th>
                                    <th class="py-3 px-6 text-left">Banco de Dados</th>
                                    <th class="py-3 px-6 text-left">Plano</th>
                                    <th class="py-3 px-6 text-left">Status</th>
                                    <th class="py-3 px-6 text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm">
                                @forelse ($tenants as $tenant)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="py-3 px-6 text-left">{{ $tenant->id }}</td>
                                        <td class="py-3 px-6 text-left">{{ $tenant->name }}</td>
                                        <td class="py-3 px-6 text-left">{{ $tenant->domain ?? '-' }}</td>
                                        <td class="py-3 px-6 text-left">{{ $tenant->database }}</td>
                                        <td class="py-3 px-6 text-left">
                                            <span class="px-2 py-1 rounded-full text-xs 
                                                {{ $tenant->plan === 'basic' ? 'bg-blue-100 text-blue-800' : 
                                                   ($tenant->plan === 'premium' ? 'bg-purple-100 text-purple-800' : 
                                                   'bg-yellow-100 text-yellow-800') }}">
                                                {{ ucfirst($tenant->plan) }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-6 text-left">
                                            <span class="px-2 py-1 rounded-full text-xs 
                                                {{ $tenant->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $tenant->status === 'active' ? 'Ativo' : 'Inativo' }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                            <div class="flex item-center justify-center">
                                                <a href="{{ route('admin.tenants.edit', $tenant->id) }}" class="w-4 mr-2 transform hover:text-blue-500 hover:scale-110">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                    </svg>
                                                </a>
                                                <button wire:click="delete({{ $tenant->id }})" wire:confirm="Tem certeza que deseja excluir este tenant?" class="w-4 mr-2 transform hover:text-red-500 hover:scale-110">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-6 px-6 text-center text-gray-500">
                                            Nenhum tenant encontrado.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginação -->
                    <div class="mt-4">
                        {{ $tenants->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 