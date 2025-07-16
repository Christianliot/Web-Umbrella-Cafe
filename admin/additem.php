<?php
require_once 'check_session.php';
require_once '../config/koneksi.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../user/index.php");
    exit();
}

$success = $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $price = (int) $_POST['price'];
    $description = htmlspecialchars($_POST['description']);
    $stock = (int) $_POST['stock'];

    // Upload gambar
    $imageName = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $imageName = uniqid() . '.' . $ext;
        move_uploaded_file($_FILES['image']['tmp_name'], "../public/img/products/" . $imageName);
    }

    // Simpan ke database
    $stmt = $conn->prepare("INSERT INTO products (name, price, description, stock, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sisds", $name, $price, $description, $stock, $imageName);

    if ($stmt->execute()) {
        $success = "Produk berhasil ditambahkan!";
    } else {
        $error = "Gagal menambahkan produk: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Menu - Admin</title>
  <link rel="stylesheet" href="../public/css/style.css">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
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
        <a href="menu.php" class="user-nav-link active"><i class='bx bx-coffee'></i> Add Item</a>
        <a href="seeorder.php" class="user-nav-link"><i class='bx bx-receipt'></i> See Orders</a>
        <a href="../auth/logout.php" class="user-nav-link logout"><i class='bx bx-log-out'></i> Logout</a>
      </div>
    </div>
  </nav>

  <section class="user-featured">
    <h2 class="user-section-title">Tambah Menu Baru</h2>

    <?php if ($success): ?>
      <p style="color: lightgreen; text-align:center;"><?= $success ?></p>
    <?php elseif ($error): ?>
      <p style="color: red; text-align:center;"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="admin-form">
      <input type="text" name="name" placeholder="Nama Produk" required>
      <input type="number" name="price" placeholder="Harga (Rp)" required>
      <textarea name="description" placeholder="Deskripsi Produk" rows="3" required></textarea>
      <input type="number" name="stock" placeholder="Stok" required>
      <input type="file" name="image" accept="image/*" required>
      <button type="submit" class="btn">Tambah</button>
    </form>
  </section>

  <script>
    document.querySelectorAll('.user-nav-link').forEach(link => {
      if (link.href === window.location.href) {
        link.classList.add('active');
      }
    });
  </script>
</body>
</html>
