@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">           
            @include('includes.message')

            <div class="card pub_image pub_image_detail">
                <div class="card-header">

                    @if($image->user->image)
                    <div class="container-avatar">
                        <!--     <img src="{{ url('user/avatar/'.Auth::user()->image)}}" />-->
                        <!-- NOTE: with image object we can access to user object-->
                        <img src="{{ route('user.avatar',['filename' => $image->user->image])}}" class="avatar" />
                    </div> 
                    @endif

                    <div class="data-user"> 

                        {{ $image->user->name.' '.$image->user->surname }}

                        <span class="nickname">
                            {{'| @'.$image->user->nick}} 

                        </span>

                    </div>
                </div>

                <div class="card-body">
                    <div class="image-container image-detail">
                        <img src="{{route('image.file', ['filename' => $image->image_path]) }}" />
                    </div>

                    <div class="description">
                        <span class="nickname">{{'@'. $image->user->nick}} </span> 
                        <p>{{ $image->description}}</p>
                    </div>

                    <div class="likes">

                        <!--   check if we (current user liked the image)-->
                        <?php $user_like = false ?>

                        @foreach($image->likes as $like)
                        @if($like->user->id == Auth::user()->id)
                        <?php $user_like = true ?>
                        @endif
                        @endforeach

                        @if($user_like)
                        <!--   We use data-id property to javascript  Ajax request-->
                        <img src="{{asset('img/heart-red.png')}}" data-id="{{$image->id}}" class="btn-dislike" />
                        @else 
                        <img src="{{asset('img/heart-gray.png')}}" data-id="{{$image->id}}" class="btn-like" />

                        @endif
                        <span class="number_likes"> {{ count($image->likes) }}</span>

                    </div>



                    @if(Auth::user() && Auth::user()->id == $image->user->id)
                    <div class="actions">
                        <a class="btn btn-sm btn-primary" href="{{route('image.edit', ['id' => $image->id]) }}">Update</a>
                        <!--      <a class="btn btn-sm  btn-danger" href="{{ route('image.delete', ['id' => $image->id])}}">Borrar</a>-->
                        <!-- Button to Open the Modal -->
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModal">
                            Delete
                        </button>

                        <!-- The Modal -->
                        <div class="modal" id="myModal">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">¿Estás seguro?</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        If you delete this image, you will never be able to recover it, are you sure?      </div>

                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                                        <a class="btn  btn-danger" href="{{ route('image.delete', ['id' => $image->id])}}">Erase definitely</a>

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    @endif
                    <div class="clearfix"></div>
                    <div class="comments">
                        <h2>Comments {{count($image->comments)}}</h2>
                        <hr>
                        <form method="POST" action="{{route('comment.save') }}">
                            @csrf
                            <input type="hidden" name="image_id" value="{{$image->id}}" />
                            <p>
                                <textarea class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}" name="content" > </textarea>
                                @if($errors->has('content'))
                                <span class="invalid-feedback" role="alert">
                                    <strong> {{$errors->first('content') }}</strong>
                                </span>
                                @endif
                            </p>
                            <button class="btn btn-success" type="submit" >Send </button>
                        </form>
                        @foreach($image->comments as $comment) 
                        <div class="comments">

                            <span class="nickname">{{'@'. $comment->user->nick}} </span> 
                            <span class="nickname date">{{'| ' .\FormatTime::LongTimeFilter($comment->created_at)}}</span>
                            <p>{{ $comment->content}} <br/>

                                @if(Auth::check() && ($comment->user_id == Auth::user()->id || $comment->image->user_id == Auth::user()->id))
                                <a href="{{ route('comment.delete', ['id' => $comment->id]) }}" class="btn btn-sm btn-danger">Delete</a>
                                @endif
                            </p>
                        </div>

                        @endforeach

                    </div>
                </div>
            </div>



        </div>


    </div>
</div>

@endsection
