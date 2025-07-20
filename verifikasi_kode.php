<?php
session_start();
include('config.php');
include('includes/headerAdmin.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode = $_POST['kode'];

    // Ambil data dari checkout_temp
    $stmt = $conn->prepare("SELECT * FROM checkout_temp WHERE kode = ?");
    $stmt->bind_param("s", $kode);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();

    if ($data) {
        $id_user = $data['id_user'];
        $total = $data['total'];
        $detail_keranjang = json_decode($data['detail'], true);  // Decode data keranjang

        // Simpan ke tabel pesanan
        $stmt = $conn->prepare("INSERT INTO pesanan (id_user, total) VALUES (?, ?)");
        $stmt->bind_param("ii", $id_user, $total);
        $stmt->execute();
        $id_pesanan = $stmt->insert_id;
        $stmt->close();

        // Simpan ke tabel pesanan_detail
        foreach ($detail_keranjang as $id_produk => $jumlah) {
            $res = mysqli_query($conn, "SELECT harga FROM produk WHERE id_produk = $id_produk");
            $produk = mysqli_fetch_assoc($res);
            $total_harga = $produk['harga'] * $jumlah;

            $stmt = $conn->prepare("INSERT INTO pesanan_detail (id_pesanan, id_produk, quantity, total_harga) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiii", $id_pesanan, $id_produk, $jumlah, $total_harga);
            $stmt->execute();
            $stmt->close();
        }

        // Hapus data dari checkout_temp setelah berhasil
        $stmt = $conn->prepare("DELETE FROM checkout_temp WHERE kode = ?");
        $stmt->bind_param("s", $kode);
        $stmt->execute();
        $stmt->close();

        echo '<div class="alert alert-success text-center mt-5">✅ Pesanan berhasil diverifikasi dan disimpan ke database utama.</div>';
    } else {
        echo '<div class="alert alert-danger text-center mt-5">❌ Kode tidak valid atau sudah digunakan.</div>';
    }
}
?>

<!-- Form Verifikasi -->
<!DOCTYPE html>
<html>
<head>
    <title>Verifikasi Kode Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow p-4 w-100" style="max-width: 400px;">
        <h3 class="text-center mb-4">Verifikasi Kode</h3>
        <form method="POST">
            <div class="mb-3">
                <label for="kode" class="form-label">Masukkan Kode Checkout:</label>
                <input type="text" name="kode" id="kode" class="form-control" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Verifikasi</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>

<?php include('includes/footer.php'); ?>