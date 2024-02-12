import { getCSRF } from "../utils/SCRF.js";

const listCounters = document.querySelectorAll("#timeAssigment")
const inputSessionExten = document.getElementById("idExtenSession")
let listCountersMaped = []
let intervalManager = null

listCounters.forEach(element => {
    const date = new Date(`1970-01-01T${element.textContent}`)
    const sessionId = element.getAttribute("sessionId")
    listCountersMaped.push({
        id: sessionId,
        time: {
            hours: date.getHours(),
            minutes: date.getMinutes(),
            seconds: date.getSeconds()
        }
    })
})

function removeListSessions(id) {
    const listFilter = listCountersMaped.filter(session => session.id != id)
    listCountersMaped = listFilter
}

function addBtnExtenseSession(id) {
    let button = document.createElement("button")
    button.textContent = "Extender tiempo"
    button.className = "btn btn-sm btn-warning text-white fw-bold"
    button.setAttribute("data-bs-toggle", "modal")
    button.setAttribute("data-bs-target", "#idOption")

    button.addEventListener("click", e => {
        inputSessionExten.value = id
    })

    listCounters.forEach(element => {
        if (element.getAttribute("sessionId") === id) {
            element.innerHTML = ""
            element.appendChild(button)
            colorFinished(element)
        }
    })
}

function colorFinished(element) {
    element.parentElement.classList.add("table-danger");
}

function changeTimeSession(time, id) {
    if (time.hours <= 0 && time.minutes <= 0) {
        removeListSessions(id)
        return addBtnExtenseSession(id)
    }
    let minutes = time.minutes - 1
    if (minutes < 0) {
        time.minutes = 59
        time.hours = time.hours - 1
        if (time.hours < 0) {
            time.hours = 0
        }
    } else {
        time.minutes = time.minutes - 1
    }
}

function reloadUI() {
    listCountersMaped.map(session => {
        listCounters.forEach(element => {
            if (session.id === element.getAttribute("sessionId")) {
                const time = session.time
                element.textContent = `${time.hours}:${time.minutes}:${time.seconds}`
            }
        })
    })
}

async function sendChangeTime() {
    try {
        const response = await axios.post("/sesion/tiempos",
            {
                listSessions: listCountersMaped
            },
            {
                headers: {
                    "X-CSRF-Token": getCSRF()
                }
            })
        console.log(response)
    } catch (e) {
        console.log(e)
    }
}

async function main() {
    if (listCountersMaped.length <= 0) {
        return clearInterval(intervalManager)
    }
    listCountersMaped.forEach(session => {
        changeTimeSession(session.time, session.id)
    })
    await sendChangeTime()
    reloadUI()
    console.log(listCountersMaped)
}

if (listCounters.length >= 0) {
    intervalManager = setInterval(main, 60000);
}

