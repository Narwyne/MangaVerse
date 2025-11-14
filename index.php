<?php

session_start();

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
}

include 'db.php';

// ---------- PAGINATION SETUP ----------
$limit = 15; // 3x5 layout = 15 cards per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// ---------- FETCH MANGA DATA ----------
$sql = "SELECT * FROM manga ORDER BY date_added DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// ---------- TOTAL COUNT FOR PAGINATION ----------
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
  <link rel="stylesheet" href="home.css">
  <link rel="stylesheet" href="sidebar.css">
  <title>Home</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
  <script src="caroselScript.js" defer></script>
  <script src="sidebarScript.js" defer></script>

</head>
<body>

<style>
  
  .manga-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  grid-template-rows: repeat(6, auto);
  gap: 5px;
  padding-top: 7px;
  padding-left: 5px;
  padding-right: 5px;
}

.manga-card {
  background-color: #1e1e1e;
  border-radius: 5px;
  box-shadow: 0 0 6px rgba(0,0,0,0.5);
  overflow: hidden;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  border: 1px solid #333;
}
.manga-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 0 12px rgba(255, 221, 0, 0.3);
}
.manga-content {
  display: flex;
  align-items: flex-start;
  padding: 10px;
  height: 155px;
}
.manga-content img {
  width: 105px;
  height: 155px;
  object-fit: cover;
  border-radius: 4px;
  margin-right: 15px;

}
.manga-info {
  color: #fff;
  flex: 1;
}
.manga-info h3 {
  font-size: 1.2em;
  margin-bottom: 10px;
  text-align: left;
}
.manga-info p {
  font-size: 1em;
  color: #ccc;
  margin: 4px 0;
}
</style>

  <!-- Sidebar (Right Side) -->
  <div class="sidebar" id="sidebar">
    <a href="#">Profile</a>
    <a href="#">About Us</a>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
      <a href="adminPanel.php">Admin Panel</a>
    <?php endif; ?>
    <a href="logout.php" class="logout">Log Out</a>
  </div>

  <!-- Overlay -->
  <div class="overlay" id="overlay"></div>

  <div class="container">
    <div class="item header">
      <div id="logo"></div>
      <div class="search-bar">
        <input type="text" placeholder="Search...">
        <button><span class="material-symbols-outlined">search</span></button>
      </div>
      <button id="menuBtn"><span class="material-symbols-outlined">menu</span></button>
    </div>

    <div class="item carosel">
      <div class="slides">
        <img src="pictures/Best-Shonen-Mangas-Recommendations.jpg" alt="Slide 1">
        <img src="pictures/C20241210.webp" alt="Slide 2">
        <img src="pictures/123123.jpg" alt="Slide 3">
        <img src="pictures/3307142.jpg" alt="Slide 4">
        <img src="pictures/OIP.webp" alt="Slide 5">
        <img src="pictures/underrated-shounen-manga.avif" alt="Slide 6">
      </div>
    </div>

    <div class="item item3top">Latest Chapter</div>
    <div class="item recommendationsTop">Recommendations</div>

    <div class="item item3 latestMain">
        <div class="manga-grid">
          <?php
          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              $imagePath = $row['photo'];
              if (!str_starts_with($imagePath, 'uploads/')) {
                $imagePath = 'uploads/' . $imagePath;
              }

              // Safely escape quotes and newlines for JavaScript
              $safeTitle = addslashes($row['title']);
              $safeDescription = addslashes($row['description'] ?? '');
              $safeGenres = addslashes($row['genres']);
              $safeStatus = addslashes($row['status']);

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
                </div>
              ";
            }
          } else {
            echo "<p style='text-align:center;'>No manga found.</p>";
          }
          ?>
        </div>
    </div>

</body> 
</html>