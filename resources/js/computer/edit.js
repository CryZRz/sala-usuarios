import axios from "axios"
import { addPortComputer } from "./addPort"
import { fetchMorePogramsAvailable } from "./fetchMorePrograms"
import { addButtonLoadPorgrams, renderListPrograms } from "./program"
import ShowLoading from "../utils/showLoading"
import { showMessage } from "../utils/showMessages"
import {showErrors} from "../utils/showError.js";

let dataComputer = {
    ram: 0,
    name: "",
    ports: [],
    programs: []
}
let indexPageProgramsAvailable = 1

const inputName = document.getElementById("input-name")
const inputRam = document.getElementById("input-ram")
const btnsRemoveProgram = document.querySelectorAll("#btn-remove-program")
const btnsRemovePortEditable = document.querySelectorAll("#btn-remove-port-editable")
const btnsAddNewPrograms = document.querySelectorAll("#btn-add-program")
const btnSendEdit = document.getElementById("btn-send")
const csrfToken = document.querySelector('[name="csrf-token"]')
const btnsEditPortEditable = document.querySelectorAll("#btn-edit-port-editable")
const listLiPorts = document.querySelectorAll("#li-port-editable")
const containerPorgramsComputer = document.getElementById("section-programs-computer")
const listPortsComputerEditable = document.getElementById("list-ports-editable")
const listProgramsAvailable = document.getElementById("list-programs-available")
const btnShowMorePrograms = document.getElementById("btn-show-more")
const loadingPageContainer = document.getElementById("section-loading")

async function sendDataComputer(){
    const loading = new ShowLoading(loadingPageContainer)
    loading.setPageLoading()
    try {
        loading.onLoading()
        await axios.post(`/equipo/${idComputer}`, {
            dataComputer,
            Headers: {"X-CSRF-Token": csrfToken.content}
        })
        loading.offLoading()
        window.location.reload()
    } catch (e) {
        loading.offLoading()
        const listErrors = Object.values(e.response.data.errors)
        showErrors(listErrors)
        console.log(e)
    }
}

async function programAviableCallback(e){
    e.preventDefault()
    const loading = new ShowLoading(listProgramsAvailable)
    loading.setSmallLoading()
    loading.onLoading()

    try {
        const response = await fetchMorePogramsAvailable(++indexPageProgramsAvailable, idComputer)
        renderListPrograms(response, listProgramsAvailable, dataComputer)
        if(response.data.next_page_url == null){
            btnShowMorePrograms.innerHTML = ""
        }
        loading.offLoading()
    } catch (e) {
        loading.offLoading()
        console.log(e)
    }
}

async function getListPorgramsAviable(){
    const loading = new ShowLoading(listProgramsAvailable)
    loading.setSmallLoading()

    try {
        loading.onLoading()
        const listPrograms = await fetchMorePogramsAvailable(indexPageProgramsAvailable, idComputer)
        renderListPrograms(listPrograms, listProgramsAvailable, dataComputer)

        if(listPrograms.data.next_page_url != null){
            addButtonLoadPorgrams(
                btnShowMorePrograms,
                programAviableCallback,
            )
        }
        loading.offLoading()
    } catch (e) {
        loading.offLoading()
        console.log(e)
    }
}

window.addEventListener("load", e => {
    dataComputer.name = inputName.value
    dataComputer.ram = inputRam.value
    getListPorgramsAviable()
    addPortComputer(dataComputer)
})

btnsAddNewPrograms.forEach(b => {
    b.addEventListener("change", e => {
        const id = b.getAttribute("program")
        if(dataComputer.programs.includes(id)){
            dataComputer.programs = dataComputer.programs.filter(p => p != id)
        }else{
            dataComputer.programs.push(id)
        }
    })
})


async function removePorgram(id){
    const loading = new ShowLoading(loadingPageContainer)
    loading.setPageLoading()
    try {
        loading.onLoading()
        await axios.delete(`/equipo-programa/${id}`)
        removeProgramsUI(id)
        loading.offLoading()
        showMessage("Programa eliminado correctamente", "green", "white")
    } catch (e) {
        loading.offLoading()
        console.log(e);
    }
}

async function sendEditPort(id, data){
    const loading = new ShowLoading(loadingPageContainer)
    loading.setPageLoading()
    try {
        loading.onLoading()
        await axios.post(`/equipo-puerto/${id}`, data)
        loading.offLoading()
        showMessage("Puerto editado correctamente", "green", "white")
    } catch (e) {
        loading.offLoading()
        console.log(e);
    }
}

function removePortUI(idPort){
    const ports = Array.from(listLiPorts).filter(p => p.getAttribute("port") != idPort)
    listPortsComputerEditable.replaceChildren(...ports)
}

async function removePort(id){
    const loading = new ShowLoading(loadingPageContainer)
    loading.setPageLoading()
    try {
        loading.onLoading()
        await axios.delete(`/equipo-puerto/${id}`)
        removePortUI(id)
        loading.offLoading()
        showMessage("Puerto eliminado correctamente", "green", "white")
    } catch (e) {
        loading.offLoading()
        console.log(e);
    }
}


function removeProgramsUI(programRemoveId){
    const listPorgramsComputer = document.querySelectorAll("#li-program-computer")
    const programs = Array.from(listPorgramsComputer).filter(p => p.getAttribute("program") != programRemoveId)

    containerPorgramsComputer.replaceChildren(...programs)
}

btnsRemoveProgram.forEach(b => {
    b.addEventListener("change", e => {
        if (confirm("Estas seguro de remover el programa de esta computadora")) {
            removePorgram(b.getAttribute("program"))
        }
    })
})

btnsRemovePortEditable.forEach(b => {
    b.addEventListener("click", e => {
        e.preventDefault()
        if (confirm("Estas seguro de remover el puerto de esta computadora")) {
            removePort(b.getAttribute("port"))
        }
    })
})

btnsEditPortEditable.forEach(b => {
    b.addEventListener("click", e => {
        e.preventDefault()
        const idPort = b.getAttribute("port")
        const portEdit = Array.from(listLiPorts).find(p => p.getAttribute("port") === idPort)

        const portType = portEdit.querySelector("#port-type-editable")
        const portAmount = portEdit.querySelector("#port-ammount-editable")
        const data= {
            "type": portType.value,
            "amount": portAmount.value
        }
        sendEditPort(idPort, data)
    })
})

btnSendEdit.addEventListener("click", e => {
    e.preventDefault()
    sendDataComputer()
})

inputName.addEventListener("change", e => {
    dataComputer.name = e.target.value
    console.log(dataComputer)
})

inputRam.addEventListener("change", e => {
    dataComputer.ram = e.target.value
    console.log(dataComputer)
})
