<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Acerca de</title>
    <link rel="stylesheet" href="{{asset('/css/fonts.css')}}">
    <link rel="stylesheet" href="{{asset('/css/styles.css')}}">
</head>
<style>
    main{
        padding:0 ;
        margin: 0;
        height:100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    div.card{
        border-radius: 10px;
        border: solid orange 2px;
        padding: 30px 60px 60px;
        background: #c7c7c7;
    }
</style>
<body>
<x-header/>
<x-aside/>
<main>
   <div class="card">
       <h2>Acerca de</h2>
       <p>Proyecto realizado por Pablo Martín Morente, alumno del Ciclo Superior de Desarrollo de Aplicaciones Web, del
       I.E.S. TRASSIERRA</p>
   </div>
</main>

</body>
<script src="{{asset('/js/main.js')}}"></script>
</html>
