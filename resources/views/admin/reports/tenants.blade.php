@extends('layouts.admin')

@section('title', 'Relatório de Inquilinos')

@section('content')
<div class="container px-6 mx-auto grid">
    <div class="flex justify-between items-center">
        <h2 class="my-6 text-2xl font-semibold text-gray-700">
            Relatório de Inquilinos
        </h2>
        <a href="{{ route('reports') }}" class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
            <svg class="w-4 h-4 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Voltar</span>
        </a>
    </div>

    <!-- Cartões de estatísticas -->
    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
        <!-- Cartão Total de Inquilinos -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs">
            <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">
                    Total de Inquilinos
                </p>
                <p class="text-lg font-semibold text-gray-700">
                    128
                </p>
            </div>
        </div>
        
        <!-- Cartão Inquilinos Ativos -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs">
            <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">
                    Inquilinos Ativos
                </p>
                <p class="text-lg font-semibold text-gray-700">
                    115
                </p>
            </div>
        </div>
        
        <!-- Cartão Inquilinos Inativos -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs">
            <div class="p-3 mr-4 text-red-500 bg-red-100 rounded-full">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">
                    Inquilinos Inativos
                </p>
                <p class="text-lg font-semibold text-gray-700">
                    13
                </p>
            </div>
        </div>
        
        <!-- Cartão Novos Inquilinos (Mês) -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs">
            <div class="p-3 mr-4 text-purple-500 bg-purple-100 rounded-full">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">
                    Novos Inquilinos (Mês)
                </p>
                <p class="text-lg font-semibold text-gray-700">
                    8
                </p>
            </div>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="grid gap-6 mb-8 md:grid-cols-2">
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs">
            <h4 class="mb-4 font-semibold text-gray-800">Inquilinos por Plano</h4>
            <div class="relative" style="height: 300px;">
                <canvas id="tenantsByPlanChart"></canvas>
            </div>
        </div>

        <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs">
            <h4 class="mb-4 font-semibold text-gray-800">Crescimento de Inquilinos</h4>
            <div class="relative" style="height: 300px;">
                <canvas id="tenantsGrowthChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Tabela de Inquilinos -->
    <div class="w-full overflow-hidden rounded-lg shadow-xs mb-8">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                        <th class="px-4 py-3">Inquilino</th>
                        <th class="px-4 py-3">Plano</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Data de Registro</th>
                        <th class="px-4 py-3">Último Acesso</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y">
                    <tr class="text-gray-700">
                        <td class="px-4 py-3">
                            <div class="flex items-center text-sm">
                                <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                    <div class="absolute inset-0 rounded-full bg-gray-200 flex items-center justify-center">
                                        <span class="text-xs font-medium text-gray-600">EC</span>
                                    </div>
                                </div>
                                <div>
                                    <p class="font-semibold">Empresa Comercial Ltda</p>
                                    <p class="text-xs text-gray-600">empresa@comercial.com</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            Profissional
                        </td>
                        <td class="px-4 py-3 text-xs">
                            <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full">
                                Ativo
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            15/03/2023
                        </td>
                        <td class="px-4 py-3 text-sm">
                            Hoje, 10:23
                        </td>
                    </tr>

                    <tr class="text-gray-700">
                        <td class="px-4 py-3">
                            <div class="flex items-center text-sm">
                                <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                    <div class="absolute inset-0 rounded-full bg-gray-200 flex items-center justify-center">
                                        <span class="text-xs font-medium text-gray-600">IS</span>
                                    </div>
                                </div>
                                <div>
                                    <p class="font-semibold">Indústria do Sul S.A.</p>
                                    <p class="text-xs text-gray-600">contato@industriasul.com</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            Enterprise
                        </td>
                        <td class="px-4 py-3 text-xs">
                            <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full">
                                Ativo
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            02/01/2023
                        </td>
                        <td class="px-4 py-3 text-sm">
                            Ontem, 15:45
                        </td>
                    </tr>

                    <tr class="text-gray-700">
                        <td class="px-4 py-3">
                            <div class="flex items-center text-sm">
                                <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                    <div class="absolute inset-0 rounded-full bg-gray-200 flex items-center justify-center">
                                        <span class="text-xs font-medium text-gray-600">MC</span>
                                    </div>
                                </div>
                                <div>
                                    <p class="font-semibold">Mercado Central</p>
                                    <p class="text-xs text-gray-600">admin@mercadocentral.com</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            Básico
                        </td>
                        <td class="px-4 py-3 text-xs">
                            <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full">
                                Inativo
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            10/11/2022
                        </td>
                        <td class="px-4 py-3 text-sm">
                            20/04/2023
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t bg-gray-50 sm:grid-cols-9">
            <span class="flex items-center col-span-3">
                Mostrando 3 de 128 inquilinos
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
        // Gráfico de Inquilinos por Plano
        const tenantsByPlanCtx = document.getElementById('tenantsByPlanChart').getContext('2d');
        new Chart(tenantsByPlanCtx, {
            type: 'pie',
            data: {
                labels: ['Básico', 'Profissional', 'Enterprise'],
                datasets: [{
                    data: [45, 65, 18],
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

        // Gráfico de Crescimento de Inquilinos
        const tenantsGrowthCtx = document.getElementById('tenantsGrowthChart').getContext('2d');
        new Chart(tenantsGrowthCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
                datasets: [{
                    label: 'Novos Inquilinos',
                    data: [5, 8, 12, 7, 10, 8],
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
                            precision: 0
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection 