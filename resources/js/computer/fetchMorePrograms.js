async function fetchMorePrograms(index){
    try {
        return await axios.get(`/api/programas?page=${index}`)
    } catch (e) {
        throw new Error(e)
    }
}

async function fetchMorePogramsAvailable(index, id){
    try {
        return await axios.get(`/equipo-programas/${id}?page=${index}`)
    } catch (e) {
        throw new Error(e)
    }
}

export {fetchMorePrograms, fetchMorePogramsAvailable}
