<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>adminPanel</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="sidebar.css">
    <link rel="stylesheet" href="aPanel.css">
    <script src="sidebarScript.js" defer></script>
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
    </div>
     

</div>
                <!-- Sidebar (Right Side) -->
                <div class="sidebar" id="sidebar">
                    <a href="#">Profile</a>
                    <a href="#">About Us</a>
                    <a href="#" class="logout">Log Out</a>
                </div>

                <!-- Overlay -->
                <div class="overlay" id="overlay"></div>
</body>
</html>