<?php
session_start();
include('config.php');

if (!isset($_GET['id'])) {
    die("ID Pesanan tidak ditemukan.");
}

$id_pesanan = intval($_GET['id']);

// PERBAIKAN QUERY: Menggunakan tabel 'pengguna' dan kolom 'id_pengguna' & 'username'
$query_pesanan = "
    SELECT p.*, u.username as nama_pelanggan 
    FROM pesanan p 
    JOIN pengguna u ON p.id_user = u.id_pengguna 
    WHERE p.id = ?
";
$stmt_pesanan = $conn->prepare($query_pesanan);
$stmt_pesanan->bind_param("i", $id_pesanan);
$stmt_pesanan->execute();
$pesanan = $stmt_pesanan->get_result()->fetch_assoc();

if (!$pesanan) {
    die("Pesanan tidak valid.");
}

// Ambil detail pesanan
$query_detail = "
    SELECT pd.quantity, pd.total_harga, pr.nama as nama_produk 
    FROM pesanan_detail pd 
    JOIN produk pr ON pd.id_produk = pr.id_produk 
    WHERE pd.id_pesanan = ?
";
$stmt_detail = $conn->prepare($query_detail);
$stmt_detail->bind_param("i", $id_pesanan);
$stmt_detail->execute();
$detail_result = $stmt_detail->get_result();

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pesanan #<?php echo $pesanan['id']; ?></title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Courier+Prime:wght@400;700&display=swap');
        body {
            font-family: 'Courier Prime', monospace;
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            color: #000;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 1.5rem;
        }
        .info, .items, .total {
            margin-bottom: 15px;
        }
        .info p, .items p, .total p {
            margin: 3px 0;
        }
        .line {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
        .items table {
            width: 100%;
            border-collapse: collapse;
        }
        .items th, .items td {
            padding: 2px 0;
        }
        .items .qty {
            text-align: left;
        }
        .items .price {
            text-align: right;
        }
        .total {
            text-align: right;
        }
        .footer {
            text-align: center;
            font-size: 0.8rem;
        }
        @media print {
            body { margin: 0; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h1>Loafy Bakery</h1>
        <p>Jl. Roti Enak No. 123, Jakarta</p>
    </div>

    <div class="info">
        <p>No: #<?php echo htmlspecialchars($pesanan['id']); ?></p>
        <p>Tgl: <?php echo date('d/m/y H:i', strtotime($pesanan['tanggal'])); ?></p>
        <p>Plg: <?php echo htmlspecialchars($pesanan['nama_pelanggan']); ?></p>
    </div>

    <div class="line"></div>

    <div class="items">
        <table>
            <?php while($detail = $detail_result->fetch_assoc()): ?>
            <tr>
                <td colspan="2"><?php echo htmlspecialchars($detail['nama_produk']); ?></td>
            </tr>
            <tr>
                <td class="qty"><?php echo $detail['quantity']; ?> x <?php echo number_format($detail['total_harga'] / $detail['quantity'], 0, ',', '.'); ?></td>
                <td class="price"><?php echo number_format($detail['total_harga'], 0, ',', '.'); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
    
    <div class="line"></div>

    <div class="total">
        <p>Total: Rp <?php echo number_format($pesanan['total'], 0, ',', '.'); ?></p>
    </div>
    
    <div class="line"></div>

    <div class="footer">
        <p>Terima Kasih Atas Kunjungan Anda</p>
    </div>

</body>
</html>