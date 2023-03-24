<?php

namespace App\View\Components;

use App\Models\Image;
use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;

class PostComponent extends Component
{
    public $post;
    /**
     * Create a new component instance.
     */
    public function __construct($post)
    {
        $this->post = $post;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $image = Image::find($this->post->image_id);
        return view('components.post-component', ['image' => $image]);
    }
}
