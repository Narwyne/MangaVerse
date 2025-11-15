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
  <link rel="stylesheet" href="home.css">
  <link rel="stylesheet" href="sidebar.css">
  <style>
    body {
      background-color: #121212;
      color: #fff;
      font-family: 'Istok Web', sans-serif;
      margin: 0;
      padding: 0;
    }

    .manga-container {
      max-width: 900px;
      margin: 40px auto;
      padding: 20px;
      background-color: #1e1e1e;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
    }

    .manga-header {
      display: flex;
      gap: 20px;
      align-items: flex-start;
    }

    .manga-header img {
      width: 200px;
      height: 300px;
      object-fit: cover;
      border-radius: 8px;
      border: 1px solid #333;
    }

    .manga-details {
      flex: 1;
    }

    .manga-details h1 {
      font-size: 2em;
      margin-bottom: 10px;
    }

    .manga-details p {
      margin: 5px 0;
      color: #ccc;
    }

    .description-box {
      margin-top: 20px;
      padding: 15px;
      background-color: #2a2a2a;
      border-radius: 8px;
      line-height: 1.6;
    }

    .chapter-list {
      margin-top: 30px;
    }

    .chapter-list h2 {
      margin-bottom: 10px;
    }

    .chapter-list ul {
      list-style: none;
      padding: 0;
    }

    .chapter-list li {
      background-color: #2a2a2a;
      margin-bottom: 8px;
      padding: 10px 15px;
      border-radius: 6px;
      transition: background 0.3s;
    }

    .chapter-list li:hover {
      background-color: #3a3a3a;
    }

    .chapter-list a {
      color: #ffcc00;
      text-decoration: none;
      font-weight: bold;
    }

    .chapter-list a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="manga-container">
  <div class="manga-header">
    <img src="uploads/<?php echo htmlspecialchars($manga['photo']); ?>" alt="<?php echo htmlspecialchars($manga['title']); ?>">
    <div class="manga-details">
      <h1><?php echo htmlspecialchars($manga['title']); ?></h1>
      <p><strong>Genres:</strong> <?php echo htmlspecialchars($manga['genres']); ?></p>
      <p><strong>Status:</strong> <?php echo htmlspecialchars($manga['status']); ?></p>
    </div>
  </div>

  <div class="description-box">
    <strong>Description:</strong><br>
    <?php echo nl2br(htmlspecialchars($manga['description'])); ?>
  </div>

  <div class="chapter-list">
    <h2>Chapters</h2>
    <ul>
      <?php
      $chapters_sql = "SELECT * FROM chapters WHERE manga_id = $manga_id ORDER BY chapter_number ASC";
      $chapters_result = $conn->query($chapters_sql);
      if ($chapters_result->num_rows > 0) {
        while ($chapter = $chapters_result->fetch_assoc()) {
          echo "<li><a href='chapter.php?id=" . $chapter['id'] . "'>Chapter " . $chapter['chapter_number'] . ": " . htmlspecialchars($chapter['title']) . "</a></li>";
        }
      } else {
        echo "<li>No chapters available.</li>";
      }
      ?>
    </ul>
  </div>
</div>

</body>
</html>