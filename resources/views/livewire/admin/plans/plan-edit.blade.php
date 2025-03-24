<div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Editar Plano</h2>
                        <a href="{{ route('admin.plans') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
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
                            <!-- Nome do Plano -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nome do Plano</label>
                                <input type="text" wire:model="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Preço -->
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700">Preço (R$)</label>
                                <input type="number" wire:model="price" id="price" step="0.01" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Descrição -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
                            <textarea wire:model="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                            @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select wire:model="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="active">Ativo</option>
                                <option value="inactive">Inativo</option>
                            </select>
                            @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Recursos/Features -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Recursos do Plano</label>
                            
                            <div class="flex mt-1">
                                <input type="text" wire:model="feature" wire:keydown.enter.prevent="addFeature" placeholder="Adicionar recurso..." class="flex-1 rounded-l-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <button type="button" wire:click="addFeature" class="px-4 py-2 bg-blue-600 text-white rounded-r-md hover:bg-blue-700">
                                    Adicionar
                                </button>
                            </div>
                            
                            <ul class="mt-3 space-y-2">
                                @foreach ($features as $index => $feature)
                                    <li class="flex items-center justify-between p-2 bg-gray-50 rounded">
                                        <span>{{ $feature }}</span>
                                        <button type="button" wire:click="removeFeature({{ $index }})" class="text-red-500 hover:text-red-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Atualizar Plano
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 