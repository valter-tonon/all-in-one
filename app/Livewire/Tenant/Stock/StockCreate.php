<?php

namespace App\Livewire\Tenant\Stock;

use App\Application\DTOs\StockDTO;
use App\Application\Services\StockService;
use Livewire\Component;

class StockCreate extends Component
{
    public $name = '';
    public $description = '';
    public $quantity = 0;
    public $price = 0;
    public $sku = '';
    public $category = '';
    public $status = 'active';
    
    protected $rules = [
        'name' => 'required|min:3|max:255',
        'description' => 'nullable|max:1000',
        'quantity' => 'required|integer|min:0',
        'price' => 'required|numeric|min:0',
        'sku' => 'nullable|max:50',
        'category' => 'nullable|max:100',
        'status' => 'required|in:active,inactive',
    ];
    
    public function mount()
    {
        // Inicialização do componente
    }
    
    public function render()
    {
        return view('livewire.tenant.stock.stock-create')
            ->layout('components.layouts.app');
    }
    
    public function save(StockService $stockService)
    {
        $this->validate();
        
        try {
            $dto = new StockDTO(
                name: $this->name,
                quantity: (int) $this->quantity,
                price: (float) $this->price,
                description: $this->description,
                sku: $this->sku,
                category: $this->category,
                status: $this->status
            );
            
            $stock = $stockService->create($dto);
            
            session()->flash('message', 'Produto criado com sucesso!');
            return redirect()->route('tenant.stock.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao criar produto: ' . $e->getMessage());
        }
    }
} 