@extends("layouts.authLayout")

@section("title")
    Crear Equipo
@endsection

@section("vite")
    <meta name="csrf-token" content="{{csrf_token()}}">
    @vite(["resources/js/equipment/index.js"])
@endsection

@section("main")
    <main>
        <h1>Agregar Equipo de computo</h1>
        <form action="" method="POST">
            <section>
                <input id="input-ram" name="ram" type="number" placeholder="Ingresa la ram en GB" required>
                <input id="input-name" name="cpu" type="text" placeholder="Nombre del procesador" required>
            </section>
            <section id="ports-section">
                <label for="">Puertos</label>
                <button id="btn-add-port">Agregar</button>
                <div id="list-prots">
            </section>
            <section id="programs-section">
                <h3>Programas</h3>
            </section>
            <section>
                <button id="btn-send">Agregar Computadora</button>
            </section>
        </form>
    </main>
    
@endsection