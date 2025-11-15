<?php

session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
  header("Location: mrHakermen.php");
  exit();
}

include 'db.php';

// ---------- PAGINATION SETUP ----------
$limit = 6; // 3x2 layout = 6 cards per page

// Get the current page number from URL (default = 1)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the offset for the SQL query
$offset = ($page - 1) * $limit;



// ---------- FETCH MANGA DATA ----------
// Fetch manga from the database with pagination
$sql = "SELECT * FROM manga ORDER BY date_added DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// ---------- TOTAL COUNT FOR PAGINATION ----------
// Get total number of manga to calculate how many pages we need
$total_sql = "SELECT COUNT(*) AS total FROM manga";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_manga = $total_row['total'];
$total_pages = ceil($total_manga / $limit);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>addChapter</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="sidebar.css">
    <link rel="stylesheet" href="aPanel.css">
    <link rel="stylesheet" href="css/aChapter.css">
    <script src="sidebarScript.js" defer></script>
    <script src="addingChapterScript.js" defer></script>

</head>
<body>

<div class="aPanel">

    <div class="panel aTop">
        <div id="mangaverse">Welcome to Manga<span id="verse">Verse</span> admin panel</div>
        <button id="menuBtn"><span class="material-symbols-outlined">menu</span></button>
    </div>

    <div class="panel aSide">
        <button onclick="window.location.href='adminPanel.php';">Admin Panel</button> <br>
        <button onclick="window.location.href='addManga.php';">Add Manga</button> <br>
        <button disabled="disabled">Add Chapter</button> <br>
        <button onclick="window.location.href='editManga.php';">Edit Manga</button> <br>
        <button onclick="window.location.href='deleteManga.php';">Delete Manga</button>
    </div>
    <div class="panel aMain">
        <div class="mTop mmm">Add Chapter</div>
            <div class="mMain">
                <div class="search-bar">
                    <input type="text" placeholder="Search...">
                    <button><span class="material-symbols-outlined">search</span></button>
                </div>
                    <div class="manga-grid">
                        <?php
                        // Check if there are any manga in the database
                        if ($result->num_rows > 0) {

                            // Loop through each manga and display it as a card
                            while($row = $result->fetch_assoc()) {

                                // Handle image path automatically
                                $imagePath = $row['photo'];

                                // If the database only has filename (e.g. "naruto.jpg"), add "uploads/"
                                if (!str_starts_with($imagePath, 'uploads/')) {
                                    $imagePath = 'uploads/' . $imagePath;
                                }

                                // Display each manga card
                                echo "
                                    <div class='manga-card'>
                                        <div class='manga-content'>
                                            <img src='" . htmlspecialchars($imagePath) . "' alt='" . htmlspecialchars($row['title']) . "'>
                                            <div class='manga-info'>
                                                <h3>" . htmlspecialchars($row['title']) . "</h3>
                                                <p><b>Tags:</b> " . htmlspecialchars($row['genres']) . "</p>
                                                <p><b>Status:</b> " . htmlspecialchars($row['status']) . "</p>
                                                <p><b>Chapters:</b> 0</p>
                                            </div>
                                        </div>
                                        <button class='add-chapter-btn' onclick=\"openModal(" . (int)$row['id'] . ")\">Add Chapter</button>

                                    </div>
                                ";
                            }

                        } else {
                            // If no manga found
                            echo "<p style='text-align:center;'>No manga found.</p>";
                        }
                        ?>
                    </div>
        </div>                
        <!-- ---------- PAGINATION LINKS ---------- -->
                <!-- PAGINATION -->
            <div class="pagination">
                    <?php
                    // Get total number of manga
                    $result = $conn->query("SELECT COUNT(*) AS total FROM manga");
                    $row = $result->fetch_assoc();
                    $total_records = $row['total'];
                    $total_pages = ceil($total_records / $limit);

                    // Previous button
                    if ($page > 1) {
                        echo '<a href="?page=' . ($page - 1) . '">&laquo; Prev</a>';
                    } else {
                        echo '<a class="disabled">&laquo; Prev</a>';
                    }

                    // Page numbers
                    for ($i = 1; $i <= $total_pages; $i++) {
                        $active = ($i == $page) ? 'active' : '';
                        echo '<a href="?page=' . $i . '" class="' . $active . '">' . $i . '</a>';
                    }

                    // Next button
                    if ($page < $total_pages) {
                        echo '<a href="?page=' . ($page + 1) . '">Next &raquo;</a>';
                    } else {
                        echo '<a class="disabled">Next &raquo;</a>';
                    }
                    ?>
            </div>

    </div>


<!-- Sidebar (Right Side) -->
<div class="sidebar" id="sidebar">
    <a href="#">Profile</a>
    <a href="index.php">Home</a>
    <a href="#">About Us</a>
    <a href="logout.php" class="logout">Log Out</a>
</div>

<!-- Overlay -->
<div class="overlay" id="overlay"></div>


<!-- adding chapter -->
<div id="chapterModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Add New Chapter</h2>

    <form id="chapterForm" method="POST" enctype="multipart/form-data" action="uploadChapter.php">
      <input type="hidden" name="manga_id" id="manga_id">

      <label>Chapter Number:</label>
      <input type="number" name="chapter_number" min="1" required><br><br>

      <label>Chapter Title:</label>
      <input type="text" name="chapter_title" required>

      <label>Upload Images:</label>
      <input type="file" name="chapter_images[]" multiple accept="image/*" required>

      <button type="submit">Upload Chapter</button>
    </form>
  </div>
</div>


<!-- Minimal JS to open/close the modal and set manga_id -->
<script>
  // get modal and close button
  const chapterModal = document.getElementById('chapterModal');
  const closeBtn = chapterModal ? chapterModal.querySelector('.close') : null;

  // openModal sets the hidden manga_id input and shows modal
  function openModal(mangaId) {
    const idInput = document.getElementById('manga_id');
    if (idInput) idInput.value = mangaId;
    if (chapterModal) chapterModal.style.display = 'flex';
  }

  // close modal on close button click
  if (closeBtn) {
    closeBtn.addEventListener('click', () => {
      chapterModal.style.display = 'none';
    });
  }

  // close modal when clicking outside content
  window.addEventListener('click', (e) => {
    if (e.target === chapterModal) {
      chapterModal.style.display = 'none';
    }
  });
</script>
</body>
</html>
