<?php

session_start();

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
}

include 'db.php';

// ---------- FETCH RECOMMENDATIONS ----------
// $rec_sql = "SELECT * FROM manga ORDER BY RAND() LIMIT 8"; // 6 random recommendations
// $rec_result = $conn->query($rec_sql);

$rec_sql = "SELECT * FROM manga WHERE id IN (12,11,1,8,7,19,17,14)"; // specific recommendations
$rec_result = $conn->query($rec_sql);

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

// ---------- FETCH MANGA DATA WITH CHAPTER COUNT ----------
$sql = "
  SELECT m.*, 
         (SELECT COUNT(*) FROM chapters c WHERE c.manga_id = m.id) AS chapter_count
  FROM manga m
  ORDER BY date_added DESC
  LIMIT $limit OFFSET $offset
";
$result = $conn->query($sql);

// ---------- FETCH MANGA DATA WITH CHAPTER COUNT AND LAST UPDATE ----------
$sql = "
  SELECT m.*, 
         (SELECT COUNT(*) FROM chapters c WHERE c.manga_id = m.id) AS chapter_count,
         COALESCE((SELECT MAX(c.date_added) FROM chapters c WHERE c.manga_id = m.id), m.date_added) AS last_update
  FROM manga m
  ORDER BY last_update DESC
  LIMIT $limit OFFSET $offset
";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookmark</title>
        <link rel="stylesheet" href="css/MobileTop.css">
        <link rel="stylesheet" href="css/sidebar.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
        <link rel="icon" href="pictures/favicon.ico" type="image/x-icon">
        <script src="Scripts/sidebarScript.js" defer></script>
</head>
<body>
<style>
body {
background-color: rgba(41, 41, 41, 1);
}
.bookmarkContainer{
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}
.bookmark{
    color: white;
    font-family: 'Istok Web', sans-serif;
    font-weight: bold;
    font-size: 20px;

}
.bookmarkTop{
    height:57px;
    background-color: rgba(239, 191, 4, 1);
    display: flex;
    align-items: center;
    align-self: center;
    padding-left: 10px;
    margin: 10px 10px 0px 10px;
    border-radius: 5px 5px 0px 0px;
}
.bookmarkMain{
    height:900px;
    max-height: 800px;
    background-color: rgba(31, 31, 31, 1);
    padding-left: 10px;
    display: flex;
    margin: 0px 10px 0px 10px;
}
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
  border-radius:9px;
  box-shadow: 0 0 6px rgba(0,0,0,0.5);
  overflow: hidden;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  border: 1px solid #333;
  font-family: 'Istok Web', sans-serif;
  /* font-weight: bold; */
}
.manga-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 0 12px rgba(255, 221, 0, 0.3);
}
.manga-content {
  display: flex;
  align-items: flex-start;
  padding: 5px;
  height: 165px;
}
.manga-content img {
  width: 115px;
  height: 165px;
  object-fit: cover;
  /* margin-top: 5px;
  margin-left: 5px; */
  border-radius: 5px;
  margin-right: 15px;

}
.manga-info {
  color: #fff;
  flex: 1;
}
.manga-info h3 {
  font-size: 1.1em;
  margin-bottom: 10px;
  text-align: left;
}
.manga-info p {
  font-size: 1em;
  color: #ccc;
  margin: 2px 0;
}
</style>

    <div class="item header">
      <a href="index.php"><div id="logo"></div></a>
        <form method="GET" action="search.php" class="search-bar">
          <input type="text" name="search" placeholder="Search...">
          <button type="submit"><span class="material-symbols-outlined">search</span></button>
        </form>
      <button id="menuBtn"><span class="material-symbols-outlined">menu</span></button>
    </div>

        <div class="bookmarkTop bookmark">Bookmark</div>
        <div class="bookmarkMain bookmark">
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
                  <a href='mangaMobile.php?id=" . $row['id'] . "' style='text-decoration:none; color:inherit;'>
                    <div class='manga-card'>
                      <div class='manga-content '>
                        <img src='" . htmlspecialchars($imagePath) . "' alt='" . htmlspecialchars($row['title']) . "'>
                        <div class='manga-info'>
                          <h3>" . htmlspecialchars($row['title']) . "</h3>
                          <p><b>Tags:</b> " . htmlspecialchars($row['genres']) . "</p>
                          <p><b>Status:</b> " . htmlspecialchars($row['status']) . "</p>
                          <p><b>Chapters:</b> " . $row['chapter_count'] . "</p>
                        </div>
                      </div>
                    </div>
                  </a>
                ";
              }
            } else {
              echo "<p style='text-align:center;'>No manga found.</p>";
            }
            ?>
          </div>
        </div>
  <!-- Sidebar (Right Side) -->
  <div class="sidebar" id="sidebar">
    <a href="profile.php" class="admin"> <span class="material-symbols-outlined Sicons">account_circle</span> Profile</a>
    <a href="bookmark.php" class="admin"> <span class="material-symbols-outlined Sicons">bookmark</span> Bookmark</a>
    <a href="#" class="admin" > <span class="material-symbols-outlined Sicons">info</span> About Us</a>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
      <a href="adminPanel.php" class="admin"> <span class="material-symbols-outlined Sicons">admin_panel_settings</span> Admin Panel</a>
    <?php endif; ?>
    <a href="logout.php" class="logout"> <span class="material-symbols-outlined Sicons">logout</span><span class="lgout">Log Out</span></a>
  </div>

  <!-- Overlay -->
  <div class="overlay" id="overlay"></div>
  
</body>
</html>