<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{   
// $table property of Eloquent ORM to indicate which table we are working
    protected $table = 'images';
    
    
    // One to Many Relationship
    // 1 image models many comments
        public function comments(){
         return $this->hasMany('App\Comment')->orderBy('id','desc');
         }
         
         // One To Many Relationship
         
         public function likes(){
             return $this->hasMany('App\Like');
                         
         }
             //Many to One Relationship
         //Many images can be created by a user
         public function user(){
             return $this->belongsTo('App\User', 'user_id');
         }
    
         
    
    
}
