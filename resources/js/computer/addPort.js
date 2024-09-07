export function addPortComputer(dataComputer){
    const btnAddPort = document.getElementById("btn-add-port")
    const sectionListPorts = document.getElementById("list-prots")

    let counterPorts = 1
    let listPortsAdd = []

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
        inputType.className = "col-lg-5 col-12 p-1 mb-2"

        let inputAmount = document.createElement("input")
        inputAmount.setAttribute("type", "number")
        inputAmount.setAttribute("placeholder", "Cantidad")
        inputAmount.className = "col-lg-5 col-12 p-1 mb-2"

        let btnRemove = document.createElement("button");
        btnRemove.textContent = "Eliminar"
        btnRemove.setAttribute("id", `${counterPorts}`)
        btnRemove.setAttribute("class", "btn btn-danger p-1 col-lg-1 col-12 mb-2")

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
}
