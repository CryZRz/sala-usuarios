export async function getListComputersAvailable(){
    try {
        const getListComputers = await axios.get("/api/cargarEquipos")
        return getListComputers.data
    }catch (e){
        throw e
    }
}
