@guest @php die(header("Location: " . URL::to('/')));@endphp @endguest
    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editar juego</title>
    <link rel="stylesheet" href="{{asset('/css/fonts.css')}}">
    <link rel="stylesheet" href="{{asset('/css/styles.css')}}">
    <link rel="stylesheet" href="{{asset('/css/gamePage.css')}}">
</head>
<body>
<x-header/>
<x-aside/>
<main class="createGame">
    @php
        if(!is_null($game->thumbnail) && File::exists(public_path($game->thumbnail))) $imgSource=asset($game->thumbnail);
        else $imgSource=asset('icons/game-default.png');
    @endphp
    <h1>Actualiza tu juego</h1>
    <div class="imgContainer">
        <img src="{{$imgSource}}" id="userAvatarPlaceholder">
        <img src="{{asset('icons/edit.svg')}}" alt="" class="editIcon" id="editIcon">
    </div>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p class="errors">{{ $error}}</p>
        @endforeach

    @endif
    <form action="{{route('updateGame',['gameId'=>$game->idGame])}}"method="post" enctype="multipart/form-data">
        @csrf

        <input type="file" id="imgUpload"  name="imgUpload" hidden>
        <div><label for="name">Nombre: </label><input type="text" name="name" placeholder="name" id="name"  value="{{$game->name}}"></div>
        <div>
            <label for="description">Descripción:</label>
            <textarea class="description" id="description" name="description">{{$game->description}}</textarea>
        </div>
        <div>
            <label for="installInstructions">Cómo jugar:</label>
            <textarea class="content" id="content" name="installInstructions" placeholder="Añade en una línea nueva cada Instrucción. Ejemplo:
                        &#10Instrucción 1.&#10Instrucción 2.&#10Instrucción 3.&#10&#10Resultado final:
                        &#10 1.Instrucción 1.&#10 2.Instrucción 2.&#10 3.Instrucción 3.">{!! $game->installInstructions !!}</textarea>
        </div>
        <div><label for="file">Juego (archivo .zip o .rar)</label> <input type="file" name="file" id="file"></div>
        <div class="buttons"><input type="submit" value="Guardar cambios" ><input type="button" value="Eliminar" id="deleteGame" url="{{route('deleteGame',['gameId'=>$game->idGame])}}"></div>
    </form>
    </fieldset>
</main>

</body>
<script src="{{asset('/js/main.js')}}"></script>
<script>
    let deleteButton=document.getElementById('deleteGame')
    deleteButton.addEventListener('click',deleteGame)
    let url=deleteButton.getAttribute('url')
    function deleteGame(){
        if(confirm('¿Seguro que quieres borrar este juego?')) window.location.href=url;
    }
</script>
</html>
