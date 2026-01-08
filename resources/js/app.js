import "./bootstrap";

function tableActionDropdown() {
    return {
        isOpen: false,
        style: "",
        toggle(e) {
            const rect = e.currentTarget.getBoundingClientRect();

            this.style = `
                top: ${rect.bottom + window.scrollY + 4}px;
                left: ${rect.right - 180 + window.scrollX}px;
            `;

            this.isOpen = !this.isOpen;
        },
    };
}
