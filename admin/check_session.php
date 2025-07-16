<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Session timeout (30 menit)
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    session_unset();
    session_destroy();
    header("Location: ../login.php?timeout=1");
    exit();
}
$_SESSION['LAST_ACTIVITY'] = time();

// Tidak perlu redirect role di sini (akan dihandle masing-masing halaman)
?>