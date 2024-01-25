<aside class="aside">
    <img src="{{asset('/icons/arrow-left.svg')}}" class="leftArrow" onclick="muestraAside()">
    <div class="content">
    @guest
            <div class="imgContainer" id="asideAvatar"><img src="{{asset('user-avatars/default-avatar.jpg')}}" alt=""  ></div>

            <form action="{{route('login')}}" method="post">
            @csrf
     <label for="username">Nombre de Usuario</label>
     <input type="text" name="username">
     <label for="password">Contraseña</label>
     <input type="password" name="password">
     <input type="submit" value="INICIAR SESIÓN">
 </form>
            <div class="errors" id="errorDiv">
            @if ($errors->any())
                    <span class="errors">{{$errors->all()[0]}}</span>
            @endif
            </div>
        <span style="margin-top: 20px;display: flex;gap: 10px">¿Aún no estás registrado?<a href="{{route('register')}}" style="color: orange">Regístrate</a></span>
    @else

            @php
                $user=auth()->user();
                    if(File::exists(public_path(auth()->user()->profile_image))) $imgSource=asset(auth()->user()->profile_image);
                    else $imgSource=asset('user-avatars/default-avatar.jpg')
            @endphp
            <div class="imgContainer" id="asideAvatar">
                <img src="{{$imgSource}}">
            </div>
            <p>¡Hola <b>{{$user->name}}</b>!</p>
            <div class="asideLinks">
                <p><img src="{{asset('icons/house-solid.svg')}}" alt="house" class="icon"><a href="{{route('home')}}">Inicio</a></p>
            @if($user->admin)
                    <p><img src="{{asset('icons/briefcase-solid.svg')}}" alt="admin control panel" class="icon"><a href="{{route('controlPanel')}}">Panel de control</a></p>
                @endif
                <p><img src="{{asset('icons/user-solid.svg')}}" alt="user" class="icon"><a href="{{route('profilePage', ['userId' => auth()->user()->id])}}">Mi perfil</a></p>
                <p><img src="{{asset('icons/plus-solid.svg')}}" alt="plus" class="icon"><a href="{{route('createGame')}}">Publicar juego</a></p>
                <p><img src="{{asset('icons/heart-solid.svg')}}" alt="heart" class="icon"><a href="{{route('favouriteGames')}}">Juegos Favoritos</a></p>
                <p><img src="{{asset('icons/user-plus-solid.svg')}}" alt="heart" class="icon"><a href="{{route('followingUsers')}}">Usuarios que sigo</a></p>

            </div>
            <a href="/logout">cerrar sesión</a>
    @endguest
    </div>
</aside>
