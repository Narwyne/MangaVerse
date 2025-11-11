<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Sanitize and collect form data
  $id = intval($_POST['id']);
  $title = trim($_POST['title']);
  $description = trim($_POST['description']);
  $genres = isset($_POST['genres']) ? implode(', ', $_POST['genres']) : '';
  $status = $_POST['status'];

  // Check if a new image was uploaded
  if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/';
    $fileName = basename($_FILES['photo']['name']);
    $targetFile = $uploadDir . $fileName;

    // Move uploaded file to target directory
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
      // Update with new image
      $sql = "UPDATE manga SET title=?, description=?, genres=?, status=?, photo=? WHERE id=?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("sssssi", $title, $description, $genres, $status, $fileName, $id);
    } else {
      die("Error uploading image.");
    }
  } else {
    // Update without changing image
    $sql = "UPDATE manga SET title=?, description=?, genres=?, status=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $title, $description, $genres, $status, $id);
  }

  // Execute and redirect
  if ($stmt->execute()) {
    header("Location: editManga.php?success=1");
    exit();
  } else {
    echo "Error updating manga: " . $stmt->error;
  }
}
?>