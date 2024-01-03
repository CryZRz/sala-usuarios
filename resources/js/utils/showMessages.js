import StartToastifyInstance from "toastify-js"
import "toastify-js/src/toastify.css"

const toastifyMessge = StartToastifyInstance({
    text: "This is a toast",
    duration: 2000,
    newWindow: true,
    gravity: "top", // `top` or `bottom`
    position: "right", // `left`, `center` or `right`,
    style: {
      background: "red",
      color: "white"
    },
})

function showMessage(message, background, color){
    toastifyMessge.options.text = message
    toastifyMessge.options.style = {
        background: background,
        color: color,
    }
    toastifyMessge.showToast()  
}

export {showMessage}