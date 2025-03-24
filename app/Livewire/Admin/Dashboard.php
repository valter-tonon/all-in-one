<?php

namespace App\Livewire\Admin;

use App\Application\Services\TenantService;
use App\Application\Services\PlanService;
use App\Domain\Entities\Tenant;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;
    
    public $totalTenants;
    public $activeTenantsCount;
    public $monthlyRevenue;
    public $newTenantsToday;
    public $searchTerm = '';
    public $growthData = [];
    
    protected $listeners = ['refresh' => '$refresh'];

    public function mount(TenantService $tenantService, PlanService $planService)
    {
        $this->loadDashboardData($tenantService, $planService);
    }
    
    public function loadDashboardData(TenantService $tenantService, PlanService $planService)
    {
        // Total de tenants
        $this->totalTenants = $tenantService->count();
        
        // Tenants ativos
        $this->activeTenantsCount = DB::table('tenants')->where('status', 'active')->count();
        
        // Receita mensal (calculada com base nos planos ativos)
        $this->calculateMonthlyRevenue($tenantService, $planService);
        
        // Novos tenants hoje
        $this->newTenantsToday = DB::table('tenants')
            ->whereDate('created_at', Carbon::today())
            ->count();
        
        // Dados de crescimento para o gráfico
        $this->loadGrowthData();
    }
    
    protected function calculateMonthlyRevenue(TenantService $tenantService, PlanService $planService)
    {
        $revenue = 0;
        $activeTenants = DB::table('tenants')->where('status', 'active')->get();
        $plans = $planService->getAll()->keyBy('name');
        
        foreach ($activeTenants as $tenant) {
            if (isset($plans[$tenant->plan])) {
                $revenue += $plans[$tenant->plan]->price;
            }
        }
        
        $this->monthlyRevenue = $revenue;
    }
    
    protected function loadGrowthData()
    {
        $months = [];
        $counts = [];
        
        // Obter dados dos últimos 6 meses
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthName = $date->locale('pt_BR')->shortMonthName;
            $monthStart = Carbon::now()->subMonths($i)->startOfMonth();
            $monthEnd = Carbon::now()->subMonths($i)->endOfMonth();
            
            $count = DB::table('tenants')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->count();
            
            $months[] = $monthName;
            $counts[] = $count;
        }
        
        $this->growthData = [
            'months' => $months,
            'counts' => $counts
        ];
    }
    
    public function updatedSearchTerm()
    {
        $this->resetPage();
    }

    public function render(TenantService $tenantService)
    {
        $tenants = $tenantService->getPaginated(10, $this->searchTerm);
        
        return view('livewire.admin.dashboard', [
            'tenants' => $tenants
        ])->layout('components.layouts.app');
    }
} 