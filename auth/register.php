<?php
session_start();
require '../config/koneksi.php';

$error = '';
$success = '';

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Cek konfirmasi password
    if ($password !== $confirm_password) {
        $error = "Konfirmasi password tidak cocok!";
    } else {
        // Cek apakah username sudah ada
        $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();
        $check_result = $check->get_result();

        if ($check_result->num_rows > 0) {
            $error = "Username sudah digunakan!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $role = 'user';

            $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $hashed_password, $role);

            if ($stmt->execute()) {
                $success = "Pendaftaran berhasil! Silakan login.";
            } else {
                $error = "Terjadi kesalahan saat mendaftar.";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Daftar - Coffee Shop</title>
  <link rel="stylesheet" href="../public/css/style.css">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <style>
    .error-message, .success-message {
      text-align: center;
      margin-bottom: 15px;
      padding: 10px;
      border-radius: 5px;
      font-size: 14px;
    }
    .error-message {
      background-color: #ffebeb;
      color: #cc0000;
    }
    .success-message {
      background-color: #e7ffe7;
      color: #00aa00;
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <form method="POST" action="">
      <img src="../public/img/logo.png" alt="logo" class="logo" />
      <h1>Daftar Akun</h1>

      <?php if (!empty($error)): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
      <?php elseif (!empty($success)): ?>
        <div class="success-message"><?= htmlspecialchars($success) ?></div>
      <?php endif; ?>

      <div class="input-box">
        <input 
          type="text" 
          name="username" 
          placeholder="Username" 
          required 
          value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>"
        />
        <i class="bx bx-user"></i>
      </div>

      <div class="input-box">
        <input 
          type="password" 
          name="password" 
          placeholder="Password" 
          required 
        />
        <i class="bx bx-lock"></i>
      </div>

      <div class="input-box">
        <input 
          type="password" 
          name="confirm_password" 
          placeholder="Konfirmasi Password" 
          required 
        />
        <i class="bx bx-lock-alt"></i>
      </div>

      <button type="submit" name="register" class="btn">Daftar</button>
      <p style="margin-top: 10px; text-align: center;">
        Sudah punya akun? <a href="login.php">Login di sini</a>
      </p>
    </form>
  </div>
</body>
</html>
