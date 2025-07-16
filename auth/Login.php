<?php
session_start();
require '../config/koneksi.php';

$error = '';
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            
            // Redirect berdasarkan role
            header("Location: ../" . ($user['role'] == 'admin' ? 'admin/' : 'user/') . "index.php");
            exit();
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Coffee Shop</title>
  <link rel="stylesheet" href="../public/css/style.css" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <style>
      .error-message {
          color: #ff3333;
          background: #ffebeb;
          padding: 10px;
          border-radius: 5px;
          margin-bottom: 15px;
          text-align: center;
          font-size: 14px;
      }
      .register-link {
          margin-top: 10px;
          text-align: center;
          font-size: 14px;
      }
      .register-link a {
          color: #007bff;
          text-decoration: none;
      }
      .register-link a:hover {
          text-decoration: underline;
      }
  </style>
</head>
<body>
  <div class="wrapper">
    <form method="POST" action="">
      <img src="../public/img/logo.png" alt="logo" class="logo" />
      <h1>Login</h1>

      <?php if (!empty($error)): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <div class="input-box">
        <input 
          type="text" 
          name="username" 
          placeholder="Username" 
          required 
          value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>" />
        <i class="bx bx-user"></i>
      </div>

      <div class="input-box">
        <input 
          type="password" 
          name="password" 
          placeholder="Password" 
          required />
        <i class="bx bx-lock"></i>
      </div>

      <button type="submit" name="login" class="btn">Login</button>

      <div class="register-link">
        Don't have an account? <a href="register.php">Register</a>
      </div>
    </form>
  </div>
</body>
</html>
