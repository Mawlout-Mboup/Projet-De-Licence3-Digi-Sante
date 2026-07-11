document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("form").forEach((form) => {
        form.addEventListener("submit", (event) => {
            const requiredFields = form.querySelectorAll("[required]");
            let valid = true;

            requiredFields.forEach((field) => {
                const empty = !String(field.value || "").trim();
                field.classList.toggle("is-invalid", empty);

                if (empty) {
                    valid = false;
                }
            });

            if (!valid) {
                event.preventDefault();
                const firstInvalid = form.querySelector(".is-invalid");
                firstInvalid?.focus();
            }
        });

        form.querySelectorAll(".is-invalid").forEach((field) => {
            field.addEventListener("input", () => field.classList.remove("is-invalid"));
        });
    });
});
