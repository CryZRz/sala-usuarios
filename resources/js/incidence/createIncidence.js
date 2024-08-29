import {showError} from "../utils/showError.js";
import {getInfoStudent} from "../utils/studentU.js";
import ShowLoading from "../utils/showLoading.js";

const inputControlNumber = document.getElementById("control-number")
const btnFindStudent = document.getElementById("btn-find-student")

const loadingContainer = document.getElementById("loading-container")
const inputsInfoStudent = document.querySelectorAll(".input-info")
const nameStudentInput = document.getElementById("name-student-input")
const lastNameStudentInput = document.getElementById("last-name-student-input")
const careerStudentInput = document.getElementById("career-student-input")
const semesterStudentInput = document.getElementById("semester-student-input")
const descriptionStudentInput = document.getElementById("description-student-input")
const formCreateIncidence = document.getElementById("form-create-incidence")
const inputControlNumberHidden = document.getElementById("control-number-hidden")

const loadingManager = new ShowLoading(loadingContainer)
loadingManager.setPageLoading()

function clearInputsStudent(){
    inputsInfoStudent.forEach(input => {
        input.value = ""
    })
}

function fillDataInputs(data){
    nameStudentInput.value = data.student.name
    lastNameStudentInput.value = data.student.lastName
    careerStudentInput.value = data.career
    semesterStudentInput.value = data.semester
}

btnFindStudent.addEventListener("click", async _ =>{
    await main()
})

inputControlNumber.addEventListener("keypress", async e => {
    if (e.key === "Enter"){
        await main()
    }
})

formCreateIncidence.addEventListener("submit", e => {
    let err = false
    inputsInfoStudent.forEach(input => {
        if (input.value.length <= 0){
            err = true
        }
    })
    if (err){
        e.preventDefault()
        return showError("Debes rellenar todos los campos")
    }
})

async function main(){
    clearInputsStudent()
    descriptionStudentInput.disabled = true
    const controlNumber = inputControlNumber.value

    if (controlNumber.length <= 0){
        return showError("Debes ingresar el numero de control")
    }

    try {
        loadingManager.onLoading()
        const dataStudent = await getInfoStudent(controlNumber)
        fillDataInputs(dataStudent)
        inputControlNumberHidden.value = controlNumber
        descriptionStudentInput.disabled = false
        loadingManager.offLoading()
    }catch (e){
        inputControlNumberHidden.value = ""
        loadingManager.offLoading()
    }
}
