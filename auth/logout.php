<?php
session_start();

// 1. Hapus semua data session
$_SESSION = array();

// 2. Hapus cookie session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), 
        '', 
        time() - 42000,
        $params["path"], 
        $params["domain"],
        $params["secure"], 
        $params["httponly"]
    );
}

// 3. Hancurkan session
session_destroy();

// 4. Redirect ke login
header("Location: login.php");
exit;
?>