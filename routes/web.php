<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Image;

Route::get('/', function () {
    
//    $images = Image::all();
//    foreach($images as $image){
//       echo $image->description;
//    }
//    die();
    
    return view('welcome');
});

//Main
Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

//Users
Route::get('/configuracion', 'UserController@config')->name('config');
Route::post('/user/update', 'UserController@update')->name('user.update');
Route::get('/user/avatar/{filename}', 'UserController@getImage')->name('user.avatar'); // show avatar
Route::get('/perfil/{id}', 'UserController@profile')->name('profile');  //show profile user
Route::get('/gente/{search?}', 'UserController@index')->name('user.index');  //list users

//Image
Route::get('/subir-imagen', 'ImageController@create')->name('image.create');
Route::post('/image/save', 'ImageController@save')->name('image.save');
Route::get('/image/file/{filename}', 'ImageController@getImage')->name('image.file');  //show image
Route::get('/image/{id}', 'ImageController@detail')->name('image.detail');  //show image
Route::get('/imagen/delete/{id}', 'ImageController@delete')->name('image.delete');  //delete image
Route::get('/image/editar/{id}', 'ImageController@edit')->name('image.edit');  //edit image
Route::post('/image/update', 'ImageController@update')->name('image.update');

//Comments
Route::post('/comment/save', 'CommentController@save')->name('comment.save');
Route::get('/comment/delete/{id}', 'CommentController@delete')->name('comment.delete');  //delete comment
//Likes
Route::get('/like/{image_id}', 'LikeController@like')->name('like.save');  //save like
Route::get('/dislike/{image_id}', 'LikeController@dislike')->name('like.delete');  //erase like
Route::get('/likes', 'LikeController@index')->name('likes.index');  //show like list


