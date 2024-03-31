@extends("layouts.authLayout")

@section("main")
    <main class="container">
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        REPORTE DE TIEMPO DE USO DEL CENTRO DE COMPUTO
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="p-2">
                        <form action="{{route('report1')}}" method="get">
                            <div class="mb-2">
                                <label for="career" class="mb-1">Carrera</label>
                                <select class="col-12 mx-auto" name="career" id="career">
                                    @foreach(\App\Http\Utils\CareersE::getCareers() as $career)
                                        <option value="{{$career}}">{{$career}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2">
                                <label for="semester" class="mb-1">Semestre</label>
                                <input id="semester" name="semester" class="col-12 mx-auto " type="number" placeholder="semestre">
                            </div>
                            <div class="mb-2">
                                <label for="period" class="mb-1">Periodo</label>
                                <select id="period" class="col-12 mx-auto" name="periodId">
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
                        REPORTE DE TIEMPO DE USO DEL CENTRO DE COMPUTO POR CARRERA
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="p-2">
                        <form action="{{route('report2')}}" method="get">
                            <div class="mb-2">
                                <label for="period" class="mb-1">Periodo</label>
                                <select id="period" class="col-12 mx-auto" name="periodId">
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
                        REPORTE DE TIEMPO DE USO DEL CENTRO DE COMPUTO POR CARRERA DETALLE
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="p-2">
                        <form action="{{route('report3')}}" method="get">
                            <div class="mb-2">
                                <label for="period" class="mb-1">Periodo</label>
                                <select id="period" class="col-12 mx-auto" name="periodId">
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
                        REPORTE CANTIDAD DE USOS DE LOS EQUIPOS POR CARRERA
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="p-2">
                        <form action="{{route('report4')}}" method="get">
                            <div class="mb-2">
                                <label for="period" class="mb-1">Periodo</label>
                                <select id="period" class="col-12 mx-auto" name="periodId">
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
                        REPORTE CANTIDAD DE USOS POR CARRERA
                    </button>
                </h2>
                <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="p-2">
                        <form action="{{route('report5')}}" method="get">
                            <div class="mb-2">
                                <label for="period" class="mb-1">Periodo</label>
                                <select id="period" class="col-12 mx-auto" name="periodId">
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
