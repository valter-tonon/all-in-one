<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Application\DTOs\TenantDTO;
use App\Application\Services\TenantService;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class TenantRegistrationController extends Controller
{
    protected $tenantService;

    public function __construct(TenantService $tenantService)
    {
        $this->tenantService = $tenantService;
    }

    /**
     * Exibe o formulário de registro para um novo tenant
     */
    public function showRegistrationForm(Request $request)
    {
        $plan = $request->query('plan', 'basic');
        return view('tenant.register', ['plan' => $plan]);
    }

    /**
     * Processa o registro de um novo tenant
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'plan' => ['required', 'string', 'in:basic,professional,enterprise'],
        ]);

        try {
            DB::beginTransaction();
            
            // Criar o usuário
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'email_verified_at' => now(), // Considerar remover isso e implementar verificação de email
            ]);

            // Criar o tenant
            $domain = Str::slug($validated['company_name']) . '.localhost';
            $database = 'tenant_' . Str::slug($validated['company_name']);
            
            $tenantDto = new TenantDTO(
                name: $validated['company_name'],
                database: $database,
                domain: $domain,
                plan: $validated['plan']
            );
            
            $tenant = $this->tenantService->create($tenantDto);
            
            // Associar o usuário ao tenant (isso depende da implementação específica do seu sistema)
            // Exemplo: $tenant->users()->attach($user->id);
            
            DB::commit();
            
            // Fazer login do usuário
            Auth::login($user);
            
            // Redirecionar para o painel do tenant
            return redirect()->to('http://' . $domain . '/login');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Ocorreu um erro ao criar o tenant: ' . $e->getMessage()]);
        }
    }
} 