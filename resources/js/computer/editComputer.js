import axios from "axios";
import {showMessage} from "../utils/showMessages.js";
import {showError} from "../utils/showError.js";

document.addEventListener("alpine:init", () => {
    Alpine.data("editComputer", (initialComputerId) => ({
        ports: [],
        programs: [],
        programsToAdd: [],
        programsSelectToAdd: [],
        computerId: initialComputerId,
        createModal: false,
        editModal: false,
        addProgram: false,
        textFindPort: "",
        textFindProgram: "",
        textFindProgramToAdd: "",

        isFindProgramsToAdd: false,
        isFindProgram: false,
        isFindPort: false,

        isGettingMorePrograms: false,
        hasMoreProgramsToAdd: false,

        createPort: {
            amount: 0,
            computer_id: 0,
            created_at: "",
            id: 0,
            type: "",
            updated_at: "",
        },
        portEdit: {
            amount: 0,
            computer_id: 0,
            created_at: "",
            id: 0,
            type: "",
            updated_at: "",
        },
        nextPathMoreProgram: "",

        async init(){
            this.$watch('addProgram', async () => {
                if(this.addProgram && this.programsToAdd.length <= 0){
                    try {
                        this.programsToAdd = await this.fetchProgramsToAdd()
                    }catch (e){
                        console.log(e)
                    }
                }
            })

            try {
                this.programs = await this.fetchPrograms()
                this.ports = await this.fetchPorts()
            }catch (e){
                console.log(e)
            }
        },

        async fetchPorts(){
           try {
               this.isFindPort = true
               const ports = await axios.get(`/api/puertos/${this.computerId}`)
               this.isFindPort = false
               return ports.data.data
           } catch (e){
               throw e
           }
        },

        async fetchPrograms(){
          try {
              this.isFindProgram = true
              const response = await axios.get(`/api/programas/${this.computerId}`)
              this.isFindProgram = false
              return response.data.data
          }catch (e){
              throw e
          }
        },

        async fetchProgramsToAdd(){
            try {
                this.isFindProgramsToAdd = true
                const response = await axios.get(`/api/equipo/${this.computerId}/programas-faltantes`)

                this.nextPathMoreProgram = response.data.next_page_url

                if (this.nextPathMoreProgram != null){
                    this.hasMoreProgramsToAdd = true;
                }

                this.isFindProgramsToAdd = false
                return response.data.data
            }catch (e){
                throw e
            }
        },

        removeProgramFlag(programToAdd){
            this.programsSelectToAdd = this.programsSelectToAdd.filter(p => p.id !== programToAdd.id)
        },

        //Esto puede llegar a ser costoso
        verifyInclude(programAdd){
            return this.programsSelectToAdd.find(p => p.id === programAdd.id)
        },

        async savePort(){
            try {
                this.$store.loader.show()
                const response = await axios.post("/api/puerto", {
                    type: this.createPort.type,
                    amount: this.createPort.amount,
                    computer: this.computerId
                })
                this.ports.unshift(response.data)
                this.$store.loader.hide()
                this.createModal = false
                showMessage("Puerto creado correctamente", "green")
            }catch (e){
                this.$store.loader.hide()
            }
        },

        async confirmEditPort(){
            try {
                this.$store.loader.show()
                const response = await axios.post(`/api/puerto/${this.portEdit.id}`, {
                    type: this.portEdit.type,
                    amount: this.portEdit.amount
                })
                this.ports = this.ports.map(port => {
                    if (port.id === response.data.id) {
                        return response.data
                    }
                    return port
                })
                this.$store.loader.hide()
                this.editModal = false
                showMessage("Puerto actulizado correctamente", "green")
            }catch (e){
                this.$store.loader.hide()
            }
        },

        async findPort(){
            try {
                this.isFindPort = true
                const ports = await axios.get(`/api/puertos/${this.computerId}?find=${this.textFindPort}`)
                this.ports = ports.data.data
                this.isFindPort = false
            } catch (e){
                throw e
            }
        },

        async findProgram(){
            try {
                this.isFindProgram = true
                const programs = await axios.get(`/api/programas/${this.computerId}?find=${this.textFindProgram}`)
                this.programs = programs.data.data
                this.isFindProgram = false
            } catch (e){
                throw e
            }
        },

        async prepareEdit(port){
            this.editModal = true
            this.portEdit = {...port}
        },

        async deletePort(port){
            if (!confirm("Deseas borrar el puerto")){
                return
            }
            try {
                this.$store.loader.show()
                await axios.delete(`/api/puerto/${port.id}`)
                this.ports = this.ports.filter(portFilter => portFilter.id !== port.id)
                this.$store.loader.hide()
                showMessage("Puerto eliminado")
            }catch (e){
                this.$store.loader.hide()
            }
        },

        async findProgramToAdd(){
            try {
                this.isFindProgramsToAdd = true
                const response = await axios.get(`/api/equipo/${this.computerId}/programas-faltantes?find=${this.textFindProgramToAdd}`)
                this.programsToAdd = response.data.data
                this.isFindProgramsToAdd = false
            }catch (e){
                throw e
            }
        },

        addProgramSelect(event, program){
            if(event.target.checked){
                this.programsSelectToAdd.push(program)
            }else{
                this.programsSelectToAdd = this.programsSelectToAdd.filter(programf => programf.id !== program.id)
            }
            console.log(this.programsSelectToAdd)
        },

        async confirmAddPrograms(){
            if (this.programsSelectToAdd.length <= 0){
                return showError("Debes seleccionar programas")
            }
            try {
                this.$store.loader.show()
                await axios.post(`/api/equipo/${this.computerId}}/agregar-programas`, {
                    programs: this.programsSelectToAdd.map(p => p.id),
                })

                const newPrograms = this.programsToAdd.filter(program =>
                    this.programsSelectToAdd.map(pro => pro.id).includes(program.id) &&
                    !this.programs.some(p => p.id === program.id)
                );
                this.programs.push(...newPrograms)
                this.programsSelectToAdd = []
                this.$store.loader.hide()
                this.addProgram = false
                showMessage("Programa agregado")
            }catch (e){
                this.$store.loader.hide()
                showError("Error al agregar programa, intenta mas tarde")
            }
        },

        async deleteProgram(program){
            if (!confirm("Deseas borrar el programa")){
                return
            }
            try {
                this.$store.loader.show()
                await axios.delete(`/api/equipo/${this.computerId}/eliminar-programa/${program.id}`)
                this.programs = this.programs.filter(programF => programF.id !== program.id)
                    showMessage("Pograma eliminado")
                this.$store.loader.hide()
            }catch (e){
                this.$store.loader.hide()
            }
        },

        async loadMoreProgramsToAdd(){
            if (this.hasMoreProgramsToAdd){
                try {
                    this.isGettingMorePrograms = true;
                    const response = await axios.get(this.nextPathMoreProgram);

                    this.nextPathMoreProgram = response.data.next_page_url;
                    if (this.nextPathMoreProgram == null){
                        this.hasMoreProgramsToAdd = false;
                    }

                    this.isGettingMorePrograms = false;
                    this.programsToAdd = [...this.programsToAdd, ...response.data.data];
                }catch (e){
                    throw e
                }
            }
        },
    }))
})
