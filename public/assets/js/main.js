document.addEventListener("DOMContentLoaded", () => {
    const alerts = document.querySelectorAll(".alert");
    alerts.forEach((a) => {
        setTimeout(() => {
            a.style.transition = "opacity 0.4s ease-out, transform 0.4s ease-out";
            a.style.opacity = "0";
            a.style.transform = "translateY(-4px)";
            setTimeout(() => a.remove(), 500);
        }, 3500);
    });
});