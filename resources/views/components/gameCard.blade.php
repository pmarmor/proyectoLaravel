@php
if (strlen($game->description)>119)$description= substr($game->description,0,120).'...';
else $description=$game->description;
if (strlen($game->description)>49)$descriptionMobile= substr($game->description,0,50).'...';
else $descriptionMobile=$game->description;
@endphp
<div class="gameCardWelcome">
    <img src="{{asset($game->thumbnail)}}">
    <h3>{{$game->name}}</h3>
    <a href="{{route('profilePage',['userId'=>$game->id])}}" class="userLink">{{'@'.$game->username}}</a>
    <p>{{$description}}</p>
    <a class="download downloadWelcomeCard" href="{{route('gamePage',["gameId"=>$game->idGame])}}">VER MÁS</a>
</div>
