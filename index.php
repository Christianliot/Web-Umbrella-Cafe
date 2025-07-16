<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_role'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: auth/login.php");
    exit();
}

// Routing berdasar role (admin/user)
switch ($_SESSION['user_role']) {
    case 'admin':
        header("Location: admin/index.php");
        break;

    case 'user':
        header("Location: user/index.php");
        break;

    default:
        echo "Role tidak dikenali.";
}
