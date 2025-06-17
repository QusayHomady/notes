<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Noteapp extends Model
{
   protected $table="noteapp";
   
protected $primaryKey = 'notes_id';

   protected $guarded=["note_id"];



   public function user(){
    $this->belongsToMany(User::class,"favorites");
   }

   
       public $timestamps = true;

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->translatedFormat('d M Y - h:i A')
        );
    }

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->translatedFormat('d M Y - h:i A')
        );
    }
   
}
