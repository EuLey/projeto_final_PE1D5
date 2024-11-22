<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Cadastro extends Component
{
    public $nome;
    public $email;
    public $senha;
    public $confirmarSenha;

    public function render()
    {
        return view('livewire.cadastro');
    }

    public function criarUsuario()
    {
        if ($this->nome == '' || $this->email == '' || $this->senha == '') {
            $this->dispatch('erro-cadastro');
            return;
        }
        if ($this->senha == $this->confirmarSenha) {
            User::create([
                'name' => $this->nome,
                'email' => $this->email,
                'password' => Hash::make($this->senha),
            ]);
            $this->redirectRoute('login');
        }
    }
}
