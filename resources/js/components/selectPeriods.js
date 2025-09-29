import axios from "axios";

window.addEventListener("alpine:init", () => {
    Alpine.data("selectPeriods", (periodQuery) => ({
        periods: [],
        isLoadingPeriods: false,

        periodSelected: 0,
        findPeriodText: "",
        showListPeriods: false,

        hasMorePeriods: false,
        nextPath: "",
        isLoadingMore: false,

        async init(){
            if (periodQuery){
                await this.getPeriodQuery()
            }else{
                await this.fetchPeriods()
            }
        },

        async getPeriodQuery(){
            try {
                const response = await axios.get(`/period/${periodQuery}`);
                this.periods.push(response.data);
                this.findPeriodText = response.data.name
                this.periodSelected = response.data.id
            }catch (e ){
                this.isLoadingPeriods = false
            }
        },

        async findPeriod(){
            try {
                this.isLoadingPeriods = true
                const response = await axios.get(`/periods?name=${this.findPeriodText}`)

                this.nextPath = response.data.next_page_url
                if (this.nextPath !== null){
                    this.hasMorePeriods = true
                }

                this.periods = response.data.data
                this.isLoadingPeriods = false
            }catch (e ){
                this.isLoadingPeriods = false
            }
        },

        async fetchPeriods(){
            try {
                this.isLoadingPeriods = true
                const response = await axios.get(`/periods`)
                this.findPeriodText = response.data.data[0].name
                this.periodSelected = response.data.data[0].id
                this.periods = response.data.data
                this.isLoadingPeriods = false

                this.nextPath = response.data.next_page_url
                if (this.nextPath != null) {
                    this.hasMorePeriods = true
                }
            } catch (e) {
                this.isLoadingPeriods = false
            }
        },

        selectPeriod(period){
            this.periodSelected = period.id
            this.findPeriodText = period.name
        },

        async loadMore(){
            if (this.hasMorePeriods) {
                try {
                    this.isLoadingMore = true

                    const response = await axios.get(this.nextPath)
                    this.periods = [...this.periods, ...response.data.data]

                    this.nextPath = response.data.next_page_url
                    if (response.data.next_page_url == null) {
                        this.hasMorePeriods = false
                    }
                    this.isLoadingMore = false
                }catch (e ){

                }
            }
        }
    }))
})
