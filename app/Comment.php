<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $table='comments';
    
         //Many to One Relationship
         //Many comments can be created by a user
         public function user(){
             return $this->belongsTo('App\User', 'user_id');
         }
         
         //Many to One Relationship
         //Many comments can have an image
         public function image(){
             return $this->belongsTo('App\Image', 'image_id');
         }
    
}
