import {showError} from "../utils/showError.js";
import ShowLoading from "../utils/showLoading.js";

const listSessionCheck = document.querySelectorAll(".checkSesion")
const btnSendEndSessions = document.getElementById("btnTerminarMultiple")
const btnConfirmEndSessions = document.getElementById("btnEndSelectSessions")
const loadingContainer = document.getElementById("section-loading");

const loadingManager = new ShowLoading(loadingContainer)
loadingManager.setPageLoading()

let listSessionToRemove = []

async function sendEndSessions(){
    try {
        await axios.delete("/sesiones", {
            data: {
                listSessions: listSessionToRemove
            }
        })
    }catch (e){
        throw e
    }
}

listSessionCheck.forEach(session => {
    session.addEventListener("change", eventCheckSession => {
        const idSession = session.getAttribute("data-id-sesion")
        if (eventCheckSession.target.checked){
            listSessionToRemove.push(idSession)
        }else{
            listSessionToRemove = listSessionToRemove.filter(sessionToRm => sessionToRm !== idSession)
        }

        if (listSessionToRemove.length > 0){
            btnSendEndSessions.removeAttribute("disabled")
        }else{
            btnSendEndSessions.setAttribute("disabled", true)
        }
    })
})

btnConfirmEndSessions.addEventListener("click", async e => {
    e.preventDefault()
    if (listSessionToRemove.length > 0){
        try{
            loadingManager.onLoading()
            await sendEndSessions()
            loadingManager.offLoading()
            return location.reload()
        } catch (e){
            loadingManager.offLoading()
        }
    }

    showError("No hay sesiones seleccionadas")
})
