<?php

namespace App\View\Components;

use App\Models\Image;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Component;

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
        if($image){
            $url = Storage::url($image->image);
            $contents = Storage::disk('public')->get($image->image);
            $size = getimagesize(Storage::disk('public')->path($image->image));
            dump($size);
        }
        return view('components.post-component', ['image' => $image]);
    }
}
