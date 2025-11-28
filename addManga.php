<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
  header("Location: login.php");
  exit();
}
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Basic input sanitization and presence checks
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $genres = isset($_POST['genre']) && is_array($_POST['genre']) ? $_POST['genre'] : [];
    $genres_str = implode(', ', array_map('trim', $genres));
    $status = isset($_POST['status']) ? trim($_POST['status']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $hiatus = isset($_POST['hiatus']) ? trim($_POST['hiatus']) : 'No'; // Default to No

    $errors = [];

    if ($title === '') {
        $errors[] = 'Title is required.';
    }
    if ($status === '') {
        $errors[] = 'Status is required.';
    }
    if ($description === '') {
        $errors[] = 'Description is required.';
    }

    // Handle image upload with validation
    $photo = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'File upload error (code: ' . $_FILES['photo']['error'] . ').';
        } else {
                // Limit file size (25 MB)
                $maxSize = 25 * 1024 * 1024; // 25 MB in bytes
                if ($_FILES['photo']['size'] > $maxSize) {
                    $errors[] = 'File is too large. Maximum 25MB allowed.';
            } else {
                // Validate MIME type using finfo
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime = finfo_file($finfo, $_FILES['photo']['tmp_name']);
                finfo_close($finfo);

                $allowed = [
                    'image/jpeg' => 'jpg',
                    'image/png' => 'png',
                    'image/gif' => 'gif',
                    'image/webp' => 'webp',
                    'image/avif' => 'avif'
                ];

                if (!array_key_exists($mime, $allowed)) {
                    $errors[] = 'Invalid image type. Allowed: jpg, png, gif, webp, avif.';
                } else {
                    // Create uploads directory if needed
                    $upload_dir = __DIR__ . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }

                    // Generate a unique filename
                    try {
                        $ext = $allowed[$mime];
                        $unique = time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
                    } catch (Exception $e) {
                        // fallback if random_bytes not available
                        $unique = time() . '_' . mt_rand(1000, 9999) . '.' . $ext;
                    }

                    $target_file = $upload_dir . $unique;

                    if (!move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
                        $errors[] = 'Failed to move uploaded file.';
                    } else {
                        // store only the filename (not the full path) in DB
                        $photo = $unique;
                    }
                }
            }
        }
    } else {
        $errors[] = 'Image is required.';
    }

    // If no errors, insert into DB
    if (empty($errors)) {
        $sql = "INSERT INTO manga (title, genres, status, description, hiatus, photo) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            $errors[] = 'Database error: ' . $conn->error;
        } else {
            $stmt->bind_param('ssssss', $title, $genres_str, $status, $description, $hiatus, $photo);
            if ($stmt->execute()) {
                // Success: redirect back to admin panel (with a small alert)
                echo "<script>alert('Manga added successfully!');window.location.href='addChapter.php';</script>";
                $stmt->close();
                $conn->close();
                exit;
            } else {
                $errors[] = 'Database execute error: ' . $stmt->error;
                $stmt->close();
            }
        }
    }

    // If we reach here there were errors — show them to the user
    if (!empty($errors)) {
        $escaped = array_map(function($s){ return addslashes($s); }, $errors);
        $msg = implode('\n', $escaped);
        echo "<script>alert('Error:\n" . $msg . "');</script>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>addManga</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/aPanel.css">
    <link rel="stylesheet" href="css/aManga.css">
    <script src="Scripts/sidebarScript.js" defer></script>
</head>
<body>

<div class="aPanel">
    <div class="panel aTop">
        <div id="mangaverse">Welcome to Manga<span id="verse">Verse</span> admin panel</div>
        <button id="menuBtn"><span class="material-symbols-outlined">menu</span></button>
    </div>

    <div class="panel aSide">
        <button onclick="window.location.href='adminPanel.php';">Admin Panel</button> <br>
        <button disabled="disabled">Add Manga</button> <br>
        <button onclick="window.location.href='addChapter.php';">Add Chapter</button> <br>
        <button onclick="window.location.href='deleteChapter.php';">Delete Chapter</button> <br>
        <button onclick="window.location.href='editManga.php';">Edit Manga</button> <br>
        <button onclick="window.location.href='deleteManga.php';">Delete Manga</button>
    </div>

    <div class="panel aMain">  
        <div class="mTop mmm">Add Manga</div>
        <div class="mMain addManga"> 
            <form class="mBox" enctype="multipart/form-data" method="POST">
                <div class="mContent title">
                    <label for="title">Title :</label>
                    <input type="text" id="title" name="title" required>
                </div>

                <div class="mContent">
                    <label for="photo">Photo :</label>
                    <label for="photo" class="upload-label">Choose Image</label>
                    <input type="file" id="photo" name="photo" accept="image/*" required>
                    <img id="preview" src="#" alt="Preview" style="display:none;">
                </div>

                <!-- Description -->
                <div class="mContent">
                    <label id="scriptionD" for="description">Description :</label>
                    <textarea id="description" name="description" placeholder="Enter manga description..." required></textarea>
                </div>

                <!-- Checkboxes -->
                <div class="mContent">
                    <label>Genre :</label>
                    <div class="genre-container">
                        <div><input type="checkbox" id="action" name="genre[]" value="Action"> <label for="action">Action</label></div>
                        <div><input type="checkbox" id="adventure" name="genre[]" value="Adventure"> <label for="adventure">Adventure</label></div>
                        <div><input type="checkbox" id="comedy" name="genre[]" value="Comedy"> <label for="comedy">Comedy</label></div>
                        <div><input type="checkbox" id="drama" name="genre[]" value="Drama"> <label for="drama">Drama</label></div>
                        <div><input type="checkbox" id="fantasy" name="genre[]" value="Fantasy"> <label for="fantasy">Fantasy</label></div>
                        <div><input type="checkbox" id="horror" name="genre[]" value="Horror"> <label for="horror">Horror</label></div>
                        <div><input type="checkbox" id="mystery" name="genre[]" value="Mystery"> <label for="mystery">Mystery</label></div>
                        <div><input type="checkbox" id="romance" name="genre[]" value="Romance"> <label for="romance">Romance</label></div>
                        <div><input type="checkbox" id="scifi" name="genre[]" value="Sci-Fi"> <label for="scifi">Sci-Fi</label></div>
                        <div><input type="checkbox" id="sliceoflife" name="genre[]" value="Slice of Life"> <label for="sliceoflife">Slice of Life</label></div>
                        <div><input type="checkbox" id="sports" name="genre[]" value="Sports"> <label for="sports">Sports</label></div>
                        <div><input type="checkbox" id="supernatural" name="genre[]" value="Supernatural"> <label for="supernatural">Supernatural</label></div>
                        <div><input type="checkbox" id="thriller" name="genre[]" value="Thriller"> <label for="thriller">Thriller</label></div>
                    </div>
                </div>

                <div class="mContent">
                     <label>Status : </label>
                    <input type="radio" id="ongoing" name="status" value="Ongoing"> <label class="cbFont" for="ongoing">Ongoing</label>
                    <input type="radio" id="completed" name="status" value="Completed"> <label class="cbFont" for="completed">Completed</label>
                </div>

                <!-- Hiatus -->
                <!-- <div class="mContent">
                    <label>Hiatus :</label>
                    <input type="radio" id="hiatus_yes" name="hiatus" value="Yes"> <label class="cbFont" for="hiatus_yes">Yes</label>
                    <input type="radio" id="hiatus_no" name="hiatus" value="No" checked> <label class="cbFont" for="hiatus_no">No</label>
                </div> -->

                <div class="mContent submitBtn">
                    <button type="submit">Add Manga</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Sidebar (Right Side) -->
<div class="sidebar" id="sidebar">
    <a href="#">Profile</a>
    <a href="index.php">Home</a>
    <a href="#">About Us</a>
    <a href="logout.php" class="logout">Log Out</a>
</div>

<!-- Overlay -->
<div class="overlay" id="overlay"></div>

<script>
    // Preview uploaded image
    document.getElementById('photo').addEventListener('change', function(event) {
        const preview = document.getElementById('preview');
        const file = event.target.files[0];
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }
    });
</script>

</body>
</html>
