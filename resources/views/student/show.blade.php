@extends("layouts.authLayout")

@section("title")
    Crear usuario
@endsection
    @vite(['resources/js/utils/showError.js'])
@section("vite")

@endsection

@section("main")
    <main>
        <section class="container">
            <h1>Registrar estudiante</h1>
            <form action="{{route("student.store")}}" method="POST">
                @csrf
                <section class="row mb-3">
                    <div class="col-lg-6">
                        <label for="name">Nombre</label>
                        <input
                            class="col-12 p-1 @error('name') form-control is-invalid @enderror"
                            name="name"
                            type="text"
                            placeholder="Nombre del alumno"
                        >
                        @error('name')
                            <p class="text-danger small m-0 fw-medium">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="col-lg-6">
                        <label for="lastName">Apellidos</label>
                        <input
                            class="col-12 p-1 @error('lastName') form-control is-invalid @enderror"
                            name="lastName"
                            type="text"
                            placeholder="Apellidos del alumno"
                        >
                        @error('lastName')
                            <p class="text-danger small m-0 fw-medium">{{$message}}</p>
                        @enderror
                    </div>
                </section>
                <section class="mb-2">
                    <label for="career">Carrera</label>
                    <select class="col-12 p-1 @error('career') form-select is-invalid @enderror" name="career">
                        @foreach ($careers as $career)
                            <option value="{{$career}}">
                                {{$career}}
                            </option>
                        @endforeach
                    </select>
                    @error('career')
                        <p class="text-danger small m-0 fw-medium">{{$message}}</p>
                    @enderror
                </section>
                <section class="row mb-3">
                    <div class="col-lg-6">
                        <label for="semester">Semestre</label>
                        <input
                            class="col-12 p-1 @error('semester') form-control is-invalid @enderror"
                            type="number"
                            name="semester"
                            placeholder="Semestre del alumno"
                        >
                        @error('semester')
                            <p class="text-danger small m-0 fw-medium">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="col-lg-6">
                        <label for="controlNumber">Numero de control</label>
                        <input
                            class="col-12 p-1 @error('controlNumber') form-control is-invalid @enderror"
                            name="controlNumber"
                            type="text"
                            placeholder="Numero de control"
                        >
                        @error('controlNumber')
                            <p class="text-danger small m-0 fw-medium">{{$message}}</p>
                        @enderror
                    </div>
                </section>
                <section>
                    <button class="btn btn-primary col-12">Guardar alumno</button>
                </section>
            </form>
        </section>
    </main>
@endsection
