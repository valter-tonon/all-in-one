<?php

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use function Livewire\Volt\state;

state(['password' => '']);

$confirmPassword = function () {
    $this->validate([
        'password' => ['required'],
    ]);

    if (! Auth::guard('web')->validate([
        'email' => Auth::user()->email,
        'password' => $this->password,
    ])) {
        throw ValidationException::withMessages([
            'password' => __('auth.password'),
        ]);
    }

    session(['auth.password_confirmed_at' => time()]);

    $this->redirect(
        session('url.intended', RouteServiceProvider::HOME),
        navigate: true
    );
};

?>

<div>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
                Confirmar Senha
            </h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <div class="mb-4 text-sm text-gray-600">
                Esta é uma área segura do aplicativo. Por favor, confirme sua senha antes de continuar.
            </div>

            <form wire:submit="confirmPassword" class="space-y-6">
                <div>
                    <label for="password" class="block text-sm font-medium leading-6 text-gray-900">
                        Senha
                    </label>
                    <div class="mt-2">
                        <input wire:model="password" id="password" name="password" type="password" autocomplete="current-password" required 
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <button type="submit" 
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Confirmar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div> 