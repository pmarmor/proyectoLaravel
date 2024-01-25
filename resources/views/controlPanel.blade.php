@guest @php die(header("Location: " . URL::to('/')));@endphp
@else @if(auth()->user()['admin']<1) @php    die(header("Location: " . URL::to('/')));@endphp @endif
@endguest
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Panel de control</title>
    <link rel="stylesheet" href="{{asset('/css/fonts.css')}}">
    <link rel="stylesheet" href="{{asset('/css/styles.css')}}">
    <link rel="stylesheet" href="{{asset('/css/controlPanel.css')}}">
</head>
    <body>
    <x-header/>
    <x-aside/>
    <main class="">
        <h2 style="">Tabla de Usuarios</h2>
        @if(auth()->user()->admin==2)<x-tableSuperAdmin :usuarios="$usuarios"/>
        @else <x-tableAdmin :usuarios="$usuarios"/>
        @endif
        {{ $usuarios->onEachSide(2)->links('vendor.pagination.showingResults')}}
        <h2>Sanciones</h2>
        <div class="tableFunctions" >
            <form class="userBanForm" action="{{route('banUser')}}" method="post">
                @csrf
                <label for="type">Suspender usuario</label>
                <input type="text" name='username'placeholder="nombre de usuario" id="username"> <label>hasta:</label>
                <input type="datetime-local" name="banDateTime" id="dateTime">
                <input type="button" value="Aceptar" id="banButton">
            </form>
            <form class="removeBanForm" action="{{route('removeBan')}}" method="post">
                @csrf
                <input type="text" name='username'placeholder="nombre de usuario" id="usernameRemove">
                <input type="button" value="Eliminar restricciones" id="removeBanButton">
            </form>
        </div>
        <h2>Crear usuarios</h2>
        <form action="/register" method="post">
            @csrf
            <input type="text" name="name" placeholder="nombre">
            <input type="text" name="username" placeholder="usuario">
            <input type="password" name="password" placeholder="contraseña">
            <input type="text" name="email" placeholder="correo electrónico">
            <select name="rol" id="" value="Rol">
                <option value="rol" selected disabled>Rol</option>
                <option value="admin">Administrador</option>
                <option value="noAdmin">No adiministrador</option>
            </select>
            <input type="submit" value="submit">
        </form>
    </main>

</body>
<script src="{{asset('js/main.js')}}"></script>
</html>
