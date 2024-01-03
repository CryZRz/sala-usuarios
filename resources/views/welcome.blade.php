<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome</title>
</head>
<body>
    <form action="{{route("login.destroy")}}" method="POST">
        @csrf
        @method("delete")
        <button>Cerrar sesion</button>
    </form>
</body>
</html>
