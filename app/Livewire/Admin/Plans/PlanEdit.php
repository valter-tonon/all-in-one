<?php

namespace App\Livewire\Admin\Plans;

use App\Application\DTOs\PlanDTO;
use App\Application\Services\PlanService;
use Livewire\Component;

class PlanEdit extends Component
{
    public $planId;
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
    
    public function mount($id)
    {
        $this->planId = $id;
        $this->loadPlan();
    }
    
    public function loadPlan()
    {
        try {
            $plan = app(PlanService::class)->findById($this->planId);
            
            if (!$plan) {
                session()->flash('error', 'Plano não encontrado.');
                return redirect()->route('admin.plans');
            }
            
            $this->name = $plan->name;
            $this->description = $plan->description;
            $this->price = $plan->price;
            $this->features = is_array($plan->features) ? $plan->features : [];
            $this->status = $plan->status;
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao carregar plano: ' . $e->getMessage());
            return redirect()->route('admin.plans');
        }
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
            
            $planService->update($this->planId, $planDTO);
            
            session()->flash('message', 'Plano atualizado com sucesso!');
            return redirect()->route('admin.plans');
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao atualizar plano: ' . $e->getMessage());
        }
    }
    
    public function render()
    {
        return view('livewire.admin.plans.plan-edit')
            ->layout('components.layouts.app');
    }
} 