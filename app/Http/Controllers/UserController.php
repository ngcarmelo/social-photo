<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use App\User; //user modelo

class UserController extends Controller {

    //we add this constructor to use the middleware auth
    public function __construct() {
        $this->middleware('auth');
    }

    public function index($search = null) {
        if (!empty($search)) {
            $users = User::where('nick', 'LIKE', '%' . $search . '%')
                    ->orWhere('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('surname', 'LIKE', '%' . $search . '%')
                    ->orderBy('id', 'desc')
                    ->paginate(5);

            return view('user.index', [
                'users' => $users
            ]);
        } else {
            // $users = User::all();
            $users = User::orderBy('id', 'desc')->paginate(5);

            return view('user.index', [
                'users' => $users
            ]);
        }
    }

    public function config() {
        //folder user --> file config.blade.php
        return view('user.config');
    }

    public function update(Request $request) {
        //get user identify
        $user = \Auth::user();
        $id = $user->id;

        //in nick and email fields we add an additional validation
        //in unique validation we add an exception for the own user
        //form validation
        $validate = $this->validate($request, ['name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'nick' => 'required|string|max:255|unique:users,nick,' . $id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        ]);

        //pick up here the form fields data
        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');

        //Assign new values to 'user object'
        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;
        $user->email = $email;

        //Update image
        $image_path = $request->file('image_path');
        if ($image_path) {
            //assign unique name to image file
            $image_path_name = time() . $image_path->getClientOriginalName();
            //Save image in storage folder (storage/app/users)
            Storage::disk('users')->put($image_path_name, File::get($image_path));

            //assign image name into  user object
            $user->image = $image_path_name;
        }
        //query  Database
        $user->update();

        return redirect()->route('config')
                        ->with(['message' => 'User updated correctly']);
//       
//       var_dump($id);
//       var_dump($name);
//       die();
    }

    public function getImage($filename) {
        $file = Storage::disk('users')->get($filename);
        return new Response($file, 200);
    }

    public function profile($id) {
        $user = User::find($id);

        return view('user.profile', [
            'user' => $user
        ]);
    }

}
