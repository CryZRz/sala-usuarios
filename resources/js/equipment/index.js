import axios from "axios";

const sectionListPorts = document.getElementById("list-prots")
const btnAddPort = document.getElementById("btn-add-port")
const programsSection = document.getElementById("programs-section")
const inputName = document.getElementById("input-name")
const inputRam = document.getElementById("input-ram")
const btnSendDataComputer = document.getElementById("btn-send")
const csrfToken = document.querySelector('[name="csrf-token"]')

let dataComputer = {
    ram: 0,
    name: "",
    ports: [],
    programs: []
}

let listPorgramsAdd = []
let counterPorts = 1
let listPortsAdd = []

async function sendDataComputer(){
    try {
        const data = await axios.post("/equipo", {
            dataComputer,
            Headers: {"X-CSRF-Token": csrfToken.content}
        })
        console.log(data)
    } catch (e) {
        console.log(e)
    }
}

function removeNodePort(id){
    const elementsPorts = [...document.getElementsByClassName("liPort")]

    const elementsFilter = elementsPorts.filter(e => {
        const idElement = e.getAttribute("port") 
        return idElement != id
    })
    listPortsAdd = listPortsAdd.filter(p => p.id != id)
    dataComputer.ports = listPortsAdd

    sectionListPorts.replaceChildren(...elementsFilter)
}

function setDataPorts(id, name, data){
    listPortsAdd = listPortsAdd.map(p => {
        if (p.id == id) {
            p[name] = data
        }

        return p
    })
    dataComputer.ports = listPortsAdd
}

function createNodePort(){
    let child = document.createElement("div")
    child.setAttribute("id", `prot-${counterPorts}`)
    child.setAttribute("class", "liPort")
    child.setAttribute("port", `${counterPorts}`)
    let inputType = document.createElement("input")
    inputType.setAttribute("type", "text")
    inputType.setAttribute("placeholder", "Tipo de puerto (USB, HDMI)")

    let inputAmount = document.createElement("input")
    inputAmount.setAttribute("type", "number")
    inputAmount.setAttribute("placeholder", "Cantidad")

    let btnRemove = document.createElement("button");
    btnRemove.textContent = "Eliminar"
    btnRemove.setAttribute("id", `${counterPorts}`)

    btnRemove.addEventListener("click", e => {
        e.preventDefault()
        removeNodePort(e.target.id)
    })
    inputType.addEventListener("change", e => {
        const id = child.getAttribute("port")
        setDataPorts(id, "name", e.target.value)
    })
    inputAmount.addEventListener("change", e => {
        const id = child.getAttribute("port")
        setDataPorts(id, "amount", e.target.value)
    })

    child.appendChild(inputType)
    child.appendChild(inputAmount)
    child.appendChild(btnRemove)

    listPortsAdd.push({
        id: counterPorts,
        name: "",
        amount: ""
    })

    return child
}

btnAddPort.addEventListener("click", e => {
    e.preventDefault()
    const child = createNodePort()
    sectionListPorts.appendChild(child)
    counterPorts++
})

async function getListPorgrams(){
    try {
        const fetchListPrograms = await axios.get("/api/programas")
        return fetchListPrograms
    } catch (e) {
        throw new Error(e)
    }
}

function createElementProgram(program){
    let container = document.createElement("div")
    let name = document.createElement("h3")
    name.textContent = `Nombre: ${program.name}`
    let version = document.createElement("span")
    version.textContent = `Version: ${program.version}`
    let inputCheck = document.createElement("input")
    inputCheck.setAttribute("type", "checkbox")
    container.appendChild(name)
    container.appendChild(version)
    container.appendChild(inputCheck)

    inputCheck.addEventListener("change", e => {
        if(listPorgramsAdd.includes(program.id)){
             listPorgramsAdd = listPorgramsAdd.filter(p => p != program.id)
        }else{
            listPorgramsAdd.push(program.id)
        }
        
        dataComputer.programs = listPorgramsAdd
    })

    return container
}

async function renderListPrograms(){
    try {
        const {data: {data, links}} = await getListPorgrams()
        console.log(links)
        data.map(p => {
            console.log(p)
            const programChild = createElementProgram(p)
            programsSection.appendChild(programChild)
        })
    } catch (e) {
        alert(e)
    }
}

renderListPrograms()

inputName.addEventListener("change", e => {
    dataComputer.name = e.target.value
    console.log(dataComputer)
})

inputRam.addEventListener("change", e => {
    dataComputer.ram = e.target.value
    console.log(dataComputer)
})

btnSendDataComputer.addEventListener("click", e => {
    e.preventDefault()
    sendDataComputer()
})