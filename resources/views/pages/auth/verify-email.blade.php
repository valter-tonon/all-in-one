<?php

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use function Livewire\Volt\state;

state(['status' => null]);

$sendVerification = function () {
    if (Auth::user()->hasVerifiedEmail()) {
        $this->redirect(
            RouteServiceProvider::HOME,
            navigate: true
        );

        return;
    }

    Auth::user()->sendEmailVerificationNotification();

    $this->status = 'verification-link-sent';
};

$logout = function () {
    Auth::guard('web')->logout();

    session()->invalidate();
    session()->regenerateToken();

    $this->redirect('/', navigate: true);
};

?>

<div>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
                Verificação de Email
            </h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <div class="mb-4 text-sm text-gray-600">
                Obrigado por se registrar! Antes de começar, você poderia verificar seu endereço de e-mail clicando no link que acabamos de enviar para você? Se você não recebeu o e-mail, teremos prazer em enviar outro.
            </div>

            @if ($status === 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-600">
                    Um novo link de verificação foi enviado para o endereço de e-mail fornecido durante o registro.
                </div>
            @endif

            <div class="mt-4 flex items-center justify-between">
                <button wire:click="sendVerification" type="button"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-600 disabled:opacity-25 transition">
                    Reenviar Email de Verificação
                </button>

                <button wire:click="logout" type="button"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Sair
                </button>
            </div>
        </div>
    </div>
</div> 