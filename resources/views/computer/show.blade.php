@extends("layouts.authLayout")

@section("title")
    Equipos
@endsection

@section("main")
    <main>
        
        @foreach ($computers as $computer)
            <div>
                @foreach ($computer->programs as $program)
                    {{$program->program}}
                @endforeach
            </div>
        @endforeach
    </main>
@endsection