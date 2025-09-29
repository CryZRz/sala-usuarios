@extends("layouts.authLayout")

@section("title")
    Generar token
@endsection

@section("main")
    <main>
        <h2>Generar Token de Acceso API</h2>
        <form method="POST" action="{{route("token.get")}}">
            @csrf
            <button type="submit">Generar Token</button>
        </form>
    </main>
@endsection

