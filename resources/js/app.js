import "./bootstrap";

const container = document.getElementById("cakes-container");
const btnRight = document.getElementById("scroll-right");

btnRight.addEventListener("click", () => {
    container.scrollBy({ left: 320, behavior: "smooth" }); // scroll lebih presisi
});

let isDown = false;
let startX;
let scrollLeft;

container.addEventListener("mousedown", (e) => {
    isDown = true;
    container.classList.add("active");
    startX = e.pageX - container.offsetLeft;
    scrollLeft = container.scrollLeft;
});
container.addEventListener("mouseleave", () => {
    isDown = false;
    container.classList.remove("active");
});
container.addEventListener("mouseup", () => {
    isDown = false;
    container.classList.remove("active");
});
container.addEventListener("mousemove", (e) => {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX - container.offsetLeft;
    const walk = (x - startX) * 2; // scroll speed
    container.scrollLeft = scrollLeft - walk;
});

// Optional: Support touch events for mobile smooth swipe
let touchStartX = 0;
container.addEventListener("touchstart", (e) => {
    touchStartX = e.touches[0].clientX;
    scrollLeft = container.scrollLeft;
});
container.addEventListener("touchmove", (e) => {
    const touchX = e.touches[0].clientX;
    const walk = (touchStartX - touchX) * 2;
    container.scrollLeft = scrollLeft + walk;
});

// responsive untuk card bagian halaman Recommended cakes
document.getElementById("scroll-right")?.addEventListener("click", () => {
    document
        .getElementById("cakes-container")
        .scrollBy({ left: 300, behavior: "smooth" });
});

document
    .getElementById("scroll-right-mobile")
    ?.addEventListener("click", () => {
        document
            .getElementById("cakes-container")
            .scrollBy({ left: 300, behavior: "smooth" });
    });


    