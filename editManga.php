<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
  header("Location: login.php");
  exit();
}

include 'db.php';

// ---------- PAGINATION SETUP ----------
$limit = 6; // 3x2 layout = 6 cards per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// ---------- FETCH MANGA DATA ----------
$sql = "SELECT * FROM manga ORDER BY date_added DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// ---------- TOTAL COUNT FOR PAGINATION ----------
$total_sql = "SELECT COUNT(*) AS total FROM manga";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_manga = $total_row['total'];
$total_pages = ceil($total_manga / $limit);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Manga</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
  <link rel="stylesheet" href="sidebar.css">
  <link rel="stylesheet" href="aPanel.css">
  <link rel="stylesheet" href="css/eManga.css">
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
    <button onclick="window.location.href='addChapter.php';">Add Chapter</button> <br>
    <button disabled="disabled">Edit Manga</button> <br>
    <button onclick="window.location.href='deleteManga.php';">Delete Manga</button>
  </div>

  <div class="panel aMain">
    <div class="mTop mmm">Edit Manga</div>
    <div class="mMain">
      <div class="search-bar">
        <input type="text" placeholder="Search...">
        <button><span class="material-symbols-outlined">search</span></button>
      </div>

      <div class="manga-grid">
        <?php
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            $imagePath = $row['photo'];
            if (!str_starts_with($imagePath, 'uploads/')) {
              $imagePath = 'uploads/' . $imagePath;
            }

            // Safely escape quotes and newlines for JavaScript
            $safeTitle = addslashes($row['title']);
            $safeDescription = addslashes($row['description'] ?? '');
            $safeGenres = addslashes($row['genres']);
            $safeStatus = addslashes($row['status']);

            echo "
              <div class='manga-card'>
                <div class='manga-content'>
                  <img src='" . htmlspecialchars($imagePath) . "' alt='" . htmlspecialchars($row['title']) . "'>
                  <div class='manga-info'>
                    <h3>" . htmlspecialchars($row['title']) . "</h3>
                    <p><b>Tags:</b> " . htmlspecialchars($row['genres']) . "</p>
                    <p><b>Status:</b> " . htmlspecialchars($row['status']) . "</p>
                    <p><b>Chapters:</b> 0</p>
                  </div>
                </div>
                <!-- Edit Manga Button -->
                <button class='edit-manga-btn' 
                  onclick='openEdit(" . $row['id'] . ", `" . $safeTitle . "`, `" . $safeDescription . "`, `" . $safeGenres . "`, `" . $safeStatus . "`)'>
                  Edit Manga
                </button>
              </div>
            ";
          }
        } else {
          echo "<p style='text-align:center;'>No manga found.</p>";
        }
        ?>
      </div>
    </div>

    <!-- ---------- PAGINATION LINKS ---------- -->
    <div class="pagination">
      <?php
      if ($page > 1) {
        echo '<a href="?page=' . ($page - 1) . '">&laquo; Prev</a>';
      } else {
        echo '<a class="disabled">&laquo; Prev</a>';
      }

      for ($i = 1; $i <= $total_pages; $i++) {
        $active = ($i == $page) ? 'active' : '';
        echo '<a href="?page=' . $i . '" class="' . $active . '">' . $i . '</a>';
      }

      if ($page < $total_pages) {
        echo '<a href="?page=' . ($page + 1) . '">Next &raquo;</a>';
      } else {
        echo '<a class="disabled">Next &raquo;</a>';
      }
      ?>
    </div>
  </div>
</div>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
  <a href="#">Profile</a>
  <a href="index.php">Home</a>
  <a href="#">About Us</a>
  <a href="logout.php" class="logout">Log Out</a>
</div>

<!-- Overlay -->
<div class="overlay" id="overlay"></div>

<!-- 🔹 EDIT POPUP WINDOW -->
<div class="popup-overlay" id="editOverlay">
  <div class="popup">
    <span class="close-btn" onclick="closeEdit()">✖</span>
    <h2>Edit Manga</h2>
    <form action="updateManga.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" id="editId" name="id">

      <!-- Manga Title -->
      <label>Title:</label>
      <input type="text" id="editTitle" name="title" required>

      <!-- ✅ Manga Description -->
      <label>Description:</label>
      <textarea id="editDescription" name="description" rows="4" required></textarea>

      <!-- Manga Genres -->
      <label>Genres:</label>
      <div class="checkbox-group">
        <?php
          $genres = ["Action", "Comedy", "Drama", "Romance", "Fantasy", "Sci-Fi", "Adventure", "Horror", "Slice of Life"];
          foreach ($genres as $genre) {
            echo "<label><input type='checkbox' name='genres[]' value='$genre'> $genre</label>";
          }
        ?>
      </div>

      <!-- Manga Status -->
      <label>Status:</label>
      <select id="editStatus" name="status" required>
        <option value='Ongoing'>Ongoing</option>
        <option value='Completed'>Completed</option>
        <option value='Hiatus'>Hiatus</option>
      </select>

      <!-- Manga Cover -->
      <label>Change Cover Image:</label>
      <input type="file" name="photo">

      <!-- Submit -->
      <button type="submit">Save Changes</button>
    </form>
  </div>
</div>

<script>
// ---------- OPEN EDIT MODAL ----------
function openEdit(id, title, description, genres, status) {
  document.getElementById("editOverlay").style.display = "flex";
  document.getElementById("editId").value = id;
  document.getElementById("editTitle").value = title;
  document.getElementById("editDescription").value = description; // ✅ FIXED: now shows description
  document.getElementById("editStatus").value = status;

  // Uncheck all checkboxes first
  document.querySelectorAll('input[name="genres[]"]').forEach(cb => cb.checked = false);

  // Re-check genres that match the DB value
  let genreList = genres.split(",").map(g => g.trim().toLowerCase());
  document.querySelectorAll('input[name="genres[]"]').forEach(cb => {
    if (genreList.includes(cb.value.toLowerCase())) {
      cb.checked = true;
    }
  });
}

// ---------- CLOSE EDIT MODAL ----------
function closeEdit() {
  document.getElementById("editOverlay").style.display = "none";
}
</script>

</body>
</html>
