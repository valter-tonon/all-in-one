<?php

use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use function Livewire\Volt\state;

state([
    'email' => '',
    'password' => '',
    'remember' => false,
]);

$login = function () {
    $validated = $this->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $throttleKey = Str::transliterate(Str::lower($this->email).'|'.request()->ip());

    if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($throttleKey);

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    if (! auth()->attempt($validated, $this->remember)) {
        RateLimiter::hit($throttleKey);

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    RateLimiter::clear($throttleKey);

    session()->regenerate();

    $this->redirect(session('url.intended', RouteServiceProvider::HOME));
};

?>

<div>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
                Entrar na sua conta
            </h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form wire:submit="login" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">
                        Email
                    </label>
                    <div class="mt-2">
                        <input wire:model="email" id="email" name="email" type="email" autocomplete="email" required 
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">
                            Senha
                        </label>
                        @if (Route::has('password.request'))
                        <div class="text-sm">
                            <a href="{{ route('password.request') }}" class="font-semibold text-indigo-600 hover:text-indigo-500">
                                Esqueceu sua senha?
                            </a>
                        </div>
                        @endif
                    </div>
                    <div class="mt-2">
                        <input wire:model="password" id="password" name="password" type="password" autocomplete="current-password" required 
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center">
                    <input wire:model="remember" id="remember" name="remember" type="checkbox" 
                        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                    <label for="remember" class="ml-2 block text-sm text-gray-900">
                        Lembrar de mim
                    </label>
                </div>

                <div>
                    <button type="submit" 
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Entrar
                    </button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm text-gray-500">
                Não tem uma conta?
                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">
                    Registre-se
                </a>
                @endif
            </p>
        </div>
    </div>
</div> 