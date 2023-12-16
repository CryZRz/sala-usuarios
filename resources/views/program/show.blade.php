@extends("layouts.authLayout")

@section("title")
    Programas
@endsection

@section("main")
    <main>
        @foreach ($programs as $program)
            <a href="/programa/{{$program->id}}">
                <div>
                    <h3>{{$program->name}}</h3>
                    <p>{{$program->version}}</p>
                </div>
            </a>
        @endforeach
    </main>
@endsection