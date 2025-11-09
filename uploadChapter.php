<?php
include 'db.php';

// Check if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $manga_id = $_POST['manga_id'];
    $chapter_title = $_POST['chapter_title'];

    // Folder for this chapter
    $folder_name = "chapter_" . time();
    $upload_dir = "chapters/" . $folder_name;

    // Create the folder if not exists
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Upload each image
    foreach ($_FILES['chapter_images']['tmp_name'] as $key => $tmp_name) {
        $file_name = basename($_FILES['chapter_images']['name'][$key]);
        $target_file = $upload_dir . "/" . $file_name;

        move_uploaded_file($tmp_name, $target_file);
    }

    // Count how many chapters this manga already has
    $result = $conn->query("SELECT COUNT(*) AS total FROM chapters WHERE manga_id = $manga_id");
    $row = $result->fetch_assoc();
    $chapter_number = $row['total'] + 1;

    // Insert chapter record
    $sql = "INSERT INTO chapters (manga_id, chapter_number, chapter_title, images_folder) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $manga_id, $chapter_number, $chapter_title, $upload_dir);
    $stmt->execute();

    // Redirect back to addChapter page
    header("Location: addChapter.php?success=1");
    exit();
} else {
    echo "Invalid request.";
}
?>
