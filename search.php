<?php

session_start();

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
}

include 'db.php';

$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$limit = 8;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$whereClause = '';
if (!empty($search)) {
  $whereClause = "WHERE title LIKE '%$search%' OR genres LIKE '%$search%' OR description LIKE '%$search%'";
}

$sql = "SELECT * FROM manga $whereClause ORDER BY date_added DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="icon" href="pictures/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <script src="Scripts/sidebarScript.js" defer></script>
</head>
<body>
    
<style>
body{
    background-color: rgba(41, 41, 41, 1);
}
.searchTop{
    width: auto;
    height: 65px;
    background-color: rgba(239, 191, 4, 1);
    display: flex;
    align-items: center;
    padding-left: 20px;
    font-size: 24px;
    color: white;
    font-family: 'Istok Web', sans-serif;
    font-weight: bold;
}

.manga-grid {
  display: grid;
  grid-template-columns: repeat(1, minmax(280px, 1fr));
  gap: 15px;
  font-family: 'Istok Web', sans-serif;
  margin-top: 15px;
  margin-bottom: 15px;
  margin-left: 5px;
  margin-right: 5px;
}
/* .searchMain {
    padding: 15px;
} */
.manga-card {
  background-color: #1e1e1e;
  border-radius: 6px;
  overflow: hidden;
  box-shadow: 0 0 8px rgba(0,0,0,0.4);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  border: 1px solid #333;
  color: #fff;
}

.manga-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 0 12px rgba(255, 221, 0, 0.3);
}

.manga-content {
  display: flex;
  padding: 10px;
  height: 170px;
}

.manga-content img {
  width: 115px;
  height: 165px;
  object-fit: cover;
  border-radius: 4px;
  margin-right: 15px;
}

.manga-info {
  flex: 1;
  display: flex;
  flex-direction: column;
  /* justify-content: space-between; */
}

.manga-info h3 {
  font-size: 1.1em;
  margin: 0 0 10px;
  color: #ffcc00;
}

.manga-info p {
  font-size: 0.95em;
  margin: 3px 0;
  color: #ccc;
}

.pagination {
  text-align: center;
  margin: 5px 0;
}

.pagination a {
  display: inline-block;
  background-color: #ffcc00;
  color: #000;
  padding: 6px 12px;
  margin: 0 5px;
  border-radius: 6px;
  font-weight: bold;
  text-decoration: none;
  transition: background 0.3s;
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
</style>

<div class="item header">
    <a href="index.php"><div id="logo"></div></a>
      <form method="GET" action="search.php" class="search-bar">
          <input type="text" name="search" placeholder="Search...">
          <button type="submit"><span class="material-symbols-outlined">search</span></button>
      </form>
    <button id="menuBtn"><span class="material-symbols-outlined">menu</span></button>
</div>

<div class="searchTop">
    Search Results for :<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>
</div>

<div class="SearchMain">
  <div class="manga-grid">
    <?php
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $imagePath = $row['photo'];
        if (!str_starts_with($imagePath, 'uploads/')) {
          $imagePath = 'uploads/' . $imagePath;
        }

        echo "
          <a href='manga.php?id=" . $row['id'] . "' style='text-decoration:none; color:inherit;'>
            <div class='manga-card'>
              <div class='manga-content'>
                <img src='" . htmlspecialchars($imagePath) . "' alt='" . htmlspecialchars($row['title']) . "'>
                <div class='manga-info'>
                  <h3>" . htmlspecialchars($row['title']) . "</h3>
                  <p><b>Tags:</b> " . htmlspecialchars($row['genres']) . "</p>
                  <p><b>Status:</b> " . htmlspecialchars($row['status']) . "</p>
                  <p><b>Description:</b> " . htmlspecialchars($row['description']) . "</p>
                </div>
              </div>
            </div>
          </a>
        ";
      }
    } else {
      echo "<p style='text-align:center; color:white;'>No results found for '<b>" . htmlspecialchars($search) . "</b>'.</p>";
    }
    ?>
  </div>
</div>

<div class="item item5">
                    <!-- PAGINATION -->
    <div class="pagination">
        <?php
            // Count total filtered results
            $count_sql = "SELECT COUNT(*) AS total FROM manga $whereClause";
            $count_result = $conn->query($count_sql);
            $count_row = $count_result->fetch_assoc();
            $total_records = $count_row['total'];
            $total_pages = ceil($total_records / $limit);

            // Preserve search term in pagination links
            $searchParam = !empty($search) ? '&search=' . urlencode($search) : '';

            if ($page > 1) {
            echo '<a href="?page=' . ($page - 1) . $searchParam . '">&laquo; Prev</a>';
            } else {
            echo '<a class="disabled">&laquo; Prev</a>';
            }

            for ($i = 1; $i <= $total_pages; $i++) {
            $active = ($i == $page) ? 'active' : '';
            echo '<a href="?page=' . $i . $searchParam . '" class="' . $active . '">' . $i . '</a>';
            }

            if ($page < $total_pages) {
            echo '<a href="?page=' . ($page + 1) . $searchParam . '">Next &raquo;</a>';
            } else {
            echo '<a class="disabled">Next &raquo;</a>';
            }
        ?>
    </div>
</div>

    <!-- Sidebar (Right Side) -->
<div class="sidebar" id="sidebar">
<a href="profile.php">Profile</a>
<a href="#">About Us</a>
<?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <a href="adminPanel.php">Admin Panel</a>
<?php endif; ?>
<a href="logout.php" class="logout">Log Out</a>
</div>
    <!-- Overlay -->
<div class="overlay" id="overlay"></div>

</body>
</html>