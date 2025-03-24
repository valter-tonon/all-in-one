<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UserMenu extends Component
{
    public function logout()
    {
        Auth::logout();
        
        session()->invalidate();
        session()->regenerateToken();
        
        return redirect('/login');
    }
    
    public function render()
    {
        return view('livewire.admin.user-menu', [
            'user' => Auth::user(),
        ]);
    }
} 