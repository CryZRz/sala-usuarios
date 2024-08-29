import axios from "axios";
export async function getInfoStudent(controlNumber){
    try {
        const request =  await axios.get(`/estudiante/${controlNumber}`)
        return request.data.data
    }catch (e){
        throw e
    }
}
