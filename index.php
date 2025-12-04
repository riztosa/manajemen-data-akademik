<?php
include 'koneksi.php';

// 1. Query untuk mengambil data mahasiswa (digabung dengan prodi)
$query_mahasiswa = "SELECT m.nim, m.nama_mahasiswa, ps.nama_prodi, ps.akreditasi 
                    FROM mahasiswa m 
                    LEFT JOIN program_studi ps ON m.kode_prodi = ps.kode_prodi
                    ORDER BY m.nim ASC";
$result_mahasiswa = mysqli_query($koneksi, $query_mahasiswa);

// 2. Query untuk mengambil data program studi
$query_prodi = "SELECT * FROM program_studi ORDER BY kode_prodi ASC";
$result_prodi = mysqli_query($koneksi, $query_prodi);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Data Akademik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 40px;
        }

        .card-header {
            background-color: #343a40;
            color: white;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <h3>Manajemen Data Akademik</h3>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="mahasiswa-tab" data-bs-toggle="tab" data-bs-target="#mahasiswa-tab-pane" type="button" role="tab" aria-controls="mahasiswa-tab-pane" aria-selected="true">Data Mahasiswa</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="prodi-tab" data-bs-toggle="tab" data-bs-target="#prodi-tab-pane" type="button" role="tab" aria-controls="prodi-tab-pane" aria-selected="false">Data Program Studi</button>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="mahasiswa-tab-pane" role="tabpanel" aria-labelledby="mahasiswa-tab" tabindex="0">
                        <div class="p-3">
                            <a href="tambah.php" class="btn btn-primary mb-3">➕ Tambah Mahasiswa</a>
                            <table class="table table-striped table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>NIM</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Program Studi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result_mahasiswa)) : ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['nim']) ?></td>
                                            <td><?= htmlspecialchars($row['nama_mahasiswa']) ?></td>
                                            <td><?= $row['nama_prodi'] ? htmlspecialchars($row['nama_prodi']) : '-' ?></td>
                                            <td>
                                                <a href="edit.php?nim=<?= $row['nim'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="hapus.php?nim=<?= $row['nim'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="prodi-tab-pane" role="tabpanel" aria-labelledby="prodi-tab" tabindex="0">
                        <div class="p-3">
                            <a href="tambah_prodi.php" class="btn btn-success mb-3">🎓 Tambah Program Studi</a>
                            <table class="table table-striped table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Kode Prodi</th>
                                        <th>Nama Program Studi</th>
                                        <th>Akreditasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result_prodi)) : ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['kode_prodi']) ?></td>
                                            <td><?= htmlspecialchars($row['nama_prodi']) ?></td>
                                            <td><?= htmlspecialchars($row['akreditasi']) ?></td>
                                            <td>
                                                <a href="edit_prodi.php?kode=<?= $row['kode_prodi'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="hapus_prodi.php?kode=<?= $row['kode_prodi'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('PERINGATAN: Yakin ingin menghapus prodi ini?')">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Script kecil untuk membuka tab yang sesuai berdasarkan URL hash
        document.addEventListener('DOMContentLoaded', function() {
            const hash = window.location.hash;
            if (hash) {
                const tab = document.querySelector(`button[data-bs-target="${hash}"]`);
                if (tab) {
                    new bootstrap.Tab(tab).show();
                }
            }
        });
    </script>

</body>

</html>
<?php
mysqli_close($koneksi);
?>