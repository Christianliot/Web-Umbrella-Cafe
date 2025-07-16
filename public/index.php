<?php
require_once '../config/koneksi.php';
session_start();

// Routing dasar
$page = $_GET['page'] ?? 'login';

switch($page) {
    case 'login':
        require_once '../app/controllers/LoginController.php';
        $controller = new LoginController();
        $controller->index();
        break;
        
    case 'admin/dashboard':
        require_once '../app/controllers/BarangController.php';
        $controller = new BarangController();
        $controller->dashboardAdmin();
        break;
        
    // Tambahkan case lainnya sesuai kebutuhan
    default:
        header("HTTP/1.0 404 Not Found");
        echo "Halaman tidak ditemukan";
        break;
}
?>