<?php
session_start();
include 'db.php';
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
}

if (!isset($_GET['id'])) {
  echo "No chapter ID provided.";
  exit();
}

$chapter_id = (int)$_GET['id'];
$sql = "SELECT * FROM chapters WHERE id = $chapter_id";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
  echo "Chapter not found.";
  exit();
}

$chapter = $result->fetch_assoc();

// Get manga info for this chapter
$manga_sql = "SELECT title FROM manga WHERE id = {$chapter['manga_id']} LIMIT 1";
$manga_result = $conn->query($manga_sql);
$manga = $manga_result->num_rows ? $manga_result->fetch_assoc() : null;


// Find previous chapter
$prev_sql = "SELECT id FROM chapters WHERE manga_id = {$chapter['manga_id']} AND chapter_number < {$chapter['chapter_number']} ORDER BY chapter_number DESC LIMIT 1";
$prev_result = $conn->query($prev_sql);
$prev_chapter = $prev_result->num_rows ? $prev_result->fetch_assoc()['id'] : null;

// Find next chapter
$next_sql = "SELECT id FROM chapters WHERE manga_id = {$chapter['manga_id']} AND chapter_number > {$chapter['chapter_number']} ORDER BY chapter_number ASC LIMIT 1";
$next_result = $conn->query($next_sql);
$next_chapter = $next_result->num_rows ? $next_result->fetch_assoc()['id'] : null;

// ✅ Load images from folder
$folder = 'chapters/manga_' . $chapter['manga_id'] . '/chapter_' . $chapter['chapter_number'];
$images = glob($folder . '/*.{jpg,jpeg,png,webp}', GLOB_BRACE);

// Sort numerically by filename
usort($images, function($a, $b) {
  return (int)preg_replace('/\D/', '', basename($a)) <=> (int)preg_replace('/\D/', '', basename($b));
});

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
<html>
<head>
  <meta charset="UTF-8">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <script src="Scripts/sidebarScript.js" defer></script>
  <title> <?= htmlspecialchars($manga['title']) ?>  Chapter <?= $chapter['chapter_number'] ?>  <?= htmlspecialchars($chapter['chapter_title']) ?></title>
  <style>
body {
  background-color: rgba(41, 41, 41, 1);
  color: #fff;
  font-family: 'Istok Web', sans-serif;
  text-align: center;
}
.chapter-image {
  width: 100%;
  max-width: 900px;
  margin:  auto;
  display: block;
  box-shadow: 0 0 10px rgba(255,255,255,0.1);
}
.chapter-nav {
  margin: 0px 0px 40px 0px;
  text-align: center;
}

.nav-link {
  display: inline-block;
  margin: 0px;
  padding: 10px 20px;
  background-color: rgba(19, 18, 18, 1);
  color: #ffffffff;
  border-radius: 5px;
  text-decoration: none;
  font-weight: bold;
  transition: background-color 0.3s ease;
}
.back{
  margin-top: 20px;
}
.nav-link:hover {
  background-color: rgba(239, 191, 4, 1);
  color: #ffffff;
}
.nChap {
  text-align: center;
  background-color: rgba(19, 18, 18, 1);
  padding: 10px 20px;
  width: 10px;
  display: inline-block;
  border-radius: 5px;
  text-decoration: none;
  font-weight: bold;
    }
  </style>
</head>
<body>

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

<div class="item header">
  <a href="index.php"><div id="logo"></div></a>
    <form method="GET" action="search.php" class="search-bar">
        <input type="text" name="search" placeholder="Search...">
        <button type="submit"><span class="material-symbols-outlined">search</span></button>
    </form>
  <button id="menuBtn"><span class="material-symbols-outlined">menu</span></button>
</div>
 
  <h1>Chapter <?= $chapter['chapter_number'] ?> <?= htmlspecialchars($chapter['chapter_title']) ?></h1>
  <a href="manga.php?id=<?= $chapter['manga_id'] ?>" class="nav-link back">
  <?= htmlspecialchars($manga['title']) ?>
  </a>

  <div class="chapter-nav">
  <?php if ($prev_chapter): ?>
    <a href="chapter.php?id=<?= $prev_chapter ?>" class="nav-link prev">&laquo; Prev Chapter</a>
  <?php endif; ?>

  <p class="nChap"><?= $chapter['chapter_number'] ?></p>

  <?php if ($next_chapter): ?>
    <a href="chapter.php?id=<?= $next_chapter ?>" class="nav-link next">Next Chapter &raquo;</a>
  <?php endif; ?>
</div>
  <?php
  if ($images) {
    foreach ($images as $img) {
      echo "<img src='$img' class='chapter-image'>";
    }
  } else {
    echo "<p>No images found for this chapter.</p>";
  }
  ?>
  
  <a href="manga.php?id=<?= $chapter['manga_id'] ?>" class="nav-link back">
  <?= htmlspecialchars($manga['title']) ?>
  </a>
  
<div class="chapter-nav">
  <?php if ($prev_chapter): ?>
    <a href="chapter.php?id=<?= $prev_chapter ?>" class="nav-link prev">&laquo; Prev Chapter</a>
  <?php endif; ?>

  <p class="nChap"><?= $chapter['chapter_number'] ?></p>

  <?php if ($next_chapter): ?>
    <a href="chapter.php?id=<?= $next_chapter ?>" class="nav-link next">Next Chapter &raquo;</a>
  <?php endif; ?>
</div>
</body>
</html>