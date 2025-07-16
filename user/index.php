<?php
require_once '../admin/check_session.php';
require_once '../config/koneksi.php';

if ($_SESSION['role'] !== 'user') {
    header("Location: ../admin/index.php");
    exit();
}

$products = $conn->query("SELECT * FROM products WHERE stock > 0 LIMIT 4");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - CoffeeSpace</title>
    <link rel="stylesheet" href="../public/css/style.css"> <!-- Hanya gunakan style.css -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
.user-greeting-bar {
    background: transparent;
    border: 2px solid rgba(255, 255, 255, 0.2);
  backdrop-filter: blur(20px);
    padding: 30px 50px;
    text-align: left;
    border-radius: 8px;
    margin: 40px auto 20px;
    width: fit-content;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

.user-greeting-bar h2 {
    font-size: 26px;
    color: #fff;
    margin: 0 0 6px;
}

.user-greeting-bar p {
    font-size: 14px;
    color: #fff;
    margin: 0;
}
.ntah{
    color: #9ee0ff;
    text-decoration: none;
}

    </style>
</head>
<body class="user-page">
    <!-- Navigation -->
    <nav class="user-nav">
        <div class="user-nav-container">
            <a href="index.php" class="user-logo">
                <img src="../public/img/logo.png" alt="CoffeeSpace Logo">
                <span>Umbrella Cafe</span>
            </a>
            <div class="user-nav-links">
                <a href="index.php" class="user-nav-link active">
                    <i class='bx bx-home'></i> Home
                </a>
                <a href="menu.php" class="user-nav-link">
                    <i class='bx bx-coffee'></i> Menu
                </a>
                <a href="order.php" class="user-nav-link">
                    <i class='bx bx-receipt'></i> Order
                </a>
                <a href="../auth/logout.php" class="user-nav-link logout">
                    <i class='bx bx-log-out'></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <section class="user-greeting-bar">
    <h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?> 👋</h2>
    <p>Have a great coffee experience today! <br>
    When you feel like you drowning in an ocean of stress, <br>
    remember your savior walks on water<br><br>
    have a bad day? maybe a cup of coffe can help <a href="menu.php" class="ntah">Order Now</a></p>
</section>

    <script>
        // Highlight active nav link
        document.querySelectorAll('.user-nav-link').forEach(link => {
            if (link.href === window.location.href) {
                link.classList.add('active');
            }
        });
    </script>
</body>
</html>