<?php
require_once 'check_session.php'; // WAJIB diinclude pertama
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin dashboard</title>
    <link rel="stylesheet" href="../public/css/style.css"> <!-- Hanya gunakan style.css -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body class="user-page">
    <!-- Navigation -->
    <nav class="user-nav">
        <div class="user-nav-container">
            <a href="index.php" class="user-logo">
                <img src="../public/img/logo.png" alt="CoffeeSpace Logo">
                <span>Umbrella cafe</span>
            </a>
            <div class="user-nav-links">
                <a href="index.php" class="user-nav-link active">
                    <i class='bx bx-home'></i> Home
                </a>
                <a href="additem.php" class="user-nav-link">
                    <i class='bx bx-coffee'></i>add item
                </a>
                <a href="seeorder.php" class="user-nav-link">
                    <i class='bx bx-receipt'></i>See Orders
                </a>
                <a href="../auth/logout.php" class="user-nav-link logout">
                    <i class='bx bx-log-out'></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="user-hero">
        <div class="user-hero-content">
            <h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?></h1>
            <p>See user orders</p>
            <a href="seeorder.php" class="user-primary-btn">
                See user orders<i class='bx bx-chevron-right'></i>
            </a>
        </div>
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