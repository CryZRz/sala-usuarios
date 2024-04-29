import ShowLoading from "../utils/showLoading";

$(document).ready(function () {
    const pantallaCarga = document.getElementById("section-loading");
    const carga = new ShowLoading(pantallaCarga);
    const form = $("#form-importar");

    carga.setPageLoading();

    form.on('submit', function (event) {
        event.preventDefault();
        event.stopPropagation();
        if (form.get(0).checkValidity()) {
            carga.onLoading();
            form.unbind('submit').submit()
        }
    });
});
