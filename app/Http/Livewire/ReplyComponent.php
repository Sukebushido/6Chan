<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ReplyComponent extends Component
{
    public $boardName;
    public $show;

    // protected $listeners = ['show' => 'render'];

    public function render()
    {
        return view('livewire.reply-component');
    }
}
