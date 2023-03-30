<?php

namespace App\View\Components;

use App\Models\Board;
use App\Models\Thread;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PostFormComponent extends Component
{
    public $isThread = false;
    public $thread = null;
    public $boardName;
    /**
     * Create a new component instance.
     */
    public function __construct($isThread, $threadId, $boardName)
    {
        $this->isThread = $isThread;
        if ($isThread) {
            $this->thread = Thread::find($threadId);
        }
        $this->boardName = $boardName;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {   
        return view('components.post-form-component');
    }
}
