/*
==========================================================
DIGI-SANTE
HOME SLIDER
==========================================================
*/

document.addEventListener("DOMContentLoaded", () => {

    const slides = document.querySelectorAll(".slide");

    const indicators = document.querySelectorAll(".indicator");

    const thumbnails = document.querySelectorAll(".thumbnail");

    const progressBar = document.getElementById("progressBar");

    const nextBtn = document.getElementById("nextSlide");

    const prevBtn = document.getElementById("prevSlide");
    const slideCount = document.querySelector(".slide-count strong");

    if (
        slides.length === 0 ||
        indicators.length === 0 ||
        thumbnails.length === 0 ||
        !progressBar ||
        !nextBtn ||
        !prevBtn
    ) {
        return;
    }

    let current = 0;

    let timer = null;

    const duration = 5000;

    function showSlide(index) {

        slides.forEach((slide) => {

            slide.classList.remove("active");

        });

        indicators.forEach((item) => {

            item.classList.remove("active");

        });

        thumbnails.forEach((item) => {

            item.classList.remove("active");

        });

        slides[index].classList.add("active");

        indicators[index].classList.add("active");

        thumbnails[index].classList.add("active");

        if (slideCount) {
            slideCount.textContent = String(index + 1).padStart(2, "0");
        }

        progressBar.style.width =
            ((index + 1) / slides.length) * 100 + "%";

        current = index;

    }

    function nextSlide() {

        let index = current + 1;

        if (index >= slides.length) {

            index = 0;

        }

        showSlide(index);

    }

    function prevSlide() {

        let index = current - 1;

        if (index < 0) {

            index = slides.length - 1;

        }

        showSlide(index);

    }

    nextBtn.addEventListener("click", () => {

        nextSlide();

        restart();

    });

    prevBtn.addEventListener("click", () => {

        prevSlide();

        restart();

    });
        indicators.forEach((indicator, index) => {

        indicator.addEventListener("click", () => {

            showSlide(index);

            restart();

        });

    });

    thumbnails.forEach((thumbnail, index) => {

        thumbnail.addEventListener("click", () => {

            showSlide(index);

            restart();

        });

    });

    function autoplay() {

        timer = setInterval(() => {

            nextSlide();

        }, duration);

    }

    function restart() {

        clearInterval(timer);

        autoplay();

    }

    document.addEventListener("keydown", (event) => {

        if (event.key === "ArrowRight") {

            nextSlide();

            restart();

        }

        if (event.key === "ArrowLeft") {

            prevSlide();

            restart();

        }

    });

    document.addEventListener("visibilitychange", () => {

        if (document.hidden) {

            clearInterval(timer);

        } else {

            restart();

        }

    });

    showSlide(0);

    autoplay();

});
