<?php
include 'koneksi.php';

// Proses update data jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $kode_prodi = $_POST['kode_prodi'];
  $nama_prodi = $_POST['nama_prodi'];
  $akreditasi = $_POST['akreditasi'];

  $query = "UPDATE program_studi SET nama_prodi=?, akreditasi=? WHERE kode_prodi=?";

  $stmt = mysqli_prepare($koneksi, $query);
  mysqli_stmt_bind_param($stmt, "sss", $nama_prodi, $akreditasi, $kode_prodi);

  if (mysqli_stmt_execute($stmt)) {
    header("Location: index.php#prodi-tab-pane");
    exit();
  } else {
    echo "Error: " . mysqli_error($koneksi);
  }
  mysqli_stmt_close($stmt);
}

// Ambil data prodi yang akan diedit dari database
$kode_to_edit = $_GET['kode'];
$query_prodi = "SELECT * FROM program_studi WHERE kode_prodi = ?";
$stmt_prodi = mysqli_prepare($koneksi, $query_prodi);
mysqli_stmt_bind_param($stmt_prodi, "s", $kode_to_edit);
mysqli_stmt_execute($stmt_prodi);
$result_prodi = mysqli_stmt_get_result($stmt_prodi);
$prodi = mysqli_fetch_assoc($result_prodi);
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Edit Program Studi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container mt-4">
    <div class="card">
      <div class="card-header">
        <h3>Form Edit Program Studi</h3>
      </div>
      <div class="card-body">
        <form action="edit_prodi.php" method="POST">
          <div class="mb-3">
            <label for="kode_prodi" class="form-label">Kode Prodi</label>
            <input type="text" class="form-control" id="kode_prodi" name="kode_prodi" value="<?php echo htmlspecialchars($prodi['kode_prodi']); ?>" readonly>
          </div>
          <div class="mb-3">
            <label for="nama_prodi" class="form-label">Nama Program Studi</label>
            <input type="text" class="form-control" id="nama_prodi" name="nama_prodi" value="<?php echo htmlspecialchars($prodi['nama_prodi']); ?>" required>
          </div>
          <div class="mb-3">
            <label for="akreditasi" class="form-label">Akreditasi</label>
            <input type="text" class="form-control" id="akreditasi" name="akreditasi" maxlength="1" value="<?php echo htmlspecialchars($prodi['akreditasi']); ?>" required>
          </div>
          <button type="submit" class="btn btn-success">Update</button>
          <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
      </div>
    </div>
  </div>
</body>

</html>
<?php
mysqli_close($koneksi);
?>