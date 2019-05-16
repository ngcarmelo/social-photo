<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment; //Model Comment

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function save(Request $request){
        //Validation
        $validate = $this->validate($request, [
                   'image_id' => 'integer|required',
                   'content' => 'string|required'
                ]);
        
        //Data from form
       $user = \Auth::user();
       $image_id = $request->input('image_id'); 
       $content = $request->input('content'); 
       
       //Asign values to the objet
        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->image_id = $image_id;
        $comment->content = $content;
        
        //Save object in database
        $comment->save();
       
        //Redirection
        
        return redirect()->route('image.detail',['id' => $image_id])
                ->with(['message' => 'Has publicado tu comentario correctamente!!']);
 
//       var_dump($content);
//       die();
    }
    
    public function delete($id){
        //Get data from -->  login user
        $user =\Auth::user();
        
        //Get Comment object
        $comment = Comment::find($id);
        
        
        //Check if we are the owner of our publication,  comment//publication
        
        if($user && ($comment->user_id == $user->id || $comment->image->user_id == $user->id)){
            
            $comment->delete();
            
           return redirect()->route('image.detail',['id' => $comment->image->id])
                ->with(['message' => 'Comentario eliminado correctamente!!']);
        }else {
             return redirect()->route('image.detail',['id' => $comment->image->id])
                ->with(['message' => 'El Comentario no se ha eliminado!!']);
        }
        
    }
}
