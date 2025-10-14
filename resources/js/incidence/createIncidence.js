import axios from "axios";
import {showError} from "../utils/showError.js";
import {showToast} from "../utils/toastU.js";

document.addEventListener("alpine:init", () => {
    Alpine.data("createIncidence", () => ({
        controlNumberFind: "",
        isDisabled: true,
        description: "",
        formIncidence: null,
        studentData: {
            career: "",
            controlNumber: "",
            lastName: "",
            name: "",
            semester: 0,
        },

        init(){

        },

        async findStudent(event){
            event.preventDefault()
            try {
                const student = await axios.get(`/estudiante/${this.controlNumberFind}`)
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

                if (e.status === 404){
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
        },

        sendIncidence(event){
            event.preventDefault()
            if (this.studentData.controlNumber !== this.controlNumberFind){
                return showError("Los numeros de control no coinciden")
            }
            if (this.isDisabled){
                return showError("Debes haber un estudiante valido")
            }
            if (this.description === ""){
                return showError("Debes agregar una descripcion")
            }

            this.$refs.formIncidence.submit()
        }
    }))
})
