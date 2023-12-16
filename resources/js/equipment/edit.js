import axios from "axios"
import { addPortComputer } from "./addPort"

let dataComputer = {
    ram: 0,
    name: "",
    ports: [],
    programs: []
}

addPortComputer(dataComputer)

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
const listPorgramsComputer = document.querySelectorAll("#li-program-computer")
const listPortsComputerEditable = document.getElementById("list-ports-editable")

async function sendDataComputer(){
    try {
        const data = await axios.post(`/equipo/${idComputer}`, {
            dataComputer,
            Headers: {"X-CSRF-Token": csrfToken.content}
        })
        console.log(data)
    } catch (e) {
        console.log(e)
    }
}

window.addEventListener("load", e => {
    dataComputer.name = inputName.value
    dataComputer.ram = inputRam.value
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
    try {
        const deleteProgram = await axios.delete(`/equipo-programa/${id}`)
        removeProgramsUI(id)
    } catch (e) {
        console.log(e);
    }
}

async function sendEditPort(id, data){
    try {
        const editPort = await axios.post(`/equipo-puerto/${id}`, data)
    } catch (e) {
        console.log(e);
    }
}

function removePortUI(idPort){
    const ports = Array.from(listLiPorts).filter(p => p.getAttribute("port") != idPort)
    listPortsComputerEditable.replaceChildren(...ports)
}

async function removePort(id){
    try {
        const deleteProgram = await axios.delete(`/equipo-puerto/${id}`)
        removePortUI(id)
    } catch (e) {
        console.log(e);
    }
}

function removeProgramsUI(programRemoveId){
    const programs = Array.from(listPorgramsComputer).filter(p => p.getAttribute("program") != programRemoveId)
    
    containerPorgramsComputer.replaceChildren(...programs)
}

btnsRemoveProgram.forEach(b => {
    b.addEventListener("change", e => {
        if (confirm("Estas seguro de remover el programa de esta computadora")) {
            return removePorgram(b.getAttribute("program"))
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
        const portEdit = Array.from(listLiPorts).filter(p => p.getAttribute("port") === idPort)

        const portType = portEdit[0].querySelector("#port-type-editable")
        const portAmount = portEdit[0].querySelector("#port-ammount-editable")
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