<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $conn->real_escape_string($_POST['username']);
  $password = $_POST['password'];

  // Run query
  $sql = "SELECT * FROM users WHERE username='$username'";
  $result = $conn->query($sql);

  if ($result && $result->num_rows === 1) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
      $_SESSION['username'] = $row['username'];
      $_SESSION['role'] = $row['role'];

      if ($row['role'] === 'admin') {
        header("Location: adminPanel.php");
      } else {
        header("Location: index.php");
      }
      exit();
    } else {
      // Incorrect password → show modal
      echo "<script>
              document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('passwordModal').style.display = 'block';
              });
            </script>";
    }
  } else {
    // User not found → show modal
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
              document.getElementById('userModal').style.display = 'block';
            });
          </script>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MangaVerse Login</title>
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
  margin-bottom: 25px;
}

.logo h1 {
  font-size: 40px;
  font-weight: 700;
  margin-bottom: 10px;
}

.logo span {
  color: #efbf04;
}

.login-header {
  text-align: center;
  font-weight: 600;
  font-size: 20px;
  margin-top: 20px;
  margin-bottom: 20px;
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

.login-btn {
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

.login-btn:hover {
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
  top: 60px;
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
  display: none;
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
  padding-bottom: 20px;
}

.modal-content h2 {
  color: #efbf04;
}

.close {
  color: #aaa;
  float: right;
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
      <div class="login-header">Log in to your account</div>
      <form action="#" method="POST">
        <label class="linput" for="username">Username :</label>
        <input type="text" id="username" name="username" required />

        <label class="linput" for="password">Password :</label>
        <input type="password" id="password" name="password" required />

        <div class="options">
        </div>

        <button class="login-btn" type="submit">Log in</button>
      </form>

      <div class="footer">
        No account? <a href="register.php">Register</a>
      </div>
    </div>
  </div>


<!-- Incorrect Password Modal -->
<div id="passwordModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span><br>
    <h2>Incorrect Password</h2>
    <p>Please try again.</p>
  </div>
</div>

<!-- User Not Found Modal -->
<div id="userModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span><br>
    <h2>User Not Found</h2>
    <p>Please register or check your username.</p>
  </div>
</div>

<script>
  function setupModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    const closeBtn = modal.querySelector(".close");

    closeBtn.onclick = () => {
      modal.style.display = "none";
    };

    window.onclick = (event) => {
      if (event.target === modal) {
        modal.style.display = "none";
      }
    };
  }

  setupModal("usernameModal");
  setupModal("passwordModal");
  setupModal("userModal");
</script>

</body>
</html>
