<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
</head>
<body>
    <form action="{{route("register.store")}}" method="POST">
        @csrf
        <label for="name">Nombre</label>
        <input type="text" name="name" id="name" placeholder="Nombre" required>
        <label for="email">Correo</label>
        <input type="email" name="email" id="email" placeholder="Correo" required>
        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password" placeholder="Contraseña" required>
        <button>Enviar</button>
    </form>
</body>
</html>