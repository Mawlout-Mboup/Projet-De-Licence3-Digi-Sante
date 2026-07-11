document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".chart-card").forEach((card) => {
        const chart = card.querySelector(".mini-chart");

        if (!chart) {
            return;
        }

        const tooltip = document.createElement("div");
        tooltip.className = "chart-tooltip";
        card.appendChild(tooltip);

        chart.querySelectorAll("polyline").forEach((line) => {
            const points = (line.getAttribute("points") || "")
                .trim()
                .split(/\s+/)
                .map((point) => point.split(",").map(Number))
                .filter(([x, y]) => Number.isFinite(x) && Number.isFinite(y));

            points.forEach(([x, y], index) => {
                const dot = document.createElementNS("http://www.w3.org/2000/svg", "circle");
                dot.setAttribute("class", "chart-dot");
                dot.setAttribute("cx", String(x));
                dot.setAttribute("cy", String(y));
                dot.setAttribute("r", "5");
                dot.setAttribute("tabindex", "0");
                dot.setAttribute("role", "button");
                dot.setAttribute("aria-label", `Point ${index + 1}`);
                chart.appendChild(dot);

                const show = () => {
                    const chartRect = chart.getBoundingClientRect();
                    const cardRect = card.getBoundingClientRect();
                    const viewBox = chart.viewBox.baseVal;
                    const left = ((x - viewBox.x) / viewBox.width) * chartRect.width + chartRect.left - cardRect.left;
                    const top = ((y - viewBox.y) / viewBox.height) * chartRect.height + chartRect.top - cardRect.top;

                    card.classList.add("is-chart-active");
                    tooltip.innerHTML = `<small>Releve ${index + 1}</small>${Math.round(150 - y)}`;
                    tooltip.style.display = "block";
                    tooltip.style.left = `${Math.max(8, Math.min(left + 12, cardRect.width - 128))}px`;
                    tooltip.style.top = `${Math.max(8, top - 44)}px`;
                };

                const hide = () => {
                    card.classList.remove("is-chart-active");
                    tooltip.style.display = "none";
                };

                dot.addEventListener("mouseenter", show);
                dot.addEventListener("focus", show);
                dot.addEventListener("mouseleave", hide);
                dot.addEventListener("blur", hide);
            });
        });
    });
});
