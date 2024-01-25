<div class="gameCard">
    <a href="{{route('gamePage',['gameId'=>$game->idGame])}}"class="linkSvg"><img src="{{asset('icons/up-right-from-square-solid.svg')}}" alt=""></a>
<a href="{{route('gamePage',['gameId'=>$game->idGame])}}"><img src="{{asset($game->thumbnail)}}"></a>
    <div class="gameInfo">
        <a href="{{route('gamePage',['gameId'=>$game->idGame])}}">{{$game->name}}</a>
        <a class="download" id="buttonToggle" href="{{URL::to($game->downloadLink)}}">DESCARGAR</a>
    </div>
</div>
