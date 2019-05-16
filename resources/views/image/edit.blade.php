@extends('layouts.app')
@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit my Image</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('image.update')}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="image_id" value="{{$image->id}}" />
                        <div class="form-group row">
                            <label for="image_path" class="col-md-3 col-form-label text-md-right">Image</label>
                            <div class="col-md-7">

                                <!--                              show image-->
                                @if($image->user->image)
                                <div class="container-avatar">
         <!--                               <img src="{{ route('user.avatar',['filename' => $image->user->image])}}" class="avatar" />-->
                                    <img src="{{route('image.file', ['filename' => $image->image_path]) }}" class="avatar" />
                                </div> 
                                @endif
<!--                                <input id="image_path" type="file" name="image_path" class="form-control {{ $errors->has('image_path') ? 'is-invalid' : '' }}" />-->
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input  {{ $errors->has('image_path') ? ' is-invalid' : '' }}" id="image_path" lang="es" name="image_path" >
                                    <label class="custom-file-label" for="customFileLang">Select Image</label>
                                </div>




                                @if($errors->has('image_path'))
                                <span class="invalid-feedback" role="alert">
                                    <strong> {{$errors->first('image_path') }}</strong>
                                </span>
                                @endif
                            </div>

                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-3 col-form-label text-md-right">Description</label>
                            <div class="col-md-7">
                                <textarea id="description"  name="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" required>{{$image->description}}</textarea>
                                @if($errors->has('description'))
                                <span class="invalid-feedback" role="alert">
                                    <strong> {{$errors->first('description') }}</strong>
                                </span>
                                @endif
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-3">
                                <input type="submit" value="Edit image" class="btn btn-primary">

                            </div>

                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
