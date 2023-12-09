<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
    <form action="{{route("login.store")}}" method="POST">
        @csrf
        <label for="email">Correo</label>
        @if (session()->exists('erros'))
            {{$erros}}
        @endif
        <input id="email" type="email" name="email" required placeholder="Correo">
        <label for="password">Contraseña</label>
        <input type="password" required name="password" id="password" placeholder="Contraseña">
        <button>Login</button>
    </form>
</body>
</html>