<?php

namespace App\Livewire\Admin\Tenants;

use App\Application\Services\TenantService;
use Livewire\Component;
use Livewire\WithPagination;

class TenantList extends Component
{
    use WithPagination;

    public $searchTerm = '';
    public $statusFilter = '';

    public function mount()
    {
        // Inicialização do componente
    }

    public function render(TenantService $tenantService)
    {
        // Obter os tenants paginados diretamente do serviço
        $tenants = $tenantService->getPaginated(
            perPage: 10,
            searchTerm: $this->searchTerm,
            statusFilter: $this->statusFilter
        );
        
        return view('livewire.admin.tenants.tenant-list', [
            'tenants' => $tenants
        ])->layout('components.layouts.app');
    }
    
    public function delete($id)
    {
        try {
            app(TenantService::class)->delete($id);
            session()->flash('message', 'Tenant excluído com sucesso!');
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao excluir tenant: ' . $e->getMessage());
        }
    }
} 