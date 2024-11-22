<?php

namespace App\Livewire;

use Livewire\Component;

class Historico extends Component
{
    public $transcricao;
    public $input;

    public function render()
    {
        return view('livewire.historico');
    }

    public function mount($id)
    {
        $this->transcricao = \App\Models\Transcription::where('id_video', $id)->first();
        $this->input = \App\Models\Video::find($id);
        $this->input = $this->input->titulo;
    }
}
