<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    echo "Unauthorized";
    exit();
}

include 'db.php'; // FIXED — use correct DB file

if (!isset($_POST['manga_id']) || !isset($_POST['chapter_id'])) {
    echo "Missing data.";
    exit();
}

$manga_id = (int)$_POST['manga_id'];
$chapter_id = (int)$_POST['chapter_id'];

// --- GET CHAPTER INFO ---
$sql = "SELECT chapter_number, images_folder FROM chapters WHERE id = $chapter_id AND manga_id = $manga_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "Chapter not found.";
    exit();
}

$row = $result->fetch_assoc();
$chapter_number = $row['chapter_number'];
$folder = $row['images_folder'];

// --- DELETE FOLDER ---
$fullPath = __DIR__ . "/chapters/" . $folder;

function deleteDir($dir) {
    if (!file_exists($dir)) return;

    $files = array_diff(scandir($dir), ['.', '..']);
    foreach ($files as $file) {
        $path = "$dir/$file";
        if (is_dir($path)) {
            deleteDir($path);
        } else {
            unlink($path);
        }
    }
    rmdir($dir);
}

deleteDir($fullPath);

// --- DELETE FROM DATABASE ---
$deleteSQL = "DELETE FROM chapters WHERE id = $chapter_id";
$conn->query($deleteSQL);

header("Location: deleteChapter.php?success=1");
exit();
