export function getCSRF(){
    const csrfToken = document.querySelector('[name="csrf-token"]')
    return csrfToken.content
}
