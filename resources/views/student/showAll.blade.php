@extends("layouts.authLayout")

@section("title")
    Estudiantes
@endsection

@section("main")
    <main>
        <section class="container">
            <h1>Lista de alumnos</h1>
            <section>
                <a class="btn btn-primary col-12 mt-3" href="{{route("student.show")}}">
                    Agregar nuevo alumno
                </a>
            </section>
            <section>
                @forelse ($students as $student)
                    <div class="row mt-3 border border-2 rounded">
                        <div class="d-flex col-lg-2 justify-content-center">
                            <i class="bi bi-person-badge-fill" style="font-size: 5rem"></i>
                        </div>
                        <div class="col-lg-8 mb-2 d-flex flex-column justify-content-center">
                            <div class="col-12">
                                Numero de control: <p class="d-inline fw-bold">{{$student->controlNumber}}</p>
                            </div>
                            <div class="col-12">
                                Nombre: <p class="d-inline fw-bold">{{$student->name}} {{$student->lastName}}</p>
                            </div>
                            <div class="col-12">
                                Carrera: <p class="d-inline fw-bold">{{$student->career}}</p>
                            </div>
                            <div class="col-12">
                                Semestre: <p class="d-inline fw-bold">{{$student->semester}}</p>
                            </div>
                        </div>
                        <div class="col-lg-2 d-flex flex-column justify-content-center">
                            <a class="btn btn-success mb-2 col-12" href="/estudiante/{{$student->id}}">
                                Editar
                            </a>
                            <form action="{{url("/estudiante/".$student->id)}}" method="POST">
                                @method("delete")
                                @csrf
                                <button class="btn btn-danger mb-2 col-12">Eliminar</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <span class="d-block alert alert-danger p-2 m-2">No hay estudiantes</span>
                @endforelse
            </section>
            <section class="mt-3">
                {{ $students->links() }}
            </section>
        </section>
    </main>
@endsection
