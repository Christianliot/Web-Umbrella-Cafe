<?php
require_once '../admin/check_session.php';
require_once '../config/koneksi.php';

if ($_SESSION['role'] !== 'user') {
    header("Location: ../admin/index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = '';

// Proses pesanan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_id'], $_POST['quantity'])) {
        $product_id = (int)$_POST['product_id'];
        $quantity = (int)$_POST['quantity'];

        $product = $conn->query("SELECT price, stock FROM products WHERE id = $product_id")->fetch_assoc();
        if ($quantity > $product['stock']) {
            $message = "error:Stok tidak mencukupi!";
        } else {
            $total_price = $product['price'] * $quantity;

            $conn->begin_transaction();
            try {
                $stmt = $conn->prepare("INSERT INTO orders (user_id, order_date, status, total_price) VALUES (?, NOW(), 'pending', ?)");
                $stmt->bind_param("id", $user_id, $total_price);
                $stmt->execute();
                $order_id = $conn->insert_id;

                $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $product['price']);
                $stmt->execute();

                $conn->query("UPDATE products SET stock = stock - $quantity WHERE id = $product_id");

                $conn->commit();
                $message = "success:Pesanan berhasil dibuat!";
            } catch (Exception $e) {
                $conn->rollback();
                $message = "error:Gagal membuat pesanan: " . $e->getMessage();
            }
        }
    }
}

$products = $conn->query("SELECT * FROM products WHERE stock > 0");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order - CoffeeSpace</title>
  <link rel="stylesheet" href="../public/css/style.css">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <style>
 .order-table {
  width: 100%;
  border-collapse: collapse;
  background: rgba(255, 255, 255, 0.05);
  color: #fff;
  font-size: 14px;
  margin-top: 20px;
}

.order-table th, .order-table td {
  border: 1px solid rgba(255,255,255,0.1);
  padding: 10px;
  text-align: center;
  vertical-align: middle;
}

.order-table th {
  background: rgba(0,0,0,0.4);
}

.table-img {
  width: 60px;
  height: 60px;
  object-fit: cover;
  border-radius: 5px;
}

.qty-field {
  width: 50px;
  padding: 5px;
  border-radius: 5px;
  border: none;
  text-align: center;
}

.inline-form {
  display: inline-flex;
  gap: 5px;
  align-items: center;
}

.order-btn {
  padding: 5px 10px;
  background: #fff;
  color: #333;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.order-btn:hover {
  background: #f0c040;
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
        <a href="order.php" class="user-nav-link active"><i class='bx bx-cart'></i> Order</a>
        <a href="../auth/logout.php" class="user-nav-link logout"><i class='bx bx-log-out'></i> Logout</a>
      </div>
    </div>
  </nav>

  <!-- Konten -->
  <div class="order-container">
  <h2 style="text-align:center; margin-bottom: 20px;">Pesan Produk</h2>

  <?php if ($message): ?>
    <?php list($type, $text) = explode(':', $message, 2); ?>
    <div class="order-message <?= $type ?>"><?= htmlspecialchars($text) ?></div>
  <?php endif; ?>

  <table class="order-table">
    <thead>
      <tr>
        <th>Gambar</th>
        <th>Nama</th>
        <th>Deskripsi</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Jumlah</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($p = $products->fetch_assoc()): ?>
        <tr>
          <td><img src="../public/img/products/<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" class="table-img"></td>
          <td><?= htmlspecialchars($p['name']) ?></td>
          <td><?= htmlspecialchars($p['description']) ?></td>
          <td>Rp <?= number_format($p['price'], 0, ',', '.') ?></td>
          <td><?= $p['stock'] ?></td>
          <td>
            <form method="POST" class="inline-form">
              <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
              <input type="number" name="quantity" value="1" min="1" max="<?= $p['stock'] ?>" class="qty-field">
          </td>
          <td>
              <button type="submit" class="order-btn">Pesan</button>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>


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
