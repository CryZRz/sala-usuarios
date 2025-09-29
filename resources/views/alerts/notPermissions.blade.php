@extends("layouts.mainLayout")

@section("title")
    Sin permisos
@endsection

@section("module")
    Restricciòn
@endsection

@section("content")
    <x-show-alert-component
        text="No tienes permisos necesarios para acceder o realizar la acción"
    />
@endsection
