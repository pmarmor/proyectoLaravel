@guest @php die(header("Location: " . URL::to('/')));@endphp @endguest
    @php $user=auth()->user(); @endphp
    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editar información</title>
    <link rel="stylesheet" href="{{asset('/css/fonts.css')}}">
    <link rel="stylesheet" href="{{asset('/css/styles.css')}}">
    <link rel="stylesheet" href="{{asset('/css/register.css')}}">
</head>
<body>
<x-header/>
<x-aside/>
<main>
    <fieldset class="editUser">
        <legend>Cambia tu información de usuario</legend>
        <form action="{{route('updateUser')}}"method="post" enctype="multipart/form-data">
            @php
                        if(File::exists(public_path(auth()->user()->profile_img))) $imgSource=asset(auth()->user()->profile_image);
                        else $imgSource=asset('user-avatars/default-avatar.jpg')
            @endphp
            @csrf
            <div class="imgContainer">
                <img src="{{$imgSource}}" id="userAvatarPlaceholder">
                <img src="{{asset('icons/edit.svg')}}" alt="" class="editIcon" id="editIcon">
            </div>
            <label for="name">Nombre: </label><input type="text" name="name" id="" value="{{$user->name}}">
            <label for="username">Nombre de usuario: </label><input type="text" name="username" id="" value="{{$user->username}}">
            <label for="email">Correo electrónico: </label><input type="text" name="email" id="" value="{{$user->email}}">
            <input type="file" id="imgUpload"  name="imgUpload" hidden>
            <input type="submit">
        </form>
        <a href="{{route('editPassword')}}" style="align-self: center; margin-top: 20px">Cambiar contraseña</a>
        @if ($errors->any())
            <span class="errors">{{$errors->all()[0]}}</span>
        @endif
        @if(session('success'))
            {!! session('success') !!}
        @endif
    </fieldset>
</main>
</body>
<script src="{{asset('js/main.js')}}"></script>
</html>
