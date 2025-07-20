<?php
session_start();
include('config.php');
include('includes/headerAdmin.php');

// Pastikan hanya admin yang bisa mengakses
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: login.php");
    exit();
}

// PERBAIKAN QUERY: Menggunakan tabel 'pengguna' dan kolom 'id_pengguna' & 'username'
$query = "SELECT p.*, u.username as nama_pelanggan FROM pesanan p JOIN pengguna u ON p.id_user = u.id_pengguna ORDER BY p.tanggal DESC";
$result = mysqli_query($conn, $query);
?>

<style>
    body { background-color: #f8f9fa; }
    .card { border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    .card-header { background-color: #fff; border-bottom: 1px solid #f0f0f0; font-weight: 600; font-size: 1.1rem; }
    .list-group-item { border: none; padding: 0.75rem 1.25rem; }
    .total-row { font-weight: bold; font-size: 1.1rem; }
    .print-button { font-size: 0.8rem; padding: 5px 12px; }

    /* Print styles */
    @media print {
        body * { visibility: hidden; }
        .print-area, .print-area * { visibility: visible; }
        .print-area { position: absolute; left: 0; top: 0; width: 100%; }
        .no-print { display: none !important; }
        .card { box-shadow: none; border: 1px solid #ddd; margin-bottom: 20px !important; }
        h2 { font-size: 1.5rem; text-align: center; }
    }
</style>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <h2 class="mb-0">Riwayat Semua Pesanan</h2>
        <button onclick="window.print()" class="btn btn-dark">🖨️ Cetak Laporan</button>
    </div>

    <div class="print-area">
        <h2 class="d-none d-print-block mb-4">Laporan Semua Pesanan</h2>

        <?php if(mysqli_num_rows($result) > 0): ?>
            <?php while ($pesanan = mysqli_fetch_assoc($result)): ?>
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Pesanan #<?php echo $pesanan['id']; ?> - Oleh: <?php echo htmlspecialchars($pesanan['nama_pelanggan']); ?></span>
                        <span class="text-muted" style="font-size: 0.9rem;"><?php echo date('d M Y, H:i', strtotime($pesanan['tanggal'])); ?></span>
                    </div>
                    <ul class="list-group list-group-flush">
                        <?php
                        $id_pesanan = $pesanan['id'];
                        $detail_query = "
                            SELECT pd.quantity, pd.total_harga, p.nama
                            FROM pesanan_detail pd
                            JOIN produk p ON pd.id_produk = p.id_produk
                            WHERE pd.id_pesanan = $id_pesanan
                        ";
                        $detail_result = mysqli_query($conn, $detail_query);
                        while ($detail = mysqli_fetch_assoc($detail_result)):
                        ?>
                            <li class="list-group-item d-flex justify-content-between">
                                <span><?php echo htmlspecialchars($detail['nama']); ?> (x<?php echo $detail['quantity']; ?>)</span>
                                <span>Rp. <?php echo number_format($detail['total_harga'], 0, ',', '.'); ?></span>
                            </li>
                        <?php endwhile; ?>
                        <li class="list-group-item d-flex justify-content-between total-row bg-light">
                            <span>TOTAL</span>
                            <span>Rp. <?php echo number_format($pesanan['total'], 0, ',', '.'); ?></span>
                        </li>
                    </ul>
                    <div class="card-footer bg-white text-end no-print">
                        <a href="cetak_struk.php?id=<?php echo $pesanan['id']; ?>" target="_blank" class="btn btn-primary print-button">Cetak Struk</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="alert alert-info">Belum ada pesanan yang tercatat.</div>
        <?php endif; ?>
    </div>
</div>

<?php include('includes/footer.php'); ?>