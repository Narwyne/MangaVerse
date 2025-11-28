<?php
include 'db.php';

if (!isset($_GET['manga_id'])) {
    echo json_encode([]);
    exit();
}

$manga_id = (int)$_GET['manga_id'];

$sql = "SELECT id, chapter_number, chapter_title FROM chapters WHERE manga_id = $manga_id ORDER BY chapter_number ASC";
$result = $conn->query($sql);

$chapters = [];

while ($row = $result->fetch_assoc()) {
    $chapters[] = $row;
}

echo json_encode($chapters);
