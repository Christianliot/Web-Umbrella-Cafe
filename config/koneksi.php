<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'coffe_shop';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Set charset
mysqli_set_charset($conn, 'utf8mb4');
?>