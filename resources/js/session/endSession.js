import ShowLoading from "../utils/showLoading.js";

const selectOptionFind = document.getElementById("opcionBuscar")
const findByControlNumberContainer = document.getElementById("busquedaNumControl")
const findByComputerNumberContainer = document.getElementById("busquedaNumEquipo")
const formEndSession = document.getElementById("formFinGeneral")
const loadingManager = new ShowLoading()

async function getListSessions(){
    try {
        const listSessionRequest = await axios.get("/cargarEquiposUso")
        return listSessionRequest.data
    }catch (e){
        throw e
    }
}

async function findByComputerNumber(){
    const selectElementListComputers = document.getElementById("selectEquiposFin")
    selectElementListComputers.innerText = ""
    formEndSession.action = "/session/terminar-num-euipo"
    try {
        const listComputers = await getListSessions()
        listComputers.map(computer => {
            const optionComputerElement = document.createElement("option")
            optionComputerElement.value = computer.computer_number
            optionComputerElement.text = computer.computer_number
            selectElementListComputers.appendChild(optionComputerElement)
        })
    }catch (e){
        throw e
    }
}

selectOptionFind.addEventListener("change", async e => {
    if (e.target.value === "1"){
        findByComputerNumberContainer.hidden = true
        findByControlNumberContainer.hidden = false
        formEndSession.action = "/session/terminar-num-control"
    }else{
        findByControlNumberContainer.hidden = true
        findByComputerNumberContainer.hidden = false
        loadingManager.setNode(findByComputerNumberContainer)
        loadingManager.setSmallLoading()
        try {
            loadingManager.onLoading()
            await findByComputerNumber()
            loadingManager.offLoading()
        }catch (e){
            loadingManager.offLoading()
            console.log(e)
        }
    }
})
