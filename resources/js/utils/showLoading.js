import '../../scss/utils/loadingPage.scss'
import 'animate.css'

class ShowLoading {

    constructor(node = null){
        this.node = node
        this.nodeStyle
    }

    setSmallLoading(){
        let conatiner = document.createElement("div")
        conatiner.className = "spinner-border"
        conatiner.role = "status"
        let child = document.createElement("span")
        child.className = "sr-only"
        conatiner.appendChild(child)

        this.nodeStyle = conatiner
    }

    setPageLoading(){
        let mainContainer = document.createElement("section")
        mainContainer.className = "loading-container"

        let infoContainer = document.createElement("div")
        infoContainer.className = "animate__animated animate__flash"

        let imgLoading = document.createElement("img")
        imgLoading.className = "img-loading"
        imgLoading.src = "/images/tecnmLGW.png"
        imgLoading.alt = "tecnm-logo"

        let messageLoding = document.createElement("h1")
        messageLoding.className = "title"
        messageLoding.textContent = "Cargando"

        infoContainer.appendChild(imgLoading)
        infoContainer.appendChild(messageLoding)
        mainContainer.appendChild(infoContainer)

        this.nodeStyle = mainContainer
    }

    setNode(node){
        this.node = node
    }

    onLoading(){
        this.node.appendChild(this.nodeStyle)
    }

    offLoading(){
        this.node.removeChild(this.nodeStyle)
    }
}

export default ShowLoading
