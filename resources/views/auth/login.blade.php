<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-r from-blue-500 to-purple-600">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="flex justify-center mb-8">
                <x-authentication-card-logo />
            </div>
            
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-8">
                {{ __('Bem-vindo de volta!') }}
            </h2>

            <x-validation-errors class="mb-4" />

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <x-label for="email" value="{{ __('E-mail') }}" class="text-sm font-medium text-gray-700" />
                    <x-input id="email" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm shadow-sm placeholder-gray-400
                        focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" 
                        type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                </div>

                <div>
                    <x-label for="password" value="{{ __('Senha') }}" class="text-sm font-medium text-gray-700" />
                    <x-input id="password" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm shadow-sm placeholder-gray-400
                        focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" 
                        type="password" name="password" required autocomplete="current-password" />
                </div>

                <div class="flex items-center justify-between">
                    <label for="remember_me" class="flex items-center">
                        <x-checkbox id="remember_me" name="remember" />
                        <span class="ml-2 text-sm text-gray-600">{{ __('Lembrar-me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-blue-600 hover:text-blue-500" href="{{ route('password.request') }}">
                            {{ __('Esqueceu sua senha?') }}
                        </a>
                    @endif
                </div>

                <div class="flex flex-col space-y-4 mt-6">
                    <x-button class="w-full justify-center py-2.5 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                        {{ __('Entrar') }}
                    </x-button>

                    <div class="text-center">
                        <span class="text-sm text-gray-600">{{ __('Não tem uma conta?') }}</span>
                        <a href="{{ route('register') }}" class="text-sm text-blue-600 hover:text-blue-500 font-medium ml-1">
                            {{ __('Registre-se') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout> 