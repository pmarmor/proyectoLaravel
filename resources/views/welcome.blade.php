<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> DevUpload</title>
    <link rel="stylesheet" href="{{asset('/css/fonts.css')}}">
    <link rel="stylesheet" href="{{asset('/css/styles.css')}}">
</head>
    <body>
    <x-header/>
    <x-aside/>
<main class="welcome">
    <h2>Lista de juegos</h2>
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
