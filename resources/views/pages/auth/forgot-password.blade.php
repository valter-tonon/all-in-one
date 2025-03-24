<?php

use Illuminate\Support\Facades\Password;
use function Livewire\Volt\state;

state(['email' => '', 'status' => null]);

$sendPasswordResetLink = function () {
    $this->validate([
        'email' => ['required', 'email'],
    ]);

    $status = Password::sendResetLink(
        $this->only('email')
    );

    if ($status === Password::RESET_LINK_SENT) {
        $this->status = __($status);
        $this->email = '';
    } else {
        $this->addError('email', __($status));
    }
};

?>

<div>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
                Recuperar Senha
            </h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <div class="mb-4 text-sm text-gray-600">
                Esqueceu sua senha? Sem problemas. Basta nos informar seu endereço de e-mail e enviaremos um link de redefinição de senha que permitirá que você escolha uma nova.
            </div>

            @if ($status)
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ $status }}
                </div>
            @endif

            <form wire:submit="sendPasswordResetLink" class="space-y-6">
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
                    <button type="submit" 
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Enviar Link de Recuperação
                    </button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm text-gray-500">
                <a href="{{ route('login') }}" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">
                    Voltar para o Login
                </a>
            </p>
        </div>
    </div>
</div> 