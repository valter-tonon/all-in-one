<div class="p-6">
    <!-- Cards de Métricas -->
    <div class="grid grid-cols-4 gap-6 mb-8">
        <!-- Total de Tenants -->
        <div class="bg-blue-100 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold">{{ $totalTenants }}</h3>
                    <p class="text-sm text-gray-600">Total de Tenants</p>
                    <span class="text-xs text-blue-600">
                        @if($totalTenants > 0)
                            {{ $activeTenantsCount }} ativos ({{ round(($activeTenantsCount / $totalTenants) * 100) }}%)
                        @else
                            0 ativos (0%)
                        @endif
                    </span>
                </div>
                <div class="bg-blue-200 p-3 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Tenants Ativos -->
        <div class="bg-green-100 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold">{{ $activeTenantsCount }}</h3>
                    <p class="text-sm text-gray-600">Taxa de Ativação</p>
                    <span class="text-xs text-green-600">
                        @if($totalTenants > 0)
                            {{ round(($activeTenantsCount / $totalTenants) * 100) }}% taxa de ativação
                        @else
                            0% taxa de ativação
                        @endif
                    </span>
                </div>
                <div class="bg-green-200 p-3 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Receita Mensal -->
        <div class="bg-purple-100 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold">R$ {{ number_format($monthlyRevenue, 2, ',', '.') }}</h3>
                    <p class="text-sm text-gray-600">Receita Mensal</p>
                    <span class="text-xs text-purple-600">
                        @if($activeTenantsCount > 0)
                            Média: R$ {{ number_format($monthlyRevenue / $activeTenantsCount, 2, ',', '.') }}/tenant
                        @else
                            Média: R$ 0,00/tenant
                        @endif
                    </span>
                </div>
                <div class="bg-purple-200 p-3 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Novos Tenants -->
        <div class="bg-orange-100 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold">{{ $newTenantsToday }}</h3>
                    <p class="text-sm text-gray-600">Registros Hoje</p>
                    <span class="text-xs text-orange-600">
                        {{ $newTenantsToday }} {{ $newTenantsToday == 1 ? 'registro' : 'registros' }} hoje
                    </span>
                </div>
                <div class="bg-orange-200 p-3 rounded-full">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Tenants -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold">Lista de Tenants</h2>
            <div class="flex gap-4">
                <div class="relative">
                    <input 
                        type="text" 
                        wire:model.debounce.300ms="searchTerm"
                        placeholder="Pesquisar tenants..." 
                        class="pl-10 pr-4 py-2 border rounded-lg"
                    >
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <a href="{{ route('admin.tenants.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    + Novo Tenant
                </a>
            </div>
        </div>

        <!-- Tabela -->
        <table class="w-full">
            <thead>
                <tr class="text-left border-b">
                    <th class="pb-3">EMPRESA</th>
                    <th class="pb-3">PLANO</th>
                    <th class="pb-3">DATA DE CRIAÇÃO</th>
                    <th class="pb-3">STATUS</th>
                    <th class="pb-3">AÇÕES</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tenants as $tenant)
                <tr class="border-b">
                    <td class="py-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        {{ $tenant->name }}
                    </td>
                    <td class="py-4">
                        <span class="px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-sm">
                            {{ $tenant->plan }}
                        </span>
                    </td>
                    <td class="py-4">{{ $tenant->created_at->format('d M Y') }}</td>
                    <td class="py-4">
                        <span class="px-3 py-1 {{ $tenant->status == 'active' ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-600' }} rounded-full text-sm">
                            {{ $tenant->status == 'active' ? 'Ativo' : 'Inativo' }}
                        </span>
                    </td>
                    <td class="py-4">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.tenants.edit', $tenant->id) }}" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                            </a>
                            <button wire:click="$emit('openDeleteModal', {{ $tenant->id }})" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-4 text-center text-gray-500">
                        Nenhum tenant encontrado
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="mt-4">
            {{ $tenants->links() }}
        </div>
    </div>

    <!-- Gráfico de Crescimento -->
    <div class="bg-white rounded-lg shadow p-6 mt-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold">Crescimento de Tenants</h2>
            <div class="flex gap-2">
                <button class="px-3 py-1 text-sm bg-blue-500 text-white rounded">Últimos 6 meses</button>
            </div>
        </div>
        <div class="h-64">
            <!-- Gráfico de barras simples -->
            <div class="flex items-end justify-between h-full">
                @foreach($growthData['months'] as $index => $month)
                <div class="flex flex-col items-center">
                    <div class="w-16 bg-blue-100 rounded-t" style="height: {{ max(20, min(200, $growthData['counts'][$index] * 20 + 20)) }}px"></div>
                    <div class="mt-1 text-xs font-semibold">{{ $growthData['counts'][$index] }}</div>
                    <span class="mt-1 text-sm text-gray-600">{{ $month }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div> 