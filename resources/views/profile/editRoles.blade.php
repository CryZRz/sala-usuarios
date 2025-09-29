@extends("layouts.profileLayout")

@section("data")
    <div x-data="editRoleUser({{$user->id}})">

        <x-modal-component :id="'showAddRole'" title="Agregar rol">
            <x-slot name="body">
                <template x-if="rolesToAdd.length > 0">
                    <div class="flex gap-1 flex-wrap overflow-y-auto h-10">
                        <template x-for="roleToAdd in rolesToAdd">
                            <div class="bg-brand-primary rounded-md p-2 text-white text-sm">
                                <span x-text="roleToAdd.name"></span>
                                <i @click="removeRoleFlag(roleToAdd)" class="bi bi-x-lg cursor-pointer"></i>
                            </div>
                        </template>
                    </div>
                </template>
                <div id="dropdownSearch" class="z-10 bg-white rounded-lg shadow-sm w-full">
                    <div class="p-3">
                        <label for="input-group-search" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input
                                type="text"
                                id="input-group-search"
                                class="outline-0 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                                placeholder="Buscar rol"
                                x-model="findRoleText"
                                @input="findRole()"
                            >
                        </div>
                    </div>
                    <div class="h-32 overflow-y-auto">
                        <template x-if="!isLoadingRoles">
                            <ul
                                @scroll.passive="($el.scrollHeight - $el.scrollTop <= $el.clientHeight + 2) && loadMoreRoles()"
                                class="h-28 px-3 pb-3 overflow-y-auto text-sm text-gray-700" aria-labelledby="dropdownSearchButton" >
                                <template x-for="role in roles">
                                    <li>
                                        <div class="flex items-center p-2 rounded-sm hover:bg-gray-100">
                                            <input :checked="rolesToAdd.find(roleToAdd => roleToAdd.id === role.id)" @change="addRoleToSave($event, role)" id="checkbox-item-11" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2">
                                            <label x-text="role.name" for="checkbox-item-11" class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm"></label>
                                        </div>
                                    </li>
                                </template>
                                <li>
                                    <template x-if="isLoadingMoreRoles">
                                        <x-loading-spin-component styles="h-5 w-5"/>
                                    </template>
                                </li>
                            </ul>
                        </template>
                        <template x-if="isLoadingRoles">
                            <x-loading-spin-component/>
                        </template>
                    </div>
                </div>
            </x-slot>
            <x-slot name="confirmButton">
                <button @click="confirmAddRoles()" class="bg-brand-primary p-2 text-white rounded-md">
                    Añadir
                </button>
            </x-slot>
        </x-modal-component>

        @if(session("error"))
            <div class="my-4">
                <span class="block p-2 bg-red-200 text-brand-alert font-extralight">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    {{session("error")}}
                </span>
            </div>
        @endif

        <div class="relative flex flex-col bg-white shadow-sm border border-slate-200 rounded-lg w-full">
            <div class="p-4">
                <div class="mb-4 flex items-center justify-between">
                    <h5 class="text-slate-800 text-lg font-semibold">
                        Lista de roles
                    </h5>
                    @canUse("$module.addRoles")
                        <button
                            @click="showModalRoles()"
                            class="cursor-pointer bg-brand-primary text-white p-2 rounded-md text-sm"
                        >
                            <i class="bi bi-person-fill-add text-md"></i>
                            Añadir
                        </button>
                    @else
                        <button
                            title="No tienes permiso"
                            class="cursor-not-allowed opacity-75 bg-brand-primary text-white p-2 rounded-md text-sm"
                        >
                            <i class="bi bi-person-fill-add text-md"></i>
                            Añadir
                        </button>
                    @endcanUse
                </div>
                <div class="divide-y divide-slate-200">
                    @foreach($roles as $role)
                        <div class="flex items-center justify-between pb-3 pt-3 last:pb-0">
                            <div class="flex items-center gap-x-3 text-gray-500">
                                <i class="bi bi-person-fill-gear text-3xl"></i>
                                <div>
                                    <h6 class="text-gray-800 font-semibold">
                                        {{$role->name}}
                                    </h6>
                                    <p class="text-gray-600 text-sm">
                                        {{$role->description}}
                                    </p>
                                </div>
                            </div>
                            <div class="flex gap-1">
                                <a href="{{route("roleManager.edit", $role->id)}}" class="mx-1 text-brand-primary">
                                    <i class="bi bi-pen text-lg"></i>
                                </a>
                                <form action="{{route("profile.removeRole", [$user->id, $role->id])}}" method="post">
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit" class=" cursor-pointer text-brand-alert">
                                        <i class="bi bi-trash text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
