<?php
session_start();
include 'db.php';

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

// ✅ Load images from folder
$folder = 'chapters/manga_' . $chapter['manga_id'] . '/chapter_' . $chapter['chapter_number'];
$images = glob($folder . '/*.{jpg,jpeg,png,webp}', GLOB_BRACE);

// Sort numerically by filename
usort($images, function($a, $b) {
  return (int)preg_replace('/\D/', '', basename($a)) <=> (int)preg_replace('/\D/', '', basename($b));
});


?>

<!DOCTYPE html>
<html>
<head>
  <title>Chapter <?= $chapter['chapter_number'] ?> - <?= htmlspecialchars($chapter['chapter_title']) ?></title>
  <style>
    body {
      background-color: #121212;
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
  </style>
</head>
<body>
  <h1>Chapter <?= $chapter['chapter_number'] ?>: <?= htmlspecialchars($chapter['chapter_title']) ?></h1>
  <?php
  if ($images) {
    foreach ($images as $img) {
      echo "<img src='$img' class='chapter-image'>";
    }
  } else {
    echo "<p>No images found for this chapter.</p>";
  }
  ?>
</body>
</html>