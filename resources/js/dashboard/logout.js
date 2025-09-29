import axios from "axios";
import {showError} from "../utils/showError.js";

window.addEventListener("alpine:init", () => {
    Alpine.data("logout", () => ({
        showConfirmLogout: false,

        async init(){

        },

        async logout(){
            try {
                this.$store.loader.show()
                const countSessions = await axios.get("/api/sesiones/activas");
                if (countSessions.data.activeSessions !== 0) {
                    this.showConfirmLogout = true;
                }else{
                    await this.confirmLogout()
                }
                this.$store.loader.hide()
            }catch(err){
                this.$store.loader.hide()
                showError("Error al cerrar sesion intenta mas tarde");
            }
        },

        async confirmLogout(){
            try {
                await axios.delete("/logout");
                window.location.reload()
            }catch(err){
                showError("Error al cerrar sesion intenta mas tarde");
            }
        },

    }))
})
