import axios from "axios";
import { addPortComputer } from "./addPort";
import {showErrors} from "../utils/showError";
import {fetchMorePrograms} from "./fetchMorePrograms";
import { addButtonLoadPorgrams, renderListPrograms } from "./program";
import ShowLoading from "../utils/showLoading";

const programsSection = document.getElementById("programs-section")
const inputName = document.getElementById("input-name")
const inputRam = document.getElementById("input-ram")
const inputComputerNumber = document.getElementById("input-computer-number")
const btnSendDataComputer = document.getElementById("btn-send")
const btnShowMore = document.getElementById("btn-show-more")
const csrfToken = document.querySelector('[name="csrf-token"]')
const loadingPageContainer = document.getElementById("section-loading")

let dataComputer = {
    ram: 0,
    name: "",
    computerNumber: 0,
    ports: [],
    programs: []
}
let indexListPrograms = 1

addPortComputer(dataComputer)

async function sendDataComputer(){
    const loading = new ShowLoading(loadingPageContainer)
    loading.setPageLoading()
    try {
        loading.onLoading()
        const data = await axios.post("/equipo", {
            dataComputer,
            Headers: {"X-CSRF-Token": csrfToken.content}
        })
        loading.offLoading()
        history.back()
    } catch (e) {
        loading.offLoading()
        const listErrors = Object.values(e.response.data.errors)
        showErrors(listErrors)
    }
}

async function getMorePrograms(e){
    e.preventDefault()
    const loading = new ShowLoading(programsSection)
    loading.setSmallLoading()

    try {
        loading.onLoading()
        const response = await fetchMorePrograms(++indexListPrograms)
        renderListPrograms(response, programsSection, programsSection)
        if(response.data.next_page_url == null){
            btnShowMore.innerHTML = ""
        }
        loading.offLoading()
    } catch (e) {
        loading.offLoading()
    }
}

async function showListPrograms(){
    const loading = new ShowLoading(programsSection)
    loading.setSmallLoading()
    try {
        loading.onLoading()
        const listPrograms = await fetchMorePrograms(indexListPrograms)
        renderListPrograms(listPrograms, programsSection, dataComputer)

        if(listPrograms.data.next_page_url != null){
            addButtonLoadPorgrams(
                btnShowMore,
                getMorePrograms
            )
        }
        loading.offLoading()
    } catch (e) {
        loading.offLoading()
    }
}


inputName.addEventListener("change", e => {
    dataComputer.name = e.target.value
})

inputRam.addEventListener("change", e => {
    dataComputer.ram = e.target.value
})

inputComputerNumber.addEventListener("change", e => {
    dataComputer.computerNumber = e.target.value
})

btnSendDataComputer.addEventListener("click", e => {
    e.preventDefault()
    sendDataComputer()
})

showListPrograms()
