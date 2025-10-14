import axios from "axios";
import {showError} from "../utils/showError.js";
import {showMessage} from "../utils/showMessages.js";

window.addEventListener("alpine:init", () => {
    Alpine.data("createToken", () => ({
        token: "",
        isLoading: false,
        title: "",
        showToken: false,

        async createToken(e){
            e.preventDefault();

            if(this.title === ""){
                return showError("Debes agregar un titulo")
            }

            try {
                this.$store.loader.show()
                const token = await axios.post("/api/generar-token", {
                    "title": this.title
                })

                this.token = token.data
                this.$store.loader.hide()
                this.showToken = true
            }catch(err){
                console.log(err)
                this.$store.loader.hide()
                showError("Error al generar el token")
            }
        },

        async copyToken(){
            try {
                await navigator.clipboard.writeText(this.token);
                showMessage("Copiado correctamente")
            }catch (e){
                showError("Debes de dar permisos")
            }
        },

    }))
})
