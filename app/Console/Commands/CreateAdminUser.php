<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create {name?} {email?} {password?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria um usuário administrador';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name') ?? $this->ask('Nome do administrador');
        $email = $this->argument('email') ?? $this->ask('Email do administrador');
        $password = $this->argument('password') ?? $this->secret('Senha do administrador');

        // Verifica se o usuário já existe
        $existingUser = User::where('email', $email)->first();
        if ($existingUser) {
            $this->error("Usuário com email {$email} já existe!");
            return 1;
        }

        // Cria o usuário
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'email_verified_at' => now(),
        ]);

        $this->info("Usuário administrador {$name} criado com sucesso!");
        return 0;
    }
} 