@guest @php die(header("Location: " . URL::to('/')));@endphp @endguest
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Publica tu juego</title>
    <link rel="stylesheet" href="{{asset('/css/fonts.css')}}">
    <link rel="stylesheet" href="{{asset('/css/styles.css')}}">
    <link rel="stylesheet" href="{{asset('/css/gamePage.css')}}">
</head>
    <body>
    <x-header/>
    <x-aside/>
<main class="createGame">
        <h1>Publica tu juego</h1>
    <div class="imgContainer">
        <img src="{{asset('icons/game-default.png')}}" style="background: #77C3B0" id="gameImgPlaceholder">
        <img src="{{asset('icons/edit.svg')}}" alt="" class="editIcon" id="editIcon">
    </div>
    @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <p class="errors">{{ $error}}</p>
                @endforeach

    @endif
    <form action="{{route('createGame')}}"method="post" enctype="multipart/form-data">
        @csrf

        <input type="file" id="imgUpload"  name="imgUpload" hidden>
        <div><label for="name">Nombre: </label><input type="text" name="name" placeholder="name" id="name"  style="width: 250px"></div>
        <div>
            <label for="description">Descripción:</label>
                <textarea class="description" id="description" name="description"></textarea>
        </div>
        <div><label for="version">Versión actual: </label><input style="width: 400px" type="text"  name="version" placeholder="la versión debe tener 3 números separados por un punto. Ej: 1.0.0"></div>
        <div>
            <label for="content">Notas de la versión:</label>
            <textarea class="content" id="content" name="patchNotes" placeholder="Añade en una línea nueva cada característica. Ejemplo:
                        &#10Característica 1.&#10Característica 2.&#10Característica 3.&#10&#10Resultado final:
                        &#10 1.Característica 1.&#10 2.Característica 2.&#10 3.Característica 3."></textarea>
        </div>
        <div>
            <label for="installInstructions">Cómo jugar:</label>
            <textarea class="content" id="content" name="installInstructions" placeholder="Añade en una línea nueva cada Instrucción. Ejemplo:
                        &#10Instrucción 1.&#10Instrucción 2.&#10Instrucción 3.&#10&#10Resultado final:
                        &#10 1.Instrucción 1.&#10 2.Instrucción 2.&#10 3.Instrucción 3."></textarea>
        </div>
        <div><label for="file">Juego (archivo .zip o .rar)</label> <input type="file" name="file" id="file"></div>
        <input type="submit" value="publicar juego" style="margin: auto">
    </form>
    @if(session('success'))
        {!! session('success') !!}
    @endif
    </fieldset>
</main>

</body>
<script src="{{asset('/js/main.js')}}"></script>
</html>
