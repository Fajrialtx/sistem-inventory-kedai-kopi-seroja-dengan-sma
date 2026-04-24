<!-- breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url($role . '/beranda'); ?>">Beranda</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url($role . '/peramalan'); ?>">Peramalan</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
    </ol>
</nav>

<!-- Info Produk -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Produk</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $produk['nama_produk']; ?></div>
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
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Tanggal Eksekusi</div>
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
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Prediksi (3 / 5 / 7 Hari)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php if ($prediksi) : ?>
                                <?php
                                $p3 = isset($prediksi['periodes'][3]['prediksi']) ? $prediksi['periodes'][3]['prediksi'] : '-';
                                $p5 = isset($prediksi['periodes'][5]['prediksi']) ? $prediksi['periodes'][5]['prediksi'] : '-';
                                $p7 = isset($prediksi['periodes'][7]['prediksi']) ? $prediksi['periodes'][7]['prediksi'] : '-';
                                ?>
                                <span class="text-primary"><?= $p3; ?></span> / 
                                <span class="text-success"><?= $p5; ?></span> / 
                                <span class="text-warning"><?= $p7; ?></span>
                                <small>items</small>
                            <?php else : ?>
                                <span class="text-muted">-</span>
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
</div>

<!-- Grafik -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-chart-area mr-2"></i>Grafik Penjualan & Prediksi — <?= $produk['nama_produk']; ?>
        </h6>
    </div>
    <div class="card-body">
        <div style="position: relative; height: 400px; width: 100%;">
            <canvas id="chartProduk"></canvas>
        </div>
    </div>
</div>

<!-- Tabel Data Penjualan -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-table mr-2"></i>Data Penjualan Harian — <?= $produk['nama_produk']; ?>
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-sm" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Penjualan (items)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data_penjualan)) : ?>
                        <?php foreach ($data_penjualan as $key => $p) : ?>
                            <tr>
                                <td class="text-center"><?= $key + 1; ?></td>
                                <td class="text-center"><?= tanggal($p['tgl_penjualan']); ?></td>
                                <td class="text-center"><?= (int)$p['total_penjualan']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="3" class="text-center text-muted">Belum ada data penjualan</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Tombol Kembali -->
<div class="mb-4">
    <a href="javascript:history.back()" class="btn btn-secondary btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-arrow-left"></i>
        </span>
        <span class="text">Kembali</span>
    </a>
</div>

<!-- Chart.js -->
<script src="<?= base_url('assets/vendor/chart.js/Chart.min.js'); ?>"></script>
<script>
    var ctx = document.getElementById('chartProduk').getContext('2d');

    var labels = [
        <?php foreach ($data_penjualan as $p) : ?>
            "<?= tanggal($p['tgl_penjualan']); ?>",
        <?php endforeach; ?>
    ];

    var dataAktual = [
        <?php foreach ($data_penjualan as $p) : ?>
            <?= (int)$p['total_penjualan']; ?>,
        <?php endforeach; ?>
    ];

    <?php
    $pred3 = ($prediksi && isset($prediksi['periodes'][3]['prediksi'])) ? $prediksi['periodes'][3]['prediksi'] : 'null';
    $pred5 = ($prediksi && isset($prediksi['periodes'][5]['prediksi'])) ? $prediksi['periodes'][5]['prediksi'] : 'null';
    $pred7 = ($prediksi && isset($prediksi['periodes'][7]['prediksi'])) ? $prediksi['periodes'][7]['prediksi'] : 'null';
    ?>

    var hasPrediksi = (<?= $pred3; ?> !== null || <?= $pred5; ?> !== null || <?= $pred7; ?> !== null);

    if (hasPrediksi) {
        labels.push('Prediksi');
        dataAktual.push(null);
    }

    // Garis prediksi: hubungkan titik terakhir aktual ke titik prediksi
    var lastVal = dataAktual.length > 1 ? dataAktual[dataAktual.length - 2] : null;
    var baseLen = dataAktual.length - (hasPrediksi ? 1 : 0);

    function makePredLine(predVal) {
        var arr = new Array(baseLen).fill(null);
        if (baseLen > 0) arr[baseLen - 1] = lastVal;
        if (hasPrediksi) arr.push(predVal);
        return arr;
    }

    var datasets = [{
        label: 'Penjualan Aktual',
        data: dataAktual,
        borderColor: 'rgba(78, 115, 223, 1)',
        backgroundColor: 'rgba(78, 115, 223, 0.08)',
        borderWidth: 2,
        pointBackgroundColor: 'rgba(78, 115, 223, 1)',
        pointRadius: 4,
        fill: true,
        spanGaps: false
    }];

    if (<?= $pred3; ?> !== null) {
        datasets.push({
            label: 'SMA 3 Hari (Prediksi: ' + <?= $pred3; ?> + ')',
            data: makePredLine(<?= $pred3; ?>),
            borderColor: 'rgba(54, 162, 235, 1)',
            backgroundColor: 'transparent',
            borderWidth: 2,
            borderDash: [5, 5],
            pointBackgroundColor: 'rgba(54, 162, 235, 1)',
            pointRadius: 5,
            pointStyle: 'triangle',
            fill: false,
            spanGaps: true
        });
    }
    if (<?= $pred5; ?> !== null) {
        datasets.push({
            label: 'SMA 5 Hari (Prediksi: ' + <?= $pred5; ?> + ')',
            data: makePredLine(<?= $pred5; ?>),
            borderColor: 'rgba(28, 200, 138, 1)',
            backgroundColor: 'transparent',
            borderWidth: 2,
            borderDash: [5, 5],
            pointBackgroundColor: 'rgba(28, 200, 138, 1)',
            pointRadius: 5,
            pointStyle: 'rect',
            fill: false,
            spanGaps: true
        });
    }
    if (<?= $pred7; ?> !== null) {
        datasets.push({
            label: 'SMA 7 Hari (Prediksi: ' + <?= $pred7; ?> + ')',
            data: makePredLine(<?= $pred7; ?>),
            borderColor: 'rgba(246, 194, 62, 1)',
            backgroundColor: 'transparent',
            borderWidth: 2,
            borderDash: [5, 5],
            pointBackgroundColor: 'rgba(246, 194, 62, 1)',
            pointRadius: 5,
            pointStyle: 'star',
            fill: false,
            spanGaps: true
        });
    }

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            title: {
                display: true,
                text: 'Grafik Penjualan & Prediksi SMA - <?= addslashes($produk['nama_produk']); ?>',
                fontSize: 14
            },
            scales: {
                yAxes: [{
                    ticks: { beginAtZero: true },
                    scaleLabel: { display: true, labelString: 'Jumlah Terjual (items)' }
                }],
                xAxes: [{
                    scaleLabel: { display: true, labelString: 'Tanggal' }
                }]
            },
            legend: { display: true, position: 'top' },
            tooltips: { mode: 'index', intersect: false }
        }
    });
</script>
