<?php

namespace App\Http\Controllers;

use App\Image;
use App\Lib;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function saveImage(){
        $path = request()->file->store('files');
        $image = new Image();
        $image->file_name = $path;
        $image->save();
        // Storage::put("files/",request()->file);
        return $path;
        // dd(request()->allFiles());
    }

    public function createLib(Lib $lib){
        return back()->with('status','success');
    }

}
