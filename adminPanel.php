<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
  header("Location: mrHakermen.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>adminPanel</title>
      <link rel="icon" href="pictures/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/aPanel.css">
    <script src="Scripts/sidebarScript.js" defer></script>
</head>
<body>

<div class="aPanel">

    <div class="panel aTop">
        <div id="mangaverse">Welcome to Manga<span id="verse">Verse</span> admin panel</div>
        <button id="menuBtn"><span class="material-symbols-outlined">menu</span></button>
    </div>

    <div class="panel aSide">
        <button disabled="disabled">Admin Panel</button> <br>
        <button onclick="window.location.href='addManga.php';">Add Manga</button> <br>
        <button onclick="window.location.href='addChapter.php';">Add Chapter</button> <br>
        <button onclick="window.location.href='deleteChapter.php';">Delete Chapter</button> <br>
        <button onclick="window.location.href='editManga.php';">Edit Manga</button> <br>
        <button onclick="window.location.href='deleteManga.php';">Delete Manga</button>
    </div>
    <div class="panel aMain">
        <div class="mTop mmm">Admin Panel</div>
        <div class="mMain"> </div>
    </div>
     

</div>
        <!-- Sidebar (Right Side) -->
        <div class="sidebar" id="sidebar">
            <a href="profile.php" class="admin"> <span class="material-symbols-outlined Sicons">account_circle</span> Profile</a>
            <a href="index.php" class="admin"><span class="material-symbols-outlined">home</span>Home</a>
            <a href="bookmark.php" class="admin"> <span class="material-symbols-outlined Sicons">bookmark</span> Bookmark</a>
            <a href="#" class="admin" > <span class="material-symbols-outlined Sicons">info</span> About Us</a>
            <a href="logout.php" class="logout"> <span class="material-symbols-outlined Sicons">logout</span><span class="lgout">Log Out</span></a>
        </div>
        <!-- Overlay -->
        <div class="overlay" id="overlay"></div>

</body>
</html>