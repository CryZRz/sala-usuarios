import axios from "axios";
import {showError} from "../utils/showError.js";
import {showToast} from "../utils/toastU.js";

document.addEventListener("alpine:init", () => {
    Alpine.data("createSession", () => ({
        controlNumberFind: "",
        isDisabled: true,
        formIncidence: null,
        studentData: {
            career: "",
            controlNumber: "",
            lastName: "",
            name: "",
            semester: 0,
        },

        computersAvaiable: [],
        textFindComputer: "",
        showListComputerChange: false,
        hoursSession: 0,
        minutesSession: 0,
        timeAssigment: "",

        nextPathComputer: null,
        hasMoreComputers: false,
        isLoadingMorePrograms: false,


        async init(){
            await this.getListComputersAvaiable()
        },

        async getListComputersAvaiable(){
            try {
                this.loadingFetchPrograms = true
                const response = await axios.get("/api/cargarEquipos")
                this.computersAvaiable = response.data.data

                this.nextPathComputer = response.data.next_page_url
                if (this.nextPathComputer !== null){
                    this.hasMoreComputers = true
                }

                this.loadingFetchPrograms = false
            }catch (e){
                this.loadingFetchPrograms = false
                showError("Error al consultar programas intenta mas tarde")
            }
        },

        async findStudent(event){
            event.preventDefault()
            try {
                const student = await axios.get(`/api/sesion/${this.controlNumberFind}`)
                this.studentData = student.data.data.student
                this.isDisabled = false
            }catch (e){
                this.studentData = {
                    career: "",
                    controlNumber: "",
                    lastName: "",
                    name: "",
                    semester: 0,
                }
                this.isDisabled = true
                if (e.response) {
                    // Error de respuesta del servidor (por ejemplo 404, 500, etc.)
                    const statusCode = e.response.status

                    if (statusCode === 422) {
                        return showError("El usuario no esta activo")
                    }

                    if (statusCode === 409) {
                        return showError("El estudiante tiene una sesion activa")
                    }
                    if (statusCode === 404){
                        return showToast(
                            "Alumno no regitrado\n Haz click para registrarlo"
                            , {
                                background: "#d1be4e",
                                color: "white"
                            },
                            {
                                onClick: () => {
                                    location.href = "/estudiante"
                                }
                            }).show()
                    }
                }
            }
        },

        async findComputerByNum(){
            try {
                this.loadingFetchPrograms = true
                const response = await axios.get(`/api/cargarEquipos?find=${this.textFindComputer}`)
                this.computersAvaiable = response.data.data

                this.nextPathComputer = response.data.next_page_url
                if (this.nextPathComputer !== null){
                    this.hasMoreComputers = true
                }

                this.loadingFetchPrograms = false
            }catch (e){
                this.loadingFetchPrograms = false
                showError("Error al consultar la computadora intenta mas tarde")
            }
        },

        selectComputerChange(computer){
            this.textFindComputer = computer.computer_number
        },

        async loadMore(){
            if(this.hasMoreComputers){
                try {
                    this.isLoadingMorePrograms = true

                    const response = await axios.get(this.nextPathComputer)
                    this.computersAvaiable = [...this.computersAvaiable, ...response.data.data]

                    this.nextPathComputer = response.data.next_page_url
                    if (this.nextPathComputer === null){
                        this.hasMoreComputers = false
                    }

                    this.isLoadingMorePrograms = false
                }catch (e){
                    showError("Error al consultar programas intenta mas tarde")
                }
            }
        },

        validateSession(event){
            event.preventDefault();

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
            // formato HH:MM:00
            this.timeAssigment = `${String(this.hoursSession).padStart(2, '0')}:${String(this.minutesSession).padStart(2, '0')}:00`;

            //Se supone que con un bind del input y this.timeAssigment deberia de funcionar pero llega null al backend lpmdr
            this.$refs.timeAssigmentInput.value = this.timeAssigment
            this.$refs.formNewSession.submit()
        }
    }))
})
