@guest @php die(header("Location: " . URL::to('/')));@endphp @endguest
    @php $user=auth()->user(); @endphp
    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cambiar contraseña</title>
    <link rel="stylesheet" href="{{asset('/css/fonts.css')}}">
    <link rel="stylesheet" href="{{asset('/css/styles.css')}}">
    <link rel="stylesheet" href="{{asset('/css/register.css')}}">
</head>
<body>
<x-header/>
<x-aside/>
<main>
    <fieldset class="editUser" style="min-height: 300px;">
        <legend>Cambiar contraseña</legend>
        <form action="{{route('updatePassword')}}" method="post">
            @csrf
            <label>Escribe contraseña</label>
            <input type="password" name="password">
            <label>Confirma tu contraseña</label>
            <input type="password" name="passwordConfirm">
            <input type="submit" value="Confirmar">
        </form>
        @if ($errors->any())
            <div class="errorsDiv">
                <span class="errors">{{$errors->all()[0]}}</span>
            </div>
        @endif
        @if(session('success'))
            <div class="errorsDiv">
                {!! session('success') !!}
            </div>
        @endif
    </fieldset>

</main>
</body>
<script src="{{asset('js/main.js')}}"></script>
</html>
