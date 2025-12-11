<?php
$host = 'localhost';
$db = 'mangaverse';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $conn->real_escape_string($_POST['username']);
  $email = $conn->real_escape_string($_POST['email']);
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirmPassword'];

  // Check if username already exists
  $checkSql = "SELECT id FROM users WHERE username = '$username'";
  $checkResult = $conn->query($checkSql);

  if ($checkResult->num_rows > 0) {
    // Username taken → trigger modal
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
              document.getElementById('usernameModal').style.display = 'block';
            });
          </script>";
  } elseif ($password !== $confirmPassword) {
    echo "<script>alert('Passwords do not match');</script>";
  } else {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$hashedPassword', '$role')";
    if ($conn->query($sql) === TRUE) {
      echo "<script>alert('Registration successful'); window.location.href='login.php';</script>";
    } else {
      echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MangaVerse Register</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background-color: #2b2b2b;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      color: white;
    }

    .login-box {
      width: 380px;
      background-color: #111111;
      border-radius: 6px;
      overflow: hidden;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.6);
      border-top: 6px solid #efbf04;
    }

    .logo {
      text-align: center;
      margin-bottom: 10px;
    }

    .logo h1 {
      font-size: 40px;
      font-weight: 700;
      margin-bottom: 20px;
    }

    .logo span {
      color: #efbf04;
    }

    .login-header {
      text-align: center;
      font-weight: 600;
      font-size: 21px;
      margin-top: 10px;
      margin-bottom: 10px;
    }

    form {
      padding: 25px 35px 15px;
    }

    label {
      display: block;
      font-size: 13px;
      margin-bottom: 5px;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      background-color: #3a3a3a;
      border: none;
      border-radius: 4px;
      color: white;
      padding: 10px;
      font-size: 14px;
      margin-bottom: 18px;
      outline: none;
    }

    .options {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 12px;
      margin-top: -8px;
      margin-bottom: 18px;
    }

    .options label {
      display: flex;
      align-items: center;
      gap: 5px;
      cursor: pointer;
    }

    .options a {
      color: #efbf04;
      text-decoration: none;
    }

    .options a:hover {
      text-decoration: underline;
    }

    .register-btn {
      width: 100%;
      background-color: #efbf04;
      color: #ffffffff;
      font-weight: 600;
      border: none;
      padding: 10px;
      border-radius: 4px;
      font-size: 15px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .register-btn:hover {
      background-color: #ffd633;
    }

    .footer {
      background-color: #3a3a3a;
      padding: 12px 0;
      text-align: center;
      font-size: 13px;
      border-radius: 0 0 6px 6px;
    }

    .footer a {
      color: #efbf04;
      text-decoration: none;
      font-weight: 600;
    }

    .footer a:hover {
      text-decoration: underline;
    }

    input[type="checkbox"] {
      accent-color: #efbf04;
    }

    .container {
      text-align: center;
    }

    .top-logo {
      position: absolute;
      right: 40%;
      top: 25px;
      width: 300px;
      text-align: center;
      justify-content: center;

    }

    .top-logo h1 {
      font-size: 42px;
      font-weight: 700;
    }

    .top-logo span {
      color: #efbf04;
    }
    .linput{
      display: flex;
      text-align: start;
    }
  .modal {
  display: none; /* Hidden by default */
  position: fixed;
  z-index: 999;
  left: 0; top: 0;
  width: 100%; height: 100%;
  background-color: rgba(0,0,0,0.6);
    }

  .modal-content {
    background-color: #111;
    margin: 15% auto;
    padding: 5px;
    border-radius: 8px;
    width: 300px;
    text-align: center;
    color: #fff;
    border-top: 4px solid #efbf04;
  }

  .modal-content h2 {
    color: #efbf04;
  }

  .close {
    display: inline;
    color: #aaa;
    float: right;
    top: 20px;
    font-size: 24px;
    cursor: pointer;
  }
  .close:hover {
    color: #fff;
  }
  </style>
</head>
<body>
  <div class="container">
    <div class="top-logo">
      <h1>Manga<span>Verse</span></h1>
    </div>

    <div class="login-box">
      <div class="login-header">Register</div>
      <form action="#" method="POST">
        <label class="linput" for="username">Username :</label>
        <input type="text" id="username" name="username" required />

        <label class="linput" for="email">Email :</label>
        <input type="text" id="email" name="email" required />

        <input type="hidden" name="role" value="user" />

        <label class="linput" for="password">Password :</label>
        <input type="password" id="password" name="password" required />

        <label class="linput" for="confirmPassword">Confirm Password :</label>
        <input type="password" id="confirmPassword" name="confirmPassword" required />

        <div class="options">
            <a href="login.php">Back to Login</a>
        </div>

        <button class="register-btn" type="submit">Register</button>
      </form>

      <div class="footer">
        Already Have an Account? <a href="login.php">Login</a>
      </div>
    </div>
  </div>


<!-- Username Taken Modal -->
<div id="usernameModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span><br>
    <h2>Username Already Taken</h2>
    <p>Please choose a different username.</p>
  </div>
</div>

<script>
  // Get modal and close button
  const modal = document.getElementById("usernameModal");
  const closeBtn = document.querySelector("#usernameModal .close");

  // Close when clicking the X
  closeBtn.onclick = () => {
    modal.style.display = "none";
  };

  // Close when clicking outside the modal
  window.onclick = (event) => {
    if (event.target === modal) {
      modal.style.display = "none";
    }
  };
</script>
</body>
</html>
