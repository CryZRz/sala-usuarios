@extends("layouts.reportesLayout")

@section("title")
    Total de tiempo por carrera
@endsection

@section("vite")
    @vite(["resources/js/reports/totalTimeCareer.js"])
@endsection

@section("content")
    <main class="container">
        <section class="mt-4">
            <h1 class="fw-bold">REPORTE DE TIEMPO DE USO</h1>
        </section>
        <section>
            <span class="d-block">Reporte tiempo de uso de todas las carreras</span>
            <span class="d-block">Generado a fecha: {{\Carbon\Carbon::now()}}</span>
            <span class="d-block">Periodo: {{$period->name}}</span>
            <span class="d-block">Expedido por: {{auth()->user()->name}} {{auth()->user()->email}}</span>
        </section>
        <x-print-component/>
        <section class="mt-3">
            <h3>Total tiempo: {{$sumTotalTime}}</h3>
        </section>
        @foreach ($listReports as $report)
            <table class="w-100 fw-bold text-center mb-3 mt-4" border="none">
                <tr class="bg-azul-tecnm w-full text-white p-1">
                    <td colspan="6">Uso</td>
                </tr>
                <tr class="bg-azul-tecnm w-full text-white">
                    <td>Carrera</td>
                    <td>Tiempo de uso</td>
                </tr>
                <tr class="border-end border-start border-black">
                    <td class="p-1">{{$report->career}}</td>
                    <td class="p-1">{{$report->totalTime}}</td>
                </tr>
            </table>
        @endforeach
        <div class="w-3p5 mx-auto mt-5">
            <canvas id="ctx"></canvas>
        </div>
        @if(!empty($studentsReport))
            <div class="mt-5">
                <h3 class="fw-bold">Detalle de usos</h3>
                @foreach($studentsReport as $studentReport)
                    <h3 class="fw-bold mt-4">{{$studentReport["career"]}}</h3>
                    <section class="mb-2">
                        @foreach($studentReport["data"] as $report)
                            <table class="w-100 fw-bold text-center mb-3" colspan="6">
                                <tr class="bg-azul-tecnm w-full text-white p-1" style="color: white">
                                    <td colspan="6">Alumno</td>
                                </tr>
                                <tr class="bg-azul-tecnm w-full text-white" style="color: white">
                                    <td>Nombre</td>
                                    <td>N.Control</td>
                                    <td>Semestre</td>
                                    <td colspan="3">Carrea</td>
                                </tr>
                                <tr class="border-end border-start border-black">
                                    <td class="p-1">{{$report->student->name}} {{$report->student->lastName}}</td>
                                    <td class="p-1">{{$report->studentUpdate->controlNumber}}</td>
                                    <td class="p-1">{{$report->studentUpdate->semester}}</td>
                                    <td class="p-1" colspan="3">{{$report->studentUpdate->career}}</td>
                                </tr>
                                <tr class="bg-azul-tecnm w-full text-white p-1" style="color: white">
                                    <td colspan="6">Uso</td>
                                </tr>
                                <tr class="bg-azul-tecnm w-full text-white" style="color: white">
                                    <td colspan="1">Tiempo de uso</td>
                                    <td colspan="2">Inicio</td>
                                    <td colspan="2">Fin</td>
                                    <td colspan="1">Uso</td>
                                </tr>
                                <tr class="border-end border-start border-black">
                                    <td class="p-1" colspan="1">{{$report->timeAssigment}}</td>
                                    <td class="p-1" colspan="2">{{$report->startTime}}</td>
                                    <td class="p-1" colspan="2">{{$report->endTime}}</td>
                                    <td class="p-1" colspan="1">{{$report->application->name}}</td>
                                </tr>
                                <tr class="bg-azul-tecnm w-full text-white p-1" style="color: white">
                                    <td colspan="6">Equipo</td>
                                </tr>
                                <tr class="bg-azul-tecnm w-full text-white" style="color: white">
                                    <td colspan="2">Id</td>
                                    <td colspan="2">ram</td>
                                    <td colspan="2">cpu</td>
                                </tr>
                                <tr class="border-end border-start border-black">
                                    <td colspan="2">{{$report->computer->id}}</td>
                                    <td colspan="2">{{$report->computer->ram}}</td>
                                    <td colspan="2">{{$report->computer->cpu}}</td>
                                </tr>
                                <tr class="bg-azul-tecnm w-full text-white p-1" style="color: white">
                                    <td colspan="6">Administrador</td>
                                </tr>
                                <tr class="bg-azul-tecnm w-full text-white text-center" style="color: white">
                                    <td colspan="3">Nombre</td>
                                    <td colspan="3">Correo</td>
                                </tr>
                                <tr class="border-end border-start border-bottom border-black">
                                    <td colspan="3">{{$report->owner->name}}</td>
                                    <td colspan="3">{{$report->owner->email}}</td>
                                </tr>
                            </table>
                        @endforeach
                    </section>
                @endforeach
            </div>
        @endif

        <script>
            const dataReport = @json($dataJs)
        </script>
    </main>
@endsection
