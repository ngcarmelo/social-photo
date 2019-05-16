<div class="card pub_image">
    <div class="card-header">

        @if($image->user->image)
        <div class="container-avatar">
            <!--     <img src="{{ url('user/avatar/'.Auth::user()->image)}}" />-->
            <!-- NOTE: with image object we can access to user object-->
            <img src="{{ route('user.avatar',['filename' => $image->user->image])}}" class="avatar" />
        </div> 
        @endif

        <div class="data-user"> 
            <a href="{{ route('profile', ['id' => $image->user->id])}}"> 
                {{ $image->user->name.' '.$image->user->surname }}

                <span class="nickname">
                    {{'| @'.$image->user->nick}} 

                </span>
            </a>
        </div>

    </div>

    <div class="card-body">
        <div class="image-container">
            <img src="{{route('image.file', ['filename' => $image->image_path]) }}" />
        </div>

        <div class="description">

            <span class="nickname">{{'@'. $image->user->nick}} </span> 
            <span class="nickname date">{{'| ' .\FormatTime::LongTimeFilter($image->created_at)}} </span>
            <p>{{ $image->description}}</p>
        </div>

        <div class="likes">

            <!--                         check if we (current user liked the image)-->
            <?php $user_like = false; ?>

            @foreach($image->likes as $like)
            @if($like->user->id == Auth::user()->id)
            <?php $user_like = true; ?>
            @endif
            @endforeach

            @if($user_like)
            <!--                         We use data-id property to javascript request-->
            <img src="{{asset('img/heart-red.png')}}" data-id="{{$image->id}}" class="btn-dislike" />
            @else 
            <img src="{{asset('img/heart-gray.png')}}" data-id="{{$image->id}}" class="btn-like" />

            @endif
            <span class="number_likes"> {{ count($image->likes) }}</span>

        </div>
        <div class="comments">
            <a href="{{ route('image.detail', ['id' => $image->id])}}" class="btn btn-sm btn-warning btn-comments">Comments {{count($image->comments)}}</a>
        </div>
    </div>
</div>