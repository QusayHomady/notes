<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Noteapp extends Model
{
   protected $table="noteapp";
   
protected $primaryKey = 'notes_id';

   protected $guarded=["note_id"];

        public $timestamps = false;


   public function user(){
    $this->belongsToMany(User::class,"favorites");
   }
   
}
