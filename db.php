<?php
$host = "localhost"; // usually localhost
$user = "root";      // your MySQL username
$pass = "";          // your MySQL password (empty in XAMPP)
$dbname = "mangaverse";

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>