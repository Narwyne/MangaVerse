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

$rec_sql = "SELECT * FROM manga WHERE id IN (12,11,1,8,7,19)"; // specific recommendations
$rec_result = $conn->query($rec_sql);

// ---------- PAGINATION SETUP ----------
$limit = 10; // 3x5 layout = 15 cards per page
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
    <title>Mobile View</title>
        <link rel="stylesheet" href="css/MobileTop.css">
        <link rel="stylesheet" href="css/sidebar.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
        <link rel="icon" href="pictures/favicon.ico" type="image/x-icon">
        <script src="Scripts/sidebarScript.js" defer></script>
<style>
.recommendationsTop {
    margin: 10px 5px 0px 5px;
    background-color: #efbf04;
    max-width: 100%;
    height: 40px;
    color: #ffffff;
    font-size: 20px;
    border-radius: 5px 5px 0px 0px;
}
.recommendations {
    margin: 0px 5px 0px 5px;
    background-color: #4a4a4a;
    max-width: 100%;
    height: auto;
    display: grid;
    position: relative;
    justify-content: center;
    grid-template-columns: repeat(3, 0fr);
    background-color: rgba(64, 64, 64, 1);
    gap: 4px;
    padding: 8px;
}
.recommendationsBot {
    margin: 0px 5px 0px 5px;
    background-color: rgba(0,0,0,0.5);
    max-width: 100%;
    height: 40px;
    color: #ffffff;
    font-size: 20px;
    border-radius: 0px 0px 5px 5px;
}
.letters{
    font-family: 'Istok Web', sans-serif;
    font-weight: bold;
    color: whitesmoke;
}
.rec{
    position: relative;
    top: 7px;
    left: 5px;
}
.recommendations-grid {
  display: grid;
  position: relative;
  grid-template-columns: repeat(3, 0fr); /* 3 per row */
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
  height: 190px;
}

.recommend-card:hover {
  transform: scale(1.05);
  box-shadow: 0 0 10px rgba(255, 221, 0, 0.4);
}

.recommend-card img {
  width: 115px;
  height: 145px;
  object-fit: cover;
  border-radius: 4px;
}

.recommend-title {
  margin-top: 3px;
  font-size: 12px;
  color: #ffffffff; /* yellow accent */
  font-family: 'Istok Web', sans-serif;
}
.mainTop {
    margin: 10px 5px 0px 5px;
    background-color: #efbf04;
    max-width: 100%;
    height: 40px;
    color: #ffffff;
    font-size: 20px;
    border-radius: 5px 5px 0px 0px;
}
.mainBot {
    margin: 0px 5px 0px 5px;
    background-color: rgba(0,0,0,0.5);
    max-width: 100%;
    height: 40px;
    color: #ffffff;
    font-size: 20px;
    border-radius: 0px 0px 5px 5px;
}
/* asdadsasdasdasdasdadasdasdasdasdasds */

.manga-grid {
  display: grid;
  grid-template-columns: repeat(1, 2fr);
  grid-template-rows: repeat(1, auto);
  gap: 5px;
  padding-top: 7px;
  padding-left: 5px;
  padding-right: 5px;
  background-color: rgba(64, 64, 64, 1);
  margin: 0px 5px 0px 5px;
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
  padding: 4px;
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
    padding: 0px 10px;
    margin: 0 5px;
    border-radius: 6px;
    font-weight: bold;
    text-decoration: none;
    transition: background 0.3s;
    margin-top: 0px;
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
    color: #667;
    pointer-events: none;
}
footer {
    margin: 5px 5px 10px 5px; /* Matches the margin of your other sections */
    border-radius: 5px;
    border-top: 1px solid #333; /* Subtle line to separate from content */
}
</style>
    
</head>
<body>
    <div class="container">
        <div class="black header">
            <a href="index.php"><div id="logo"></div></a>
                <form method="GET" action="search.php" class="search-bar">
                <input type="text" name="search" placeholder="Search...">
                <button type="submit"><span class="material-symbols-outlined">search</span></button>
                </form>
            <button id="menuBtn"><span class="material-symbols-outlined">menu</span></button>
        </div>
    </div>
<div class="letters recommendationsTop"><span class="rec">Recommendations</span></div>

<span class="recommendations"> 
    <?php
        if ($rec_result->num_rows > 0) {
        while($row = $rec_result->fetch_assoc()) {
            $imagePath = $row['photo'];
            if (!str_starts_with($imagePath, 'uploads/')) {
            $imagePath = 'uploads/' . $imagePath;
            }

            echo "
            <a href='manga.php?id=" . $row['id'] . "' style='text-decoration:none; color:inherit;'>
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
</span>
<div class="letters recommendationsBot"><span class="rec"></span></div> 


<div class="letters mainTop"><span class="rec">Latest Update</span></div>
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
        <a href='manga.php?id=" . $row['id'] . "' style='text-decoration:none; color:inherit;'>
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
<div class="letters mainBot"><span class="rec">            
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
        </div></span>
    </div> 

    <footer style="text-align: center; padding: 15px; background-color: #131212; color: #ccc; font-family: 'Istok Web', sans-serif; font-size: 13px;">
        <p>&copy; <?php echo date("Y"); ?> MangaVerse. All rights reserved.</p>
    </footer>

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