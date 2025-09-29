import axios from "axios";
import {showError} from "../utils/showError.js";
import {isNumber, uid} from "chart.js/helpers";

document.addEventListener("alpine:init", () => {
    Alpine.data("createComputer", () => ({
        ports: [],
        programs: [],
        programsToAdd: [],
        programsSelectToAdd: [],
        hasMore: false,
        nextPath: "",
        isGettingMore: false,
        isLoadingPrograms: false,

        //arrays temporales de busqueda
        portsFind: [],
        programsFind: [],

        createPortModal: false,
        editPortModal: false,
        addProgram: false,
        textFindPort: "",
        textFindProgram: "",
        textFindProgramToAdd: "",

        ram: "",
        cpu: "",
        computerNumber: "",

        createPort: {
            amount: 0,
            id: 0,
            type: "",
        },
        portEdit: {
            amount: 0,
            id: 0,
            type: "",
        },

        async init(){
            this.$watch('addProgram', async () => {
                if(this.addProgram && this.programsToAdd.length <= 0){
                    try {
                        this.programsToAdd = await this.fetchProgramsToAdd()
                    }catch (e){
                        showError("Error al obtener programas")
                    }
                }
                this.fillProgramsToAdd()
            })
        },

        async fetchProgramsToAdd(){
            try {
                this.isLoadingPrograms = true
                const response = await axios.get(`/api/programas`)

                this.nextPath = response.data.next_page_url

                if (this.nextPath != null){
                    this.hasMore = true;
                }

                this.isLoadingPrograms = false;
                return response.data.data
            }catch (e){
                throw e
            }
        },

        fillProgramsToAdd(){
          this.programsSelectToAdd = [...this.programs]
        },

         savePort(){

             if (this.createPort.type === "" || this.createPort.amount <= 0){
                return showError("Debes rellenar los campos")
            }
             if (!isNumber(this.portEdit.amount) ){
                 return showError("La cantidad debe ser numerica")
             }

             this.ports.push({
                 id: uid(),
                 type: this.createPort.type,
                 amount: this.createPort.amount,
             })
             this.createPort.type = ""
             this.createPort.amount = 0
             this.createPortModal = false

            this.portsFind = [...this.ports]
         },

        confirmEditPort(){
            if (this.portEdit.amount <= 0 || this.portEdit.type === ""){
                return showError("Debes rellenar los campos")
            }
            if (!isNumber(this.portEdit.amount) ){
                return showError("La cantidad debe ser numerica")
            }

            this.ports = this.ports.map(port => {
                if (port.id === this.portEdit.id){
                    return this.portEdit
                }
                return port
            })

            this.editPortModal = false
            this.portsFind = [...this.ports]
        },

        findPort(){
            if (this.textFindPort.trim() === ""){
                this.ports = this.portsFind
            }else{
                this.ports = this.portsFind.filter(port => port.type.toLowerCase().includes(this.textFindPort.toLocaleLowerCase()))
            }
        },

        findProgram(){
            if (this.textFindProgram.trim() === ""){
                this.programs = this.programsFind
            }else{
                this.programs = this.programsFind.filter(program => program.name.toLowerCase().includes(this.textFindPort.toLocaleLowerCase()))
            }
        },

        prepareEdit(port){
            this.editPortModal = true
            this.portEdit = {...port}
        },

        async deletePort(port){
            if (!confirm("Deseas borrar el puerto")){
                return
            }
            this.ports = this.ports.filter(portF => portF.id !== port.id)
            this.portsFind = [...this.ports]
        },

        async findProgramToAdd(){
            try {
                this.isLoadingPrograms = true

                const response = await axios.get(`/api/programas?find=${this.textFindProgramToAdd}`)
                this.nextPath = response.data.next_page_url
                if (this.nextPath != null){
                    this.hasMore = true;
                }

                this.programsToAdd = response.data.data
                this.isLoadingPrograms = false
            }catch (e){
                showError("Error al obtener programa")
            }
        },

        addProgramSelect(event, program){
            if(event.target.checked){
                this.programsSelectToAdd.push(program)
            }else{
                this.programsSelectToAdd = this.programsSelectToAdd.filter(programf => programf.id !== program.id)
            }
        },

        removeProgramFlag(program){
            this.programsSelectToAdd = this.programsSelectToAdd.filter(programf => programf.id !== program.id)
        },

        confirmAddPrograms(){
            this.programs = [...this.programsSelectToAdd]
            this.programsFind = [...this.programsSelectToAdd]
            this.addProgram = false
        },

        deleteProgram(program){
            this.programs = this.programs.filter(programF => programF.id !== program.id)
            this.programsSelectToAdd = [...this.programs]
            this.programsFind = [...this.programs]
        },

        verifyProgramSelect(program){
            if (this.programsSelectToAdd.find(programF => programF.id === program.id) !== undefined){
                return true
            }

            return false
        },

        async loadMore(){
            if (this.hasMore){
                try {
                    this.isGettingMore = true;
                    const response = await axios.get(this.nextPath);

                    this.nextPath = response.data.next_page_url;
                    if (this.nextPath == null){
                        this.hasMore = false;
                    }

                    this.isGettingMore = false;
                    this.programsToAdd = [...this.programsToAdd, ...response.data.data];
                }catch (e){
                    throw e
                }
            }
        },

        async validateData(event){
            event.preventDefault()
            if (this.computerNumber === ""){
                return showError("El numero de equipos es obligatorio")
            }
            if (this.cpu === "" && this.ram === ""){
                return showError("La ram y el cpu deben son obligatorios")
            }
            if (this.programs.length <= 0){
                return showError("Debes agregar al menos 1 programa")
            }
            if (this.ports.length <= 0 ){
                return showError("Debes agregar al menos 1 peurto")
            }

            try {
                await axios.post("/equipo", {
                    name: this.cpu,
                    ram: this.ram,
                    computerNumber: this.computerNumber,
                    ports: this.ports,
                    programs: this.programs.map(pr => pr.id)
                })

                window.location.href = "/equipos"
            }catch (e){
                showError("Error al crear equipo intenta mas tarde")
            }

        }
    }))
})
