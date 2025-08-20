import "../bootstrap";

import { Offcanvas, Modal } from "bootstrap";
window.Offcanvas = Offcanvas;
window.Modal = Modal;

document.addEventListener("livewire:init", () => {
    Livewire.on("open-offcanvas", () => {
        const offcanvasEl = document.getElementById("offcanvasRight");
        const bsOffcanvas =
            Offcanvas.getInstance(offcanvasEl) || new Offcanvas(offcanvasEl);
        bsOffcanvas.show();
    });

    Livewire.on("close-offcanvas", () => {
        const offcanvasEl = document.getElementById("offcanvasRight");
        const bsOffcanvas = Offcanvas.getInstance(offcanvasEl);

        if (bsOffcanvas) {
            bsOffcanvas.hide();
        }
    });

    Livewire.on("active-modal", () => {
        const modalElement = document.getElementById("productModal");
        const bsModal =
            Modal.getInstance(modalElement) || new Modal(modalElement);
        bsModal.show();
    });

    Livewire.on("close-modal", () => {
        const modalElement = document.getElementById("productModal");
        const bsModal = Modal.getInstance(modalElement);
        if (bsModal) {
            bsModal.hide();
        }
    });
});
