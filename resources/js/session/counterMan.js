import axios from "axios";
import {showError} from "../utils/showError.js";

window.addEventListener("alpine:init", () => {
    Alpine.data("counterManager", (sessions) => ({
        modalExtendTime: false,
        modalEndSession: false,
        modalChangeComputer: false,
        loadingFetchPrograms: false,
        showListComputerChange: false,

        sessions: [],
        computersAvaiable: [],

        sessionEndId: 0,
        sessionChangeComputerId: 0,
        sessionChangeTime: 0,

        refModalChangeComp: null,

        textFindComputer: "",
        hoursSession: 0,
        minutesSession: 0,

        init(){
            this.sessions = sessions
        },

        async changeComputer(session){
            try {
                this.loadingFetchPrograms = true
                const response = await axios.get("/api/cargarEquipos")
                this.computersAvaiable = response.data.data
                this.modalChangeComputer = true
                this.sessionChangeComputerId = session.id
                this.loadingFetchPrograms = false
            }catch (e){
                this.loadingFetchPrograms = false
                console.log(e)
            }
        },

        async findComputerByNum(){
            try {
                this.loadingFetchPrograms = true
                const response = await axios.get(`/api/cargarEquipos?find=${this.textFindComputer}`)
                this.computersAvaiable = response.data.data
                this.loadingFetchPrograms = false
            }catch (e){
                this.loadingFetchPrograms = false
                console.log(e)
            }
        },

        selectComputerChange(computer){
            this.textFindComputer = computer.computer_number
        },

        confirmChangeComputer(event){
            event.preventDefault()
            if (this.sessionChangeComputerId !== 0){
                return this.$refs.refModalChangeComp.submit()
            }
            return showError("Error al seleccionar sesion")
        },

        endSession(session){
            this.modalEndSession = true
            this.sessionEndId = session.id
        },

        changeTime(session){
            this.modalExtendTime = true
            this.sessionChangeTime = session.id
        },

        confirmChangeTime(event){
            event.preventDefault()

            const h = Number(this.hoursSession);
            const m = Number(this.minutesSession);

            if (h < 0 || m < 0) {
                return showError("La duración no puede tener valores negativos.");
            }

            if (h === 0 && m === 0) {
                return showError("Debes añadir el tiempo.");
            }

            if (h > 5 || (h === 5 && m > 0)) {
                return showError("La sesión es máximo de 5 horas.");
            }

            if (m > 59) {
                return showError("Los minutos deben ser menores a 60.");
            }

            this.$refs.timeAssigment.value = `${String(this.hoursSession).padStart(2, '0')}:${String(this.minutesSession).padStart(2, '0')}:00`
            this.$refs.formChangeTime.submit()
        }
    }))
})
