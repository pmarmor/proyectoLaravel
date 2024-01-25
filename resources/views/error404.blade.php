<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>404</title>
    <link rel="stylesheet" href="{{asset('/css/fonts.css')}}">
    <link rel="stylesheet" href="{{asset('/css/styles.css')}}">
</head>
<style>
    body{
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 90vh;
    }
    body h2.error{
        margin: 0;
        font-size: 100px;
    }
    header img:last-child{
        display: none;
    }
</style>
<body>
<x-header/>
<h2 class="error">404</h2>
<h3>El recurso no existe</h3>
<span>Volver a <a href="/">inicio</a></span>
<script src="{{asset('/js/main.js')}}"></script>
</body>
</html>
