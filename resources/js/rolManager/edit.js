import axios from "axios";
import {showError} from "../utils/showError.js";
import {showMessage} from "../utils/showMessages.js";

window.addEventListener("alpine:init", () => {
    Alpine.data("editRol", (permissions, roleId) => ({
        textFindPermission: "",
        modules: [],
        permissionsToAdd: [],
        dependenciesToConfirm: [],
        permissionSelected: 0,

        isLoadingModules: false,
        moduleSelected: 0,
        findModuleText: "",
        showListModules: false,
        showListPermissions: false,
        isLoadingListPermissions: false,

        showModalConfirmDependencies: false,
        showConfirmRemovePermission: false,

        hasMoreModules: false,
        nextPathModules: null,
        isLoadingMoreModules: false,

        hasMorePermissions: false,
        nextPathPermission: null,
        isLoadingMorePermissions: false,

        async init(){
            await this.fetchModules()
            this.permissionsToAdd = permissions
        },

        async findModule(){
            this.hasmoreModules = false;
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

        async getDependencies(permissionId){
            try {
                this.$store.loader.show()
                const permissions = await axios.get(`/api/permiso/${permissionId}/dependencias`)
                this.$store.loader.hide()
                return permissions.data
            }catch (e){
                this.$store.loader.hide()
                showError("Error al consultar intentalo mas tarde")
            }
        },

        async confirmAddPermission(){
            try {
                this.$store.loader.show()
                const permissionsAdd = await axios.post(`/api/rol/${roleId}/permiso/${this.permissionSelected}`)
                this.permissionsToAdd = this.permissionsToAdd.filter(per => !permissionsAdd.data.blinzzia.includes(per))
                this.$store.loader.hide()
                this.showModalConfirmDependencies = false
                showMessage("Permiso agregado correctamente")
            }catch (e){
                showError("Error al agregar intentalo mas tarde")
            }
        },

        async removePermissionOwn(){
            try {
                this.$store.loader.show()

                const response = await axios.delete(`/api/rol/${roleId}/permiso/${this.permissionSelected}`)
                this.permissionsToAdd = this.permissionsToAdd.filter(per => !response.data.blinzzia.includes(per))
                this.showConfirmRemovePermission = false
                this.$store.loader.hide()
                showMessage("Permiso eliminado correctamente")

            }catch (e){
                this.$store.loader.hide()
                this.showConfirmRemovePermission = false

                if(e.status === 409){
                    showError(e.response.data.error)
                }
            }
        },

        async confirmRemovePermission(){
            return await this.removePermissionOwn();
        },

        async changeStatePermission(event, permission){
            this.permissionSelected = permission.id

            if (this.permissionsToAdd.includes(permission.id)){
                this.showConfirmRemovePermission = true
            }else{
                const dependencies = await this.getDependencies(permission.id)

                if (dependencies.length <= 0){
                    await this.confirmAddPermission()
                } else{
                    this.dependenciesToConfirm = dependencies
                    this.showModalConfirmDependencies = true
                }
            }
        },

        async findPermission(){
            this.hasMorePermissions = false

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

        async loadMoreModules(){
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
                    console.log(permissions.data)
                    if (this.nextPathPermission === null) {
                        this.hasMorePermissions = false
                    }

                    this.permissions = [...this.permissions, ...permissions.data.data]
                    this.isLoadingMorePermissions = false
                }catch (e){
                    showError("Error al obtener permisos")
                }
            }
        }

    }))
})
