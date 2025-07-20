<?php
session_start();
include('config.php');

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION['user']['id'];
$keranjang = $_SESSION['keranjang'] ?? [];

if (empty($keranjang)) {
    echo "Keranjang kosong.";
    exit;
}

// Hitung total
$total = 0;
foreach ($keranjang as $id_produk => $jumlah) {
    $result = mysqli_query($conn, "SELECT harga FROM produk WHERE id_produk = $id_produk");
    $data = mysqli_fetch_assoc($result);
    $total += $data['harga'] * $jumlah;
}

// Generate kode checkout unik (6 karakter acak)
$kode = strtoupper(substr(md5(uniqid(rand(), true)), 0, 6));

// Simpan detail keranjang sebagai JSON
$detail_json = json_encode($keranjang);

// Simpan ke checkout_temp
$stmt = $conn->prepare("INSERT INTO checkout_temp (kode, id_user, total, detail) VALUES (?, ?, ?, ?)");
$stmt->bind_param("siis", $kode, $id_user, $total, $detail_json);
$stmt->execute();


// Kosongkan keranjang agar tidak diulang
unset($_SESSION['keranjang']);
$_SESSION['checkout_kode'] = $kode;
$_SESSION['total_belanja'] = $total;

// Tampilkan kode ke user
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kode Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="text-center border p-5 bg-white shadow rounded">
        <h1 class="mb-3 text-success">Checkout Berhasil</h1>
        <p>Berikan kode berikut ke kasir untuk memproses pesanan Anda:</p>
        <h2 class="display-4 fw-bold text-primary"><?php echo $kode; ?></h2>
        <p class="text-muted">Total: Rp. <?php echo number_format($total, 0, ',', '.'); ?></p>
        <a href="index.php" class="btn btn-secondary mt-3">Kembali ke Beranda</a>
    </div>
</body>
</html>

