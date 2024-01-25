<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Usuarios que sigo</title>
    <link rel="stylesheet" href="{{asset('/css/fonts.css')}}">
    <link rel="stylesheet" href="{{asset('/css/styles.css')}}">
</head>
<body>
<x-header/>
<x-aside/>
<main class="welcome">
    <h2>Usuarios que sigo</h2>
    <hr>
    <div style="overflow: auto;display: flex;gap: 60px;max-width: 100vw;width: 100%; justify-content: flex-start;padding-left: 50px; box-sizing: border-box">
        @foreach($users as $user)
            <div class="userCards">
                <div class="imgContainer" style="border-radius: 100%">
                    <img src="{{asset($user->profile_image)}}" alt="">
                </div>
                <a href="{{route('profilePage',['userId'=>$user->id])}}" class="username">{{'@'.$user->username}}</a>
                <a class="download downloadWelcomeCard" href="{{route('profilePage',['userId'=>$user->id])}}">VER MÁS</a>
            </div>
        @endforeach
    </div>
    <h2>Juegos de usuarios que sigo</h2>
    <hr>
    <div class="gameCards">
        @foreach($games as $game)
            <x-gameCard :game="$game"/>
        @endforeach
    </div>
</main>

</body>
<script src="{{asset('/js/main.js')}}"></script>
</html>
