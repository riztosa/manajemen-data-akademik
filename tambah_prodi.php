<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include 'koneksi.php';

  $kode_prodi = $_POST['kode_prodi'];
  $nama_prodi = $_POST['nama_prodi'];
  $akreditasi = $_POST['akreditasi'];

  $query = "INSERT INTO program_studi (kode_prodi, nama_prodi, akreditasi) VALUES (?, ?, ?)";

  $stmt = mysqli_prepare($koneksi, $query);
  mysqli_stmt_bind_param($stmt, "sss", $kode_prodi, $nama_prodi, $akreditasi);

  if (mysqli_stmt_execute($stmt)) {
    header("Location: index.php#prodi-tab-pane");
    exit();
  } else {
    echo "Error: " . mysqli_error($koneksi);
  }
  mysqli_stmt_close($stmt);
  mysqli_close($koneksi);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Tambah Program Studi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container mt-4">
    <div class="card">
      <div class="card-header">
        <h3>Form Tambah Program Studi</h3>
      </div>
      <div class="card-body">
        <form action="tambah_prodi.php" method="POST">
          <div class="mb-3">
            <label for="kode_prodi" class="form-label">Kode Prodi</label>
            <input type="text" class="form-control" id="kode_prodi" name="kode_prodi" maxlength="2" required>
          </div>
          <div class="mb-3">
            <label for="nama_prodi" class="form-label">Nama Program Studi</label>
            <input type="text" class="form-control" id="nama_prodi" name="nama_prodi" required>
          </div>
          <div class="mb-3">
            <label for="akreditasi" class="form-label">Akreditasi</label>
            <input type="text" class="form-control" id="akreditasi" name="akreditasi" maxlength="1" required>
          </div>
          <button type="submit" class="btn btn-success">Simpan</button>
          <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
      </div>
    </div>
  </div>
</body>

</html>