<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
}

include 'db.php';

$manga_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$sql = "SELECT * FROM manga WHERE id = $manga_id";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
  echo "Manga not found.";
  exit();
}

$manga = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($manga['title']); ?></title>
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
      <script src="Scripts/sidebarScript.js" defer></script>
</head>
<body>

<style>
.Manga-background-picture {
  grid-column: 1 / 7;
  width: 100%;
  height: 300px;
  background-image: url('uploads/<?php echo htmlspecialchars($manga['photo']); ?>');
  background-size: cover;
  background-position:  25% 25%;
  background-repeat: no-repeat;
  position: relative;
}
.Manga-picture {
    position: absolute;
    bottom: -140px;
    left: 100px;
    width: 200px;
    height: 300px;
    background-image: url('uploads/<?php echo htmlspecialchars($manga['photo']); ?>');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    border: 2px solid #121212;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.7);
}
.title {
    position: absolute;
    bottom: 20px;
    left: 320px;
    color: white;
    font-size: 36px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
    font-family: 'Istok Web', sans-serif;
    font-weight: 600;
}
.Manga-contents {
    grid-column: 1 / 7;
    background-color: rgba(41, 41, 41, 1);
    height: 650px;
    max-height: max-content;
}
.Genres-Status-top {
    font-family: 'Istok Web', sans-serif;
    font-weight: 600;
    font-size: 24px;
    color: white;
    padding: 10px;
    border-bottom: 2px solid #333;
    width: 1050px;
    background-color: rgba(239, 191, 4, 1);;
    margin-top: 15px;
    margin-left: 320px;
    border-radius: 8px 8px 0px 0px ;
}
.Genres-Status-body {
    font-family: 'Istok Web', sans-serif;
    font-size: 18px;
    color: white;
    padding: 10px ;
    width: 1050px;
    background-color: rgba(64, 64, 64, 1);
    margin-left: 320px;
    border-radius: 0px 0px 8px 8px ;
}
.discription-top {
    font-family: 'Istok Web', sans-serif;
    font-weight: 600;
    font-size: 24px;
    color: white;
    padding: 10px;
    border-bottom: 2px solid #333;
    width: 1050px;
    background-color: rgba(239, 191, 4, 1);;
    margin-top: 15px;
    margin-left: 320px;
    border-radius: 8px 8px 0px 0px ;
}
.discription-main {
    font-family: 'Istok Web', sans-serif;
    font-size: 18px;
    color: white;
    padding: 10px ;
    width: 1050px;
    background-color: rgba(64, 64, 64, 1);
    margin-left: 320px;
    border-radius: 0px 0px 8px 8px ;
}
.chapter-top {
    font-family: 'Istok Web', sans-serif;
    font-weight: 600;
    font-size: 24px;
    color: white;
    padding: 10px;
    border-bottom: 2px solid #333;
    width: 1050px;
    background-color: rgba(239, 191, 4, 1);;
    margin-top: 15px;
    margin-left: 320px;
    border-radius: 8px 8px 0px 0px ;
}
.chapter-main {
    font-family: 'Istok Web', sans-serif;
    font-size: 18px;
    color: white;
    padding: 10px ;
    width: 1050px;
    background-color: rgba(64, 64, 64, 1);
    margin-left: 320px;
    margin-bottom: 15px;
    border-radius: 0px 0px 8px 8px ;
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
      <a href="index.php"><div id="logo"></div></a>
        <form method="GET" action="search.php" class="search-bar">
          <input type="text" name="search" placeholder="Search...">
          <button type="submit"><span class="material-symbols-outlined">search</span></button>
        </form>
      <button id="menuBtn"><span class="material-symbols-outlined">menu</span></button>
  </div>

    <div class="Manga-background-picture">
        <div class="Manga-picture"></div>
        <h1 class="title"><?php echo htmlspecialchars($manga['title']); ?></h1>
    </div>

    <div class="Manga-contents">

        <div class="Genres-Status-top">Genres & Status</div>
        <div class="Genres-Status-body">
            <p><strong>Genres:</strong> <?php echo htmlspecialchars($manga['genres']); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($manga['status']); ?></p>
        </div>
        
        <div class="discription-top">Description</div>
        <div class="discription-main">
            <p><?php echo nl2br(htmlspecialchars($manga['description'])); ?></p>
        </div>

        <div class="chapter-top">Chapter</div>
        <div class="chapter-main">
            <?php
            $chapters_sql = "SELECT * FROM chapters WHERE manga_id = $manga_id ORDER BY chapter_number ASC";
            $chapters_result = $conn->query($chapters_sql);

            if ($chapters_result->num_rows > 0) {
                echo "<ul style='list-style:none; padding:0;'>";
                while ($chapter = $chapters_result->fetch_assoc()) {
                echo "<li style='margin-bottom:10px;'>
                        <a href='chapter.php?id=" . $chapter['id'] . "' 
                            style='color:#ffcc00; text-decoration:none; font-weight:bold;'>
                            Chapter " . $chapter['chapter_number'] . ": " . htmlspecialchars($chapter['chapter_title']) . "
                        </a>
                        </li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No chapters available yet.</p>";
            }
            ?>
        </div>

    </div>

</body>
</html>