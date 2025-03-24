<?php

use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Tenants\TenantList;
use App\Livewire\Admin\Tenants\TenantCreate;
use App\Livewire\Admin\Tenants\TenantEdit;
use App\Livewire\Tenant\Stock\StockList;
use App\Livewire\Tenant\Stock\StockCreate;
use App\Livewire\Tenant\Stock\StockEdit;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Rotas de administração
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    
    // Rotas para gerenciamento de tenants
    Route::get('/tenants', TenantList::class)->name('tenants');
    Route::get('/tenants/create', TenantCreate::class)->name('tenants.create');
    Route::get('/tenants/{id}/edit', TenantEdit::class)->name('tenants.edit');
    
    // Rotas para gerenciamento de planos
    Route::get('/plans', \App\Livewire\Admin\Plans\PlanList::class)->name('plans');
    Route::get('/plans/create', \App\Livewire\Admin\Plans\PlanCreate::class)->name('plans.create');
    Route::get('/plans/{id}/edit', \App\Livewire\Admin\Plans\PlanEdit::class)->name('plans.edit');
    
    // Rotas para relatórios
    Route::get('/reports/tenants', function () {
        return view('admin.reports.tenants');
    })->name('reports.tenants');
    
    Route::get('/reports/revenue', function () {
        return view('admin.reports.revenue');
    })->name('reports.revenue');
    
    // Rota para configurações
    Route::get('/settings', \App\Livewire\Admin\Settings::class)->name('settings');
    
    // Rota para relatórios (geral)
    Route::get('/reports', function () {
        return view('admin.reports.index');
    })->name('reports');
});

// Rotas de tenant (estoque)
Route::prefix('tenant')->middleware(['auth'])->group(function () {
    // Rotas para gerenciamento de estoque
    Route::get('/stock', StockList::class)->name('tenant.stock.index');
    Route::get('/stock/create', StockCreate::class)->name('tenant.stock.create');
    Route::get('/stock/{id}/edit', StockEdit::class)->name('tenant.stock.edit');
});

require __DIR__.'/auth.php';
