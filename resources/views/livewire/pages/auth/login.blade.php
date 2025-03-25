<?php

use App\Livewire\Forms\LoginForm;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        // Redirecionamento direto sem navigate:true para evitar problemas
        redirect()->intended(RouteServiceProvider::HOME);
    }
}; ?>

<div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-500 to-purple-600 py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8 bg-white p-12 rounded-xl shadow-2xl">
        <div class="text-center">
            <h2 class="mt-2 text-4xl font-extrabold text-gray-800">
                CRM-ERP All-in-One
            </h2>
            <p class="mt-3 text-base text-gray-600">
                Faça login para acessar o painel administrativo
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form wire:submit="login" class="mt-8 space-y-6">
            <!-- Email Address -->
            <div>
                <label for="email" class="block text-base font-medium text-gray-700">Email</label>
                <div class="mt-1">
                    <input wire:model="form.email" id="email" name="email" type="email" autocomplete="email" required 
                        class="appearance-none block w-full px-6 py-4 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-base" 
                        placeholder="seu@email.com">
                </div>
                <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-6">
                <label for="password" class="block text-base font-medium text-gray-700">Senha</label>
                <div class="mt-1">
                    <input wire:model="form.password" id="password" name="password" type="password" autocomplete="current-password" required 
                        class="appearance-none block w-full px-6 py-4 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-base" 
                        placeholder="••••••••">
                </div>
                <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between mt-6">
                <div class="flex items-center">
                    <input wire:model="form.remember" id="remember" name="remember" type="checkbox" 
                        class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-base text-gray-700">
                        Lembrar-me
                    </label>
                </div>

                @if (Route::has('password.request'))
                    <div class="text-base">
                        <a href="{{ route('password.request') }}" class="font-medium text-blue-600 hover:text-blue-500">
                            Esqueceu sua senha?
                        </a>
                    </div>
                @endif
            </div>

            <div class="mt-8">
                <button type="submit" class="w-full flex justify-center py-4 px-6 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                    Entrar
                </button>
            </div>
            
            <div class="text-center mt-4">
                <span class="text-base text-gray-600">Não tem uma conta?</span>
                <a href="{{ route('register') }}" wire:navigate class="ml-1 font-medium text-blue-600 hover:text-blue-500">
                    Registre-se
                </a>
            </div>
        </form>
    </div>
</div>
