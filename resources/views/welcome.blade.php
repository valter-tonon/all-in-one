<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CRM-ERP SaaS') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-gradient-to-br from-gray-900 to-gray-800 text-white">
        <!-- Navbar -->
        <nav class="bg-gray-800/80 backdrop-blur-sm fixed w-full z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <span class="text-red-500 text-2xl font-bold">CRM-ERP</span>
                            <span class="text-white text-xl">SaaS</span>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">
                            <a href="#recursos" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Recursos</a>
                            <a href="#planos" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Planos</a>
                            <a href="#contato" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Contato</a>
                            @auth
                                <a href="{{ url('admin/dashboard') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Entrar</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('tenant.register.form') }}?plan=professional" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium">Registrar</a>
                                @endif
                            @endauth
                        </div>
                    </div>
                    <div class="md:hidden">
                        <button type="button" class="mobile-menu-button bg-gray-700 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Mobile menu, show/hide based on menu state. -->
            <div class="mobile-menu hidden md:hidden">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                    <a href="#recursos" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Recursos</a>
                    <a href="#planos" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Planos</a>
                    <a href="#contato" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Contato</a>
                    @auth
                        <a href="{{ url('admin/dashboard') }}" class="bg-red-600 hover:bg-red-700 text-white block px-3 py-2 rounded-md text-base font-medium">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Entrar</a>
                        @if (Route::has('register'))
                            <a href="{{ route('tenant.register.form') }}?plan=professional" class="bg-red-600 hover:bg-red-700 text-white block px-3 py-2 rounded-md text-base font-medium">Registrar</a>
                        @endif
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative pt-16 pb-32 flex content-center items-center justify-center" style="min-height: 75vh;">
            <div class="absolute top-0 w-full h-full bg-center bg-cover" style="background-image: url('https://images.unsplash.com/photo-1557804506-669a67965ba0?ixlib=rb-1.2.1&auto=format&fit=crop&w=1267&q=80');">
                <span class="w-full h-full absolute opacity-75 bg-black"></span>
            </div>
            <div class="container relative mx-auto">
                <div class="items-center flex flex-wrap">
                    <div class="w-full lg:w-6/12 px-4 ml-auto mr-auto text-center">
                        <div>
                            <h1 class="text-white font-semibold text-5xl">
                                Solução Completa para sua Empresa
                            </h1>
                            <p class="mt-4 text-lg text-gray-300">
                                CRM e ERP integrados em uma única plataforma. Gerencie clientes, vendas, estoque e finanças com facilidade.
                            </p>
                            <div class="mt-10">
                                @auth
                                    <a href="{{ url('admin/dashboard') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-lg text-lg transition-all duration-300 transform hover:scale-105">
                                        Acessar Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('tenant.register.form') }}?plan=professional" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-lg text-lg transition-all duration-300 transform hover:scale-105">
                                        Começar Agora
                                    </a>
                                    <a href="{{ route('login') }}" class="ml-4 text-white border border-white hover:bg-white hover:text-gray-900 font-bold py-3 px-8 rounded-lg text-lg transition-all duration-300">
                                        Entrar
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <section id="recursos" class="py-20 bg-gray-800">
            <div class="container mx-auto px-4">
                <div class="flex flex-wrap justify-center text-center mb-16">
                    <div class="w-full lg:w-6/12 px-4">
                        <h2 class="text-4xl font-semibold text-white">Recursos Principais</h2>
                        <p class="text-lg leading-relaxed m-4 text-gray-300">
                            Tudo o que sua empresa precisa para crescer e se destacar no mercado.
                        </p>
                    </div>
                </div>
                <div class="flex flex-wrap">
                    <div class="w-full md:w-6/12 lg:w-3/12 px-4 mb-10">
                        <div class="px-6 py-8 bg-gray-700 rounded-lg shadow-lg text-center">
                            <div class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-red-600 text-white mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-white">CRM Completo</h3>
                            <p class="mt-4 text-gray-300">
                                Gerencie seus clientes, contatos e oportunidades de negócio em um único lugar.
                            </p>
                        </div>
                    </div>

                    <div class="w-full md:w-6/12 lg:w-3/12 px-4 mb-10">
                        <div class="px-6 py-8 bg-gray-700 rounded-lg shadow-lg text-center">
                            <div class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-red-600 text-white mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-white">ERP Integrado</h3>
                            <p class="mt-4 text-gray-300">
                                Controle seu estoque, vendas, compras e finanças em uma única plataforma.
                            </p>
                        </div>
                    </div>

                    <div class="w-full md:w-6/12 lg:w-3/12 px-4 mb-10">
                        <div class="px-6 py-8 bg-gray-700 rounded-lg shadow-lg text-center">
                            <div class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-red-600 text-white mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-white">Multitenancy</h3>
                            <p class="mt-4 text-gray-300">
                                Cada cliente tem seu próprio ambiente isolado e seguro com dados completamente separados.
                            </p>
                        </div>
                    </div>

                    <div class="w-full md:w-6/12 lg:w-3/12 px-4 mb-10">
                        <div class="px-6 py-8 bg-gray-700 rounded-lg shadow-lg text-center">
                            <div class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-red-600 text-white mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-white">Suporte Premium</h3>
                            <p class="mt-4 text-gray-300">
                                Conte com nossa equipe de suporte especializada para ajudar em qualquer questão.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pricing Section -->
        <section id="planos" class="py-20 bg-gray-900">
            <div class="container mx-auto px-4">
                <div class="flex flex-wrap justify-center text-center mb-16">
                    <div class="w-full lg:w-6/12 px-4">
                        <h2 class="text-4xl font-semibold text-white">Planos e Preços</h2>
                        <p class="text-lg leading-relaxed m-4 text-gray-300">
                            Escolha o plano ideal para o tamanho da sua empresa.
                        </p>
                    </div>
                </div>
                <div class="flex flex-wrap">
                    <div class="w-full md:w-4/12 px-4 mb-10">
                        <div class="px-6 py-8 bg-gray-800 rounded-lg shadow-lg text-center">
                            <h3 class="text-2xl font-semibold text-white">Básico</h3>
                            <div class="mt-4 text-5xl font-bold text-white">
                                R$99<span class="text-xl font-normal text-gray-400">/mês</span>
                            </div>
                            <p class="mt-4 text-gray-300">
                                Ideal para pequenas empresas
                            </p>
                            <ul class="mt-8 text-gray-300 space-y-3">
                                <li>Até 5 usuários</li>
                                <li>CRM básico</li>
                                <li>Controle de estoque</li>
                                <li>Suporte por email</li>
                            </ul>
                            <div class="mt-8">
                                <a href="{{ route('tenant.register.form') }}?plan=basic" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg transition-all duration-300">
                                    Começar Agora
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="w-full md:w-4/12 px-4 mb-10">
                        <div class="px-6 py-8 bg-gray-800 border-2 border-red-500 rounded-lg shadow-lg text-center transform scale-105">
                            <div class="absolute top-0 right-0 -mt-4 mr-16 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full">POPULAR</div>
                            <h3 class="text-2xl font-semibold text-white">Profissional</h3>
                            <div class="mt-4 text-5xl font-bold text-white">
                                R$199<span class="text-xl font-normal text-gray-400">/mês</span>
                            </div>
                            <p class="mt-4 text-gray-300">
                                Ideal para empresas em crescimento
                            </p>
                            <ul class="mt-8 text-gray-300 space-y-3">
                                <li>Até 20 usuários</li>
                                <li>CRM completo</li>
                                <li>ERP integrado</li>
                                <li>Suporte prioritário</li>
                            </ul>
                            <div class="mt-8">
                                <a href="{{ route('tenant.register.form') }}?plan=professional" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg transition-all duration-300">
                                    Começar Agora
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="w-full md:w-4/12 px-4 mb-10">
                        <div class="px-6 py-8 bg-gray-800 rounded-lg shadow-lg text-center">
                            <h3 class="text-2xl font-semibold text-white">Empresarial</h3>
                            <div class="mt-4 text-5xl font-bold text-white">
                                R$399<span class="text-xl font-normal text-gray-400">/mês</span>
                            </div>
                            <p class="mt-4 text-gray-300">
                                Ideal para grandes empresas
                            </p>
                            <ul class="mt-8 text-gray-300 space-y-3">
                                <li>Usuários ilimitados</li>
                                <li>CRM e ERP completos</li>
                                <li>Recursos personalizados</li>
                                <li>Suporte 24/7</li>
                            </ul>
                            <div class="mt-8">
                                <a href="{{ route('tenant.register.form') }}?plan=enterprise" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg transition-all duration-300">
                                    Começar Agora
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section id="contato" class="py-20 bg-gray-800">
            <div class="container mx-auto px-4">
                <div class="flex flex-wrap items-center">
                    <div class="w-full md:w-6/12 px-4 mr-auto ml-auto">
                        <h3 class="text-3xl font-semibold text-white">Pronto para transformar sua empresa?</h3>
                        <p class="mt-4 text-lg leading-relaxed text-gray-300">
                            Junte-se a milhares de empresas que já estão utilizando nossa plataforma para crescer e se destacar no mercado.
                        </p>
                        <div class="mt-8">
                            @auth
                                <a href="{{ url('admin/dashboard') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-lg text-lg transition-all duration-300 transform hover:scale-105">
                                    Acessar Dashboard
                                </a>
                            @else
                                <a href="{{ route('tenant.register.form') }}?plan=professional" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-lg text-lg transition-all duration-300 transform hover:scale-105">
                                    Começar Agora
                                </a>
                            @endauth
                        </div>
                    </div>
                    <div class="w-full md:w-4/12 px-4 mr-auto ml-auto">
                        <div class="relative flex flex-col min-w-0 break-words bg-gray-700 w-full mb-6 shadow-lg rounded-lg p-6">
                            <h4 class="text-xl font-semibold text-white mb-4">Entre em contato</h4>
                            <form>
                                <div class="mb-4">
                                    <input type="text" placeholder="Nome" class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full" />
                                </div>
                                <div class="mb-4">
                                    <input type="email" placeholder="Email" class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full" />
                                </div>
                                <div class="mb-4">
                                    <textarea rows="4" placeholder="Mensagem" class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full"></textarea>
                                </div>
                                <div class="text-center">
                                    <button type="button" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg transition-all duration-300">
                                        Enviar Mensagem
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 pt-8 pb-6">
            <div class="container mx-auto px-4">
                <div class="flex flex-wrap">
                    <div class="w-full md:w-4/12 px-4">
                        <h4 class="text-xl font-semibold text-white mb-4">CRM-ERP SaaS</h4>
                        <p class="text-gray-400 leading-relaxed">
                            A solução completa para gerenciamento de empresas, com CRM e ERP integrados em uma única plataforma.
                        </p>
                    </div>
                    <div class="w-full md:w-4/12 px-4">
                        <h4 class="text-xl font-semibold text-white mb-4">Links Úteis</h4>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <a href="#recursos" class="text-gray-400 hover:text-white">Recursos</a>
                            </li>
                            <li class="mb-2">
                                <a href="#planos" class="text-gray-400 hover:text-white">Planos</a>
                            </li>
                            <li class="mb-2">
                                <a href="#contato" class="text-gray-400 hover:text-white">Contato</a>
                            </li>
                        </ul>
                    </div>
                    <div class="w-full md:w-4/12 px-4">
                        <h4 class="text-xl font-semibold text-white mb-4">Contato</h4>
                        <div class="mt-2 text-gray-400">
                            <p>contato@crmerpsaas.com.br</p>
                            <p>(11) 99999-9999</p>
                        </div>
                    </div>
                </div>
                <hr class="my-6 border-gray-700" />
                <div class="flex flex-wrap items-center md:justify-between justify-center">
                    <div class="w-full md:w-4/12 px-4 mx-auto text-center">
                        <div class="text-sm text-gray-400">
                            Copyright © {{ date('Y') }} CRM-ERP SaaS v1.0 | Todos os direitos reservados
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <script>
            // Mobile menu toggle
            document.addEventListener('DOMContentLoaded', function() {
                const mobileMenuButton = document.querySelector('.mobile-menu-button');
                const mobileMenu = document.querySelector('.mobile-menu');
                
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            });
        </script>
    </body>
</html>
