<?php
session_start();
include('config.php');
include('includes/headerAdmin.php');

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $harga = (int) $_POST['harga'];
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];

    $target = "assets/images/" . basename($gambar);
    move_uploaded_file($tmp, $target);

    $query = "INSERT INTO produk (nama, harga, gambar) VALUES ('$nama', '$harga', '$gambar')";
    if (mysqli_query($conn, $query)) {
        header("Location: daftar_produk.php");
        exit();
    } else {
        $error = "Gagal menyimpan data.";
    }
}
?>

<style>
/* Gaya untuk header */
h2 {
    font-size: 2rem; /* 32px */
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 24px;
    border-bottom: 2px solid #edf2f7;
    padding-bottom: 10px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    text-align: center;
}

/* Gaya untuk form */
form {
    background-color: #fff;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

/* Gaya untuk setiap input dan label */
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

/* Gaya untuk tombol submit */
button[type="submit"] {
    width: 100%;
    padding: 12px;
    font-size: 1.125rem; /* 18px */
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

/* Gaya untuk error message */
p.text-red-500 {
    color: #e53e3e;
    font-size: 0.875rem; /* 14px */
    font-weight: 500;
}

/* Gaya untuk form input ketika validasi sedang berjalan */
input:focus {
    outline: none;
    border-color: #3490dc;
}

/* Menambahkan margin antar form field */
.space-y-4 > div {
    margin-bottom: 1.25rem; /* 20px */
}

</style>

<div class="container mx-auto max-w-xl py-6">
    <h2 class="text-2xl font-semibold mb-6">Tambah Produk</h2>
    <?php if (isset($error)) echo "<p class='text-red-500 mb-4'>$error</p>"; ?>
    <form method="POST" enctype="multipart/form-data" class="space-y-4">
        <div>
            <label class="block mb-1 font-medium">Nama Produk</label>
            <input type="text" name="nama" class="w-full border px-3 py-2 rounded-lg" required>
        </div>
        <div>
            <label class="block mb-1 font-medium">Harga</label>
            <input type="number" name="harga" class="w-full border px-3 py-2 rounded-lg" required>
        </div>
        <div>
            <label class="block mb-1 font-medium">Gambar Produk</label>
            <input type="file" name="gambar" class="w-full">
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Simpan</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>