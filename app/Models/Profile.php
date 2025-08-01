<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded=["id"];

    protected $table="profile";
    
    public $timestamps = false;
    
   public function user(){
    return $this->belongsTo(User::class);
   }     

}
