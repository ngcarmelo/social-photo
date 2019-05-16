@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8"> 
            <h1>People</h1>
            <form method="GET" action="{{ route('user.index')}}" id="buscador">
                <div class="row">
                    <div class="form-group col">
                        <input type="text" id="search"  class="form-control" />
                    </div>
                    <div class="form-group col btn-search">
                        <input type="submit" value="Search" class="btn btn-success"  />
                    </div>
                </div>
            </form>

            <hr>
            @foreach($users as $user)
            <div class="profile-user">

                @if($user->image)
                <div class="container-avatar">
                    <!--     <img src="{{ url('user/avatar/'.Auth::user()->image)}}" />-->
                    <!-- NOTE: with image object we can access to user object-->
                    <img src="{{ route('user.avatar',['filename' => $user->image])}}" class="avatar" />
                </div> 
                @endif

                <div class="user-info">
                    <h2>{{'@'. $user->nick}}</h2>
                    <h3>{{$user->name .' '. $user->surname}}</h3>
                    <p>{{'Joined: ' .\FormatTime::LongTimeFilter($user->created_at)}} </p>
                    <a href="{{ route('profile',['id'=> $user->id]) }}" class="btn btn-success">View profile</a>
                </div>
                <div class="clearfix"></div>
                <hr>
            </div>
            @endforeach

            <!-- PAGINATION -->  
            <div class="clearfix">
                {{$users->links()}}
            </div>
        </div>


    </div>
</div>

@endsection
