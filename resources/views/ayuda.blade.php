<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ayuda</title>
    <link rel="stylesheet" href="{{asset('/css/fonts.css')}}">
    <link rel="stylesheet" href="{{asset('/css/styles.css')}}">
</head>
    <body>
    <x-header/>
    <x-aside/>
<main class="help">
        <h1>Ayuda</h1>
    <h2>1.Navegación de usuarios anónimos</h2>
    <p>La aplicación permitirá a usuarios que no estén rgistrados navegar por ella, aunque tendrán funcionalidades limitadas,
    como pueden ser dar "me gusta" a los videojuegos, comentar, publicar videojuegos... Para desbloquear estas funciones,
        el usuario deberá registrarse e iniciar sesión.</p>
    <h2>2. Usuarios registrados</h2>
    Existen distintos tipos de usuarios registrados:
        <ol>
            <li>Usuarios sin privilegios: este es el usuario que se la adjudica a cualquier persona que se registre a través de la
            aplicación. Este podrá realizar, entre otras, las acciones anteriormente descritas, mas no tendrá privilegios de administrador</li>
            <li>Usuarios administradores: estos usuarios tendrán algunos privilegios más que los usuarios sin privilegios. Podrán
            sancionar a otros usuarios, crear nuevos usuarios y asignarles un rol y eliminar otros usuarios, siempre que tengan
            un rol inferior. Esto se podrá hacer desde el panel de administración al que solo pueden acceder este tipo de usuarios. Esta opción
            se encontrará en la barra lateral izquierda.
            <li>Usuarios super administradores: Este usuario goza de cualquier privilegio, ya que al tener el rol más alto, puede eliminar
            a cualquier usuario. Además, este podrá cambiar el rol de usuarios ya creados, por lo que puede subir de rango a un usuario
            sin privilegios o bajar el de un usuario administrador</li>
        </ol>

    <h2>3.Barra de navegación Lateral</h2>
    <p>Aquí se encontrarán todas las páginas a las que el usuario registrado podrá entrar. Si el usuario no ha iniciado la sesión,
    se le mostrará un formulario para poder hacerlo y una opción para registrarse, en caso de que este no lo esté.</p>
    <h3>3.1. Inicio</h3>
    <p>Redirigirá al usuario a la página principal</p>
    <h3>3.2. Panel de control</h3>
    <p>Opción desbloqueada solamente para usuarios administradores y super administradores. Permite al usuario acceder al panel de control</p>
    <h3>3.3. Mi perfil</h3>
    <p>Permite al usuario visualizar su perfil, que incluye su nombre, nombre de usuario, número de seguidores y de gente que sigue y lus juegos publicados,
    en caso de tenerlos. Al hacer click en cada tarjeta de videojuego el usuario podrá acceder a la página de dicho juego. Además,
    el usuario contará con el botón "editar información", donde podrá cambiar sus datos. En caso de visitar el perfil de otro usuario,
    este botón se sustituirá por uno de "seguir"</p>
    <h4>3.3.1. Editar información</h4>
    <p>Aparecerá un formulario con los datos del usuario escritos. Solo de deberán cambiar los datos que se quieran cambiar.
    Además, existe un botón que permite al usuario cambiar su contraseña</p>
    <h3>3.4. Publicar juego</h3>
    <p>Permite al usuario subir un juego al servidor y publicarlo. Para ello, deberá rellenar el formulario que se le muestra.
    algunos datos como el nombre del juego, la versión o el archivo que contiene el videojuego son obligatorios. Este archivo deberá
    ser ".zip",".rar" o ".7zip". La imagen del fideojuego se podrá cambiar haciendo click en la imagen que aparece (la del mando
        con el fondo verde). Además, la versión deberá cumplir el formato estándar. Deben ser tres números separados por puntos.
        Ejemplo: 1.0.0, 1.2.5, 2.0.5. Valores como 1 o 1.0 no se validarán . Pulsa <a href="https://semver.org/lang/es/">aquí</a> para ver una guía más detallada sobre
    esto.</p>
    <h3>3.5. Juegos favoritos</h3>
    <p>Aquí apareceran los juegos a los que el usuario ha dado "me gusta" anteriormente. Esto se consigue haciendo clic en el corazón
    que se encuentra en la página de cada videojuego. El usuario podrá entrar a la página de cada videojuego o eliminarlos de la lista.</p>
    <h3>3.6. Para ti</h3>
    <p>Aquí apareceran los juegos de los usuarios que el usuario siga</p>
    <h2>4. Página del videojuego</h2>
    <p>Mostrará la información del videojuego, como su nombre, imagen y usuario que lo ha publicado, además de un botón para dar me gusta
    y otro para descargar el juego. Si estás visitando tu propio videojuego, tendrás disponible un botón para modificar la información del
    videojuego. Esta página funciona de la misma manera que la de "editar usuario". Además, esta página dispone de 3 pestañas por las que
    el usuario puede navegar.</p>
    <h3>4.1. Opiniones y sugerencias</h3>
    <p>Los usuarios podrán comentar para dejar sus opiniones y sugerencias acerca del videojuego.</p>
    <h3>4.2. Notas del parche</h3>
    <p>Permite a los usuarios ver las notas del parche. Si has publicado tú el videojuego, podrás añadir nuevas notas</p>
    <h3>4.3. Cómo jugar</h3>
    <p>Permite a los usuarios ver las instrucciones que ha dado el creador del videojuego para poder jugarlo.</p>
</main>

</body>
<script src="{{asset('/js/main.js')}}"></script>
</html>
