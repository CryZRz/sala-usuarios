@extends("layouts.authLayout")

@section("title")
    Editar usuario
@endsection

@section("main")
    <main>
        {{$errors}}
        <form action="{{route("student.update", $student->id)}}" method="POST">
            @csrf
            <label for="controlNumber">Numero de control</label>
            <input 
                name="controlNumber" 
                type="text" 
                placeholder="numero de control" 
                value="{{$student->controlNumber}}"
            >
            <label for="name">Nombre</label>
            <input
                name="name"
                type="text"
                placeholder="Nombre del alumno"
                value="{{$student->name}}"
            >
            <label for="lastName">Apellidos</label>
            <input
                name="lastName"
                type="text"
                placeholder="Apellidos del alumno"
                value="{{$student->lastName}}"
            >
            <label for="career">Carrera</label>
            <select name="career" >
                @foreach ($careers as $career)
                    <option 
                        value="{{$career->value}}"
                        @if ($career->value == $student->career) selected @endif
                    >
                        {{$career->value}}
                    </option>
                @endforeach
            </select>
            <label for="semester">Semestre</label>
            <input
                type="number"
                name="semester"
                placeholder="Semestre del alumno"
                value="{{$student->semester}}"
            >
            <button>Editar alumno</button>
        </form>
    </main>
@endsection