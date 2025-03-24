<?php

namespace App\Providers;

use App\Domain\Repositories\StockRepositoryInterface;
use App\Domain\Repositories\TenantRepositoryInterface;
use App\Domain\Repositories\PlanRepositoryInterface;
use App\Infrastructure\Repositories\EloquentStockRepository;
use App\Infrastructure\Repositories\EloquentTenantRepository;
use App\Infrastructure\Repositories\EloquentPlanRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Registrar os repositórios
        $this->app->bind(TenantRepositoryInterface::class, EloquentTenantRepository::class);
        $this->app->bind(StockRepositoryInterface::class, EloquentStockRepository::class);
        $this->app->bind(PlanRepositoryInterface::class, EloquentPlanRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Compartilhar configurações do site com todas as views
        $this->loadSiteSettings();
    }
    
    protected function loadSiteSettings(): void
    {
        // Carregar configurações do arquivo JSON se existir
        $settings = [
            'site_name' => 'CRM-ERP All-in-One',
            'admin_email' => 'admin@example.com',
            'timezone' => 'America/Sao_Paulo',
        ];
        
        if (Storage::exists('settings.json')) {
            $storedSettings = json_decode(Storage::get('settings.json'), true);
            if (isset($storedSettings['general'])) {
                $settings = array_merge($settings, $storedSettings['general']);
            }
        }
        
        // Compartilhar com todas as views
        View::share('siteSettings', $settings);
    }
} 