import axios from "axios";
import {showError} from "../utils/showError.js";

window.addEventListener("alpine:init", () => {
    Alpine.data("selectRoles", () => ({
        showAddRole: false,
        roles: [],
        rolesToAdd: [],
        isLoadingRoles: false,

        roleSelected: 0,
        findRoleText: "",
        showListRoles: false,

        hasMoreRoles: false,
        nextPathRoles: null,
        isLoadingMoreRoles: false,

        async init(){
            await this.fetchroles()
        },

        async findRole(){
            this.hasmoreRoles = false;
            try {
                this.isLoadingRoles = true
                const response = await axios.get(`/api/roles?find=${this.findRoleText}`)

                this.nextPathRoles = response.data.next_page_url
                if (this.nextPathRoles != null){
                    this.hasMoreRoles = true
                }

                this.roles = response.data.data
                this.isLoadingRoles = false
            }catch (e ){
                this.isLoadingRoles = false
            }
        },

        async fetchroles(){
            try {
                this.isLoadingRoles = true
                const response = await axios.get(`/api/roles`)

                this.nextPathRoles = response.data.next_page_url
                if (this.nextPathRoles != null){
                    this.hasMoreRoles = true
                }

                this.roles = response.data.data
                this.isLoadingRoles = false
            } catch (e) {
                this.isLoadingRoles = false
                showError("Error al consultar roles intenta mas tarde")
            }
        },

        selectRole(role){
            this.roleSelected = role.id
            this.findRoleText = role.name
        },

        async showModalRoles(){
            this.showAddRole = true
            await this.fetchroles()
        },

        addRoleToSave(event, role){
            if (this.rolesToAdd.find(roleToAdd => roleToAdd.id === role.id) === undefined){
                this.rolesToAdd.push(role)
            }else {
                this.rolesToAdd = this.rolesToAdd.filter(roleToAdd => roleToAdd.id !== role.id)
            }
        },

        async loadMoreRoles(){
            if (this.hasMoreRoles){
                try {
                    this.isLoadingMoreRoles = true
                    const response = await axios.get(this.nextPathRoles)

                    this.nextPathRoles = response.data.next_page_url
                    if (this.nextPathRoles == null){
                        this.hasMoreRoles = false
                    }

                    this.roles = [...this.roles, ...response.data.data]
                    this.isLoadingMoreRoles = false
                } catch (e) {
                    this.isLoadingRoles = false
                    showError("Error al consultar roles intenta mas tarde")
                }
            }
        },

        removeRoleFlag(role){
            this.rolesToAdd = this.rolesToAdd.filter(roleToAdd => roleToAdd.id !== role.id)
        },

        async confirmAddRoles(){
            if (this.rolesToAdd.length > 0){
                try{
                    await axios.post(`/perfil/${userId}/roles`, {
                        roles: this.rolesToAdd.map(role => role.id),
                    })

                    window.location.reload()
                }catch (e){
                    showError("Error al añadir roles intenta mas tarde")
                }
            }

            showError("Debes seleccionar un rol")
        }
    }))
})
