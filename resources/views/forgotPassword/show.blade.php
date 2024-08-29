<!DOCTYPE html>
<html lang="es">

<head>
    <title>Sala de usuarios</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/scss/app.scss', 'resources/scss/forgotPassword.scss'])
</head>

<body>
<header class="section-header">

</header>
<section class="section-main">
    <form action="{{route('forgotPassword.store')}}" class="form-change-password" method="POST">
        @csrf
        <div class="info-change-password">
            <img src="./images/logoITL.png" alt="tecnm logo">
            <span class="fw-bold">¿Olvidaste tu contraseña?</span>
            <p class="text-center">
                Ingresa aqui tu correo y te enviaremos un
                enlace para recuperarla
            </p>
        </div>
        <div class="get-info-change-password">
            <div class="input-group flex-nowrap">
          <span class="input-group-text col-2" id="addon-wrapping">
            <i class="bi bi-envelope"></i>
          </span>
                <input
                    type="text"
                    class="border border-2 col-10"
                    placeholder="Correo"
                    name="email"
                    required
                >
            </div>
            <div>
                @error("email")
                <span class="text-danger small fw-bold mb-0 mt-1">{{$message}}</span>
                @enderror
                @if(session("message") != null)
                    <span class="d-block alert alert-danger p-1 mb-0 mt-2">{{session("message")}}</span>
                @endif
                @if(session("success") != null)
                    <span class="d-block alert alert-success p-1 mb-0 mt-2">{{session("success")}}</span>
                @endif
            </div>
            <button>
                Enviar
            </button>
        </div>
    </form>
</section>
</body>
</html>
