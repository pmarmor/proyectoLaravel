@php
    $feedbackArray=get_object_vars($feedback);
    $feedbackArray=explode('/',$feedbackArray['profile_image']);

 @endphp
<div class="feedback"id="{{$feedback->idComment}}">
    @if(auth()->check() && auth()->user()->id===$feedback->id) <img src="{{asset('icons/trash.png')}}" class="binIcon" link="{{route('deleteComment', ['idComment' => $feedback->idComment])}}"> @endif
    <a class="profileImg" href="{{route('profilePage', ['userId' => $feedback->id])}}">
        @if($feedbackArray[1]==='default-avatar.jpg')
        <img src="{{asset($feedback->profile_image)}}"style="min-height: 50px">
        @else
            <img src="{{asset($feedback->profile_image)}}">
        @endif
    </a>
    <div class="content">
        <a href="{{route('profilePage', ['userId' => $feedback->id])}}">{{'@'.$feedback->username}}</a>
            <p>{!! $feedback->text !!}</p>

    </div>
</div>
