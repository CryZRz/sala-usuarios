@extends("layouts.profileLayout")

@section("data")
    <div class="w-full bg-white rounded-md p-3" x-data="profileTokens()">
        <form method="POST">
            <a href="{{route("tokens.create")}}" class="bg-brand-secondary text-white rounded-md w-full p-0.5 cursor-pointer block text-center">
                Generar token
            </a>
            <div class="mt-2">
                <div class="my-3">
                    <span class="text-gray-500 text-md">Tus tokens</span>
                </div>
                <div>
                    <div class="relative flex flex-col rounded-lg bg-white shadow-sm border border-slate-200">
                        <nav class="flex min-w-[240px] flex-col gap-1 p-1.5">
                            <template x-for="token in tokens">
                                <div
                                    role="button"
                                    class="text-slate-800 flex w-full items-center rounded-md p-2 pl-3 transition-all"
                                >
                                    <input
                                        type="text"
                                        :value="token.name"
                                        placeholder="token"
                                        class="border border-gray-300 p-1 rounded-md w-full outline-0 cursor-not-allowed text-gray-400"
                                        readonly
                                    >
                                    <div class="ml-auto grid place-items-center justify-self-end">
                                        <button @click="removeToken(token)" class="cursor-pointer rounded-md border border-transparent p-2.5 text-center text-sm transition-all text-slate-600" type="button">
                                            <i class="bi bi-trash text-lg"></i>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </nav>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
