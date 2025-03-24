<?php

namespace App\Livewire\Admin\Tenants;

use App\Application\DTOs\TenantDTO;
use App\Application\Services\TenantService;
use Livewire\Component;

class TenantEdit extends Component
{
    public $tenantId;
    public $name = '';
    public $domain = '';
    public $database = '';
    public $plan = '';
    public $status = '';
    
    protected $rules = [
        'name' => 'required|min:3|max:255',
        'domain' => 'nullable|min:3|max:255',
        'plan' => 'required|in:basic,premium,enterprise',
        'status' => 'required|in:active,inactive',
    ];
    
    public function mount($id)
    {
        $this->tenantId = $id;
        $tenant = $this->loadTenant();
        
        if (!$tenant) {
            session()->flash('error', 'Tenant não encontrado.');
            return redirect()->route('admin.tenants');
        }
    }
    
    public function loadTenant()
    {
        try {
            $tenant = app(TenantService::class)->findById($this->tenantId);
            
            $this->name = $tenant->name;
            $this->domain = $tenant->domain;
            $this->database = $tenant->database;
            $this->plan = $tenant->plan;
            $this->status = $tenant->status;
            return $tenant;
        } catch (\Exception $e) {
            session()->flash('error', 'Tenant não encontrado: ' . $e->getMessage());
            return null;
        }
    }
    
    public function render()
    {
        return view('livewire.admin.tenants.tenant-edit')
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
            
            $tenant = $tenantService->update($this->tenantId, $dto);
            
            session()->flash('message', 'Tenant atualizado com sucesso!');
            return redirect()->route('admin.tenants');
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao atualizar tenant: ' . $e->getMessage());
        }
    }
} 