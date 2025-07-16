<?php
require_once 'check_session.php';
require_once '../config/koneksi.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../user/index.php");
    exit();
}

$query = $conn->query("
    SELECT 
        o.order_date, 
        u.username, 
        p.name AS product_name, 
        oi.quantity, 
        oi.price, 
        o.total_price, 
        o.status
    FROM orders o
    JOIN users u ON o.user_id = u.id
    JOIN order_items oi ON oi.order_id = o.id
    JOIN products p ON oi.product_id = p.id
    ORDER BY o.order_date DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Semua Pesanan - Admin</title>
  <link rel="stylesheet" href="../public/css/style.css" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <style>
    .orders-container {
      max-width: 1000px;
      margin: auto;
      padding: 2rem;
    }

    .orders-table {
      width: 100%;
      border-collapse: collapse;
      background: rgba(255, 255, 255, 0.05);
      color: #fff;
      font-size: 14px;
    }

    .orders-table th, .orders-table td {
      border: 1px solid rgba(255,255,255,0.1);
      padding: 10px;
      text-align: center;
    }

    .orders-table th {
      background: rgba(0,0,0,0.4);
    }

    .orders-table tr:nth-child(even) {
      background-color: rgba(255, 255, 255, 0.03);
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
        <a href="index.php" class="user-nav-link"><i class='bx bx-home'></i> Home</a>
        <a href="additem.php" class="user-nav-link"><i class='bx bx-coffee'></i> Add Item</a>
        <a href="seeorder.php" class="user-nav-link active"><i class='bx bx-receipt'></i> See Orders</a>
        <a href="../auth/logout.php" class="user-nav-link logout"><i class='bx bx-log-out'></i> Logout</a>
      </div>
    </div>
  </nav>

  <!-- Content -->
  <div class="orders-container">
    <h2 style="text-align:center; margin-bottom: 20px;">Semua Pesanan Pengguna</h2>

    <table class="orders-table">
      <thead>
        <tr>
          <th>Tanggal</th>
          <th>User</th>
          <th>Produk</th>
          <th>Qty</th>
          <th>Harga</th>
          <th>Total</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($query->num_rows > 0): ?>
          <?php while ($row = $query->fetch_assoc()): ?>
            <tr>
              <td><?= date('d-m-Y H:i', strtotime($row['order_date'])) ?></td>
              <td><?= htmlspecialchars($row['username']) ?></td>
              <td><?= htmlspecialchars($row['product_name']) ?></td>
              <td><?= $row['quantity'] ?></td>
              <td>Rp <?= number_format($row['price'], 0, ',', '.') ?></td>
              <td>Rp <?= number_format($row['price'] * $row['quantity'], 0, ',', '.') ?></td>
              <td><?= ucfirst($row['status']) ?></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="7">Belum ada pesanan.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <script>
    // Highlight nav aktif
    document.querySelectorAll('.user-nav-link').forEach(link => {
      if (link.href === window.location.href) {
        link.classList.add('active');
      }
    });
  </script>
</body>
</html>
