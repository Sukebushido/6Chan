<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function index()
    {   
        $images = Image::all();

        // dd($images);
        return view('image', ['images' => $images]);
    }

    public function store(Request $request){
        $this->validate($request, [
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);

        $image_path = $request->file('image')->store('image', 'public');

        $data = Image::create([
            'image' => $image_path
        ]);

        session()->flash('success', 'Image Upload successfully');

        return redirect()->route('image.index');
    }
}
