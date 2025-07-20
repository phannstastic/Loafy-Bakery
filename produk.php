<?php 
session_start();
include('config.php');
include('includes/header.php'); 

// --- Logic untuk menambah ke keranjang ---
if (isset($_GET['add'])) {
    $id_produk = $_GET['add'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    if ($quantity > 0) {
        if (!isset($_SESSION['keranjang'])) {
            $_SESSION['keranjang'] = [];
        }

        if (isset($_SESSION['keranjang'][$id_produk])) {
            $_SESSION['keranjang'][$id_produk] += $quantity;
        } else {
            $_SESSION['keranjang'][$id_produk] = $quantity;
        }
    }

    header("Location: keranjang.php");
    exit();
}

// --- Logic untuk pencarian ---
$keyword = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
?>

<div class="product-hero text-center text-white py-5">
    <div class="container">
        <h1 class="display-4">Menu Roti Kami</h1>
        <p class="lead">Dipanggang Segar Setiap Hari dengan Bahan Berkualitas Premium</p>
    </div>
</div>

<div class="container my-4">
    <form action="produk.php" method="GET" class="d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Cari produk..." value="<?php echo htmlspecialchars($keyword); ?>">
        <button type="submit" class="btn btn-primary">Cari</button>
    </form>
</div>

<div class="container my-5">
    <div class="row g-4">
        <?php
        // === PERBAIKAN PADA BLOK QUERY DI SINI ===
        // 1. Mulai query dengan filter status wajib
        $query = "SELECT * FROM produk WHERE status_produk = 'tersedia'";

        // 2. Jika ada keyword, tambahkan kondisi pencarian dengan 'AND'
        if ($keyword) {
            // Gunakan tanda kurung untuk mengelompokkan kondisi OR dengan benar
            $query .= " AND (nama LIKE '%$keyword%' OR harga LIKE '%$keyword%')";
        }
        // Menambahkan urutan
        $query .= " ORDER BY id_produk DESC";

        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '
                <div class="col-sm-12 col-md-6 col-lg-4 d-flex">
                    <div class="product-card shadow-sm">
                        <div class="product-image-wrapper">
                            <img src="assets/images/'.$row['gambar'].'" alt="'.htmlspecialchars($row['nama']).'">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">'.htmlspecialchars($row['nama']).'</h5>
                            <p class="card-text">Rp. '.number_format($row['harga'], 0, ',', '.').'</p>
                            <form action="produk.php?add='.$row['id_produk'].'" method="POST" class="mt-auto">
                                <div class="quantity-input">
                                    <button type="button" class="quantity-btn" onclick="decrementQuantity(this)">-</button>
                                    <input type="number" name="quantity" value="1" min="1" max="99" readonly>
                                    <button type="button" class="quantity-btn" onclick="incrementQuantity(this)">+</button>
                                </div>';
                if (isset($_SESSION['user'])) {
                    echo '<button type="submit" class="btn btn-primary w-100">Tambah ke Keranjang</button>';
                } else {
                    echo '<a href="login.php" class="btn btn-warning w-100">Login untuk membeli</a>';
                }
                echo '      </form>
                        </div>
                    </div>
                </div>';
            }
        } else {
            echo '<div class="col-12"><p class="text-center alert alert-warning">Produk tidak ditemukan.</p></div>';
        }
        ?>
    </div>
</div>

<script>
    function decrementQuantity(button) {
        var input = button.parentElement.querySelector('input[type="number"]');
        var currentValue = parseInt(input.value);
        if (currentValue > 1) {
            input.value = currentValue - 1;
        }
    }

    function incrementQuantity(button) {
        var input = button.parentElement.querySelector('input[type="number"]');
        var currentValue = parseInt(input.value);
        if (currentValue < 99) { // Batasi maksimal 99
            input.value = currentValue + 1;
        }
    }
</script>

<style>
/* Hero Section */
.product-hero {
    background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('assets/images/produk.jpg');
    background-size: cover;
    background-position: center;
    padding: 100px 0;
    margin-bottom: 30px;
}

/* Product Cards */
.product-card {
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    height: 100%;
    width: 100%;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}

/* Image Container */
.product-image-wrapper {
    position: relative;
    overflow: hidden;
    padding-top: 75%; /* 4:3 aspect ratio */
    width: 100%;
}
.product-image-wrapper img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Card Body */
.card-body {
    padding: 1.25rem;
    flex-grow: 1; /* Membuat body kartu mengisi sisa ruang */
    display: flex;
    flex-direction: column;
}
.card-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    min-height: 2.4rem; 
}
.card-text {
    font-size: 1rem;
    color: #007bff; /* Warna biru untuk harga */
    font-weight: bold;
    margin-bottom: 1rem;
}

/* Quantity Input Container */
.quantity-input {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
}
.quantity-input input {
    width: 60px;
    text-align: center;
    border: 1px solid #ddd;
    border-left: none;
    border-right: none;
    height: 38px;
    -moz-appearance: textfield; /* Firefox */
}
/* Sembunyikan panah default di input number */
.quantity-input input::-webkit-outer-spin-button,
.quantity-input input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
.quantity-input .quantity-btn {
    width: 38px;
    height: 38px;
    border: 1px solid #ddd;
    background: #f8f8f8;
    cursor: pointer;
    font-size: 1.2rem;
}
.quantity-btn:first-child { border-radius: 0.25rem 0 0 0.25rem; }
.quantity-btn:last-child { border-radius: 0 0.25rem 0.25rem 0; }
</style>

<?php include('includes/footer.php'); ?>