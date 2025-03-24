<?php

namespace App\Livewire\Tenant\Stock;

use App\Application\DTOs\StockDTO;
use App\Application\Services\StockService;
use Livewire\Component;

class StockEdit extends Component
{
    public $stockId;
    public $name = '';
    public $description = '';
    public $quantity = 0;
    public $price = 0;
    public $sku = '';
    public $category = '';
    public $status = '';
    
    protected $rules = [
        'name' => 'required|min:3|max:255',
        'description' => 'nullable|max:1000',
        'quantity' => 'required|integer|min:0',
        'price' => 'required|numeric|min:0',
        'sku' => 'nullable|max:50',
        'category' => 'nullable|max:100',
        'status' => 'required|in:active,inactive',
    ];
    
    public function mount($id)
    {
        $this->stockId = $id;
        $this->loadStock();
    }
    
    public function loadStock()
    {
        try {
            $stock = app(StockService::class)->findById($this->stockId);
            
            $this->name = $stock->name;
            $this->description = $stock->description;
            $this->quantity = $stock->quantity;
            $this->price = $stock->price;
            $this->sku = $stock->sku;
            $this->category = $stock->category;
            $this->status = $stock->status;
        } catch (\Exception $e) {
            session()->flash('error', 'Produto não encontrado: ' . $e->getMessage());
            return redirect()->route('tenant.stock.index');
        }
    }
    
    public function render()
    {
        return view('livewire.tenant.stock.stock-edit')
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
            
            $stock = $stockService->update($this->stockId, $dto);
            
            session()->flash('message', 'Produto atualizado com sucesso!');
            return redirect()->route('tenant.stock.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao atualizar produto: ' . $e->getMessage());
        }
    }
} 