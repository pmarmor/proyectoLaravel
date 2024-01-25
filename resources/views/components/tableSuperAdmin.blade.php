
@if($errors->all()) <span style="margin-bottom: 10px;color: red;font-weight: bold">{{$errors->all()[0]}}</span> @endif
 <table>
        <tr><th>Nombre</th><th>Nombre de usuario</th><th>Correo</th><th>Correo verificado</th>
            <th>Administrador</th><th>Fecha de creación</th><th>Última actualización</th><th>Sancionado hasta</th><th colspan="3">Acciones</th></tr>
        @foreach($usuarios as $usuario)
            @php
                $admin='No';
                    if ($usuario->admin==2)$admin="Super Admin";
                    else if ($usuario->admin==1)$admin="Admin";

                       $verifiedEmail=($usuario->email_verified_at == null) ? 'No' : $usuario->email_verified_at;
            @endphp
            <tr class="userPaginationRow" id="{{$usuario->id}}" >
                <td>{{$usuario->name}}</td><td><a href="{{route('profilePage',['userId'=>$usuario->id])}}">{{$usuario->username}}</a></td><td>{{$usuario->email}}</td><td>{{$verifiedEmail}}</td>
                <td>{{$admin}}</td><td>{{$usuario->created_at}}</td><td>{{$usuario->updated_at}}</td><td>{{$usuario->bannedAccount}}</td><td>
                    <a href="{{ route('toggleAdmin', ['userId' => $usuario->id]) }}">Añadir/eliminar administrador</a></td>
                <td><a class="ban" username="{{$usuario->username}}">Sancionar</a></td><td><a style="color: red" link="{{route('deleteUser', ['userId' => $usuario->id])}}">Eliminar</a></td>
            </tr>
        @endforeach
 </table>


