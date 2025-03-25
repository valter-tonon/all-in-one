@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-r from-blue-500 to-purple-600">
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <div class="flex justify-center mb-8">
            <h1 class="text-gray-900 font-bold text-xl">CRM-ERP SaaS</h1>
        </div>
        
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-8">
            Crie sua Conta Empresarial
        </h2>
        
        <p class="text-center text-gray-600 mb-6">
            Plano selecionado: <span class="font-semibold">{{ ucfirst($plan) }}</span>
            <br>
            <span class="text-sm">30 dias grátis, sem compromisso</span>
        </p>

        @if ($errors->any())
            <div class="mb-4">
                <div class="font-medium text-red-600">
                    {{ __('Ops! Algo deu errado.') }}
                </div>

                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif
        
        @if (session('error'))
            <div class="mb-4 font-medium text-sm text-red-600">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('tenant.register') }}" class="space-y-6">
            @csrf
            
            <input type="hidden" name="plan" value="{{ $plan }}">

            <!-- Company Name -->
            <div>
                <label for="company_name" class="block text-sm font-medium text-gray-700">Nome da Empresa</label>
                <input id="company_name" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm shadow-sm placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" 
                         type="text" name="company_name" value="{{ old('company_name') }}" required autofocus />
            </div>
            
            <!-- Owner Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Seu Nome Completo</label>
                <input id="name" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm shadow-sm placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" 
                         type="text" name="name" value="{{ old('name') }}" required />
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Seu E-mail</label>
                <input id="email" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm shadow-sm placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" 
                         type="email" name="email" value="{{ old('email') }}" required />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                <input id="password" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm shadow-sm placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" 
                         type="password" name="password" required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Senha</label>
                <input id="password_confirmation" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm shadow-sm placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" 
                         type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="mt-8">
                <button type="submit" class="w-full justify-center py-2.5 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                    Criar Minha Conta
                </button>
            </div>
            
            <div class="text-center text-sm text-gray-600 mt-4">
                Ao clicar em "Criar Minha Conta", você concorda com nossos 
                <a href="#" class="text-blue-600 hover:text-blue-500">Termos de Serviço</a> e 
                <a href="#" class="text-blue-600 hover:text-blue-500">Política de Privacidade</a>.
            </div>
        </form>
        
        <div class="text-center mt-6">
            <p class="text-sm text-gray-600">
                Já tem uma conta? 
                <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                    Faça login
                </a>
            </p>
        </div>
    </div>
</div>
@endsection 