<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="home.css">
  <link rel="stylesheet" href="sidebar.css">
  <title>Home</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
  <script src="caroselScript.js" defer></script>
  <script src="sidebarScript.js" defer></script>

</head>
<body>

  <!-- Sidebar (Right Side) -->
  <div class="sidebar" id="sidebar">
    <a href="#">Profile</a>
    <a href="#">About Us</a>
    <a href="#">Admin Panel</a>
    <a href="#" class="logout">Log Out</a>
  </div>

  <!-- Overlay -->
  <div class="overlay" id="overlay"></div>

  <div class="container">
    <div class="item header">
      <div id="logo"></div>
      <div class="search-bar">
        <input type="text" placeholder="Search...">
        <button><span class="material-symbols-outlined">search</span></button>
      </div>
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
      <div class="content">
        <div class="picture"> </div>
        <div class="title"></div>
        <div class="tags"></div>
        <div class="status"></div>
      </div>
      <div class="content">C2</div>
      <div class="content">C3</div>
      <div class="content">C4</div>
      <div class="content">C5</div>
      <div class="content">C6</div>
      <div class="content">C7</div>
      <div class="content">C8</div>
      <div class="content">C9</div>
      <div class="content">C10</div>
      <div class="content">C11</div>
      <div class="content">C12</div>
      <div class="content">C13</div>
      <div class="content">C14</div>
      <div class="content">C15</div>
    </div>

    <div class="item item4">4</div>
    <div class="item item5">5</div>
    <div class="item item6">6</div>
  </div>

</body>
</html>