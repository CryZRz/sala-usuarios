<div>
    @vite(["resources/js/computer/createProgram.js"])
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        Agregar programa
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class="mb-3">
                            <label for="" class="form-label">Nombre</label>
                            <input
                                id="program-name"
                                type="text"
                                name=""
                                class="col-12"
                                placeholder="Nombre del programa"
                                required
                            >
                        </div>
                        <div class="mb-3">
                            <label for="">Version</label>
                            <input
                                id="program-version"
                                type="text"
                                name=""
                                class="col-12 p-1"
                                placeholder="Version del programa"
                                required
                            >
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cerrar
                    </button>
                    <button type="button" class="btn btn-primary" id="btn-create-program">
                        Crear
                    </button>
                </div>
            </div>
        </div>
    </div>

    <button class="btn btn-warning text-white col-12" data-bs-toggle="modal" data-bs-target="#exampleModal">Agregar programa</button>
</div>
