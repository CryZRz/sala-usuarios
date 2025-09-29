document.addEventListener('alpine:init', () => {
    Alpine.store('loader', {
        active: false,
        show() {
            this.active = true;
        },
        hide() {
            this.active = false;
        },
    });
});
