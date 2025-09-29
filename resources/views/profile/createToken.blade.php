@extends("layouts.profileLayout")

@section("data")
    <div class="w-full" x-data="createToken()">

        <div>
            <template x-if="showToken">
                <div class="mb-6 w-full bg-white rounded-md p-3">
                    <span class="block text-red-500 mb-1">Alerta</span>
                    <span class="block text-red-400 text-sm">
                      Este token solo podrás verlo una vez.<br>
                      En caso de perderlo deberás generar uno nuevo.<br>
                      Por seguridad, <strong>no lo compartas con nadie</strong> ni lo publiques en ningún lugar.
                    </span>
                    <div
                        role="button"
                        class="text-slate-800 flex w-full items-center rounded-md transition-all"
                    >
                        <input
                            type="text"
                            :value="token"
                            placeholder="token"
                            class="border border-gray-300 p-1 rounded-md w-full outline-0 cursor-not-allowed text-gray-400 text-sm"
                            readonly
                        >
                        <div class="ml-auto grid place-items-center justify-self-end">
                            <button @click="copyToken()" class="cursor-pointer rounded-md border border-transparent p-2.5 text-center text-sm transition-all text-slate-600 " type="button">
                                <i class="bi bi-clipboard text-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <div class="bg-white w-full rounded-md px-4 py-2">
            <span class="text-gray-500 text-lg ">Crear token</span>
            <div class="mt-3">
                <form action="">
                    <input x-model="title" type="text" placeholder="Titulo" class="w-full rounded-md border border-gray-300 p-1 outline-0 text-gray-500">
                    <button @click="createToken($event)" class="mt-3 bg-brand-secondary w-full p-1 rounded-b-md text-white cursor-pointer">Generar token</button>
                </form>
            </div>
        </div>
    </div>
@endsection
