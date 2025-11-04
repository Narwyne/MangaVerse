<?php
include 'db.php';

// ---------- PAGINATION SETUP ----------
$limit = 6; // 3x2 layout = 6 cards per page

// Get the current page number from URL (default = 1)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the offset for the SQL query
$offset = ($page - 1) * $limit;

// ---------- FETCH MANGA DATA ----------
// Fetch manga from the database with pagination
$sql = "SELECT * FROM manga ORDER BY date_added DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// ---------- TOTAL COUNT FOR PAGINATION ----------
// Get total number of manga to calculate how many pages we need
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
    <title>adminPanel</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="sidebar.css">
    <link rel="stylesheet" href="aPanel.css">
    <script src="sidebarScript.js" defer></script>

    <style>
/* ===============================
   GRID CONTAINER FOR ALL CARDS
   =============================== */
.manga-grid {
    display: grid; /* Arrange manga cards in a grid */
    grid-template-columns: repeat(3, 1fr); /* Exactly 3 cards per row */
    grid-template-rows: repeat(2, auto);   /* 2 rows max */
    gap: 10px; /* Space between cards */
    padding-top: 10px;
    padding-left: 5px;
    padding-right: 5px;
}

/* ===============================
   MAIN CARD STYLING
   =============================== */
.manga-card {
    background-color: #1e1e1e; /* Dark background */
    border-radius: 5px; /* Rounded corners */
    box-shadow: 0 0 6px rgba(0,0,0,0.5); /* Subtle shadow */
    overflow: hidden; /* Hide overflow */
    transition: transform 0.2s ease, box-shadow 0.2s ease; /* Smooth hover effect */
    border: 1px solid #333; /* Border for definition */
}

/* Lift and glow on hover */
.manga-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0 12px rgba(255, 221, 0, 0.3);
}

/* ===============================
   MANGA CONTENT SECTION (IMAGE + TEXT SIDE BY SIDE)
   =============================== */
.manga-content {
    display: flex; /* Put image and text side by side */
    align-items: flex-start; /* Align to top */
    padding: 15px;
    height: 210px;
}

/* ===============================
   IMAGE STYLING
   =============================== */
.manga-content img {
    width: 125px; /* Match your screenshot size */
    height: 175px;
    object-fit: cover; /* Keep aspect ratio and fill box */
    border-radius: 4px; /* Slight round edges */
    margin-right: 15px; /* Space between image and text */
    margin-top: 10px;
}

/* ===============================
   INFO TEXT SECTION
   =============================== */
.manga-info {
    color: #fff;
    flex: 1; /* Take remaining space */
}

/* Manga title */
.manga-info h3 {
    font-size: 1em;
    color: #fff;
    margin-bottom: 10px;
    text-align: left;
}

/* Details (tags, status, etc.) */
.manga-info p {
    font-size: 0.6em;
    color: #ccc;
    margin: 4px 0;
}

/* ===============================
   ADD CHAPTER BUTTON
   =============================== */
.add-chapter-btn {
    background-color: #ffcc00; /* Bright yellow button */
    color: #ffffffff; /* Black text */
    font-weight: bold;
    border: none;
    padding: 15px 0;
    cursor: pointer;
    width: 100%; /* Full width */
    border-radius: 0 0 8px 8px; /* Rounded bottom corners */
    font-size: 1.2em; /* Bigger font like in the picture */
    transition: background 0.2s ease;
    position: relative;
    bottom: 0;
}

/* Button hover effect */
.add-chapter-btn:hover {
    background-color: #ffdb4d;
}

/* pagination */
.pagination {
    text-align: center;
    margin: 25px 0;
}

.pagination a {
    display: inline-block;
    background-color: #ffcc00;
    color: #000;
    padding: 10px 15px;
    margin: 0 5px;
    border-radius: 6px;
    font-weight: bold;
    text-decoration: none;
    transition: background 0.3s;
}

.pagination a:hover {
    background-color: #ffdb4d;
}

.pagination a.active {
    background-color: #000;
    color: #fff;
}

.pagination a.disabled {
    background-color: #ccc;
    color: #666;
    pointer-events: none;
}
    </style>
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
        <div class="manga-grid">
            <?php
            // Check if there are any manga in the database
            if ($result->num_rows > 0) {

                // Loop through each manga and display it as a card
                while($row = $result->fetch_assoc()) {

                    // Handle image path automatically
                    $imagePath = $row['photo'];

                    // If the database only has filename (e.g. "naruto.jpg"), add "uploads/"
                    if (!str_starts_with($imagePath, 'uploads/')) {
                        $imagePath = 'uploads/' . $imagePath;
                    }

                    // Display each manga card
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
                            <button class='add-chapter-btn' onclick=\"window.location.href='addChapter.php?id=" . $row['id'] . "'\">Add Chapter</button>
                        </div>
                    ";
                }

            } else {
                // If no manga found
                echo "<p style='text-align:center;'>No manga found.</p>";
            }
            ?>
        </div>

        <!-- ---------- PAGINATION LINKS ---------- -->
                <!-- PAGINATION -->
            <div class="pagination">
                    <?php
                    // Get total number of manga
                    $result = $conn->query("SELECT COUNT(*) AS total FROM manga");
                    $row = $result->fetch_assoc();
                    $total_records = $row['total'];
                    $total_pages = ceil($total_records / $limit);

                    // Previous button
                    if ($page > 1) {
                        echo '<a href="?page=' . ($page - 1) . '">&laquo; Prev</a>';
                    } else {
                        echo '<a class="disabled">&laquo; Prev</a>';
                    }

                    // Page numbers
                    for ($i = 1; $i <= $total_pages; $i++) {
                        $active = ($i == $page) ? 'active' : '';
                        echo '<a href="?page=' . $i . '" class="' . $active . '">' . $i . '</a>';
                    }

                    // Next button
                    if ($page < $total_pages) {
                        echo '<a href="?page=' . ($page + 1) . '">Next &raquo;</a>';
                    } else {
                        echo '<a class="disabled">Next &raquo;</a>';
                    }
                    ?>
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
