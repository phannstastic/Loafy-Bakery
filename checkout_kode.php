<?php session_start(); ?>
<?php include('includes/header.php'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kode Pemesanan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container text-center py-5">
  <h2 class="mb-4">Tunjukkan Kode Ini ke Kasir</h2>
  <h1 class="display-4 bg-light py-3 border"><?= $_SESSION['checkout']['kode'] ?? 'ERROR' ?></h1>
  <p class="text-muted">Jangan tutup halaman ini sampai kasir memverifikasi.</p>
</div>
</body>
</html>

<?php include('includes/footer.php'); ?>