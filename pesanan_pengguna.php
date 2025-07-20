<?php
session_start();
include('config.php');
include('includes/header.php');

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION['user']['id'];
?>

<style>
    body { background-color: #f8f9fa; }
    .card { border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    .card-header { background-color: #fff; border-bottom: 1px solid #f0f0f0; font-weight: 600; font-size: 1.1rem; }
    .list-group-item { border: none; padding: 0.75rem 1.25rem; }
    .total-row { font-weight: bold; font-size: 1.1rem; }
    .print-button { font-size: 0.8rem; padding: 5px 12px; }
    h2 { border-bottom: 2px solid #dee2e6; padding-bottom: 10px; }
</style>

<div class="container py-5">
    <h2 class="mb-4">📦 Pesanan Berjalan</h2>
    <?php
    $ongoing_query = "SELECT * FROM checkout_temp WHERE id_user = ? ORDER BY tanggal DESC";
    $stmt_ongoing = $conn->prepare($ongoing_query);
    $stmt_ongoing->bind_param("i", $id_user);
    $stmt_ongoing->execute();
    $ongoing_result = $stmt_ongoing->get_result();
    ?>

    <?php if ($ongoing_result->num_rows > 0): ?>
        <?php while ($row = $ongoing_result->fetch_assoc()): ?>
            <div class="card mb-3 border-left-warning shadow-sm">
                <div class="card-body">
                    <p class="mb-1 text-muted">Tanggal: <?php echo date('d M Y, H:i', strtotime($row['tanggal'])); ?></p>
                    <p class="mb-1">Kode Checkout: <span class="fw-bold text-primary"><?php echo $row['kode']; ?></span></p>
                    <p>Total: Rp. <?php echo number_format($row['total'], 0, ',', '.'); ?></p>
                    <div class="alert alert-warning mt-2 mb-0">
                        ⏳ Menunggu diverifikasi oleh kasir.
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="alert alert-info">Tidak ada pesanan yang sedang berjalan.</div>
    <?php endif; ?>

    <h2 class="mb-4 mt-5">✔️ Pesanan Selesai</h2>
    <?php
    $query = "SELECT * FROM pesanan WHERE id_user = ? ORDER BY tanggal DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $result = $stmt->get_result();
    ?>
    <?php if($result->num_rows > 0): ?>
        <?php while ($pesanan = $result->fetch_assoc()): ?>
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Pesanan #<?php echo $pesanan['id']; ?></span>
                    <span class="text-muted" style="font-size: 0.9rem;"><?php echo date('d M Y, H:i', strtotime($pesanan['tanggal'])); ?></span>
                </div>
                 <ul class="list-group list-group-flush">
                    <?php
                    $id_pesanan = $pesanan['id'];
                    $detail_query = "
                        SELECT pd.quantity, pd.total_harga, p.nama
                        FROM pesanan_detail pd
                        JOIN produk p ON pd.id_produk = p.id_produk
                        WHERE pd.id_pesanan = ?
                    ";
                    $stmt_detail = $conn->prepare($detail_query);
                    $stmt_detail->bind_param("i", $id_pesanan);
                    $stmt_detail->execute();
                    $detail_result = $stmt_detail->get_result();
                    while ($detail = $detail_result->fetch_assoc()):
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
                <div class="card-footer bg-white text-end">
                    <a href="cetak_struk.php?id=<?php echo $pesanan['id']; ?>" target="_blank" class="btn btn-primary print-button">Cetak Struk</a>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="alert alert-info">Belum ada riwayat pesanan yang selesai.</div>
    <?php endif; ?>
</div>

<?php include('includes/footer.php'); ?>