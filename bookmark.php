<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookmark</title>
      <link rel="icon" href="pictures/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/sidebar.css">
      <script src="Scripts/sidebarScript.js" defer></script>
          <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
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
    width: 888px;
    height:57px;
    background-color: rgba(239, 191, 4, 1);
    display: flex;
    align-items: center;
    align-self: center;
    padding-left: 10px;
        margin-top: 10px;
}
.bookmarkMain{
    width: 888px;
    height:900px;
    background-color: rgba(31, 31, 31, 1);
    padding-left: 10px;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
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

    <div class="bookmarkContainer">
        <div class="bookmarkTop bookmark"><span class="asd">Bookmarks</span></div>
        <div class="bookmarkMain bookmark">
          
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