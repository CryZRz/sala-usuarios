import {showError} from "../utils/showError.js";
import ShowLoading from "../utils/showLoading.js";

const pantallaCarga = document.getElementById("section-loading");
const mensajeAlumno = document.getElementById("msgNumControl");
const controlNumberInput = document.getElementById("numControl");
const nameInput = document.getElementById("nombre");
const lastNameInput = document.getElementById("apellidos");
const semesterInput = document.getElementById("semestre");
const careerInput = document.getElementById("selectCarreras");
const btnFindStudent = document.getElementById("botonBuscar")
const inputsInfoStudent = document.querySelectorAll(".info-student")
const infoSessionContainer = document.getElementById("section-info-session")
const formSession = document.getElementById("formSesion")

const loadingManager = new ShowLoading(pantallaCarga)

async function getDataStudentForSession(controlNumber){
    try {
        const dataStudentRequest= await axios.get(`/sesion/${controlNumber}`)
        return dataStudentRequest.data.data
    }catch (e){
        throw e
    }
}

function changeDisableInputsInfoStudent(value){
    inputsInfoStudent.forEach(input => {
        input.disabled = value
    })
}

function clearDataInfoStudent(){
    inputsInfoStudent.forEach(input => {
        input.value = ""
    })
}

function fillDataStudent(dataStudent){
    nameInput.value = dataStudent.student.name
    lastNameInput.value = dataStudent.student.lastName
    semesterInput.value = dataStudent.semester
    careerInput.value = dataStudent.career
    changeDisableInputsInfoStudent(true)
}

function checkErrorsSubmit(){
    formSession.action = "/sesion-estudiante"
    infoSessionContainer.hidden = false
}

controlNumberInput.addEventListener("keypress", e => {
    if (e.key === "Enter"){
        main()
        e.preventDefault()
    }
})

btnFindStudent.addEventListener("click", e => {
    main()
    e.preventDefault()
})

window.addEventListener("load", _ => {
    if (typeof errors !== "undefined" ){
        return checkErrorsSubmit()
    }
})

async function main(){
    changeDisableInputsInfoStudent(false)
    infoSessionContainer.hidden = true
    mensajeAlumno.innerText= ""
    clearDataInfoStudent()
    loadingManager.setPageLoading()

    const controlNumber = controlNumberInput.value
    if (controlNumber.length <= 0){
        return showError("Debes ingresar el numero de control")
    }

    try {
        formSession.action = "/sesion"
        loadingManager.onLoading()
        const dataStudent = await getDataStudentForSession(controlNumber)
        infoSessionContainer.hidden = false
        fillDataStudent(dataStudent)
        loadingManager.offLoading()
    }catch (error){
        if (error.response){
            if (error.response.status === 409){
                showError(error.response.data.error)
                loadingManager.offLoading()
            }
            else if (error.response.status === 404){
                infoSessionContainer.hidden = false
                mensajeAlumno.innerText = "El alumno no está registrado; continúa manualmente."
                formSession.action = "/sesion-estudiante"
                loadingManager.offLoading()
            }
        }
    }
}
