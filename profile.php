<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Fetch user + profile info
$sql = "SELECT u.username, p.nickname, p.profile_pic, p.background_pic
        FROM users u
        LEFT JOIN profile p ON u.id = p.user_id
        WHERE u.username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$profile = $result->fetch_assoc();

// Defaults if empty
$nickname = !empty($profile['nickname']) ? $profile['nickname'] : $profile['username'];
$profilePic = !empty($profile['profile_pic']) ? $profile['profile_pic'] : "uploads/default.png";
$backgroundPic = !empty($profile['background_pic']) ? $profile['background_pic'] : "uploads/default_bg.png";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/profile.css">
      <script src="Scripts/sidebarScript.js" defer></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
</head>
<body>
<style>
.container{
    background-color: rgba(41, 41, 41, 1);
    /* text-align: center;     */
}
#logo{
    height: 48px;
    width: 200px;
    background-image: url(pictures/MangaVerse.png);
    background-size: 200px;
    background-repeat: no-repeat;
    background-position: center;
    margin-left: 10px;
    justify-content: flex-start;
    margin-top: 10px;
}
.header{
    /* header */
    grid-column: 1 / 7;
    height: 60px;
    background-color: rgba(19, 18, 18, 1);
    display: flex;
    justify-content: space-between;
}
.header button {
  width: 43px;
  height: 43px;
  border: none;
  background: none;
  color: white;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
}
.header button:hover {
  background-color: rgba(239, 191, 4, 1);
  border-radius: 5px;
}
.material-symbols-outlined {
  font-size: 28px;
}
#menuBtn{
  margin-top: 9px;
  margin-right: 9px;
}
.search-bar {
  display: flex;
  align-items: center;
  background-color: #4a4a4a; /* dark gray */
  border-radius: 10px;
  overflow: hidden;
  width: 550px; /* adjust width as you like */
  height: 40px;
  position: relative;
  right: 30px;
  margin-top: 9px;
}

.search-bar input {
  flex: 1;
  border: none;
  background: transparent;
  color: white;
  padding: 0 10px;
  outline: none;
  font-size: 16px;
}

.search-bar button {
  background-color: #efbf04; /* yellow */
  border: none;
  width: 45px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
}

.search-bar button:hover {
  background-color: #d4a703; /* darker yellow on hover */
}

.search-bar .material-symbols-outlined {
  color: #4a4a4a;
  font-size: 24px;
}
.material-symbols-outlined {
  font-variation-settings:
  'FILL' 1,
  'wght' 700,
  'GRAD' 200,
  'opsz' 48
}    
</style>
<div class="container">
    <div class="item header">
      <a href="index.php"><div id="logo"></div></a>
        <form method="GET" action="search.php" class="search-bar">
          <input type="text" name="search" placeholder="Search...">
          <button type="submit"><span class="material-symbols-outlined">search</span></button>
        </form>
      <button id="menuBtn"><span class="material-symbols-outlined">menu</span></button>
    </div>

    <div class="profile-header" style="background-image:url('<?php echo htmlspecialchars($backgroundPic); ?>');">
        <div class="overlay"></div>
        <div class="profile-info">
            <img src="<?php echo htmlspecialchars($profilePic); ?>" alt="Profile Picture" class="profile-pic">
            <h1><?php echo htmlspecialchars($nickname); ?></h1>
            <p>@<?php echo htmlspecialchars($profile['username']); ?></p>
        </div>
    </div>

    <div class="profile-actions">
        <form action="uploadProfilePic.php" method="POST" enctype="multipart/form-data">
            <label>Change Profile Picture:</label>
            <input type="file" name="profile_pic" accept="image/*" required>
            <button type="submit">Upload</button>
        </form>

        <form action="uploadBackgroundPic.php" method="POST" enctype="multipart/form-data">
            <label>Change Background Picture:</label>
            <input type="file" name="background_pic" accept="image/*" required>
            <button type="submit">Upload</button>
        </form>

        <form action="updateNickname.php" method="POST">
            <label>Change Nickname:</label>
            <input type="text" name="nickname" placeholder="Enter new nickname">
            <button type="submit">Save</button>
        </form>
    </div>

  <!-- Sidebar (Right Side) -->
  <div class="sidebar" id="sidebar">
    <!-- <a href="profile.php" class="admin"> <span class="material-symbols-outlined Sicons">account_circle</span> Profile</a> -->
    <a href="index.php" class="admin"><span class="material-symbols-outlined">home</span>Home</a>
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