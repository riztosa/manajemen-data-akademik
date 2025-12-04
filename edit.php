<?php
include 'koneksi.php';

// Cek apakah form disubmit untuk update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nim = $_POST['nim'];
  $nama = $_POST['nama_mahasiswa'];
  $kode_prodi = $_POST['kode_prodi'];

  $query = "UPDATE mahasiswa SET nama_mahasiswa=?, kode_prodi=? WHERE nim=?";

  $stmt = mysqli_prepare($koneksi, $query);
  mysqli_stmt_bind_param($stmt, "sss", $nama, $kode_prodi, $nim);

  if (mysqli_stmt_execute($stmt)) {
    header("Location: index.php");
    exit();
  } else {
    echo "Error: " . mysqli_error($koneksi);
  }
  mysqli_stmt_close($stmt);
}

// Ambil data mahasiswa untuk ditampilkan di form
$nim_to_edit = $_GET['nim'];
$query_mhs = "SELECT * FROM mahasiswa WHERE nim = ?";
$stmt_mhs = mysqli_prepare($koneksi, $query_mhs);
mysqli_stmt_bind_param($stmt_mhs, "s", $nim_to_edit);
mysqli_stmt_execute($stmt_mhs);
$result_mhs = mysqli_stmt_get_result($stmt_mhs);
$mhs = mysqli_fetch_assoc($result_mhs);

// Ambil data program studi untuk dropdown
$prodi_query = "SELECT * FROM program_studi";
$prodi_result = mysqli_query($koneksi, $prodi_query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Edit Mahasiswa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container mt-4">
    <div class="card">
      <div class="card-header">
        <h3>Form Edit Mahasiswa</h3>
      </div>
      <div class="card-body">
        <form action="edit.php" method="POST">
          <div class="mb-3">
            <label for="nim" class="form-label">NIM</label>
            <input type="text" class="form-control" id="nim" name="nim" value="<?php echo htmlspecialchars($mhs['nim']); ?>" readonly>
          </div>
          <div class="mb-3">
            <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
            <input type="text" class="form-control" id="nama_mahasiswa" name="nama_mahasiswa" value="<?php echo htmlspecialchars($mhs['nama_mahasiswa']); ?>" required>
          </div>
          <div class="mb-3">
            <label for="kode_prodi" class="form-label">Program Studi</label>
            <select class="form-select" id="kode_prodi" name="kode_prodi">
              <option value="">-- Pilih Program Studi --</option>
              <?php
              while ($prodi = mysqli_fetch_assoc($prodi_result)) {
                $selected = ($prodi['kode_prodi'] == $mhs['kode_prodi']) ? 'selected' : '';
                echo "<option value='" . $prodi['kode_prodi'] . "' $selected>" . htmlspecialchars($prodi['nama_prodi']) . "</option>";
              }
              ?>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Update</button>
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