# Loafy Bakery - Sistem Point of Sale Toko Roti Berbasis Web 🍞

Selamat datang di Loafy Bakery, sebuah aplikasi web Point of Sale (POS) dan etalase produk yang dirancang untuk toko roti. Sistem ini memungkinkan pelanggan untuk melihat produk dan melakukan pemesanan, sementara admin dapat mengelola seluruh aspek operasional mulai dari produk hingga verifikasi pesanan.
**URL Website:** [Kunjungi Website](httphttp://loafybakery.infinityfreeapp.com)

![Screenshot Loafy Bakery](deploy/deploy-website.png)

---

## ✨ Fitur Utama

### Untuk Pelanggan
**Pendaftaran & Login Pengguna**: Sistem otentikasi yang aman untuk pelanggan.
**Galeri Produk**: Menampilkan semua produk roti yang tersedia dengan gambar, nama, dan harga.
**Pencarian Produk**: Fitur pencarian untuk memudahkan pelanggan menemukan produk yang diinginkan. 
**Keranjang Belanja**: Pelanggan dapat menambah, mengubah jumlah, dan menghapus produk dari keranjang belanja.
**Proses Checkout**: Proses checkout yang menghasilkan kode unik untuk verifikasi di kasir.
**Riwayat Pesanan**: Pelanggan dapat melihat riwayat pesanan yang sedang berjalan dan yang sudah selesai.
**Cetak Struk**: Kemampuan untuk mencetak struk sebagai bukti transaksi.

### Untuk Admin
**Dashboard Admin**: Halaman utama untuk admin yang menyediakan akses cepat ke semua fitur manajemen. 
**Manajemen Produk (CRUD)**: Admin dapat menambah, melihat, dan mengarsipkan/memulihkan produk.
**Verifikasi Pesanan**: Admin dapat memverifikasi pesanan pelanggan menggunakan kode checkout yang unik.
**Manajemen Pesanan**: Melihat daftar semua pesanan yang masuk dari seluruh pelanggan.

---

## 🛠️ Teknologi yang Digunakan

**Backend**: PHP 
**Frontend**: HTML, CSS, JavaScript, Bootstrap 5 
**Database**: MySQL 
* **Web Server Lokal**: XAMPP

---

## 🚀 Instalasi & Konfigurasi Lokal

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di komputer lokal Anda:

1.  **Clone Repository**
    ```bash
    git clone [https://github.com/phannstastic/Loafy-Bakery.git](https://github.com/phannstastic/Loafy-Bakery.git)
    cd Loafy-Bakery
    ```

2.  **Setup Web Server**
    * Pastikan Anda sudah menginstall [XAMPP](https://www.apachefriends.org/index.html).
    * Pindahkan folder proyek `Loafy-Bakery` ke dalam direktori `C:\xampp\htdocs\`.

3.  **Buat Database**
    * Buka `phpMyAdmin` (`http://localhost/phpmyadmin`).
    Buat database baru dengan nama `loafy_bakery`.

4.  **Impor Database**
    * Pilih database `loafy_bakery` yang baru dibuat.
    * Klik tab `Import`.
    * Pilih file `loafy_bakery.sql` dari folder proyek Anda dan jalankan proses impor.

5.  **Konfigurasi Koneksi**
    * Di dalam folder proyek, buat salinan dari file `config.example.php` (jika ada) dan ubah namanya menjadi `config.php`. Jika tidak ada, buat file baru bernama `config.php`.
    * Buka file `config.php` dan sesuaikan kredensial database dengan pengaturan lokal Anda:
    ```php
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "loafy_bakery";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    ?>
    ```

6.  **Jalankan Aplikasi**
    * Buka browser Anda dan akses `http://localhost/Loafy-Bakery`.

---

## 📂 Struktur Folder
* `assets/` - Aset statis seperti gambar.
* `includes/` - Bagian kode yang digunakan berulang (header, footer).
* `admin.php` - Halaman utama admin.
* `config.php` - File konfigurasi koneksi (diabaikan oleh .gitignore).
* `index.php` - Halaman utama aplikasi.
* `keranjang.php` - Halaman keranjang belanja.
* `login.php` - Halaman login.
* `produk.php` - Halaman galeri produk.
* `loafy_bakery.sql` - File ekspor database.

---

Dibuat dengan ❤️ oleh **Tim Mata Kanan**
