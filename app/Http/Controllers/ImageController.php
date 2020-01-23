<?php

namespace App\Http\Controllers;

use App\Image;
use App\Lib;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{

    public function list(){
        $libs = Lib::with('images')->get();
        // dd($libs);
        return view("list",["libs"=>$libs]);
    }

    public function show($id =1){
        return view("welcome",['lib'=>Lib::where('id',$id)->first()]);
    }



    public function saveImage(){
        $path = request()->file->store('public/files');
        $image = new Image();
        $path = "/storage/".substr($path,7);
        $image->file_name = $path;
        if(request()->input('id')){
            $image->lib_id = request()->input('id');
        }
        $image->save();
        return $path;
    }

    public function createLib(Lib $lib){
        
        $id = request()->only('id');
        if($id){
            Lib::where('id',$id)->update(["name"=>request("name"),"description"=>request("description")]);
            $id=$id["id"];
        }else{
            // create
            $lib->fill(request()->only($lib->getFillable()));
            $lib->save();
            $id= $lib->id;
        }
        // dd(Image::whereIn('file_name',request()->images)->where('lib_id',"==","")->get());
        if(request()->images){
            $files = Image::where('lib_id',"==","")->whereIn('file_name',request()->images)->update(["lib_id"=>$id]);
        }
        return back()->with('status','success');
    }

    public function deleteImage(){
        Image::where("file_name",request()->input('name'))->delete();
        return response()->json(['status'=>"success"]);
    }

}
