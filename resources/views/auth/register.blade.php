<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-r from-blue-500 to-purple-600">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="flex justify-center mb-8">
                <x-authentication-card-logo />
            </div>
            
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-8">
                {{ __('Criar Nova Conta') }}
            </h2>

            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <div>
                    <x-label for="name" value="{{ __('Nome Completo') }}" class="text-sm font-medium text-gray-700" />
                    <x-input id="name" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm shadow-sm placeholder-gray-400
                        focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" 
                        type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                </div>

                <div>
                    <x-label for="email" value="{{ __('E-mail') }}" class="text-sm font-medium text-gray-700" />
                    <x-input id="email" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm shadow-sm placeholder-gray-400
                        focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" 
                        type="email" name="email" :value="old('email')" required autocomplete="username" />
                </div>

                <div>
                    <x-label for="password" value="{{ __('Senha') }}" class="text-sm font-medium text-gray-700" />
                    <x-input id="password" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm shadow-sm placeholder-gray-400
                        focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" 
                        type="password" name="password" required autocomplete="new-password" />
                </div>

                <div>
                    <x-label for="password_confirmation" value="{{ __('Confirmar Senha') }}" class="text-sm font-medium text-gray-700" />
                    <x-input id="password_confirmation" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm shadow-sm placeholder-gray-400
                        focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" 
                        type="password" name="password_confirmation" required autocomplete="new-password" />
                </div>

                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <x-checkbox name="terms" id="terms" required />
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="terms" class="font-medium text-gray-700">
                                {!! __('Eu concordo com os :terms_of_service e :privacy_policy', [
                                    'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="text-blue-600 hover:text-blue-500">'.__('Termos de Serviço').'</a>',
                                    'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="text-blue-600 hover:text-blue-500">'.__('Política de Privacidade').'</a>',
                                ]) !!}
                            </label>
                        </div>
                    </div>
                @endif

                <div class="flex items-center justify-between mt-6">
                    <a class="text-sm text-blue-600 hover:text-blue-500 font-medium" href="{{ route('login') }}">
                        {{ __('Já tem uma conta?') }}
                    </a>

                    <x-button class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                        {{ __('Registrar') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout> 