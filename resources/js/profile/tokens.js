import axios from "axios";
import {showError} from "../utils/showError.js";
import {showMessage} from "../utils/showMessages.js";

window.addEventListener("alpine:init", () => {
    Alpine.data("profileTokens", () => ({
        tokens: [],
        isLoading: false,

        async init(){
            try {
                this.isLoading = true;
                const response = await axios.get("/api/tokens");
                this.tokens = response.data.data
                this.isLoading = false;
            }catch(err) {
                this.isLoading = false;
                showError("Error al consultar los tokens")
            }
        },

        async removeToken(token){
            try {
                this.$store.loader.show()
                await axios.delete(`/api/eliminar-token/${token.uuid}`);
                this.tokens = this.tokens.filter(item => item.uuid !== token.uuid);
                this.$store.loader.hide()
                showMessage("Eliminado correctamente")
            }catch(err){
                this.$store.loader.show()
                showError("Error al eliminar el token")
            }
        }
    }))
})
