@extends("layouts.reportesLayout")

@section("title")
    Reporte tiempo por equipo
@endsection

@section("vite")
    @vite(["resources/js/reports/totalTimeUseComputer.js"])
@endsection

@section("content")
    <main class="container">
        <section class="mt-4">
            <h1 class="fw-bold">REPORTE DE TIEMPO DE USO DE LOS EQUIPOS</h1>
        </section>
        <section>
            <span class="d-block">Reporte del tiempo que se usaron las computadoras</span>
            <span class="d-block">Generado a fecha: {{\Carbon\Carbon::now()}}</span>
            <span class="d-block">Periodo: {{$period->name}}</span>
            <span class="d-block">Expedido por: {{auth()->user()->name}} {{auth()->user()->email}}</span>
        </section>
        <x-print-component/>
        <section class="mt-3">
            @foreach($listReports as $report)
                <table class="w-100 mb-3">
                    <thead class="bg-azul-tecnm text-center">
                        <tr>
                            <th class="text-white p-1" colspan="4">
                                Computadora: {{$report["computerId"]}}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-azul-tecnm text-center text-white">
                            <td colspan="2">Carrera</td>
                            <td colspan="2">Tiempo total de uso</td>
                        </tr>
                        @foreach($report["careersUse"] as $careerUse)
                            <tr class="border-black border text-center">
                                <td colspan="2">{{$careerUse["career"]}}</td>
                                <td colspan="2">{{$careerUse["timeUse"]}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <section class="w-full d-flex justify-content-center align-items-center">
                    <canvas class="w-1p3 mx-auto mt-3 mb-3" id="ctx-{{$report["computerId"]}}"></canvas>
                </section>
            @endforeach
        </section>
    </main>
    <script>
        const dataReport = @json($listReports)
    </script>
@endsection
