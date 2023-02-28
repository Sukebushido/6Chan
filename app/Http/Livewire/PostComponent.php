<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PostComponent extends Component
{
    public $post;
    public $show = false;

    protected $listeners = ['show'];

    public function show(){
        $this->show = !$this->show;
    }
    
    public function render()
    {
        return view('livewire.post-component');
    }
}
