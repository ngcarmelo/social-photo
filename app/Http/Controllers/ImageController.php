<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image; //image model
use App\Comment; // comment model
use App\Like;  //like model
use Illuminate\Support\Facades\Storage; //upload files
use Illuminate\Support\Facades\File; //upload files
use Illuminate\Http\Response; //getImage fuction

class ImageController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function create(){
        
        return view('image.create');
    }
    
    public function save (Request $request){
        
        //Validation
                $validate = $this->validate($request, [
            'description' => 'required',
//            'image_path' => 'required|mimes:jpg,jpeg,png,gif'
           'image_path' => 'required|image'
        ]);
        
        //collecting data
       $image_path = $request->file('image_path');
       $description = $request->input('description');
       
       //assign values to the object
       $user = \Auth::user(); // access to user object
       
       $image = new Image();
      
       $image->description = $description;
       $image->user_id =$user->id;
       
       //var_dump($user->id);
       
       //Uploading image
       
       if($image_path){
           $image_path_name = time().$image_path->getClientOriginalName(); //File original name 
           //we need file name and the file that we are going to upload
           Storage::disk('images')->put($image_path_name, File::get($image_path));
           
            $image->image_path = $image_path_name; //this valor is going to save it in the DB
       }
       $image->save(); //laravel method (query database)
       
       return redirect()->route('home')->with([
           'message' => 'La foto ha sido subida correctamente!!'
       ]);
    }
     //fuction to access and show the images
     public function getImage($filename){
        $file = Storage::disk('images')->get($filename);
        return new Response($file, 200);
    }
    
    public function detail($id){
        $image = Image::find($id);
        
        return view('image.detail', [
            'image' => $image
        ]);
    }
    
    
   public function delete ($id){
       $user = \Auth::user();
       $image = Image::find($id);
       $comments = Comment::where('image_id', $id)->get();
       $likes = Like::where('image_id', $id)->get();
       
       if($user && $image && $image->user->id == $user->id ){
           
           //Delete comments
           if($comments && count($comments) >= 1 ){
               foreach($comments as $comment){
                   $comment->delete();
               }
           }
           //Delete likes
            if($likes && count($likes) >= 1 ){
               foreach($likes as $like){
                   $like->delete();
               }
           }
           //Delete image files
           Storage::disk('images')->delete($image->image_path);
           
           
           //Delete image register
           $image->delete();
           
            $message = array('message' => 'The image has been deleted correctly');
       }else {
           $message = array('message' => 'The image has not been deleted correctly');
           
       }
       return redirect()->route('home')->with($message);
   }
   
   public function edit($id){
       $user = \Auth::user();
       $image = Image::find($id);
       
        if($user && $image && $image->user->id == $user->id ){
            
            
            return view('image.edit', [
                'image' => $image
            ]);
            
        }else {
            
            return redirect()->route('home');
        }
       
       
   }
   
   public function update(Request $request){
       
        //Validation
        $validate = $this->validate($request, [
           'description' => 'required',
//         'image_path' => 'required|mimes:jpg,jpeg,png,gif'
           'image_path' => 'image'
        ]);
        
       //Get data
       $image_id = $request->input('image_id');
       $description = $request->input('description');
       $image_path= $request->file('image_path');
       
       //Get image object
       $image= Image::find($image_id);
       $image->description = $description; //set description property
       
       //Upload file
        if($image_path){
           $image_path_name = time().$image_path->getClientOriginalName(); //File original name 
           //we need file name and the file that we are going to upload
           Storage::disk('images')->put($image_path_name, File::get($image_path));
           
            $image->image_path = $image_path_name; //this valor is going to save it in the DB
       }
     
       //Update register
       $image->update();
       
       return redirect()->route('image.detail', ['id' => $image_id])
               ->with(['message' => 'Imagen actualizada con exito']);
   }
}
