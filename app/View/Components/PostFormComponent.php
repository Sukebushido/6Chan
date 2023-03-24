<?php

namespace App\View\Components;

use App\Models\Thread;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PostFormComponent extends Component
{
    public $thread;
    /**
     * Create a new component instance.
     */
    public function __construct($threadId)
    {
        $this->thread = Thread::find($threadId);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {   
        return view('components.post-form-component');
    }
}
