<?php

namespace App\Http\Controllers;

use App\Detail;
use Illuminate\Http\Request;

class DetailsController extends Controller
{
  public function list(){
      $details = Detail::orderBy('sorting')->get();
      return view("welcome",compact('details'));
  }

  public function sortDetails()
    {
        $posts = Detail::orderBy('sorting', 'ASC')->get();
        $id = request()->input('id');
        $sorting = request()->input('sorting');
        foreach ($posts as $item) {
            return Detail::where('id', '=', $id)->update(array('sorting' => $sorting));
        }
    }
}
