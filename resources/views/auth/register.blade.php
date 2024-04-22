@extends('layouts.authLayout')
@section('title')
    Registro
@endsection

@section('vite')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('main')
    <main class="d-flex justify-content-center my-3">
        <form action="{{ route('register.store') }}"
            class="bg-light sombraBasica rounded-5 p-4 mx-sm-5 d-inline-flex flex-column justify-content-center align-items-center"
            novalidate method="POST">
            @csrf
            <h4 class="titulo text-center mb-2">Nuevo administrador</h4>
            <div class="d-inline-flex flex-column gap-2">
                <p class="form-text text-center my-1">Recuerda que los datos que ingreses son para el nuevo administrador, no
                    los tuyos.</p>
                <div class="input-group">
                    <label for="numControl" class="input-group-text">Correo electrónico</label>
                    <input type="text" class="form-control text-center" id="email" name="email" size="30"
                        autocomplete="off" value="{{ old('email') }}" required>
                </div>
                @error('email')
                    <p class="m-0 mb-1 text-center text-danger">
                        {{ $message }}
                    </p>
                @enderror

                <div class="input-group">
                    <label class="input-group-text" for="nombre">Nombre</label>
                    <input class="form-control" type="text" id="name" name="name" autocomplete="off"
                        value="{{ old('name') }}" required>
                </div>
                @error('name')
                    <p class="m-0 mb-1 text-center text-danger">
                        {{ $message }}
                    </p>
                @enderror

                <div class="input-group">
                    <label class="input-group-text col-5" for="semestre">Contraseña</label>
                    <input type="text" class="form-control" id="pass" name="pass" autocomplete="off"
                        value="{{ old('pass') }}" required>
                </div>
                @error('password')
                    <p class="m-0 mb-1 text-center text-danger">
                        {{ $message }}
                    </p>
                @enderror

                <div class="input-group mb-1">
                    <label class="input-group-text col-5" for="semestre">Repite la contraseña</label>
                    <input type="text" class="form-control" id="confirm-password" name="confirm-password"
                        autocomplete="off" value="{{ old('confirm-password') }}" required>
                    <div class="m-0 mb-1 invalid-feedback text-center">
                        Ingresa el semestre del alumno.
                    </div>
                </div>
                @error('confirm-password')
                    <p class="m-0 mb-2 text-center text-danger">
                        {{ $message }}
                    </p>
                @enderror

                <button class="btn btn-turquesa fw-bold" type="submit">Registrar administrador</button>
            </div>
        </form>
    </main>
@endsection
