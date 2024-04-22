@extends("layouts.authLayout")

@section('title')
Crear reporte
@endsection

@section("main")
    <main class="container">
        <p class="h3 fw-bold text-center my-4">Elige un tipo de reporte</p>
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Reporte de tiempo de uso del centro de cómputo
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="px-5 py-4">
                        <form action="{{route('report1')}}" method="get">
                            <div class="mb-2">
                                <label for="form-label career" class="mb-1">Carrera</label>
                                <select class="form-select col-12 mx-auto" name="career" id="career" required>
                                    @foreach(\App\Http\Utils\CareersE::getCareers() as $career)
                                        <option value="{{$career}}">{{$career}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2">
                                <label for="semester" class="form-label mb-1">Semestre</label>
                                <input id="semester" name="semester" class="form-control col-12 mx-auto " type="number" min="1" max="13" required>
                            </div>
                            <div class="mb-2">
                                <label for="period" class="form-label mb-1">Periodo</label>
                                <select id="period" class="form-select col-12 mx-auto" name="periodId" required>
                                    @foreach($periods as $period)
                                        <option value={{$period->id}}>{{$period->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <button class="btn btn-primary col-12">Generar reporte</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Reporte de tiempo de uso del centro de cómputo por carrera
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="px-5 py-4">
                        <form action="{{route('report2')}}" method="get">
                            <div class="mb-2">
                                <label for="period" class="form-label mb-1">Periodo</label>
                                <select id="period" class="form-select col-12 mx-auto" name="periodId" required>
                                    @foreach($periods as $period)
                                        <option value={{$period->id}}>{{$period->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <button class="btn btn-primary col-12">Generar reporte</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Reporte de tiempo de uso del centro de cómputo por carrera (detallado)
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="px-5 py-4">
                        <form action="{{route('report3')}}" method="get">
                            <div class="mb-2">
                                <label for="period" class="form-label mb-1">Periodo</label>
                                <select id="period" class="form-select col-12 mx-auto" name="periodId" required>
                                    @foreach($periods as $period)
                                        <option value={{$period->id}}>{{$period->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <button class="btn btn-primary col-12">Generar reporte</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        Reporte de cantidad de usos de los equipos por carrera
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="px-5 py-4">
                        <form action="{{route('report4')}}" method="get">
                            <div class="mb-2">
                                <label for="period" class="form-label mb-1">Periodo</label>
                                <select id="period" class="form-select col-12 mx-auto" name="periodId" required>
                                    @foreach($periods as $period)
                                        <option value={{$period->id}}>{{$period->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <button class="btn btn-primary col-12">Generar reporte</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                        Reporte de cantidad de tipos de uso por carrera
                    </button>
                </h2>
                <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="px-5 py-4">
                        <form action="{{route('report5')}}" method="get">
                            <div class="mb-2">
                                <label for="period" class="form-label mb-1">Periodo</label>
                                <select id="period" class="form-select col-12 mx-auto" name="periodId" required>
                                    @foreach($periods as $period)
                                        <option value={{$period->id}}>{{$period->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <button class="btn btn-primary col-12">Generar reporte</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
