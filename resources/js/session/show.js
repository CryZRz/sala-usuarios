import {getListComputersAvailable} from "../utils/computerU.js";

const listSessions = document.querySelectorAll(".botonReasignar")
const btnsEndSession = document.querySelectorAll(".botonFin")

function addListComputersAvailable(listComputers){
    const selectElementListComputersReAsign = document.getElementById("list-computers-re-using")
    selectElementListComputersReAsign.innerHTML = ""
    listComputers.map(computer => {
        const optionComputerElement = document.createElement("option")
        optionComputerElement.value = computer.computer_number
        optionComputerElement.innerText = computer.computer_number
        selectElementListComputersReAsign.append(optionComputerElement)
    })
}

listSessions.forEach(session => {
    const changeComputerInput = document.getElementById("change-computer-input")
    const messageAlertChangeComputer = document.getElementById("msgReasignarIndividual")

    session.addEventListener("click", async e => {
        changeComputerInput.value = session.getAttribute("sessionId")
        try {
            const listComputers = await getListComputersAvailable()
            if (listComputers.length > 0){
                addListComputersAvailable(listComputers)
            }else{
                messageAlertChangeComputer.innerText = "No hay computadoras disponibles"
            }
        }catch (e){
            console.log(e)
        }
    })
})

btnsEndSession.forEach(button => {
    button.addEventListener("click", e => {
        const inputEndSession = document.getElementById("inputEndSession")
        inputEndSession.setAttribute("value", button.getAttribute("sessionId"))
    })
})
