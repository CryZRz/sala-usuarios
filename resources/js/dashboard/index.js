import axios from "axios";
import Chart from "chart.js/auto";

window.addEventListener("alpine:init", () => {
    Alpine.data("dashboard", () => ({
        isLoadingNotices: true,
        listNotices: [],
        activeIndex: 0,

        async init(){
            this.initGraphic();
            await this.fetchNotices();
        },

        initGraphic() {
            new Chart(this.$refs.graphic, {
                type: 'line',
                data: {
                    labels: ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'],
                    datasets: [{
                        label: '',
                        data: [150, 200, 170, 220, 240, 210, 182],
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        tension: 0.4  // suaviza la línea
                    }]
                },
                options: {
                    responsive: true,
                }
            });
        },

        nextNotice(){
            if (++this.activeIndex > this.listNotices.length){
                this.activeIndex = 0
            }
        },

        prevNotice(){
            if (--this.activeIndex < 0){
                this.activeIndex = this.listNotices.length
            }
        },

        async fetchNotices(){
            try {
                this.isLoadingNotices = true;
                const responseNotices = await axios.get("/api/notitec")
                this.listNotices = responseNotices.data
                this.isLoadingNotices = false;
            }catch (e){

            }
        },
    }))
})
