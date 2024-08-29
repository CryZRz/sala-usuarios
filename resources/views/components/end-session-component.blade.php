<div class="modal fade" id="modalTerminar" tabindex="-1">
    @vite(['resources/js/session/endSession.js'])
    <form id="formFinGeneral" method="POST" action="{{route("session.destroy.num.control")}}">
        @csrf
        @method('delete')
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title titulo">Terminar sesión</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center text-sm-end mx-3 mx-sm-5">
                        <div class="row align-items-center mb-2">
                            <div class="col">
                                <label for="opcionBuscar" class="form-label fw-bold">¿Cómo quieres ubicar la
                                    sesión?</label>
                            </div>
                            <div class="col">
                                <select class="form-select" name="opcionBuscar" id="opcionBuscar" required>
                                    <option value="1" required selected>Núm. de control</option>
                                    <option value="2" required>Núm. de equipo</option>
                                </select>
                            </div>
                        </div>
                        <div id="busquedaNumControl" class="row align-items-center mb-2">
                            <div class="col">
                                <label for="numControl" class="form-label fw-bold">Número de control del
                                    alumno</label>
                            </div>
                            <div class="col">
                                <input type="input" class="form-control" id="numControlFin"
                                       placeholder="Núm. control" name="controlNumber" autocomplete="off">
                            </div>
                        </div>
                        <div id="busquedaNumEquipo" class="row align-items-center" hidden>
                            <div class="col">
                                <label for="numEquipo" class="form-label fw-bold">Número de equipo</label>
                            </div>
                            <div class="col">
                                <select class="form-select" name="computerNumber" id="selectEquiposFin">
                                </select>
                            </div>
                        </div>
                        <p id="msgFinGeneral" class="text-danger text-center mt-2 mb-0"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btnFinGeneral" type="submit" class="btn btn-turquesa">Finalizar la
                        sesión</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Regresar</button>
                </div>
            </div>
        </div>
    </form>
</div>
