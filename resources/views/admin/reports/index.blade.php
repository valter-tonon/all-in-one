@extends('layouts.admin')

@section('title', 'Relatórios')

@section('content')
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700">
        Relatórios
    </h2>

    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-3">
        <!-- Card Relatório de Inquilinos -->
        <a href="{{ route('reports.tenants') }}" class="block p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-50">
            <div class="flex items-center">
                <div class="p-3 mr-4 bg-blue-500 rounded-full text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div>
                    <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">Relatório de Inquilinos</h5>
                    <p class="font-normal text-gray-700">Visualize dados e estatísticas sobre inquilinos ativos.</p>
                </div>
            </div>
        </a>

        <!-- Card Relatório de Receita -->
        <a href="{{ route('reports.revenue') }}" class="block p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-50">
            <div class="flex items-center">
                <div class="p-3 mr-4 bg-green-500 rounded-full text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">Relatório de Receita</h5>
                    <p class="font-normal text-gray-700">Acompanhe a receita mensal e anual do sistema.</p>
                </div>
            </div>
        </a>

        <!-- Card Relatório de Planos -->
        <a href="#" class="block p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-50">
            <div class="flex items-center">
                <div class="p-3 mr-4 bg-purple-500 rounded-full text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                </div>
                <div>
                    <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">Relatório de Planos</h5>
                    <p class="font-normal text-gray-700">Visualize estatísticas sobre os planos e assinaturas.</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Gráficos e Estatísticas -->
    <div class="grid gap-6 mb-8 md:grid-cols-2">
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs">
            <h4 class="mb-4 font-semibold text-gray-800">Receita Mensal</h4>
            <div class="relative" style="height: 300px;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs">
            <h4 class="mb-4 font-semibold text-gray-800">Distribuição de Planos</h4>
            <div class="relative" style="height: 300px;">
                <canvas id="plansChart"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Dados de exemplo para os gráficos
    document.addEventListener('DOMContentLoaded', function() {
        // Gráfico de Receita
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
                datasets: [{
                    label: 'Receita 2023',
                    data: [12000, 19000, 15000, 25000, 22000, 30000],
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'R$ ' + value.toLocaleString('pt-BR');
                            }
                        }
                    }
                }
            }
        });

        // Gráfico de Planos
        const plansCtx = document.getElementById('plansChart').getContext('2d');
        new Chart(plansCtx, {
            type: 'doughnut',
            data: {
                labels: ['Básico', 'Profissional', 'Enterprise'],
                datasets: [{
                    data: [30, 50, 20],
                    backgroundColor: [
                        'rgb(54, 162, 235)',
                        'rgb(75, 192, 192)',
                        'rgb(153, 102, 255)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection 