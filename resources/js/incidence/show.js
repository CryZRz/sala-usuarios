const listBtnsEndIncidences = document.querySelectorAll(".btn-end-incidence")
const formEndIncidence = document.getElementById("formEndIncidence")

listBtnsEndIncidences.forEach(button => {
    button.addEventListener("click", e => {
        const idIncidence =  button.getAttribute("id-incidence")
        if (idIncidence !== null){
            formEndIncidence.action = `incidencia/${idIncidence}`
        }

    })
})
