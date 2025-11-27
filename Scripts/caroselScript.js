const slides = document.querySelector('.slides');
const totalImages = slides.querySelectorAll('img').length;
const totalPairs = Math.ceil(totalImages / 2); // total "pages" (2 images per page)
let index = 0;

function slideShow() {
  index = (index + 1) % totalPairs;
  slides.style.transform = `translateX(-${index * 100}%)`;
}

setInterval(slideShow, 6000);