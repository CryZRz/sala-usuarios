@extends("layouts.authLayout")

@section("title")
    Crear Equipo
@endsection

@section("vite")
    <meta name="csrf-token" content="{{csrf_token()}}">
    @vite(["resources/js/computer/create.js"])
@endsection

@section("main")
    <main>
        <section id="section-loading"></section>
        <section class="container">
            <h1>Agregar equipo de cómputo</h1>
        <form class="mt-2" action="" method="POST">
            <section class="row mb-2">
                <div class="col-md-6">
                    <label for="ram">RAM</label>
                    <input
                        id="input-ram"
                        name="ram"
                        type="number"
                        class="col-12"
                        placeholder="Ingresa la ram en GB"
                        required>
                </div>
                <div class="col-md-6">
                    <label for="cpu">CPU</label>
                    <input
                        id="input-name"
                        name="cpu"
                        type="text"
                        class="col-12"
                        placeholder="Nombre del procesador"
                        required
                    >
                </div>
            </section>
            <section id="ports-section">
                <label class="h5" for="">Puertos</label>
                <button class="btn btn-warning text-white col-12 mb-2" id="btn-add-port">Agregar</button>
                <div id="list-prots">
            </section>
            <section class="mb-3">
                <label class="h5" for="">Programas</label>
                <ol class="list-group list-group-numbered" id="programs-section">

                </ol>
                <div id="btn-show-more">
                    
                </div>
            </section>
            <section>
                <button class="btn btn-primary col-12 my-2" id="btn-send">Agregar Computadora</button>
            </section>
        </form>
        </section>
    </main>
@endsection