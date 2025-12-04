<?php
include 'koneksi.php';

// Ambil data program studi untuk dropdown
$prodi_query = "SELECT * FROM program_studi";
$prodi_result = mysqli_query($koneksi, $prodi_query);

// Cek apakah form sudah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nim = $_POST['nim'];
  $nama = $_POST['nama_mahasiswa'];
  $kode_prodi = $_POST['kode_prodi'];

  // Query untuk insert data
  $query = "INSERT INTO mahasiswa (nim, nama_mahasiswa, kode_prodi) VALUES (?, ?, ?)";

  $stmt = mysqli_prepare($koneksi, $query);
  mysqli_stmt_bind_param($stmt, "sss", $nim, $nama, $kode_prodi);

  if (mysqli_stmt_execute($stmt)) {
    // Jika berhasil, redirect ke halaman utama
    header("Location: index.php");
    exit();
  } else {
    echo "Error: " . mysqli_error($koneksi);
  }
  mysqli_stmt_close($stmt);
}
mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Tambah Mahasiswa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container mt-4">
    <div class="card">
      <div class="card-header">
        <h3>Form Tambah Mahasiswa</h3>
      </div>
      <div class="card-body">
        <form action="tambah.php" method="POST">
          <div class="mb-3">
            <label for="nim" class="form-label">NIM</label>
            <input type="text" class="form-control" id="nim" name="nim" required>
          </div>
          <div class="mb-3">
            <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
            <input type="text" class="form-control" id="nama_mahasiswa" name="nama_mahasiswa" required>
          </div>
          <div class="mb-3">
            <label for="kode_prodi" class="form-label">Program Studi</label>
            <select class="form-select" id="kode_prodi" name="kode_prodi">
              <option value="">-- Pilih Program Studi --</option>
              <?php
              // Tampilkan data prodi sebagai option
              while ($prodi = mysqli_fetch_assoc($prodi_result)) {
                echo "<option value='" . $prodi['kode_prodi'] . "'>" . htmlspecialchars($prodi['nama_prodi']) . "</option>";
              }
              ?>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Simpan</button>
          <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
      </div>
    </div>
  </div>
</body>

</html>