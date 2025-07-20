<?php
session_start();
include('config.php');
include('includes/headerAdmin.php');

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: login.php");
    exit();
}
?>

    <!-- Main Content -->
    <div class="container mx-auto flex-1 p-5">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
        <!-- Product Management Section -->
        <div class="bg-white p-6 shadow-lg rounded-lg">
            <h3 class="text-lg font-semibold mb-4">Kelola Produk</h3>
            <a href="tambah_produk.php" class="block bg-blue-500 text-white p-3 rounded-lg text-center mb-4 hover:bg-blue-600 transition-all duration-300">Tambah Produk</a>
            <a href="daftar_produk.php" class="block bg-yellow-500 text-white p-3 rounded-lg text-center hover:bg-yellow-600 transition-all duration-300">Daftar Produk</a>
        </div>
                
        <!-- Payment Verification Section -->
        <div class="bg-white p-6 shadow-lg rounded-lg">
            <h3 class="text-lg font-semibold mb-4">Verifikasi Pesanan</h3>
            <a href="verifikasi_kode.php" class="block bg-green-500 text-white p-3 rounded-lg text-center hover:bg-green-600 transition-all duration-300">Verifikasi Pesanan</a>
        </div>

        <!-- Order Management Section -->
        <div class="bg-white p-6 shadow-lg rounded-lg">
            <h3 class="text-lg font-semibold mb-4">Daftar Pesanan</h3>
            <a href="pesanan.php" class="block bg-indigo-500 text-white p-3 rounded-lg text-center hover:bg-indigo-600 transition-all duration-300">Lihat Daftar Pesanan</a>
        </div>
    </div>

    <div style="margin-top: 5rem;"></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<style>
    /* General styling for the container */
.container {
    max-width: 1200px;
    margin: 0 auto;
}

/* Grid layout for product management sections */
.grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
}

@media (min-width: 768px) {
    .grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

/* Styling for the individual sections */
.bg-white {
    background-color: #ffffff;
}

.p-6 {
    padding: 1.5rem;
}

.shadow-lg {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.rounded-lg {
    border-radius: 0.5rem;
}

.text-lg {
    font-size: 1.125rem;
}

.font-semibold {
    font-weight: 600;
}

.mb-4 {
    margin-bottom: 1rem;
}

/* Button styles */
a.block {
    display: block;
    text-decoration: none;
    border-radius: 0.375rem;
    padding: 1rem;
    text-align: center;
    font-weight: 500;
    transition: background-color 0.3s ease;
}

a:hover {
    opacity: 0.9;
}

.bg-blue-500 {
    background-color: #3b82f6;
    color: white;
}

.bg-yellow-500 {
    background-color: #f59e0b;
    color: white;
}

.bg-green-500 {
    background-color: #10b981;
    color: white;
}

.bg-indigo-500 {
    background-color: #6366f1;
    color: white;
}

/* Hover states for buttons */
a.bg-blue-500:hover {
    background-color: #2563eb;
}

a.bg-yellow-500:hover {
    background-color: #d97706;
}

a.bg-green-500:hover {
    background-color: #059669;
}

a.bg-indigo-500:hover {
    background-color: #4f46e5;
}

/* Make buttons full width on small screens */
@media (max-width: 768px) {
    a.block {
        width: 100%;
    }
}

</style>

<?php include('includes/footer.php'); ?>