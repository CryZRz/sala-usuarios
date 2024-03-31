@extends("layouts.reportesLayout")

@section("title")
    Cantidad de usos por carrera
@endsection

@section("vite")
    @vite(["resources/js/reports/countApplicationPeerCareer.js"])
@endsection

@section("content")
    <main class="container">
        <section class="mt-4">
            <h1 class="fw-bold">REPORTE CANTIDAD DE USOS POR CARRERA</h1>
        </section>
        <section>
            <span class="d-block">Reporte conteo de los usos por carrera</span>
            <span class="d-block">Generado a fecha: {{\Carbon\Carbon::now()}}</span>
            <span class="d-block">Periodo: {{$period->name}}</span>
            <span class="d-block">Expedido por: {{auth()->user()->name}} {{auth()->user()->email}}</span>
        </section>
        <x-print-component/>
        <section class="mt-3">
            @foreach($listReports as $report)
                <table class="w-100 mb-3">
                    <thead>
                        <tr class="bg-azul-tecnm text-white w-100 text-center">
                            <th colspan="4">
                                Uso: {{$report["application"]["value"]->application->name}}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-azul-tecnm text-white w-100 text-center">
                            <td colspan="2">Carrera</td>
                            <td colspan="2">Cantidad de usos</td>
                        </tr>
                        @foreach($report["careersUse"] as $careerUse)
                            <tr class="border border-black text-center">
                                <td colspan="2">{{$careerUse["career"]}}</td>
                                <td colspan="2">{{$careerUse["countUse"]}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <canvas class="w-3p5 mx-auto mt-3 mb-3" id="ctx-{{$report["application"]["id"]}}"></canvas>
            @endforeach
        </section>
    </main>
    <script>
        const dataReport = @json($listReports)
    </script>
@endsection
