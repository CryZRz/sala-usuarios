<!DOCTYPE html>
<html lang="es">

<head>
  <title>Sala de usuarios | Restablecer contraseña</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/scss/app.scss', 'resources/scss/forgotPassword.scss'])
</head>

<body>
  <header class="section-header">
      <nav class="section-header-navbar">
        <div class="section-header-navbar-fl">
          <img src="/images/logoITL.png" alt="logoITL">
        </nav>
      </div>
  </header>
  <section class="section-main">
    <form action="{{route('resetPassword.store')}}" class="form-change-password" method="POST">
      @csrf
      <div class="info-change-password">
        <img src="/images/tecnmLG.png" alt="tecnm logo">
        <span class="fw-bold">Restablecer contraseña</span>
        <p class="text-center">
            Ingresa aqui la nueva contraseña para tu cuenta, asegurate de
            que coincidan.
        </p>
      </div>
      <div class="get-info-change-password">
        <div class="input-group flex-nowrap flex-column ">
          <section class="col-12">
            <input
                type="password"
                class="border border-2 col-12 p-1"
                placeholder="Nueva contraseña"
                name="password"
                required
            >
              <input type="hidden" name="token" value="{{$token}}">
              <input type="hidden" name="email" value="{{$email}}">
          </section>
          <section class="col-12 mt-2">
            <input
                type="password"
                class="border border-2 col-12 p-1"
                placeholder="Confirmar contraseña"
                name="password_confirmation"
                required
            >
          </section>
        </div>
        <div>
            @error("password")
                <span class="text-danger small fw-bold mb-0 mt-1">{{$message}}</span>
            @enderror
        </div>
        <button>
          Enviar
        </button>
      </div>
    </form>
  </section>
</body>
</html>
