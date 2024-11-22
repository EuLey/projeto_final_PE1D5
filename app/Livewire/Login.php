<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $email;
    public $senha;

    public function render()
    {
        return view('livewire.login');
    }

    public function fazerLogin()
    {
        if ($this->email === null || $this->senha === null) {
            $this->dispatch('erro-login');
            return;
        }
        Auth::attempt(['email' => $this->email, 'password' => $this->senha]);
        $this->redirectRoute('transcrever-link');

    }
}
