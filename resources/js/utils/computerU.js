export async function getListComputersAvailable(){
    try {
        const getListComputers = await axios.get("/cargarEquipos")
        return getListComputers.data
    }catch (e){
        throw e
    }
}
