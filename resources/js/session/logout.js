import * as bootstrap from 'bootstrap'
import ShowLoading from "../utils/showLoading.js";

const btnLogout = document.getElementById("btnLogout")
const btnEndSessionsModal = document.getElementById("btn-end-modal")
const btnReAssignModal = document.getElementById("btn-reassign-modal")
const inputOptionLogout = document.getElementById("input-option-logout")
const loadingContainer = document.getElementById("section-loading")

const loadingManeger = new ShowLoading(loadingContainer)
loadingManeger.setPageLoading()

async function checkActiveSessionsUser(){
    try {
        return await axios.get("/sesiones/activas")
    }catch (e){
        throw e
    }
}

async function logoutWithOutSessions(){
    try {
        await axios.delete("/logout")
    }catch (e){
        throw e
    }
}

btnEndSessionsModal.addEventListener("click", e => {
    inputOptionLogout.value = 1
})

btnReAssignModal.addEventListener("click", e => {
    inputOptionLogout.value = 2
})

btnLogout.addEventListener("click", async e => {
    e.preventDefault()
    try {
        loadingManeger.onLoading()
        await checkActiveSessionsUser()
        const modalLogout = new bootstrap.Modal(document.getElementById("logoutModal"))
        loadingManeger.offLoading()
        modalLogout.show()
    }catch (e){
        if (e.response.status === 404){
            await logoutWithOutSessions();
            loadingManeger.offLoading()
            location.reload()
        }

        loadingManeger.onLoading()
    }
})
