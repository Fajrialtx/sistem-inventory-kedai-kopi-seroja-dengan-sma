<!-- breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url($role . '/beranda'); ?>">Beranda</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url($role . '/peramalan'); ?>">Peramalan</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
    </ol>
</nav>

<!-- Header Info -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Tanggal Eksekusi</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= tanggal($tgl_eksekusi); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Jumlah Produk Diramal
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($detail); ?> produk</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box-open fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Periode Perbandingan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <span class="badge badge-primary">3 Hari</span>
                            <span class="badge badge-success">5 Hari</span>
                            <span class="badge badge-warning">7 Hari</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-layer-group fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Ringkasan Semua Produk -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-table mr-2"></i>Ringkasan Prediksi Semua Produk
        </h6>
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
                    <?php foreach ($detail as $key => $produk): ?>
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
                                <a href="<?= base_url($role . '/peramalan/grafik/' . $tgl_eksekusi . '/' . $produk['id_produk']); ?>"
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

<!-- Tombol Kembali -->
<div class="mb-4">
    <a href="<?= base_url($role . '/peramalan'); ?>" class="btn btn-secondary btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-arrow-left"></i>
        </span>
        <span class="text">Kembali ke Peramalan</span>
    </a>
</div>