<?php
include 'db.php';

// Handle only POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get form data
    $manga_id = $_POST['manga_id'];
    $chapter_number = $_POST['chapter_number'];
    $chapter_title = $_POST['chapter_title'];

    // Create a folder for chapter images
    // Example: chapters/manga_1/chapter_5/
    $baseDir = "chapters/manga_" . $manga_id . "/chapter_" . $chapter_number;
    if (!file_exists($baseDir)) {
        mkdir($baseDir, 0777, true);
    }

    // Upload images
    foreach ($_FILES['chapter_images']['tmp_name'] as $key => $tmp_name) {
        $fileName = basename($_FILES['chapter_images']['name'][$key]);
        $targetPath = $baseDir . "/" . $fileName;
        move_uploaded_file($tmp_name, $targetPath);
    }

    // Insert chapter record into database
    $stmt = $conn->prepare("INSERT INTO chapters (manga_id, chapter_number, chapter_title, images_folder) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $manga_id, $chapter_number, $chapter_title, $baseDir);
    $stmt->execute();
    $stmt->close();

    echo "<script>
        alert('✅ Chapter $chapter_number has been added successfully!');
        window.location.href = 'addChapter.php';
    </script>";
}
?>
