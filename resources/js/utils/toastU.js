import StartToastifyInstance from "toastify-js"
import "toastify-js/src/toastify.css"

function showToast(text, style = {}, properties = {}){
    const toastifyMessge = StartToastifyInstance({
        text: text,
        duration: 2000,
        newWindow: true,
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`,
        style: {...style},
        ...properties,
    })

    return {
        show()  {
            toastifyMessge.showToast()
        }
    }
}

export {showToast}
