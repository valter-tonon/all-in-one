<?php

namespace App\Livewire\Admin\Plans;

use App\Application\DTOs\PlanDTO;
use App\Application\Services\PlanService;
use Livewire\Component;

class PlanCreate extends Component
{
    public $name = '';
    public $description = '';
    public $price = 0;
    public $features = [];
    public $status = 'active';
    
    public $feature = '';
    
    protected $rules = [
        'name' => 'required|min:3|max:255',
        'description' => 'nullable|max:1000',
        'price' => 'required|numeric|min:0',
        'status' => 'required|in:active,inactive',
    ];
    
    public function mount()
    {
        // Inicialização do componente
    }
    
    public function addFeature()
    {
        if (!empty($this->feature)) {
            $this->features[] = $this->feature;
            $this->feature = '';
        }
    }
    
    public function removeFeature($index)
    {
        if (isset($this->features[$index])) {
            unset($this->features[$index]);
            $this->features = array_values($this->features);
        }
    }
    
    public function save(PlanService $planService)
    {
        $this->validate();
        
        try {
            $planDTO = new PlanDTO(
                name: $this->name,
                description: $this->description,
                price: (float) $this->price,
                features: $this->features,
                status: $this->status
            );
            
            $planService->create($planDTO);
            
            session()->flash('message', 'Plano criado com sucesso!');
            return redirect()->route('admin.plans');
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao criar plano: ' . $e->getMessage());
        }
    }
    
    public function render()
    {
        return view('livewire.admin.plans.plan-create')
            ->layout('components.layouts.app');
    }
} 