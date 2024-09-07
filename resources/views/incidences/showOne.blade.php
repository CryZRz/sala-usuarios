@extends("layouts.authLayout")

@section("main")
    <main class="d-flex justify-content-center">
        <div class="card border" style="width: 55rem;">
            <div class="card-header bg-black col-12 p-3">
                <div class="col-12 d-flex justify-content-center">
                    <img
                        class="mx-auto"
                        src="/images/tecnmLGW.png"
                        alt="itl logo"
                        style="height: 5.4rem"
                    >
                </div>
            </div>
            <div class="card-body text-center border border-black p-0">
                <div class="col-12">
                    <div>
                        <span class="fw-bold h3 text-start d-block px-3 pt-3 pb-2">Incidencia:</span>
                        <ul class="list-unstyled">
                            <li class="mb-1 d-flex justify-content-between px-3 py-0">
                                <p class="m-0 d-flex justify-content-between d-inline">Número de incidencia:</p>
                                <p class="m-0 d-inline">{{ $incidence->id }}</p>
                            </li>
                            <li class="mb-1 d-flex justify-content-between px-3 py-0">
                                <p class="m-0 fw-bold d-inline">Fecha de alta:</p>
                                <p class="m-0">{{ $incidence->created_at }}</p>
                            </li>
                            <li class="mb-1 d-flex justify-content-between px-3 py-0">
                                <p class="m-0 fw-bold d-inline">Fecha de última actualización:</p>
                                <p class="m-0">{{ $incidence->updated_at }}</p>
                            </li>
                            <li class="mb-1 d-flex justify-content-between px-3 py-0">
                                <p class="m-0 fw-bold d-inline">Estatus:</p>
                                <p class="m-0">{{ $incidence->status_text }}</p>
                            </li>
                            <li class="mb-1 text-start px-3 py-0">
                                <p class="m-0 fw-bold d-inline">Descripción:</p>
                                <p class="m-0">{{ $incidence->description }}</p>
                            </li>
                        </ul>
                    </div>

                    <div class="row">
                        <div class="border col-12 col-md-6">
                            <span class="fw-bold h3 text-start d-block px-3 pt-2 pb-2">Alumno:</span>
                            <ul class="list-unstyled">
                                <li class="mb-1 text-start px-3 py-0">
                                    <p class="m-0 fw-bold d-inline">Número de control:</p>
                                    <p class="m-0">
                                        {{ $incidence->studentUpdate->controlNumber }}
                                    </p>
                                </li>
                                <li class="mb-1 text-start px-3 py-0">
                                    <p class="m-0 fw-bold d-inline">Nombre:</p>
                                    <p class="m-0">
                                        {{ $incidence->studentUpdate->student->last_name_first }}
                                    </p>
                                </li>
                                <li class="mb-1 text-start px-3 py-0">
                                    <p class="m-0 fw-bold d-inline">Carrera:</p>
                                    <p class="m-0">{{ $incidence->studentUpdate->career }}</p>
                                </li>
                                <li class="mb-1 px-3 py-0 text-start">
                                    <p class="m-0 fw-bold d-inline">Semestre:</p>
                                    <p class="m-0 d-inline">{{ $incidence->studentUpdate->semester }}</p>
                                </li>
                            </ul>
                        </div>

                        <div class="col-12 border col-md-6">
                        <span class="fw-bold h3 text-start d-block px-3 pt-2 pb-2">
                            Creado por:
                        </span>
                            <ul class="list-unstyled">
                                <li class="mb-1 px-3 py-0 text-start">
                                    <p class="m-0 fw-bold d-inline">Nombre:</p>
                                    <p class="m-0">
                                        {{ $incidence->owner->name }}
                                    </p>
                                </li>
                                <li class="mb-1 px-3 py-0 text-start">
                                    <p class="m-0 fw-bold d-inline">Email:</p>
                                    <p class="m-0">{{ $incidence->owner->email }}</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                    </div>
            <div class="card-footer bg-black text-center text-white p-3">
                <p class="fw-bold p-0 m-0">proudly designed by CryZRz</p>
            </div>
        </div>
    </main>
@endsection
