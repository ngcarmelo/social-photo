<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like; // Like model

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
       $user = \Auth::user();
       $likes = Like::where('user_id', $user->id)->orderBy('id', 'desc')
                            ->paginate(5);
       
       return view('like.index',[
           'likes' => $likes
       ]);
       
   } 
    
    
    
    public function like($image_id){
        //Get -->  user data and image
        $user = \Auth::user();
        
        //Check if like exist and  not duplicated
        $isset_like = Like::where('user_id',$user->id)
                ->where('image_id',$image_id)
                ->count();
       
        //var_dump($isset_like);
        
       //we are going to check with isset_like variable
        if($isset_like == 0){
        $like = new Like();
        $like->user_id = $user->id;
        $like->image_id = (int)$image_id;
        
        //Save like
        $like->save();
        
        // Because we are going to use http request (Ajax), we are going to use response()->json
        return response()->json([
            'like'=>$like
        ]);
        
                
        }else {
           return response()->json([
            'message'=>'El like ya existe'
        ]);
        }
        
    }
    
    public function dislike($image_id){
         //Get -->  user data and image
        $user = \Auth::user();
        
        //Check if like exist and  not duplicated
        $like = Like::where('user_id',$user->id)
                ->where('image_id', $image_id)
                ->first();  //with first we got a only object
       
               
        
        //var_dump($isset_like);
        
       //we are going to check with isset_like variable
        if($like){
              
        //Erase like
        $like->delete();
        
        // Because we are going to use http request (Ajax), we are going to use response()->json
        return response()->json([
            'like'=>$like,
            'message' => 'You have given dislike'
        ]);
        
                
        }else {
           return response()->json([
            'message'=>'Like does not exist'
        ]);
        }
        
    }
    
   
    
    
    //End class
}
