@if(is_null($profileUser))
@php die(header("Location: " . URL::to('/')));
@endphp @endif
    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$profileUser->name}}</title>
    <link rel="stylesheet" href="{{asset('/css/fonts.css')}}">
    <link rel="stylesheet" href="{{asset('/css/styles.css')}}">
    <link rel="stylesheet" href="{{asset('/css/userPage.css')}}">
</head>
<body>
<x-header/>
<x-aside/>
<main>
    <div class="profileDisplay">
        <div class="profileTop">
            @php
                if(File::exists(public_path($profileUser['profile_image']))) $imgSource=asset($profileUser['profile_image']);
                else $imgSource=asset('user-avatars/default-avatar.jpg');
            @endphp
            <div class="imgContainer">
                <img src="{{$imgSource}}" id="userAvatarPlaceholder">
            </div>
            <div class="userNameAndTag">
                <span>{{$profileUser['name']}}</span>
                <span>{{'@'.$profileUser['username']}}</span>
            </div>
            @auth
                @if(auth()->user()->id==$profileUser['id'])<a class="buttonToggle edit loader" href="{{route('editUser')}}">Editar información</a>
                @elseif(auth()->user())<button class="buttonToggle" id="buttonToggle">Seguir</button>@endif
            @else
                <button class="buttonToggle" onclick="goToRegister(this)" id="follow" >Seguir</button>
            @endauth
        </div>

        <div class="userFollowersyFollow">
            <span>Seguidores: {{$followers}}</span>
            <span>Siguiendo: {{$follows}}</span>
        </div>
        <div class="infoDisplay">
            <h2>Juegos publicados</h2>
            <hr>
            <div class="games" style=" display:flex;gap: 30px;">
                @foreach($uploadedGames as $game)
                    <x-game :game="$game" />
                @endforeach
            </div>
        </div>
    </div>
</main>
</body>
<script>
    @auth let loggedInUserId = @json(auth()->user()->id);
    @else let loggedInUserId = null; @endauth
    let token = @json( @csrf_token() );
    let userFollows=@json( session('userFollows') );
    let buttonToggleURL= '{{route('handleFollow')}}';
    //  userFollows=userFollows[0];
</script>
<script src="{{asset('js/main.js')}}"></script>
<script src="{{asset('js/userPageFollowButton.js')}}"></script>
</html>
