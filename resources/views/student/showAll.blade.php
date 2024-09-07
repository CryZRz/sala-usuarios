@extends("layouts.authLayout")

@section("title")
    Estudiantes
@endsection

@section("main")
    <main>
        <section class="container">
            <h1>Lista de alumnos</h1>
            <section class="row">
                <a class="btn btn-primary col-12 mt-3" href="{{route("student.show")}}">
                    Agregar nuevo alumno
                </a>
            </section>
            <section class="mt-3">
                <form action="{{route('student.findAll')}}" method="GET" class="row">
                    <label for="textFind" class="col-12 mb-1 p-0">Buscar alumno:</label>
                    <input
                        class="col-11 rounded-start-2 border-1 p-2"
                        type="text"
                        name="textFind"
                        placeholder="Nombre o numero de control"
                        id="textFind"
                    >
                    <button class="col-1 border-1 rounded-end-1 bg-primary text-white">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </section>
            <section>
                @forelse ($students as $student)
                    <div class="row mt-3 border border-1 rounded bg-white">
                        <div class="d-flex col-lg-2 justify-content-center">
                            <i class="bi bi-person-badge-fill" style="font-size: 5rem"></i>
                        </div>
                        <div class="col-lg-8 mb-2 d-flex flex-column justify-content-center">
                            <div class="col-12">
                                Numero de control: <p class="d-inline fw-bold">
                                    {{$student->latestStudentUpdate()->controlNumber}}
                                </p>
                            </div>
                            <div class="col-12">
                                Nombre:
                                <p class="d-inline fw-bold">
                                    {{$student->full_name}}
                                </p>
                            </div>
                            <div class="col-12">
                                Carrera: <p class="d-inline fw-bold">
                                    {{$student->latestStudentUpdate()->career}}
                                </p>
                            </div>
                            <div class="col-12">
                                Semestre: <p class="d-inline fw-bold">
                                    {{$student->latestStudentUpdate()->semester}}
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-2 d-flex flex-column justify-content-center">
                            <a
                                class="btn btn-success mb-2 col-12"
                                href="{{route('student.edit', $student->latestStudentUpdate()->controlNumber)}}">
                                Editar
                            </a>
                            <a
                                href="{{route('student.show.one.sessions', $student->latestStudentUpdate()->controlNumber)}}"
                                class="btn-primary btn"
                            >
                                Ver
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="row">
                        <span class="d-block alert alert-danger p-2 mt-3">
                            <i class="bi bi-exclamation-octagon-fill"></i>
                            No se encontraron estudiantes
                        </span>
                    </div>
                @endforelse
            </section>
            <section class="mt-3">
                @if($paginate)
                    {{ $students->links() }}
                @endif
            </section>
        </section>
    </main>
@endsection
