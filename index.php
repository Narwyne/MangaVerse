<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="home.css">
  <title>Home</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
  <script src="caroselScript.js" defer></script>

  <style>
    /* Sidebar styles */
    .sidebar {
      position: fixed;
      top: 0;
      right: -250px; /* Start hidden on the right */
      width: 250px;
      height: 100%;
      background-color: #111;
      color: white;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding-top: 50px;
      transition: right 0.3s ease;
      z-index: 1000;
    }

    .sidebar.active {
      right: 0; /* Slide in from the right */
    }

    .sidebar a {
      text-decoration: none;
      color: white;
      background-color: #333;
      width: 80%;
      text-align: center;
      padding: 12px;
      margin: 8px 0;
      border-radius: 8px;
      transition: background 0.3s;
    }

    .sidebar a:hover {
      background-color: #facc15;
      color: black;
    }

    .sidebar .logout {
      background-color: #e11d48;
    }

    .sidebar .logout:hover {
      background-color: #f43f5e;
    }

    /* Overlay */
    .overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      display: none;
      z-index: 900;
    }

    .overlay.active {
      display: block;
    }
  </style>
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

  <script>
    const menuBtn = document.getElementById('menuBtn');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    menuBtn.addEventListener('click', () => {
      sidebar.classList.toggle('active');
      overlay.classList.toggle('active');
    });

    overlay.addEventListener('click', () => {
      sidebar.classList.remove('active');
      overlay.classList.remove('active');
    });
  </script>

</body>
</html>
