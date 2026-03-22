<!-- breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('owner/beranda'); ?>">Beranda</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
    </ol>
</nav>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h4 class="m-0 font-weight-bold text-primary"><i class="fas fa-chart-line mr-2"></i><?= $title; ?></h4>
    </div>
    <div class="card-body">
        <!-- Form Peramalan -->
        <form method="post" action="<?= base_url('owner/peramalan/hitung'); ?>">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="id_produk" class="font-weight-bold">Pilih Produk</label>
                        <select name="id_produk" id="id_produk" class="form-control" required>
                            <option value="">-- Pilih Produk --</option>
                            <?php foreach ($produk as $p) : ?>
                                <option value="<?= $p['id_produk']; ?>" <?= (isset($id_produk_dipilih) && $id_produk_dipilih == $p['id_produk']) ? 'selected' : ''; ?>>
                                    <?= $p['nama_produk']; ?> (<?= $p['kategori_produk']; ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="periode" class="font-weight-bold">Periode (Hari)</label>
                        <select name="periode" id="periode" class="form-control" required>
                            <option value="">-- Pilih Periode --</option>
                            <option value="3" <?= (isset($periode_dipilih) && $periode_dipilih == 3) ? 'selected' : ''; ?>>3 Hari</option>
                            <option value="5" <?= (isset($periode_dipilih) && $periode_dipilih == 5) ? 'selected' : ''; ?>>5 Hari</option>
                            <option value="7" <?= (isset($periode_dipilih) && $periode_dipilih == 7) ? 'selected' : ''; ?>>7 Hari</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-icon-split">
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

<?php if (isset($hasil) && $hasil !== null) : ?>

    <!-- Hasil Prediksi -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Produk</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $produk_dipilih['nama_produk']; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box-open fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Prediksi Penjualan Esok Hari</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php if ($hasil['prediksi'] !== null) : ?>
                                    <?= $hasil['prediksi']; ?> items
                                <?php else : ?>
                                    <span class="text-danger">Data tidak cukup</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">MAD (Tingkat Ketidakakuratan)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php if ($hasil['mad'] !== null) : ?>
                                    <?= $hasil['mad']; ?>
                                <?php else : ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-bullseye fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-chart-area mr-2"></i>Grafik Penjualan vs Peramalan SMA (Periode <?= $hasil['periode']; ?> Hari)</h6>
        </div>
        <div class="card-body">
            <canvas id="chartPeramalan" style="height: 320px;"></canvas>
        </div>
    </div>

    <!-- Tabel Data Perhitungan -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-table mr-2"></i>Tabel Perhitungan Single Moving Average (Periode <?= $hasil['periode']; ?> Hari)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Penjualan Aktual (items)</th>
                            <th class="text-center">Hasil SMA (items)</th>
                            <th class="text-center">Error (|Aktual - SMA|)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($hasil['data'] as $key => $value) : ?>
                            <tr>
                                <td class="text-center"><?= $key + 1; ?></td>
                                <td class="text-center"><?= tanggal($value['tgl_penjualan']); ?></td>
                                <td class="text-center"><?= $value['total_penjualan']; ?></td>
                                <td class="text-center">
                                    <?php if ($value['sma'] !== null) : ?>
                                        <?= $value['sma']; ?>
                                    <?php else : ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($value['sma'] !== null) : ?>
                                        <?= round(abs($value['total_penjualan'] - $value['sma']), 2); ?>
                                    <?php else : ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <!-- Baris Prediksi -->
                        <?php if ($hasil['prediksi'] !== null) : ?>
                            <tr class="table-success font-weight-bold">
                                <td class="text-center"><?= count($hasil['data']) + 1; ?></td>
                                <td class="text-center"><i class="fas fa-arrow-right mr-1"></i>Hari Berikutnya</td>
                                <td class="text-center">?</td>
                                <td class="text-center"><?= $hasil['prediksi']; ?></td>
                                <td class="text-center">-</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    <?php if ($hasil['mad'] !== null) : ?>
                        <tfoot>
                            <tr class="table-warning font-weight-bold">
                                <td colspan="4" class="text-right">MAD (Mean Absolute Deviation) :</td>
                                <td class="text-center"><?= $hasil['mad']; ?></td>
                            </tr>
                        </tfoot>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="<?= base_url('assets/vendor/chart.js/Chart.min.js'); ?>"></script>
    <script>
        var ctx = document.getElementById('chartPeramalan').getContext('2d');

        var labels = [
            <?php foreach ($hasil['data'] as $value) : ?>
                "<?= tanggal($value['tgl_penjualan']); ?>",
            <?php endforeach; ?>
            <?php if ($hasil['prediksi'] !== null) : ?>
                "Prediksi",
            <?php endif; ?>
        ];

        var dataAktual = [
            <?php foreach ($hasil['data'] as $value) : ?>
                <?= $value['total_penjualan']; ?>,
            <?php endforeach; ?>
            <?php if ($hasil['prediksi'] !== null) : ?>
                null,
            <?php endif; ?>
        ];

        var dataSMA = [
            <?php foreach ($hasil['data'] as $value) : ?>
                <?= ($value['sma'] !== null) ? $value['sma'] : 'null'; ?>,
            <?php endforeach; ?>
            <?php if ($hasil['prediksi'] !== null) : ?>
                <?= $hasil['prediksi']; ?>,
            <?php endif; ?>
        ];

        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Penjualan Aktual',
                    data: dataAktual,
                    borderColor: 'rgba(78, 115, 223, 1)',
                    backgroundColor: 'rgba(78, 115, 223, 0.1)',
                    borderWidth: 2,
                    pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                    pointRadius: 4,
                    fill: true,
                    spanGaps: false
                }, {
                    label: 'Hasil SMA',
                    data: dataSMA,
                    borderColor: 'rgba(28, 200, 138, 1)',
                    backgroundColor: 'rgba(28, 200, 138, 0.1)',
                    borderWidth: 2,
                    borderDash: [5, 5],
                    pointBackgroundColor: 'rgba(28, 200, 138, 1)',
                    pointRadius: 4,
                    fill: false,
                    spanGaps: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Jumlah Terjual (items)'
                        }
                    }],
                    xAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Tanggal'
                        }
                    }]
                },
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false
                }
            }
        });
    </script>

<?php endif; ?>

<!-- pesan gagal -->
<?php if ($this->session->flashdata('gagal')) : ?>
    <script>
        swal({
            icon: "error",
            title: "Gagal!",
            text: "<?= $this->session->flashdata('gagal') ?>",
            button: false,
            timer: 2000,
        });
    </script>
<?php endif; ?>
