<?php
require_once '../admin/check_session.php';
require_once '../config/koneksi.php';

if ($_SESSION['role'] !== 'user') {
    header("Location: ../admin/index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id'])) {
    $item_id = intval($_POST['item_id']);
    $user_id = $_SESSION['user_id'];

    // Validasi: pastikan item milik user dan status masih pending
    $query = $conn->prepare("
        SELECT oi.id FROM order_items oi
        JOIN orders o ON oi.order_id = o.id
        WHERE oi.id = ? AND o.user_id = ? AND o.status = 'pending'
    ");
    $query->bind_param("ii", $item_id, $user_id);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        // Hapus item dari order_items
        $delete = $conn->prepare("DELETE FROM order_items WHERE id = ?");
        $delete->bind_param("i", $item_id);
        $delete->execute();
    }
}

header("Location: order.php"); // Kembali ke halaman riwayat
exit();
