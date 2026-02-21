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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MangaVerse Mobile</title>
        <link rel="stylesheet" href="css/MobileTop.css">
        <link rel="stylesheet" href="css/sidebar.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
        <link rel="icon" href="pictures/favicon.ico" type="image/x-icon">
        <script src="Scripts/sidebarScript.js" defer></script>
        
<style>
.Manga-background-picture {
    width: 100%;
    height: 220px;
    background-image: url('uploads/<?php echo htmlspecialchars($manga['photo']); ?>');
    background-size: cover;
    background-position:  25% 25%;
    background-repeat: no-repeat;
    position: relative;
}
.Manga-picture {
    position: relative;
    bottom: -6px;
    left: 10px;
    width: 120px;
    height: 200px;
    border-radius: 5px;
    background-image: url('uploads/<?php echo htmlspecialchars($manga['photo']); ?>');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    border: 2px solid #121212;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.7);
}
.title {
    /* position: absolute; */
    bottom: 20px;
    left: 100px;
    color: white;
    font-size: 24px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
    font-family: 'Istok Web', sans-serif;
    font-weight: 600;
}
.Manga-contents {
    /* grid-column: 1 / 7; */
    background-color: rgba(41, 41, 41, 1);
    height: auto;
    max-height: max-content;
}
.Genres-Status-top {
    font-family: 'Istok Web', sans-serif;
    font-weight: 600;
    font-size: 24px;
    color: white;
    padding: 10px;
    border-bottom: 2px solid #333;
    width: auto;
    background-color: rgba(239, 191, 4, 1);;
    margin-top: 5px;
    /* margin-left: 320px; */
    border-radius: 8px 8px 0px 0px ;
}
.Genres-Status-body {
    font-family: 'Istok Web', sans-serif;
    font-size: 18px;
    color: white;
    padding: 10px ;
    width: auto;
    background-color: rgba(64, 64, 64, 1);
    /* margin-left: 320px; */
    border-radius: 0px 0px 8px 8px ;
}
.discription-top {
    font-family: 'Istok Web', sans-serif;
    font-weight: 600;
    font-size: 24px;
    color: white;
    padding: 10px;
    border-bottom: 2px solid #333;
    width: auto;
    background-color: rgba(239, 191, 4, 1);;
    margin-top: 5px;
    /* margin-left: 320px; */
    border-radius: 8px 8px 0px 0px ;
}
.discription-main {
    font-family: 'Istok Web', sans-serif;
    font-size: 18px;
    color: white;
    padding: 10px ;
    width: auto;
    background-color: rgba(64, 64, 64, 1);
    /* margin-left: 320px; */
    border-radius: 0px 0px 8px 8px ;
}
.chapter-top {
    font-family: 'Istok Web', sans-serif;
    font-weight: 600;
    font-size: 24px;
    color: white;
    padding: 10px;
    border-bottom: 2px solid #333;
    width: auto;
    background-color: rgba(239, 191, 4, 1);
    margin-top: 5px;
    /* margin-left: 320px; */
    border-radius: 8px 8px 0px 0px ;
}
.chapter-main {
    font-family: 'Istok Web', sans-serif;
    font-size: 18px;
    color: white;
    padding: 5px ;
    width: auto;
    background-color: rgba(64, 64, 64, 1);
    /* margin-left: 320px; */
    margin-bottom: 5px;
    border-radius: 0px 0px 8px 8px ;
}
.bookmarkBtn {
    /* position: relative; */
    height: 40px;
    width: 150px;
    top: 450px;
    left: 152px;
    background-color: rgba(239, 191, 4, 1);
    border-radius: 5px;
    font-size: 17px;
    color: white;
    font-family: 'Istok Web', sans-serif;
    font-weight: bold;
    border: none;
    cursor: pointer;
    margin-top: 5px;
}
.bookmarkBtn:hover {
    background-color: rgba(161, 129, 0, 1);
}
footer {
    /* margin: 5px 5px 10px 5px; */
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
    <div class="Manga-background-picture">
        <div class="Manga-picture"></div>
        
    </div>
<button class="bookmarkBtn admin"><span class="material-symbols-outlined ">bookmark_add</span>Bookmark</button>
    <div class="Manga-contents">

        <div class="Genres-Status-top">Title</div>
        <div class="Genres-Status-body">
            <h1 class="title"><?php echo htmlspecialchars($manga['title']); ?></h1>
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