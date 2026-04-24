<!-- breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url($role . '/beranda'); ?>">Beranda</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
    </ol>
</nav>

<!-- Form Generate Peramalan -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h4 class="m-0 font-weight-bold text-primary"><i class="fas fa-chart-line mr-2"></i><?= $title; ?></h4>
    </div>
    <div class="card-body">
        <form method="post" action="<?= base_url($role . '/peramalan/hitung'); ?>">
            <div class="row align-items-end">
                <div class="col-md-5">
                    <div class="form-group mb-md-0">
                        <label for="tgl_eksekusi" class="font-weight-bold">Tanggal Eksekusi Peramalan</label>
                        <input type="date" name="tgl_eksekusi" id="tgl_eksekusi" class="form-control"
                            value="<?= date('Y-m-d'); ?>" required>
                        <small class="form-text text-muted">Pilih tanggal untuk menjalankan peramalan semua
                            produk.</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-md-0">
                        <label class="font-weight-bold">Periode SMA</label>
                        <div class="d-flex align-items-center" style="height: 38px;">
                            <span class="badge badge-primary mr-2 px-3 py-2">3 Hari</span>
                            <span class="badge badge-success mr-2 px-3 py-2">5 Hari</span>
                            <span class="badge badge-warning px-3 py-2">7 Hari</span>
                        </div>
                        <small class="form-text text-muted">Otomatis dihitung untuk 3 periode perbandingan.</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-md-0">
                        <button type="submit" class="btn btn-primary btn-icon-split btn-block">
                            <span class="icon text-white-50">
                                <i class="fas fa-calculator"></i>
                            </span>
                            <span class="text">Hitung Peramalan</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================ -->
<!-- HASIL PERAMALAN TERBARU (langsung tampil di halaman utama)    -->
<!-- ============================================================ -->
<?php if (!empty($terbaru)): ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-star mr-2 text-warning"></i>Hasil Peramalan Terbaru — <?= tanggal($tgl_terbaru); ?>
            </h6>
            <button class="btn btn-danger btn-sm btn-hapus"
                data-url="<?= base_url($role . '/peramalan/hapus/' . $tgl_terbaru); ?>"
                data-tanggal="<?= tanggal($tgl_terbaru); ?>">
                <i class="fas fa-trash mr-1"></i>Hapus
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center" rowspan="2" style="vertical-align: middle;">No</th>
                            <th class="text-center" rowspan="2" style="vertical-align: middle;">Nama Produk</th>
                            <th class="text-center" rowspan="2" style="vertical-align: middle;">Kategori</th>
                            <th class="text-center" colspan="4" style="background-color: #e3f2fd;">Periode 3 Hari</th>
                            <th class="text-center" colspan="4" style="background-color: #e8f5e9;">Periode 5 Hari</th>
                            <th class="text-center" colspan="4" style="background-color: #fff8e1;">Periode 7 Hari</th>
                            <th class="text-center" rowspan="2" style="vertical-align: middle;">Grafik</th>
                        </tr>
                        <tr>
                            <th class="text-center" style="background-color: #e3f2fd;">Prediksi</th>
                            <th class="text-center" style="background-color: #e3f2fd;">Aktual</th>
                            <th class="text-center" style="background-color: #e3f2fd;">MSE</th>
                            <th class="text-center" style="background-color: #e3f2fd;">MAPE</th>
                            <th class="text-center" style="background-color: #e8f5e9;">Prediksi</th>
                            <th class="text-center" style="background-color: #e8f5e9;">Aktual</th>
                            <th class="text-center" style="background-color: #e8f5e9;">MSE</th>
                            <th class="text-center" style="background-color: #e8f5e9;">MAPE</th>
                            <th class="text-center" style="background-color: #fff8e1;">Prediksi</th>
                            <th class="text-center" style="background-color: #fff8e1;">Aktual</th>
                            <th class="text-center" style="background-color: #fff8e1;">MSE</th>
                            <th class="text-center" style="background-color: #fff8e1;">MAPE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($terbaru as $key => $produk): ?>
                            <tr>
                                <td class="text-center"><?= $key + 1; ?></td>
                                <td class="font-weight-bold"><?= $produk['nama_produk']; ?></td>
                                <td class="text-center">
                                    <span
                                        class="badge badge-<?= ($produk['kategori_produk'] == 'Makanan') ? 'danger' : 'info'; ?>">
                                        <?= $produk['kategori_produk']; ?>
                                    </span>
                                </td>
                                <!-- Periode 3 -->
                                <td class="text-center" style="background-color: #f8fbff;">
                                    <?php if (isset($produk['periodes'][3]['prediksi']) && $produk['periodes'][3]['prediksi'] !== null): ?>
                                        <strong><?= $produk['periodes'][3]['prediksi']; ?></strong> <small>items</small>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center" style="background-color: #f8fbff;">
                                    <?= isset($produk['aktual']) ? '<strong>' . $produk['aktual'] . '</strong> <small>items</small>' : '<span class="text-muted">-</span>'; ?>
                                </td>
                                <td class="text-center" style="background-color: #f8fbff;">
                                    <?= (isset($produk['periodes'][3]['mse']) && $produk['periodes'][3]['mse'] !== null) ? $produk['periodes'][3]['mse'] : '<span class="text-muted">-</span>'; ?>
                                </td>
                                <td class="text-center" style="background-color: #f8fbff;">
                                    <?= (isset($produk['periodes'][3]['mape']) && $produk['periodes'][3]['mape'] !== null) ? $produk['periodes'][3]['mape'] : '<span class="text-muted">-</span>'; ?>
                                </td>
                                <!-- Periode 5 -->
                                <td class="text-center" style="background-color: #f8fff8;">
                                    <?php if (isset($produk['periodes'][5]['prediksi']) && $produk['periodes'][5]['prediksi'] !== null): ?>
                                        <strong><?= $produk['periodes'][5]['prediksi']; ?></strong> <small>items</small>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center" style="background-color: #f8fff8;">
                                    <?= isset($produk['aktual']) ? '<strong>' . $produk['aktual'] . '</strong> <small>items</small>' : '<span class="text-muted">-</span>'; ?>
                                </td>
                                <td class="text-center" style="background-color: #f8fff8;">
                                    <?= (isset($produk['periodes'][5]['mse']) && $produk['periodes'][5]['mse'] !== null) ? $produk['periodes'][5]['mse'] : '<span class="text-muted">-</span>'; ?>
                                </td>
                                <td class="text-center" style="background-color: #f8fff8;">
                                    <?= (isset($produk['periodes'][5]['mape']) && $produk['periodes'][5]['mape'] !== null) ? $produk['periodes'][5]['mape'] : '<span class="text-muted">-</span>'; ?>
                                </td>
                                <!-- Periode 7 -->
                                <td class="text-center" style="background-color: #fffff8;">
                                    <?php if (isset($produk['periodes'][7]['prediksi']) && $produk['periodes'][7]['prediksi'] !== null): ?>
                                        <strong><?= $produk['periodes'][7]['prediksi']; ?></strong> <small>items</small>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center" style="background-color: #fffff8;">
                                    <?= isset($produk['aktual']) ? '<strong>' . $produk['aktual'] . '</strong> <small>items</small>' : '<span class="text-muted">-</span>'; ?>
                                </td>
                                <td class="text-center" style="background-color: #fffff8;">
                                    <?= (isset($produk['periodes'][7]['mse']) && $produk['periodes'][7]['mse'] !== null) ? $produk['periodes'][7]['mse'] : '<span class="text-muted">-</span>'; ?>
                                </td>
                                <td class="text-center" style="background-color: #fffff8;">
                                    <?= (isset($produk['periodes'][7]['mape']) && $produk['periodes'][7]['mape'] !== null) ? $produk['periodes'][7]['mape'] : '<span class="text-muted">-</span>'; ?>
                                </td>
                                <!-- Tombol Grafik -->
                                <td class="text-center">
                                    <a href="<?= base_url($role . '/peramalan/grafik/' . $tgl_terbaru . '/' . $produk['id_produk']); ?>"
                                        class="btn btn-outline-primary btn-sm" title="Lihat Grafik">
                                        <i class="fas fa-chart-area"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="card shadow mb-4">
        <div class="card-body text-center py-4">
            <i class="fas fa-chart-line fa-3x text-gray-300 mb-3"></i>
            <p class="text-muted mb-0">Belum ada data peramalan. Silakan hitung peramalan baru menggunakan form di atas.</p>
        </div>
    </div>
<?php endif; ?>

<!-- ============================================================ -->
<!-- RIWAYAT PERAMALAN SEBELUMNYA                                  -->
<!-- ============================================================ -->
<?php if (!empty($riwayat)): ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-history mr-2"></i>Riwayat Peramalan Sebelumnya
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th class="text-center">Tanggal Eksekusi</th>
                            <th class="text-center">Jumlah Produk</th>
                            <th class="text-center">Periode</th>
                            <th class="text-center">Dibuat Pada</th>
                            <th class="text-center" width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($riwayat as $key => $r): ?>
                            <tr>
                                <td class="text-center"><?= $key + 1; ?></td>
                                <td class="text-center font-weight-bold"><?= tanggal($r['tgl_eksekusi']); ?></td>
                                <td class="text-center"><?= $r['jumlah_produk']; ?> produk</td>
                                <td class="text-center">
                                    <span class="badge badge-primary">3 Hari</span>
                                    <span class="badge badge-success">5 Hari</span>
                                    <span class="badge badge-warning">7 Hari</span>
                                </td>
                                <td class="text-center"><?= tanggal_waktu($r['created_at']); ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url($role . '/peramalan/detail/' . $r['tgl_eksekusi']); ?>"
                                        class="btn btn-info btn-sm mr-1" title="Lihat Detail">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    <button class="btn btn-danger btn-sm btn-hapus"
                                        data-url="<?= base_url($role . '/peramalan/hapus/' . $r['tgl_eksekusi']); ?>"
                                        data-tanggal="<?= tanggal($r['tgl_eksekusi']); ?>" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Hapus sweetalert -->
<script>
    $(document).ready(function () {
        $(".btn-hapus").on("click", function (e) {
            e.preventDefault();
            var url = $(this).data('url');
            var tanggal = $(this).data('tanggal');
            swal({
                title: "Hapus Peramalan?",
                text: "Data peramalan tanggal " + tanggal + " akan dihapus permanen!",
                icon: "warning",
                buttons: ["Batal", "Ya, Hapus!"],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    window.location.href = url;
                }
            });
        });
    });
</script>

<!-- pesan sukses -->
<?php if ($this->session->flashdata('sukses')): ?>
    <script>
        swal({
            icon: "success",
            title: "Berhasil!",
            text: "<?= $this->session->flashdata('sukses') ?>",
            button: false,
            timer: 2500,
        });
    </script>
<?php endif; ?>

<!-- pesan gagal -->
<?php if ($this->session->flashdata('gagal')): ?>
    <script>
        swal({
            icon: "error",
            title: "Gagal!",
            text: "<?= $this->session->flashdata('gagal') ?>",
            button: false,
            timer: 2500,
        });
    </script>
<?php endif; ?>