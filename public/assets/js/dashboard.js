document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".metric-card, .quick-tabs a, .action-links a").forEach((item) => {
        item.addEventListener("keydown", (event) => {
            if (event.key === "Enter" || event.key === " ") {
                item.click();
            }
        });
    });

    document.querySelectorAll(".table-panel table").forEach((table) => {
        const wrapper = table.closest(".table-panel");

        if (wrapper && table.scrollWidth > wrapper.clientWidth) {
            wrapper.classList.add("has-scroll");
        }
    });
});