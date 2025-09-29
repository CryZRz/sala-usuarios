const allSelects = document.getElementsByClassName("select-header")
const cancelImportBtn = document.getElementById("cancelImportBtn")
const methodInput = document.getElementById("cancelInput")
let prevSelectedId = null

function addPrevOptionSelects(){
    for(const findSelect of allSelects){
        for(const option of findSelect.options){
            if (option.getAttribute("selectId") === prevSelectedId){
                option.style.display = "block"
            }
        }
    }
}

function removeOptionsSelects(select, optionRemove){
    for(const findSelect of allSelects){
        if (findSelect !== select){
            for(const option of findSelect.options){
                if (option.getAttribute("selectId") === optionRemove){
                    option.style.display = "none"
                    if (prevSelectedId !== optionRemove){
                        addPrevOptionSelects()
                    }
                }
            }
        }
    }
}

for(const select of allSelects){
    select.addEventListener("change", e => {
        removeOptionsSelects(select, e.target.value)
    })
    select.addEventListener("focus", e => {
        prevSelectedId = e.target.value
    })
}

cancelImportBtn.addEventListener("click",_ => {
    methodInput.checked = true
})
