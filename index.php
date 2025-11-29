<?php

session_start();

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
}

include 'db.php';

// ---------- FETCH RECOMMENDATIONS ----------
$rec_sql = "SELECT * FROM manga ORDER BY RAND() LIMIT 8"; // 6 random recommendations
$rec_result = $conn->query($rec_sql);

// $rec_sql = "SELECT * FROM manga WHERE id IN (2,5,7)"; // specific recommendations
// $rec_result = $conn->query($rec_sql);

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
  <link rel="stylesheet" href="css/home.css">
  <link rel="stylesheet" href="css/sidebar.css">
  <title>Home</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
  <script src="Scripts/caroselScript.js" defer></script>
  <script src="Scripts/sidebarScript.js" defer></script>

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

/* pagination */
.pagination {
    text-align: center;
    /* margin: 5px 0; */
      font-family: 'Istok Web', sans-serif;
}

.pagination a {
    display: inline-block;
    background-color: #ffcc00;
    color: #000;
    padding: 6px 11px;
    margin: 0 5px;
    border-radius: 6px;
    font-weight: bold;
    text-decoration: none;
    transition: background 0.3s;
    margin-top: 5px;
}

.pagination a:hover {
    background-color: #ffdb4d;
}

.pagination a.active {
    background-color: #000;
    color: #fff;
}

.pagination a.disabled {
    background-color: #ccc;
    color: #666;
    pointer-events: none;
}

.recommendations-grid {
  display: grid;
  position: relative;
  grid-template-columns: repeat(2, 0fr); /* 3 per row */
  gap: 8px;
  background-color: rgba(64, 64, 64, 1);
  padding-top: 10px;
  width: 210px;
  left: 9px;
}

.recommend-card {
  background-color: rgba(0,0,0,0.5);
  border-radius: 6px;
  text-align: center;
  padding: 7px;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  height: 205px;
}

.recommend-card:hover {
  transform: scale(1.05);
  box-shadow: 0 0 10px rgba(255, 221, 0, 0.4);
}

.recommend-card img {
  width: 120px;
  height: 150px;
  object-fit: cover;
  border-radius: 4px;
}

.recommend-title {
  margin-top: 3px;
  font-size: 12px;
  color: #ffffffff; /* yellow accent */
  font-family: 'Istok Web', sans-serif;
}
</style>

  <!-- Sidebar (Right Side) -->
  <div class="sidebar" id="sidebar">
    <a href="profile.php" class="admin"> <span class="material-symbols-outlined Sicons">account_circle</span> Profile</a>
    <a href="#" class="admin" > <span class="material-symbols-outlined Sicons">info</span> About Us</a>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
      <a href="adminPanel.php" class="admin"> <span class="material-symbols-outlined Sicons">admin_panel_settings</span> Admin Panel</a>
    <?php endif; ?>
    <a href="logout.php" class="logout"> <span class="material-symbols-outlined Sicons">logout</span><span class="lgout">Log Out</span></a>
  </div>

  <!-- Overlay -->
  <div class="overlay" id="overlay"></div>

  <div class="container">
    <div class="item header">
      <a href="index.php"><div id="logo"></div></a>
        <form method="GET" action="search.php" class="search-bar">
          <input type="text" name="search" placeholder="Search...">
          <button type="submit"><span class="material-symbols-outlined">search</span></button>
        </form>
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
                <a href='gago.php?id=" . $row['id'] . "' style='text-decoration:none; color:inherit;'>
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
      <div class="item item4">
        <div class="recommendations-grid">
          <?php
          if ($rec_result->num_rows > 0) {
            while($row = $rec_result->fetch_assoc()) {
              $imagePath = $row['photo'];
              if (!str_starts_with($imagePath, 'uploads/')) {
                $imagePath = 'uploads/' . $imagePath;
              }

              echo "
                <a href='gago.php?id=" . $row['id'] . "' style='text-decoration:none; color:inherit;'>
                  <div class='recommend-card'>
                    <img src='" . htmlspecialchars($imagePath) . "' alt='" . htmlspecialchars($row['title']) . "'>
                    <h4 class='recommend-title'>" . htmlspecialchars($row['title']) . "</h4>
                  </div>
                </a>
              ";
            }
          } else {
            echo "<p style='text-align:center;'>No recommendations available.</p>";
          }
          ?>
        </div>
</div>


        <div class="item item5">
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
        <div class="item item6"> </div>

</body> 
</html>