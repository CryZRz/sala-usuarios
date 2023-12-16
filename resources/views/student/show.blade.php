@extends("layouts.authLayout")

@section("title")
    Crear usuario
@endsection

@section("main")
    <main>
        <form action="{{route("student.store")}}" method="POST">
            @csrf
            <label for="controlNumber">Numero de control</label>
            <input name="controlNumber" type="text" placeholder="numero de control">
            <label for="name">Nombre</label>
            <input name="name" type="text" placeholder="Nombre del alumno">
            <label for="lastName">Apellidos</label>
            <input name="lastName" type="text" placeholder="Apellidos del alumno">
            <label for="career">Carrera</label>
            <select name="career">
                <option value="Ingenieria en Sistemas Computacionales">
                    Ingenieria en Sistemas Computacionales
                </option>
                <option value="Ingenieria en Gestion Empresarial">
                    Ingenieria en Gestion Empresarial
                </option>
                <option value="Ingenieria en Electromecanica">
                    Ingenieria en Electromecanica
                </option>
                <option value="Ingenieria en Logistica">
                    Ingenieria en Logistica
                </option>
                <option value="Ingenieria en Industrial">
                    Ingenieria en Industrial
                </option>
                <option value="Ingeniería en TICS">
                    Ingeniería en TICS
                </option>
            </select>
            <label for="semester">Semestre</label>
            <input type="number" name="semester" placeholder="Semestre del alumno">
            <button>Guardar alumno</button>
        </form>
    </main>
@endsection