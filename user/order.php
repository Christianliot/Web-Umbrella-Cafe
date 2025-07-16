<?php
require_once '../admin/check_session.php';
require_once '../config/koneksi.php';

if ($_SESSION['role'] !== 'user') {
    header("Location: ../admin/index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = $conn->prepare("
    SELECT o.order_date, o.status, p.name, oi.quantity, oi.price, oi.id AS item_id
    FROM orders o
    JOIN order_items oi ON o.id = oi.order_id
    JOIN products p ON oi.product_id = p.id
    WHERE o.user_id = ?
    ORDER BY o.order_date DESC
");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Riwayat Pesanan - CoffeeSpace</title>
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

    .orders-table th,
    .orders-table td {
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
  <!-- Navigasi -->
  <nav class="user-nav">
    <div class="user-nav-container">
      <a href="index.php" class="user-logo">
        <img src="../public/img/logo.png" alt="CoffeeSpace Logo">
        <span>Umbrella Cafe</span>
      </a>
      <div class="user-nav-links">
        <a href="index.php" class="user-nav-link"><i class='bx bx-home'></i> Home</a>
        <a href="menu.php" class="user-nav-link"><i class='bx bx-coffee'></i> Menu</a>
        <a href="order.php" class="user-nav-link"><i class='bx bx-cart'></i> Order</a>
        <a href="../auth/logout.php" class="user-nav-link logout"><i class='bx bx-log-out'></i> Logout</a>
      </div>
    </div>
  </nav>

  <div class="orders-container">
    <h2 style="text-align:center; margin-bottom: 20px;">Riwayat Pesanan</h2>

    <table class="orders-table">
      <thead>
        <tr>
          <th>Tanggal</th>
          <th>Produk</th>
          <th>Jumlah</th>
          <th>Harga</th>
          <th>Total</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
  <?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= date('d-m-Y H:i', strtotime($row['order_date'])) ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= $row['quantity'] ?></td>
        <td>Rp <?= number_format($row['price'], 0, ',', '.') ?></td>
        <td>Rp <?= number_format($row['price'] * $row['quantity'], 0, ',', '.') ?></td>
        <td>
          <?= ucfirst($row['status']) ?>
          <?php if (strtolower($row['status']) === 'pending'): ?>
            <form action="cancel_item.php" method="POST" style="margin-top: 5px;">
              <input type="hidden" name="item_id" value="<?= $row['item_id'] ?>">
              <button type="submit" onclick="return confirm('Yakin ingin membatalkan item ini?')">Cancel</button>
            </form>
          <?php endif; ?>
        </td>
      </tr>
    <?php endwhile; ?>
  <?php else: ?>
    <tr><td colspan="6">Belum ada pesanan.</td></tr>
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
