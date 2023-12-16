@extends("layouts.authLayout")

@section("titulo")
    Editar Computo
@endsection

@section("vite")
    <meta name="csrf-token" content="{{csrf_token()}}">
    @vite(["resources/js/equipment/edit.js"])
@endsection

@section("main")
    <h1>Agregar Equipo de computo</h1>
    <form action="" method="POST">
        <section>
            <input
                id="input-name"
                name="cpu"
                type="text"
                placeholder="Nombre del procesador"
                required
                value="{{$computer->cpu}}"
            >
            <input 
                id="input-ram" 
                name="ram" 
                type="number" 
                placeholder="Ingresa la ram en GB" 
                required
                value="{{$computer->ram}}"
            >
        </section>
        <section id="ports-section">
            <label for="">Puertos</label>
            <button id="btn-add-port">Agregar</button>
            <div id="list-prots"></div>
            <div id="list-ports-editable">
                @foreach ($computer->ports as $port)
                    <div id="li-port-editable" port="{{$port->id}}">
                        <input 
                            type="text" 
                            value="{{$port->type}}"
                            id="port-type-editable"
                        >
                        <input 
                            type="text" 
                            value="{{$port->amount}}"
                            id="port-ammount-editable" 
                        >
                        <button 
                            type="text"
                            id="btn-edit-port-editable"
                            port="{{$port->id}}"
                        >
                            Editar
                        </button>
                        <button
                            id="btn-remove-port-editable"
                            port="{{$port->id}}"
                        >
                            Eliminar
                        </button>
                    </div>
                @endforeach
            </div>
        </section>
        <section id="programs-section">
            <h3>Programas</h3>
                @foreach ($programsEditable as $programEdit)
                    <div>
                        <h3>{{$programEdit->name}}</h3>
                        <span>{{$programEdit->version}}</span>
                        <input
                            id="btn-add-program"
                            type="checkbox"
                            program="{{$programEdit->id}}"
                        >
                    </div>
                @endforeach
        </section>
        <section id="section-programs-computer">
            <h3>Programas del equipo</h3>
            @foreach ($computer->programs as $programComp)
                <div id="li-program-computer" program="{{$programComp->id}}">
                    <h3>{{$programComp->program->name}}</h3>
                    <span>{{$programComp->program->version}}</span>
                    <input
                        id="btn-remove-program"
                        type="checkbox"
                        checked 
                        program="{{$programComp->id}}"
                    >
                </div>
            @endforeach
        </section>
        <section>
            <button id="btn-send">Editar Computadora</button>
        </section>
    </form>
    </main>
    <script>
        const idComputer = {{$computer->id}}
    </script>
@endsection