@extends("layouts.mainLayout")

@section("title")
    Sin permisos
@endsection

@section("module")
    Restricciòn
@endsection

@section("content")
    <x-show-alert-component
        text="Este modulo no esta disponible por el momento"
    />
@endsection
