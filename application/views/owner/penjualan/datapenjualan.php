<!-- breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('owner/beranda'); ?>">Beranda</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
    </ol>
</nav>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-6">
                <h4 class="m-0 font-weight-bold text-primary"><i class="fas fa-shopping-cart mr-2"></i><?= $title; ?></h4>
            </div>
            <div class="col-md-6 text-md-right mt-2 mt-md-0">
                <a href="<?= base_url('owner/penjualan/tambah'); ?>" class="btn btn-primary btn-icon-split btn-sm">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Tambah Penjualan</span>
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Tanggal Penjualan</th>
                        <th>Jumlah Transaksi</th>
                        <th>Total Pendapatan</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($penjualan as $key => $value) : ?>
                        <tr>
                            <td><?= $key + 1; ?></td>
                            <td>
                                <strong><?= date('d F Y', strtotime($value['tgl_penjualan'])); ?></strong>
                            </td>
                            <td>
                                <span class="badge badge-info"><?= $value['jumlah_transaksi']; ?> transaksi</span>
                            </td>
                            <td>Rp <?= number_format($value['pendapatan_harian'], 0, ',', '.'); ?></td>
                            <td class="text-center">
                                <a href="<?= base_url('owner/penjualan/detail/' . $value['tgl_penjualan']); ?>" class="btn btn-info btn-icon-split btn-sm">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-list"></i>
                                    </span>
                                    <span class="text">Detail</span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- pesan sukses -->
<?php if ($this->session->flashdata('pesan')) : ?>
    <script>
        swal({
            icon: "success",
            title: "Berhasil!",
            text: "<?= $this->session->flashdata('pesan') ?>",
            button: false,
            timer: 2000,
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
