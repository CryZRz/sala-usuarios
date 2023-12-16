@extends("layouts.authLayout")

@section("title")
    Estudiantes
@endsection

@section("main")
    <main>
        @foreach ($students as $student)
            <div>
                <span>{{$student->controlNumber}}</span>
                <span>{{$student->name}} {{$student->lastName}}</span>
                <span>{{$student->career}}</span>
                <span>{{$student->semester}}</span>
                <a href="/estudiante/{{$student->id}}">
                    Editar
                </a>
                <form action="{{url("/estudiante/".$student->id)}}" method="POST">
                    @method("delete")
                    @csrf
                    <button>Eliminar</button>
                </form>
            </div>
        @endforeach
    </main>
@endsection