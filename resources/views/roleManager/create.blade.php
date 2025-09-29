@extends("layouts.mainLayout")

@section("title")
    Crear rol
@endsection

@section("module")
    Creacion de rol
@endsection

@section("content")
    <div class="w-full flex justify-center items-center" x-data="createRol()">

        <x-modal-component :id="'showModalConfirmDependencies'" title="Dependencia de permisos">
            <x-slot name="body">
                <div class="w-full">
                    <nav class="flex w-full flex-col gap-1 p-1.5">
                        <div>
                            <span class="text-sm text-gray-600 p-1">Los siguientes permisos se agregaran como dependencia</span>
                        </div>
                        <template x-for="dependency in dependenciesToConfirm">
                            <div
                                role="button"
                                class="text-slate-800 flex w-full items-center rounded-md p-3 mt-3 shadow transition-all hover:bg-slate-100 focus:bg-slate-100 active:bg-slate-100"
                            >
                                <div class="mr-4 grid place-items-center">
                                    <i class="bi bi-fingerprint text-3xl"></i>
                                </div>
                                <div>
                                    <h6 x-text="dependency.display_name" class="text-slate-800 font-medium text-sm">

                                    </h6>
                                    <p x-text="dependency.description" class="text-slate-500 text-xs">

                                    </p>
                                </div>
                            </div>
                        </template>
                    </nav>
                </div>
            </x-slot>
            <x-slot name="confirmButton">
                <button @click="confirmAddPermission()" class="cursor-pointer p-2 rounded-md text-white bg-brand-primary text-md">Aceptar</button>
            </x-slot>
        </x-modal-component>

        <div class="bg-white p-5 rounded-md mt-15 w-4/5">
            <div class="">
                <h3 class="font-bold text-gray-700">Creacion de rol</h3>
            </div>
            <div class="mt-10">
                <form action="{{route("roleManager.store")}}" method="post" x-ref="formCreateRol">
                    @csrf
                    <div>
                        <input name="permissions" type="hidden" x-ref="permissionsInput">
                    </div>
                    <div>
                        <label class="text-xs block text-gray-600 font-bold">Nombre</label>
                        <input name="name" x-model="name" class="w-full text-sm border p-1 border-gray-400 rounded-sm outline-0 mt-1" type="text" required>
                    </div>
                    <div class="mt-3">
                        <div class="relative w-full">
                            <label class="text-xs block text-gray-600 font-bold">Modulo</label>
                            <input @focus="showListModules = true"  @click.outside="showListModules = false"  @input="findModule()" id="find-period" class="w-full text-sm border p-1 border-gray-400 rounded-sm outline-0 mt-1" type="text" x-model="findModuleText">
                            <input name="" id="period-selected-id" type="hidden" :value="moduleSelected">
                            <template x-if="showListModules">
                                <div @scroll.passive="$el.scrollHeight - $el.scrollTop <= $el.clientHeight && loadMore()" id="periods-container" class="overflow-y-auto h-20 absolute top-full left-0 w-full border border-gray-400 bg-white rounded-sm z-50 group-focus-within:pointer-events-auto">
                                    <template x-if="!isLoadingModules">
                                        <template x-for="module in modules">
                                            <div @click="selectModule(module)" class="p-1 hover:bg-gray-200 cursor-pointer rounded-md text-sm">
                                                <span x-text="module.display_name"></span>
                                            </div>
                                        </template>
                                    </template>

                                    <template x-if="isLoadingMoreModules">
                                        <x-loading-spin-component styles="h-5 w-5 py-0.5"/>
                                    </template>

                                    <template x-if="isLoadingModules">
                                        <x-loading-spin-component/>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                    <div>
                        <template x-if="showListPermissions">
                            <template x-if="!isLoadingListPermissions">
                                <div class="relative flex flex-col my-6 bg-white shadow-sm border border-slate-200 rounded-lg w-full">
                                    <div class="p-4">
                                        <div class="mb-2 flex items-center justify-between">
                                            <h5 class="text-slate-800 text-sm font-semibold">
                                                Permisos
                                            </h5>
                                            <div>
                                                <input x-model="textFindPermission" @input="findPermission()" type="text" class="border border-gray-300 p-1 text-sm text-gray-600 rounded-md outline-0" placeholder="Buscar">
                                            </div>
                                        </div>
                                        <div
                                            @scroll.passive="($el.scrollHeight - $el.scrollTop <= $el.clientHeight + 1) && loadMorePermissions()"
                                             class="divide-y divide-slate-200 overflow-y-auto p-2 h-52">
                                            <template x-for="permission in permissions">
                                                <div class="flex items-center justify-between pb-3 pt-3 last:pb-0">
                                                    <div class="flex items-center gap-x-3">
                                                        <div>
                                                            <i class="bi bi-fingerprint text-3xl"></i>
                                                        </div>
                                                        <div>
                                                            <h6 x-text="permission.display_name" class="text-slate-800 text-sm font-semibold">

                                                            </h6>
                                                            <p x-text="permission.description" class="text-slate-600 text-xs">
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <input type="checkbox" class="cursor-pointer" @change="changeStatePermission($event,permission)" :checked="permissionsToAdd.includes(permission.id)">
                                                    </div>
                                                </div>
                                            </template>
                                            <template x-if="isLoadingMorePermissions">
                                                <x-loading-spin-component styles="h-6 w-6 mt-1"/>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <template x-if="isLoadingListPermissions">
                                <x-loading-spin-component/>
                            </template>
                        </template>
                    </div>
                    <div class="mt-3">
                        <label class="text-xs block text-gray-600 font-bold">Descripcion</label>
                        <textarea name="description" x-model="description" placeholder="Descripcion" class="mt-1 text-sm border border-gray-400 rounded-md p-1 outline-0 w-full"></textarea>
                    </div>
                    <div class="mt-5 flex justify-end w-full">
                        <button @click.prevent="sendRole()" class="cursor-pointer p-2 text-white bg-brand-primary rounded-md text-sm">Crear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
