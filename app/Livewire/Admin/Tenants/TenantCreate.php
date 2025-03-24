<?php

namespace App\Livewire\Admin\Tenants;

use App\Application\DTOs\TenantDTO;
use App\Application\Services\TenantService;
use Livewire\Component;

class TenantCreate extends Component
{
    public $name = '';
    public $domain = '';
    public $database = '';
    public $plan = 'basic';
    public $status = 'active';
    
    protected $rules = [
        'name' => 'required|min:3|max:255',
        'domain' => 'nullable|min:3|max:255',
        'database' => 'required|min:3|max:64|alpha_dash',
        'plan' => 'required|in:basic,premium,enterprise',
        'status' => 'required|in:active,inactive',
    ];
    
    public function mount()
    {
        // Inicialização do componente
    }
    
    public function render()
    {
        return view('livewire.admin.tenants.tenant-create')
            ->layout('components.layouts.app');
    }
    
    public function save(TenantService $tenantService)
    {
        $this->validate();
        
        try {
            $dto = new TenantDTO(
                name: $this->name,
                database: $this->database,
                domain: $this->domain,
                plan: $this->plan,
                status: $this->status
            );
            
            $tenant = $tenantService->create($dto);
            
            session()->flash('message', 'Tenant criado com sucesso!');
            return redirect()->route('admin.tenants');
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao criar tenant: ' . $e->getMessage());
        }
    }
} 