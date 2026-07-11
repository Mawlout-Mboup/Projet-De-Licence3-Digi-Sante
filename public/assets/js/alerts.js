document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('a[href*="/delete"], a[href*="/resoudre"], a[href*="/prendre-en-charge"]').forEach((link) => {
        link.addEventListener("click", (event) => {
            const label = link.getAttribute("aria-label") || link.textContent.trim() || "cette action";
            const message = `Confirmer : ${label} ?`;

            if (!window.confirm(message)) {
                event.preventDefault();
            }
        });
    });
});
