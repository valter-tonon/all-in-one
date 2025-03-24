<?php

namespace App\Livewire\Tenant\Stock;

use App\Application\Services\StockService;
use Livewire\Component;
use Livewire\WithPagination;

class StockList extends Component
{
    use WithPagination;

    public $searchTerm = '';
    public $categoryFilter = '';
    public $stockFilter = '';

    public function mount()
    {
        // Inicialização do componente
    }

    public function render(StockService $stockService)
    {
        $query = $stockService->getAll();
        
        // Aplicar filtro de busca
        if (!empty($this->searchTerm)) {
            $query = $stockService->search($this->searchTerm);
        }
        
        // Aplicar filtro de categoria
        if (!empty($this->categoryFilter)) {
            $query = $query->where('category', $this->categoryFilter);
        }
        
        // Aplicar filtro de estoque
        if ($this->stockFilter === 'low') {
            $query = $stockService->getLowStock();
        } elseif ($this->stockFilter === 'out') {
            $query = $stockService->getOutOfStock();
        }
        
        $stocks = $query->paginate(10);
        
        // Obter categorias únicas para o filtro
        $categories = $stockService->getAll()->pluck('category')->unique()->filter()->sort()->values();
        
        return view('livewire.tenant.stock.stock-list', [
            'stocks' => $stocks,
            'categories' => $categories
        ])->layout('components.layouts.app');
    }
    
    public function delete($id)
    {
        try {
            app(StockService::class)->delete($id);
            session()->flash('message', 'Produto excluído com sucesso!');
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao excluir produto: ' . $e->getMessage());
        }
    }
} 