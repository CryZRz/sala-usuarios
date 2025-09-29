@extends("layouts.mainLayout")

@section("title")
    Agregar estudiante
@endsection

@section("module")
    Crear estudiante
@endsection

@section("content")
    <div class="mx-10 mt-10 flex justify-center">
        <div class="bg-white rounded-md w-4/5 shadow-md p-3">
            <div class="p-3">
                <h3 class="text-gray-700 font-medium">Nuevo Estudiante</h3>
            </div>
            <div>
                <form action="{{route("student.store")}}" method="post">
                    @csrf
                    <div class="flex mx-4 gap-6 mt-4">
                        <div class="w-1/2">
                            <label class="block text-xs text-gray-800 font-semibold" for="name">Nombres</label>
                            <input id="name" class="border mt-1 w-full border-gray-300 rounded-md p-2 outline-0 text-sm focus:border-brand-primary" type="text" name="name" placeholder="Nombres">
                            @error("name")
                            <p class="text-red-500 text-xs p-1 ">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="w-1/2">
                            <label class="block text-xs text-gray-800 font-semibold" for="lastName">Apellidos</label>
                            <input id="lastName" class="border w-full mt-1 border-gray-300 rounded-md p-2 outline-0 text-sm focus:border-brand-primary" type="text" name="lastName" placeholder="Apellidos">
                            @error("lastName")
                            <p class="text-red-500 text-xs p-1 ">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="flex mx-4 gap-6 mt-4">
                        <div class="w-1/2">
                            <label class="block text-xs text-gray-800 font-semibold" for="controlNumber">Num.Control</label>
                            <input id="controlNumber" class="border w-full mt-1 border-gray-300 rounded-md p-2 outline-0 text-sm focus:border-brand-primary" type="text" name="controlNumber" placeholder="Num.Control">
                            @error("controlNumber")
                            <p class="text-red-500 text-xs p-1 ">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="w-1/2">
                            <label class="block text-xs text-gray-800 font-semibold" for="semester">Semestre</label>
                            <input id="semester" class="border w-full mt-1 border-gray-300 rounded-md p-2 outline-0 text-sm focus:border-brand-primary" type="number" name="semester" placeholder="Semestre">
                            @error("semester")
                            <p class="text-red-500 text-xs p-1 ">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="mx-4 mt-4">
                        <label class="block text-xs text-gray-800 font-semibold" for="career">Plan estudios</label>
                        <select id="career" name="career" class="border w-full mt-1 border-gray-300 rounded-md p-2 outline-0 text-sm focus:border-brand-primary">
                            @foreach ($careers as $career)
                                <option class="text-gray-600 rounded-md" value="{{$career}}" selected>
                                    {{$career}}
                                </option>
                            @endforeach
                        </select>
                        @error("career")
                        <p class="text-red-500 text-xs p-1 ">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="mx-4 mt-5 flex gap-3 justify-end">
                        <button class="bg-brand-primary cursor-pointer p-2 rounded-md text-white text-sm font-bold">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
