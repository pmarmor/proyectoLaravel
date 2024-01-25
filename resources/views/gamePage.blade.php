@if(is_null($game))
@php die(header("Location: " . URL::to('/')));
 @endphp @endif
    @php
        use App\Models\User;
    @endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$game->name}}</title>
    <link rel="stylesheet" href="{{asset('/css/fonts.css')}}">
    <link rel="stylesheet" href="{{asset('/css/styles.css')}}">
    <link rel="stylesheet" href="{{asset('/css/gamePage.css')}}">
</head>
<body>
<x-header/>
<x-aside/>
<main class="gamePage">
    @php
        if(!is_null($game->thumbnail) && File::exists(public_path($game->thumbnail))) $imgSource=asset($game->thumbnail);
        else $imgSource=asset('icons/game-default.png');
    @endphp
<div class="topMain">
    <div class="imgContainer">
        <img src="{{$imgSource}}" id="userAvatarPlaceholder" style="width: 100%;">
    </div>
    <div class="gameTitle">
        <h2>{{$game->name}}</h2>
        @auth <img src="{{asset('icons/heart-transparent.png')}}" class="heart" alt="" id="heart">
        @else <img src="{{asset('icons/heart-transparent.png')}}" class="heart" alt="" id="heart" onclick="goToRegister(this)">@endauth
        <a href="{{route('profilePage',['userId'=>$game->idUser])}}">{{'@'.User::find($game->idUser)->username}}</a>
    </div>
    @if(auth()->check() && auth()->user()->id==$game->idUser)<a href="{{route('editGame',['gameId'=>$game->idGame])}}"><img src="{{asset('icons/edit-solid.svg')}}" alt="" class="editIcon"></a> @endif
    <a class="buttonToggle" id="buttonToggle" href="{{URL::to($game->downloadLink)}}">DESCARGAR</a>
</div>

    <div class="description">
        <h2>Descripción</h2>
        {{$game->description}}
    </div>
    <nav><span id="patchNotes" class="active">Notas del parche</span>
       <span id="howToPlay">Cómo jugar</span></nav>

    <div class="patchNotes" id="one">
        @auth
            @if(auth()->user()->id==$game->idUser)
                <form action="{{route('createPatch',['idGame'=>$game->idGame])}}"method="post" enctype="multipart/form-data" class="semver">
                    <h3>Añade nuevas notas de parche</h3>
                    @if ($errors->any())
                        <div class="errors">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @csrf
                    <div><label for="version">Versión actual: </label><input type="text"  name="version"></div>
                    <div>
                        <label for="content">Notas de la versión:</label>
                        <textarea class="content" id="content" name="content" placeholder="Añade en una línea nueva cada característica. Ejemplo:
                        &#10Característica 1.&#10Característica 2.&#10Característica 3.&#10&#10Resultado final:
                        &#10 1.Característica 1.&#10 2.Característica 2.&#10 3.Característica 3."></textarea>
                    </div>
                    <input type="submit">
                </form>
            @endif
        @endauth
        @foreach($patchNotes as $elem)
        <div class="cards">
            <h2 style="font-size:20px">{{$elem->version}}</h2>
            {!!$elem->content!!}
        </div>
        @endforeach
    </div>
    <div class="featuresRealeased" style="display: none" id="two">
        <div class="developing">
            <div id="developingContent"></div>
            <div><input type="text"><button>+</button></div>
        </div>
        <div class="finished">
            <div> <input type="text"><button>+</button></div>
        </div>

    </div>
    <div class="howToPlay" style="display: none" id="three">
        {!! $game->installInstructions !!}
    </div>
    <div class="suggestions" id="">
        @auth
            <form action="{{route('uploadComment',['idGame'=>$game->idGame])}}"method="post" enctype="multipart/form-data" class="feedback">
                @csrf
                <h2 style="font-size:20px">Comenta</h2>
                <textarea name="text"></textarea>
                <input type="submit">
            </form>
        @endauth
        @foreach($feedback->all() as $elem)
            <x-feedbck :feedback="$elem" />
        @endforeach
    </div>
</main>
</body>
<script>
    let token = @json( @csrf_token() );
    let gameId=@json($game->idGame);
    let buttonToggleURL= '{{route('addGameToFav')}}';
    @auth let loggedInUserId = @json(auth()->user()->id);
    @else let loggedInUserId = null; @endauth
    let likedGames=@json(session('likedGames'));
    let heartAssets=['{{asset('icons/heart.png')}}','{{asset('icons/heart-transparent.png')}}']
    if(likedGames.indexOf(gameId)>-1)document.getElementById('heart').src='{{asset('icons/heart.png')}}'
</script>
<script src="{{asset('js/main.js')}}"></script>
@auth <script src="{{asset('js/addGameToFavourites.js')}}"></script> @endauth
<script src="{{asset('js/gamePageTabs.js')}}"></script>
</html>
