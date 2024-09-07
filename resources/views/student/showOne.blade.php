@extends("layouts.authLayout")

@section("title")
    Alumno: {{$student->full_name}}
@endsection

@section("vite")
    @vite(['resources/scss/utils/colors.scss'])
@endsection

@section("main")
    <main class="container">
        <section class="d-flex bg-white rounded-top-2 border-1">
            <div class="mx-1">
                <i class="bi bi-person-circle p-2" style="font-size: 90px"></i>
            </div>
            <div class="d-flex flex-column justify-content-center">
                <span>
                    <p class="fw-bold d-inline">Nombre: </p>{{$student->full_name}}
                </span>
                <span>
                    <p class="fw-bold d-inline">Carrera: </p>{{$studentInfo->career}}
                </span>
                <span>
                    <p class="fw-bold d-inline">N.Control: </p>{{$studentInfo->controlNumber}}
                </span>
                <span>
                    <p class="fw-bold d-inline">Semestre: </p>{{$studentInfo->semester}}
                </span>
            </div>
        </section>
        <section class="d-flex bg-light-gray border-2 flex-wrap text-center">
            <div class="bg-yellow-itl d-block p-2 flex-fill @if(isset($sessions) > 0) bg-yellow-itl-yw @endif">
                <a
                    href="{{route('student.show.one.sessions', $studentInfo->controlNumber)}}"
                    class="text-decoration-none text-black"
                >
                    Sesiones
                </a>
            </div>
            <div class="bg-yellow-itl d-block p-2 flex-fill @if(isset($incidences) > 0) bg-yellow-itl-yw @endif">
                <a
                    href="{{route('student.show.one.incidences', $studentInfo->controlNumber)}}"
                    class="text-decoration-none text-black"
                >
                    Incidencias
                </a>
            </div>
        </section>
        @if(isset($sessions))
            @if(count($sessions) > 0)
                <section class="mt-3">
                    <table class="col-md-12 text-center">
                        <thead>
                        <tr class="bg-black text-white p-3">
                            <th>Fecha inicio</th>
                            <th>Fecha fin</th>
                            <th>Duración</th>
                            <th>N.Equipo</th>
                            <th>Tipo uso</th>
                            <th>Asignado por:</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sessions as $session)
                            <tr class="border-1">
                                <td>
                                    {{$session->start_time_format->format("y/m/d h:m")}}
                                </td>
                                <td>
                                    {{$session->end_time_format->format("y/m/d h:m")}}
                                </td>
                                <td>
                                    {{$session->timeAssigment}}
                                </td>
                                <td>
                                    {{$session->computer->computer_number}}
                                </td>
                                <td>
                                    {{$session->application->name}}
                                </td>
                                <td>
                                    {{$session->owner->name}}
                                    -
                                    {{$session->owner->email}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </section>
            @else
                <div class="alert alert-danger p-2 mt-3" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <span>El alumno no tiene sesiones.</span>
                </div>
            @endif
        @endif
        @if(isset($incidences))
            @if(count($incidences) > 0)
                <section class="mt-3">
                    <table class="col-12 text-center">
                        <thead>
                        <tr class="p-2 bg-black text-white">
                            <th>Fecha creación</th>
                            <th>Fecha finalización</th>
                            <th>Descripción</th>
                            <th>Estatus</th>
                            <th>Creado por</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($incidences as $incidence)
                            <tr class="text-center border-1">
                                <td>
                                    {{$incidence->created_at}}
                                </td>
                                <td>
                                    {{$incidence->deleted_at}}
                                </td>
                                <td>
                                    @if(strlen($incidence->description) > 50)
                                        {{substr($incidence->description, 0, 50)}}...
                                    @else
                                        {{$incidence->description}}
                                    @endif
                                </td>
                                <td>
                                    {{$incidence->status_text}}
                                </td>
                                <td>
                                    {{$incidence->owner->name}}
                                    -
                                    {{$incidence->owner->email}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </section>
            @else
                <div class="alert alert-danger p-2 mt-3" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <span>El alumno no tiene incidencias.</span>
                </div>
            @endif
        @endif
    </main>
@endsection
