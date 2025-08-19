import "../bootstrap";

import { Offcanvas, Modal } from "bootstrap";
window.Offcanvas = Offcanvas;
window.Modal = Modal;

document.addEventListener("livewire:init", () => {
    Livewire.on("open-offcanvas", () => {
        const offcanvasEl = document.getElementById("offcanvasRight");
        const bsOffcanvas = new Offcanvas(offcanvasEl);
        bsOffcanvas.show();
    });

    Livewire.on("active-modal", () => {
        const modalElement = document.getElementById("productModal");
        const bsModal = new Modal(modalElement);
        bsModal.show();
    });
});
