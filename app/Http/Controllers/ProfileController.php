<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequset;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

public function alldata(){
   $profile =Auth::user()->profile;
    return response()->json($profile);
}


   public function show($id){
    $profile=Profile::where("userid",$id)->firstOrFail();
    return response()->json([$profile]);
   }

   public function store (ProfileRequset $request) {
      $user_id=Auth::user()->id;
      $valdated=$request->validated();
      $valdated["userid"]=$user_id;
    $profile=Profile::create($valdated);
    return response()->json($profile,200);
   }

   
}
