<?php
header("Content-Type: application/json");
include "db.php";

if (!isset($_POST['chapter_id'])) {
    echo json_encode(["status" => "error", "message" => "Missing chapter ID"]);
    exit;
}

$chapter_id = (int)$_POST['chapter_id'];

// Get chapter info (folder path)
$sql = "SELECT images_folder FROM chapters WHERE id = $chapter_id LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    echo json_encode(["status" => "error", "message" => "Chapter not found"]);
    exit;
}

$row = $result->fetch_assoc();
$folderPath = $row['images_folder'];  // Example: chapters/manga_21/chapter_3

// ---------- DELETE FOLDER CONTENT ----------
function deleteFolder($dir) {
    if (!is_dir($dir)) return;

    $files = array_diff(scandir($dir), ['.', '..']);

    foreach ($files as $file) {
        $fullPath = $dir . "/" . $file;

        if (is_dir($fullPath)) {
            deleteFolder($fullPath); // recursive delete
        } else {
            unlink($fullPath); // delete file
        }
    }

    rmdir($dir); // delete empty chapter folder
}

// Delete chapter folder
deleteFolder($folderPath);

// ---------- DELETE DATABASE ENTRY ----------
$conn->query("DELETE FROM chapters WHERE id = $chapter_id");

echo json_encode(["status" => "success"]);
?>
