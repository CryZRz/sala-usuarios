import showLoading from "../utils/showLoading.js";
import {showError, showErrors} from "../utils/showError.js";

async function sendCreateProgram(name, version, node){
    const showLoadingManager = new showLoading(node)
    showLoadingManager.setPageLoading()
    try {
        showLoadingManager.onLoading()
        await axios.post("/programa", {
            name,
            version
        })
        showLoadingManager.offLoading()
        location.reload()
    }catch (e){
        showLoadingManager.offLoading()
        showErrors(e.response.data.errors.name)
    }
}

const programName = document.getElementById("program-name")
const programVersion = document.getElementById("program-version")
const btnAddProgram = document.getElementById("btn-create-program")
const nodeShowLoading = document.getElementById("section-loading")

btnAddProgram.addEventListener("click", e => {
    const programNameValue = programName.value
    const programVersionValue = programVersion.value
    if (programNameValue === "" || programVersionValue === ""){
        showError("Debes agregar el nombre del programa y la version")
    }else{
        sendCreateProgram(programNameValue, programVersionValue, nodeShowLoading)
    }
})
