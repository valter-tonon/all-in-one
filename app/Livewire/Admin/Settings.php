<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class Settings extends Component
{
    public $generalSettings = [
        'site_name' => 'CRM-ERP All-in-One',
        'admin_email' => 'admin@example.com',
        'timezone' => 'America/Sao_Paulo',
    ];
    
    public $emailSettings = [
        'mail_driver' => 'smtp',
        'mail_host' => 'smtp.mailtrap.io',
        'mail_port' => '2525',
        'mail_username' => '',
        'mail_password' => '',
        'mail_encryption' => 'tls',
        'mail_from_address' => 'noreply@example.com',
        'mail_from_name' => 'CRM-ERP All-in-One',
    ];
    
    public $securitySettings = [
        'login_attempts' => 5,
        'lockout_time' => 15,
        'password_expiry_days' => 90,
        'require_2fa' => false,
    ];
    
    public function mount()
    {
        // Carregar configurações do arquivo ou banco de dados
        $this->loadSettings();
    }
    
    public function loadSettings()
    {
        // Aqui você pode carregar as configurações de um arquivo JSON ou do banco de dados
        // Por enquanto, vamos usar valores padrão definidos acima
        
        // Exemplo de carregamento de um arquivo JSON (se existir)
        if (Storage::exists('settings.json')) {
            $settings = json_decode(Storage::get('settings.json'), true);
            
            if (isset($settings['general'])) {
                $this->generalSettings = array_merge($this->generalSettings, $settings['general']);
            }
            
            if (isset($settings['email'])) {
                $this->emailSettings = array_merge($this->emailSettings, $settings['email']);
            }
            
            if (isset($settings['security'])) {
                $this->securitySettings = array_merge($this->securitySettings, $settings['security']);
            }
        }
    }
    
    public function saveSettings()
    {
        // Validar os dados
        $this->validate([
            'generalSettings.site_name' => 'required|string|max:255',
            'generalSettings.admin_email' => 'required|email',
            'generalSettings.timezone' => 'required|string',
            
            'emailSettings.mail_driver' => 'required|string',
            'emailSettings.mail_host' => 'required_if:emailSettings.mail_driver,smtp',
            'emailSettings.mail_port' => 'required_if:emailSettings.mail_driver,smtp|numeric',
            
            'securitySettings.login_attempts' => 'required|integer|min:1|max:10',
            'securitySettings.lockout_time' => 'required|integer|min:1',
            'securitySettings.password_expiry_days' => 'required|integer|min:0',
        ]);
        
        // Salvar as configurações em um arquivo JSON
        $settings = [
            'general' => $this->generalSettings,
            'email' => $this->emailSettings,
            'security' => $this->securitySettings,
        ];
        
        Storage::put('settings.json', json_encode($settings, JSON_PRETTY_PRINT));
        
        // Atualizar as configurações compartilhadas
        $this->updateSharedSettings();
        
        // Notificar o usuário
        session()->flash('message', 'Configurações salvas com sucesso!');
    }
    
    protected function updateSharedSettings()
    {
        // Atualizar as configurações compartilhadas com todas as views
        view()->share('siteSettings', $this->generalSettings);
    }
    
    public function render()
    {
        return view('livewire.admin.settings')
            ->layout('components.layouts.app');
    }
} 