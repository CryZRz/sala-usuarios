function createElementProgram(program, dataComputer){
    let container = document.createElement("li")
    container.className = "list-group-item d-flex justify-content-between align-items-star"

    let infoContainer = document.createElement("div")
    infoContainer.className = "ms-2 me-auto"
    let versionContainer = document.createElement("div")
    versionContainer.className = "fw-bold"
    versionContainer.textContent = `Nombre: ${program.name}`
    let version = document.createElement("span")
    version.textContent = `Version: ${program.version}`
    infoContainer.appendChild(versionContainer)
    infoContainer.appendChild(version)
    
    let inputCheck = document.createElement("input")
    inputCheck.setAttribute("type", "checkbox")
    
    container.appendChild(infoContainer)
    container.appendChild(inputCheck)

    inputCheck.addEventListener("change", e => {
        if(dataComputer.programs.includes(program.id)){
            dataComputer.programs = dataComputer.programs.filter(p => p != program.id)
        }else{
            dataComputer.programs.push(program.id)
        }
    })

    return container
}

function addButtonLoadPorgrams(node, callbackEvent){
    let buttonLoadPorgrams = document.createElement("button")
    buttonLoadPorgrams.textContent = "Cargar mas programas"
    buttonLoadPorgrams.className = "btn btn-dark col-12 mt-1 text-white"
    node.appendChild(buttonLoadPorgrams)

    buttonLoadPorgrams.addEventListener("click", callbackEvent)
}

function renderListPrograms(request, node, dataComputer){
    const {data: {data, links}} = request 
        console.log(links)
        data.map(p => {
            console.log(p)
            const programChild = createElementProgram(p, dataComputer)
            node.appendChild(programChild)
        })
}


export {renderListPrograms, addButtonLoadPorgrams, createElementProgram}