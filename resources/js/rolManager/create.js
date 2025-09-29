import axios from "axios";
import {showError} from "../utils/showError.js";
import {showMessage} from "../utils/showMessages.js";

window.addEventListener("alpine:init", () => {
    Alpine.data("createRol", () => ({
        name: "",
        description: "",
        textFindPermission: "",

        modules: [],
        permissions: [],
        permissionsToAdd: [],
        dependenciesToConfirm: [],
        dependenciesToConfirmIds: [],
        permissionSelected: {},

        countDependencies: {

        },

        isLoadingModules: false,
        moduleSelected: 0,
        findModuleText: "",
        showListModules: false,
        showListPermissions: false,
        isLoadingListPermissions: false,
        showModalConfirmDependencies: false,

        hasMoreModules: false,
        nextPathModules: null,
        isLoadingMoreModules: false,

        hasMorePermissions: false,
        nextPathPermission: null,
        isLoadingMorePermissions: false,

        async init(){
            await this.fetchModules()
        },

        async findModule(){
            this.hasMoreModules = false

            try {
                this.isLoadingModules = true
                const response = await axios.get(`/api/appModules?find=${this.findModuleText}`)

                this.nextPathModules = response.data.next_page_url
                if (this.nextPathModules !== null) {
                    this.hasMoreModules = true
                }

                this.modules = response.data.data
                this.isLoadingModules = false
            }catch (e ){
                this.isLoadingModules = false
            }
        },

        async fetchModules(){
            this.hasMoreModules = false

            try {
                this.isLoadingModules = true
                const response = await axios.get(`/api/appModules`)

                this.nextPathModules = response.data.next_page_url
                if (this.nextPathModules !== null) {
                    this.hasMoreModules = true
                }

                this.modules = response.data.data
                this.isLoadingModules = false
            } catch (e) {
                this.isLoadingModules = false
            }
        },

        async selectModule(module){
            this.moduleSelected = module.id
            this.findModuleText = module.display_name
            this.showListPermissions = true
            await this.getListPermissions()
        },

        async getListPermissions(){
            try {
                this.isLoadingListPermissions = true
                const permissions = await axios.get(`/api/permisos/${this.moduleSelected}`)

                this.nextPathPermission = permissions.data.next_page_url
                if (this.nextPathPermission !== null) {
                    this.hasMorePermissions = true
                }

                this.permissions = permissions.data.data
                this.isLoadingListPermissions = false
            }catch (e){
                showError("Error al obtener permisos")
            }
        },

        async findPermission(){
            this.hasmorePermissions = false
            try {
                const permissions = await axios.get(`/api/permisos/${this.moduleSelected}?find=${this.textFindPermission}`)

                this.nextPathPermission = permissions.data.next_page_url
                if (this.nextPathPermission !== null) {
                    this.hasMorePermissions = true
                }

                this.permissions = permissions.data.data
            }catch (e){
                showError("Error al obtener permisos")
            }
        },

        async getDependencies(permissionId){
            try {
                const permissions = await axios.get(`/api/permiso/${permissionId}/dependencias`)
                return permissions.data
            }catch (e){
                showError("Error al obtener las dependencias")
            }
        },

        confirmAddPermission(){
            const dependenciesUnDump = this.dependenciesToConfirmIds.filter(d => !this.permissionsToAdd.includes(d))
            dependenciesUnDump.push(this.permissionSelected.id)

            this.permissionsToAdd = [...this.permissionsToAdd, ...dependenciesUnDump]
            this.addCountDependencies(this.dependenciesToConfirmIds)

            this.permissionSelected = null
            this.dependenciesToConfirm = []
            this.showModalConfirmDependencies = false
        },

        addCountDependencies(dependencies){
            dependencies.forEach(dependency => {
                if (this.countDependencies[dependency]){
                    this.countDependencies[dependency]++
                }else{
                    this.countDependencies[dependency] = 1
                }
            })
        },

        subCountDependencies(dependencies){
            const dependenciesToRemove = []
            dependencies.forEach(dependency => {
                if (this.countDependencies[dependency]){
                    this.countDependencies[dependency]--

                    if (this.countDependencies[dependency] <= 0){
                        delete this.countDependencies[dependency]; // limpiar el contador
                        dependenciesToRemove.push(dependency)
                    }
                }else{
                    dependenciesToRemove.push(dependency)
                }
            })
            this.permissionsToAdd = this.permissionsToAdd.filter(
                p => !dependenciesToRemove.includes(p)
            )
        },

        async changeStatePermission(event, permission){
            if(this.permissionsToAdd.includes(permission.id)){
                //primero verificamos que no tenga dependecnaia
                if (this.verifyDependency(permission.id)){
                    event.target.checked = true
                    return showError("Este permiso depende de otro")
                }else{
                    //En caso de que no solicitamos al servidor las dependencias y reducimos
                    const permissions = await this.getDependencies(permission.id)

                    if (permissions.length > 0){
                        this.subCountDependencies(permissions.map(p => p.id))
                    }

                    //Nos borramos a si mismos
                    this.permissionsToAdd = this.permissionsToAdd.filter(p => p !== permission.id)
                }
            }else{
                this.permissionSelected = permission
                const permissions = await this.getDependencies(permission.id)

                if (permissions.length <= 0){
                    this.permissionsToAdd.push(this.permissionSelected.id)
                } else{
                    this.dependenciesToConfirmIds = permissions.map(p => p.id)
                    this.dependenciesToConfirm = permissions
                    this.showModalConfirmDependencies = true
                }
            }
        },

        verifyDependency(id) {
            return !!this.countDependencies[id]
        },

        async loadMore(){
            if (this.hasMoreModules){
                try {
                    this.isLoadingMoreModules = true
                    const response = await axios.get(this.nextPathModules)

                    this.nextPathModules = response.data.next_page_url
                    if (this.nextPathModules == null) {
                        this.hasMoreModules = false
                    }

                    this.modules = [...this.modules, ...response.data.data]
                    this.isLoadingMoreModules = false
                } catch (e) {
                    showError("Error al obtener permisos")
                }
            }
        },

        async loadMorePermissions(){
            if (this.hasMorePermissions){
                try {
                    this.isLoadingMorePermissions = true
                    const permissions = await axios.get(this.nextPathPermission)

                    this.nextPathPermission = permissions.data.next_page_url

                    if (this.nextPathPermission === null) {
                        this.hasMorePermissions = false
                    }

                    this.permissions = [...this.permissions, ...permissions.data.data]
                    this.isLoadingMorePermissions = false
                }catch (e){
                    showError("Error al obtener permisos")
                }
            }
        },

        async sendRole(){
            if (this.name === ""){
                return showError("Debes agregar el nombre")
            }
            if (this.description === ""){
                return showError("Debes agregar la descripcion")
            }
            if (this.permissionsToAdd.length <= 0){
                return showError("Debes seleccionar almenos un permiso")
            }

            try {
                this.$store.loader.show()
                const response = await axios.post("/rol", {
                    name: this.name,
                    description: this.description,
                    permissions: this.permissionsToAdd
                })
                this.$store.loader.hide()
                showMessage("Rol creado correctamente")
                window.location.href = "/roles"
            }catch(e){
                this.$store.loader.hide()
                return showError("Error al crear el rol intenta mas tarde")
            }
        }
    }))
})
