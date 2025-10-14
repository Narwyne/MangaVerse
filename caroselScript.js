// caroselScript.js
document.addEventListener("DOMContentLoaded", () => {
  const slides = document.querySelector(".slides");
  const images = document.querySelectorAll(".slides img");

  let index = 0;
  const total = images.length;

  // Clone the first image and append it to the end for smooth looping
  const firstClone = images[0].cloneNode(true);
  slides.appendChild(firstClone);

  function moveCarousel() {
    index++;
    slides.style.transition = "transform 1s ease";
    slides.style.transform = `translateX(-${index * 100}%)`;

    if (index === total) {
      // When reaching the clone, instantly reset to first image
      setTimeout(() => {
        slides.style.transition = "none";
        slides.style.transform = "translateX(0)";
        index = 0;
      }, 1000); // match transition duration
    }
  }

  // Auto-slide every 3 seconds
  setInterval(moveCarousel, 3000);
});
