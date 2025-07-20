<?php
session_start();
include('config.php');
include('includes/headerAdmin.php');

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: login.php");
    exit();
}

// Mengambil data produk yang akan diedit
$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk = $id");
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "<p class='text-red-500 text-center'>Produk tidak ditemukan.</p>";
    exit();
}

// Proses update data ketika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $harga = (int) $_POST['harga'];
    $update_query = "UPDATE produk SET nama='$nama', harga='$harga'";

    // Cek apakah ada file gambar baru yang diupload
    if (isset($_FILES['gambar']) && $_FILES['gambar']['name'] != "") {
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        
        // Hapus gambar lama jika ada
        if ($data['gambar'] && file_exists("assets/images/" . $data['gambar'])) {
            unlink("assets/images/" . $data['gambar']);
        }

        // Pindahkan gambar baru
        move_uploaded_file($tmp, "assets/images/$gambar");
        $update_query .= ", gambar='$gambar'";
    }

    $update_query .= " WHERE id_produk=$id";

    if (mysqli_query($conn, $update_query)) {
        header("Location: daftar_produk.php");
        exit();
    } else {
        $error = "Gagal memperbarui data.";
    }
}
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
form {
    background-color: #fff;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}
input[type="text"], input[type="number"], input[type="file"] {
    width: 100%;
    padding: 12px 15px;
    margin-top: 8px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 1rem;
    box-sizing: border-box;
}
input[type="file"] {
    padding: 8px 10px;
    background-color: #f7f7f7;
}
label {
    font-size: 1rem;
    font-weight: 500;
    color: #555;
}
button[type="submit"] {
    width: 100%;
    padding: 12px;
    font-size: 1.125rem;
    background-color: #3490dc;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}
button[type="submit"]:hover {
    background-color: #2779bd;
}
p.text-red-500 {
    color: #e53e3e;
    font-size: 0.875rem;
    font-weight: 500;
}
input:focus {
    outline: none;
    border-color: #3490dc;
}
.space-y-4 > div {
    margin-bottom: 1.25rem;
}
</style>

<div class="container mx-auto max-w-xl py-6">
    <h2>Edit Produk</h2>
    <?php if (isset($error)) echo "<p class='text-red-500 mb-4'>$error</p>"; ?>
    
    <form method="POST" enctype="multipart/form-data" class="space-y-4">
        <div>
            <label>Nama Produk</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>
        </div>
        <div>
            <label>Harga</label>
            <input type="number" name="harga" value="<?= $data['harga'] ?>" required>
        </div>
        <div>
            <label>Ganti Gambar (Opsional)</label>
            <input type="file" name="gambar">
            <div style="margin-top: 10px;">
                <p style="font-size: 0.875rem; color: #555; margin-bottom: 5px;">Gambar Saat Ini:</p>
                <img src="assets/images/<?= htmlspecialchars($data['gambar']) ?>" width="100" style="border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
            </div>
        </div>
        
        <button type="submit">Simpan Perubahan</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>