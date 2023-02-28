<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ReplyComponent extends Component
{
    public $boardName;

    protected $listeners = ['postAdded' => 'displayKek'];

    public function displayKek()
    {
        return  <<<'blade'
        <div>Kek</div>
        blade;
    }

    // public function render()
    // {
    //     return view('livewire.reply-component');
    // }
}
