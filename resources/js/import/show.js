import ShowLoading from "../utils/showLoading.js";

const formImport = document.getElementById("form-import")
const sectionLoading = document.getElementById("section-loading")
const loadingManager = new ShowLoading(sectionLoading)
loadingManager.setPageLoading()
formImport.addEventListener("submit", _ => {
    loadingManager.onLoading()
})
