<?php

namespace App\Livewire\Admin\Plans;

use App\Application\Services\PlanService;
use Livewire\Component;
use Livewire\WithPagination;

class PlanList extends Component
{
    use WithPagination;

    public $searchTerm = '';
    public $statusFilter = '';

    public function mount()
    {
        // Inicialização do componente
    }

    public function render(PlanService $planService)
    {
        // Obter os planos paginados diretamente do serviço
        $plans = $planService->getPaginated(
            perPage: 10,
            searchTerm: $this->searchTerm,
            statusFilter: $this->statusFilter
        );
        
        return view('livewire.admin.plans.plan-list', [
            'plans' => $plans
        ])->layout('components.layouts.app');
    }
    
    public function delete($id)
    {
        try {
            app(PlanService::class)->delete($id);
            session()->flash('message', 'Plano excluído com sucesso!');
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao excluir plano: ' . $e->getMessage());
        }
    }
}
