@extends('layouts.admin')

@section('title', 'Relatório de Receita')

@section('content')
<div class="container px-6 mx-auto grid">
    <div class="flex justify-between items-center">
        <h2 class="my-6 text-2xl font-semibold text-gray-700">
            Relatório de Receita
        </h2>
        <a href="{{ route('reports') }}" class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
            <svg class="w-4 h-4 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Voltar</span>
        </a>
    </div>

    <!-- Filtros de Data -->
    <div class="mb-8 bg-white rounded-lg shadow-md p-4">
        <div class="flex flex-wrap items-center justify-between">
            <h4 class="text-lg font-semibold text-gray-700 mb-4 md:mb-0">Filtrar por Período</h4>
            <div class="flex flex-wrap gap-4">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Data Inicial</label>
                    <input type="date" id="start_date" name="start_date" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Data Final</label>
                    <input type="date" id="end_date" name="end_date" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="flex items-end">
                    <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Aplicar Filtro
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Cartões de estatísticas -->
    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
        <!-- Cartão Receita Total -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs">
            <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">
                    Receita Total
                </p>
                <p class="text-lg font-semibold text-gray-700">
                    R$ 123.456,00
                </p>
            </div>
        </div>
        
        <!-- Cartão Receita Mensal -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs">
            <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">
                    Receita Mensal
                </p>
                <p class="text-lg font-semibold text-gray-700">
                    R$ 30.000,00
                </p>
            </div>
        </div>
        
        <!-- Cartão Crescimento -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs">
            <div class="p-3 mr-4 text-purple-500 bg-purple-100 rounded-full">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">
                    Crescimento (Mês)
                </p>
                <p class="text-lg font-semibold text-green-700">
                    +15%
                </p>
            </div>
        </div>
        
        <!-- Cartão Ticket Médio -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs">
            <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">
                    Ticket Médio
                </p>
                <p class="text-lg font-semibold text-gray-700">
                    R$ 250,00
                </p>
            </div>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="grid gap-6 mb-8 md:grid-cols-2">
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs">
            <h4 class="mb-4 font-semibold text-gray-800">Receita Mensal (2023)</h4>
            <div class="relative" style="height: 300px;">
                <canvas id="monthlyRevenueChart"></canvas>
            </div>
        </div>

        <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs">
            <h4 class="mb-4 font-semibold text-gray-800">Receita por Plano</h4>
            <div class="relative" style="height: 300px;">
                <canvas id="revenueByPlanChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Tabela de Transações -->
    <div class="w-full overflow-hidden rounded-lg shadow-xs mb-8">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Inquilino</th>
                        <th class="px-4 py-3">Plano</th>
                        <th class="px-4 py-3">Valor</th>
                        <th class="px-4 py-3">Data</th>
                        <th class="px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y">
                    <tr class="text-gray-700">
                        <td class="px-4 py-3 text-sm">
                            #12345
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center text-sm">
                                <div>
                                    <p class="font-semibold">Empresa Comercial Ltda</p>
                                    <p class="text-xs text-gray-600">empresa@comercial.com</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            Profissional
                        </td>
                        <td class="px-4 py-3 text-sm">
                            R$ 299,00
                        </td>
                        <td class="px-4 py-3 text-sm">
                            15/06/2023
                        </td>
                        <td class="px-4 py-3 text-xs">
                            <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full">
                                Pago
                            </span>
                        </td>
                    </tr>

                    <tr class="text-gray-700">
                        <td class="px-4 py-3 text-sm">
                            #12344
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center text-sm">
                                <div>
                                    <p class="font-semibold">Indústria do Sul S.A.</p>
                                    <p class="text-xs text-gray-600">contato@industriasul.com</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            Enterprise
                        </td>
                        <td class="px-4 py-3 text-sm">
                            R$ 599,00
                        </td>
                        <td class="px-4 py-3 text-sm">
                            14/06/2023
                        </td>
                        <td class="px-4 py-3 text-xs">
                            <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full">
                                Pago
                            </span>
                        </td>
                    </tr>

                    <tr class="text-gray-700">
                        <td class="px-4 py-3 text-sm">
                            #12343
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center text-sm">
                                <div>
                                    <p class="font-semibold">Mercado Central</p>
                                    <p class="text-xs text-gray-600">admin@mercadocentral.com</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            Básico
                        </td>
                        <td class="px-4 py-3 text-sm">
                            R$ 99,00
                        </td>
                        <td class="px-4 py-3 text-sm">
                            10/06/2023
                        </td>
                        <td class="px-4 py-3 text-xs">
                            <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full">
                                Pendente
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t bg-gray-50 sm:grid-cols-9">
            <span class="flex items-center col-span-3">
                Mostrando 3 de 50 transações
            </span>
            <span class="col-span-2"></span>
            <!-- Paginação -->
            <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                <nav aria-label="Table navigation">
                    <ul class="inline-flex items-center">
                        <li>
                            <button class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-blue" aria-label="Previous">
                                <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20">
                                    <path d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path>
                                </svg>
                            </button>
                        </li>
                        <li>
                            <button class="px-3 py-1 text-white transition-colors duration-150 bg-blue-600 border border-r-0 border-blue-600 rounded-md focus:outline-none focus:shadow-outline-blue">
                                1
                            </button>
                        </li>
                        <li>
                            <button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-blue">
                                2
                            </button>
                        </li>
                        <li>
                            <button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-blue">
                                3
                            </button>
                        </li>
                        <li>
                            <button class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-blue" aria-label="Next">
                                <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20">
                                    <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path>
                                </svg>
                            </button>
                        </li>
                    </ul>
                </nav>
            </span>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gráfico de Receita Mensal
        const monthlyRevenueCtx = document.getElementById('monthlyRevenueChart').getContext('2d');
        new Chart(monthlyRevenueCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                datasets: [{
                    label: 'Receita Mensal (R$)',
                    data: [15000, 18000, 22000, 25000, 28000, 30000, 32000, 35000, 38000, 40000, 42000, 45000],
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgb(54, 162, 235)',
                    borderWidth: 1
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

        // Gráfico de Receita por Plano
        const revenueByPlanCtx = document.getElementById('revenueByPlanChart').getContext('2d');
        new Chart(revenueByPlanCtx, {
            type: 'doughnut',
            data: {
                labels: ['Básico', 'Profissional', 'Enterprise'],
                datasets: [{
                    data: [15000, 35000, 50000],
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
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.raw || 0;
                                return label + ': R$ ' + value.toLocaleString('pt-BR');
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection 