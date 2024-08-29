const listCounters = document.querySelectorAll("#timeAssigment")
const inputSessionExten = document.getElementById("idExtenSession")
let listCountersMaped = []
let intervalManager = null

listCounters.forEach(element => {
    const date = new Date(`1970-01-01T${element.textContent.trim()}`)
    const sessionId = element.getAttribute("sessionId")
    if (date.getMinutes() <= 0 && date.getHours() <= 0 && date.getMinutes() <= 0){
        addBtnExtenseSession(sessionId)
    }else{
        listCountersMaped.push({
            id: sessionId,
            time: {
                hours: date.getHours(),
                minutes: date.getMinutes(),
                seconds: date.getSeconds()
            },
            timeFormat: {
                hours: date.getHours().toString(),
                minutes: date.getMinutes().toString(),
                seconds: date.getSeconds().toString()
            }
        })
    }
})

function removeListSessions(id) {
    listCountersMaped = listCountersMaped.filter(session => session.id !== id)
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

function checkFormat(timeFormat, time){
    timeFormat.hours = time.hours.toString()
    timeFormat.minutes = time.minutes.toString()
    timeFormat.seconds = time.seconds.toString()

    if (timeFormat.minutes.length <= 1){
        timeFormat.minutes = `0${time.minutes}`
    }
    if (timeFormat.hours.length <= 1){
        timeFormat.hours = `0${time.hours}`
    }
    if (timeFormat.seconds.length <= 1){
        timeFormat.seconds = `0${time.seconds}`
    }
}

function changeTimeSession(time, id, timeFormat) {
    if (time.hours <= 0 && time.minutes <= 0) {
        removeListSessions(id)
        return addBtnExtenseSession(id)
    }
    let minutes = time.minutes - 1
    if (time.hours === 0 && time.minutes === 1){
        time.seconds= 59
    }
    if (minutes < 0) {
        time.minutes = 59
        time.hours = time.hours - 1
        if (time.hours < 0) {
            time.hours = 0
        }
    } else {
        time.minutes = time.minutes - 1
    }

    checkFormat(timeFormat, time)
}

function reloadUI() {
    listCountersMaped.map(session => {
        listCounters.forEach(element => {
            if (session.id === element.getAttribute("sessionId")) {
                const time = session.timeFormat
                element.textContent = `${time.hours}:${time.minutes}:${time.seconds}`
            }
        })
    })
}

async function main() {
    if (listCountersMaped.length <= 0) {
        return clearInterval(intervalManager)
    }
    listCountersMaped.forEach(session => {
        changeTimeSession(session.time, session.id, session.timeFormat)
    })
    reloadUI()
}

if (listCounters.length >= 0) {
    intervalManager = setInterval(main, 60000);
}
