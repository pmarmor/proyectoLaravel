@auth@php die(header("Location: " . URL::to('/')));@endphp@endauth
    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Regístrate</title>
    <link rel="stylesheet" href="{{asset('/css/styles.css')}}">
    <link rel="stylesheet" href="{{asset('/css/fonts.css')}}">
    <link rel="stylesheet" href="{{asset('/css/register.css')}}">
</head>
<body>
<x-header/>
<main>
<fieldset>
    <legend>REGÍSTRATE</legend>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="/register" method="post">
        @csrf
        <input type="text" name="name" placeholder="nombre">
        <input type="text" name="username" placeholder="usuario">
        <input type="password" name="password" placeholder="contraseña">
        <input type="text" name="email" placeholder="correo electrónico">
        <input type="submit" value="submit">
    </form>
    <a href="/">volver</a>
</fieldset>
</main>
</body>
</html>
