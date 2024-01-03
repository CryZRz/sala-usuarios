async function fetchMorePrograms(index){
    try {
        const fetchListPrograms = await axios.get(`/api/programas?page=${index}`)
        return fetchListPrograms
    } catch (e) {
        throw new Error(e)
    }
}

async function fetchMorePogramsAvailable(index, id){
    try {
        const fetchListPrograms = await axios.get(`/equipo-programas/${id}?page=${index}`)
        return fetchListPrograms
    } catch (e) {
        throw new Error(e)
    }
}

export {fetchMorePrograms, fetchMorePogramsAvailable}