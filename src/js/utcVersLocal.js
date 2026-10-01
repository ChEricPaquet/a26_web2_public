document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".date-locale").forEach((el) => {
        const utcDateStr = el.getAttribute("datetime");
        if (utcDateStr) {
            const date = new Date(utcDateStr);
            if (!isNaN(date)) {
                el.textContent = date.toLocaleString();
            }
        }
    });
});
