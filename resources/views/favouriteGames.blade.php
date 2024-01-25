@guest
@php die(header("Location: " . URL::to('/')));
@endphp @endguest
    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Juegos favoritos</title>
    <link rel="stylesheet" href="{{asset('/css/fonts.css')}}">
    <link rel="stylesheet" href="{{asset('/css/styles.css')}}">
    <link rel="stylesheet" href="{{asset('/css/gamePage.css')}}">
</head>
<body>
<x-header/>
<x-aside/>
<main class="favouriteGames">
    @foreach($games as $game)
        @php
            if(!is_null($game->thumbnail) && File::exists(public_path($game->thumbnail))) $imgSource=asset($game->thumbnail);
            else $imgSource=asset('icons/game-default.png');
        @endphp
        <div class="favGameCard" id="{{$game->idGame}}">
            <img src="{{asset('icons/trash.png')}}" alt="" class="binIcon">
            <a href="{{route('gamePage', ['gameId' => $game->idGame])}}"><img src="{{$imgSource}}"></a>
            <div class="info">
                <h2><a href="{{route('gamePage', ['gameId' => $game->idGame])}}">{{$game->name}}</a></h2>
                <div>
                    <a href="{{route('profilePage', ['userId' => $game->idUser])}}" class="userLink">{{'@'.$game->username}}</a>
                    <a class="buttonToggle" id="buttonToggle" href="{{URL::to($game->downloadLink)}}">DESCARGAR</a>
                </div>
            </div>
        </div>

    @endforeach

</main>
</body>
<script>
    let token = @json( @csrf_token() );
    @auth let loggedInUserId = @json(auth()->user()->id);
    @else let loggedInUserId = null; @endauth
    let url= '{{route('removeGame')}}';
</script>
<script src="{{asset('js/main.js')}}"></script>
<script src="{{asset('js/addGameToFavourites.js')}}"></script>
</html>
