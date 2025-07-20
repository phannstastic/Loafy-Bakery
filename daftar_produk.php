<?php
session_start();
include('config.php');
include('includes/headerAdmin.php');

// Pastikan hanya admin yang bisa mengakses
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: login.php");
    exit();
}

// === LOGIKA UNTUK MENGARSIPKAN PRODUK ===
if (isset($_GET['arsip'])) {
    $id = intval($_GET['arsip']);
    // Mengubah status produk menjadi 'diarsipk`an'
    $query_arsip = "UPDATE produk SET status_produk = 'diarsipk`an' WHERE id_produk = ?";
    $stmt = mysqli_prepare($conn, $query_arsip);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    header("Location: daftar_produk.php");
    exit();
}

// === LOGIKA UNTUK MEMULIHKAN PRODUK ===
if (isset($_GET['pulihkan'])) {
    $id = intval($_GET['pulihkan']);
    // Mengubah status produk kembali menjadi 'tersedia'
    $query_pulihkan = "UPDATE produk SET status_produk = 'tersedia' WHERE id_produk = ?";
    $stmt = mysqli_prepare($conn, $query_pulihkan);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    header("Location: daftar_produk.php");
    exit();
}

// Mengambil semua produk (tersedia dan diarsipk`an) untuk ditampilkan di admin
$result = mysqli_query($conn, "SELECT * FROM produk ORDER BY id_produk DESC");
?>

<style>
    h2 {
        font-size: 2rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 24px;
        border-bottom: 2px solid #edf2f7;
        padding-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-align: center;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 12px;
        text-align: left;
        border: 1px solid #ddd;
    }
    th {
        background-color: #f7fafc;
        color: #4a5568;
        font-weight: 600;
    }
    td img {
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    a {
        text-decoration: none;
        font-weight: 600;
    }
    a:hover {
        text-decoration: underline;
    }
    /* Style untuk baris produk yang diarsipk`an */
    .archived-row {
        background-color: #f1f1f1; /* Warna abu-abu */
        opacity: 0.7; /* Sedikit transparan */
    }
    .archived-row td {
        color: #718096; /* Teks abu-abu */
    }
</style>

<div class="container mx-auto py-6">
    <h2 class="text-2xl font-semibold mb-4">Daftar Produk</h2>
    <div class="overflow-x-auto">
        <table class="w-full border text-sm text-left">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2">Gambar</th>
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">Harga</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <?php
                        // Menentukan style CSS jika produk diarsipk`an
                        $row_class = ($row['status_produk'] == 'diarsipk`an') ? 'archived-row' : '';
                    ?>
                    <tr class="border-b <?= $row_class ?>">
                        <td class="px-4 py-2">
                            <img src="assets/images/<?= htmlspecialchars($row['gambar']) ?>" width="80" class="rounded shadow">
                        </td>
                        <td class="px-4 py-2"><?= htmlspecialchars($row['nama']) ?></td>
                        <td class="px-4 py-2">Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                        <td class="px-4 py-2">
                            <?php if ($row['status_produk'] == 'tersedia'): ?>
                                <span style="background-color: #dcfce7; color: #166534; font-weight: 700; font-size: 0.75rem; padding: 4px 8px; border-radius: 999px;">
                                    Tersedia
                                </span>
                            <?php else: ?>
                                <span style="background-color: #e5e7eb; color: #1f2937; font-weight: 700; font-size: 0.75rem; padding: 4px 8px; border-radius: 999px;">
                                    Diarsipkan
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-2" style="white-space: nowrap;">
                            <a href="edit_produk.php?id=<?= $row['id_produk'] ?>" 
                            style="background-color: #3b82f6; color: white; padding: 5px 10px; margin-right: 5px; border-radius: 5px; text-decoration: none; font-size: 13px;">
                            Edit 
                            </a>

                            <?php if ($row['status_produk'] == 'tersedia'): ?>
                                <a href="daftar_produk.php?arsip=<?= $row['id_produk'] ?>" 
                                style="background-color: #f97316; color: white; padding: 5px 10px; border-radius: 5px; text-decoration: none; font-size: 13px;" 
                                onclick="return confirm('Anda yakin ingin mengarsipkan produk ini?')">
                                Arsipkan
                                </a>
                            <?php else: ?>
                                <a href="daftar_produk.php?pulihkan=<?= $row['id_produk'] ?>" 
                                style="background-color: #22c55e; color: white; padding: 5px 10px; border-radius: 5px; text-decoration: none; font-size: 13px;" 
                                onclick="return confirm('Anda yakin ingin memulihkan produk ini?')">
                                Pulihkan
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('includes/footer.php'); ?> 