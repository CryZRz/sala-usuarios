<div x-data
     x-show="$store.loader.active"
     class="w-screen h-screen fixed bg-[rgba(0,0,0,0.5)] z-50  flex justify-center items-center">
    <div class="animate__animated animate__flash animate__infinite">
        <div>
            <img class="w-64 opacity-75" src="/images/logoITL2.png" alt="logo itl">
        </div>
        <div class="text-center mt-1">
            <h1 class="text-white text-4xl">Cargando...</h1>
        </div>
    </div>
</div>
