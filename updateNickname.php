<?php
session_start();
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit(); }
require 'db.php';

if (!isset($_POST['nickname']) || trim($_POST['nickname']) === '') {
  header("Location: profile.php?error=No nickname provided");
  exit();
}
$newNickname = trim($_POST['nickname']);

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
  $ins = $conn->prepare("INSERT INTO profile (user_id, nickname) VALUES (?, ?)");
  $ins->bind_param("is", $user_id, $newNickname);
  $ins->execute();
} else {
  $upd = $conn->prepare("UPDATE profile SET nickname = ? WHERE user_id = ?");
  $upd->bind_param("si", $newNickname, $user_id);
  $upd->execute();
}

header("Location: profile.php?success=Nickname updated");
exit();