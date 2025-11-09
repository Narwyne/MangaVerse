// Get elements
const modal = document.getElementById("chapterModal");
const closeBtn = document.querySelector(".close");

// Open modal when button clicked
function openModal(mangaId) {
  document.getElementById("manga_id").value = mangaId;
  modal.style.display = "flex";
}

// Close modal
closeBtn.onclick = function() {
  modal.style.display = "none";
}

// Close modal when clicking outside
window.onclick = function(event) {
  if (event.target === modal) {
    modal.style.display = "none";
  }
}