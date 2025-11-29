<?php
// uploadProfilePic.php
session_start();
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit(); }
require 'db.php';

// Find user_id
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$user_id = (int)$user['id'];

// Ensure profile exists
$stmt = $conn->prepare("SELECT id FROM profile WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
if ($stmt->get_result()->num_rows === 0) {
  $ins = $conn->prepare("INSERT INTO profile (user_id) VALUES (?)");
  $ins->bind_param("i", $user_id);
  $ins->execute();
}

if (!isset($_FILES['profile_pic']) || $_FILES['profile_pic']['error'] !== 0) {
  header("Location: profile.php?error=No file or upload error");
  exit();
}

$uploadDir = "uploads/";
if (!is_dir($uploadDir)) { mkdir($uploadDir, 0777, true); }

$ext = pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION);
$ext = strtolower($ext);
$allowed = ['jpg','jpeg','png','webp','gif'];
if (!in_array($ext, $allowed)) {
  header("Location: profile.php?error=Invalid file type");
  exit();
}

$fileName = "pp_" . $user_id . "_" . time() . "." . $ext;
$targetPath = $uploadDir . $fileName;

if (!move_uploaded_file($_FILES['profile_pic']['tmp_name'], $targetPath)) {
  header("Location: profile.php?error=Failed to save file");
  exit();
}

$upd = $conn->prepare("UPDATE profile SET profile_pic = ? WHERE user_id = ?");
$upd->bind_param("si", $targetPath, $user_id);
$upd->execute();

header("Location: profile.php?success=Profile picture updated");
exit();