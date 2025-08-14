<?php

namespace App\Livewire\Dashboard\Pages\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class AuthForm extends Component
{
    public $email;
    public $password;
    public $remember = true;

    public function login()
    {
        $this->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->regenerate();

            return redirect()->route('dashboard.index');
        }

        throw ValidationException::withMessages([
            'validation' => 'E-mail ou senha inválidos.',
        ]);
    }

    public function render()
    {
        return view('livewire.dashboard.pages.auth.auth-form')->layout('livewire.dashboard.layouts.login');
    }
}
