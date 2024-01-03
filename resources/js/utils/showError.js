import StartToastifyInstance from "toastify-js"
import "toastify-js/src/toastify.css"

const toastifyError = StartToastifyInstance({
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

function showError(message){
    toastifyError.options.text = message
    toastifyError.showToast()
    
}

function showErrors(listErrors){
  listErrors.map(e => {
    toastifyError.options.text = e
    toastifyError.showToast()
  })
}

export {showError, showErrors}