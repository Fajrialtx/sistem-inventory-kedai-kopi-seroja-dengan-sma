<!-- breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('owner/stokmasuk'); ?>">Data Stok Masuk</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
    </ol>
</nav>

<!-- jika ada pesan gagal -->
<?php if (isset($gagal)) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <?= $gagal ?>
    </div>
    <script>
        $(".alert").alert();
    </script>
<?php endif ?>

<!-- Card Tambah Data  -->
<div class="col-md-8 mx-auto">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Input Stok Masuk Harian</h6>
        </div>
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <div class="row">

                    <div class="form-group col-md-12">
                        <label>Bahan Baku</label>
                        <select class="custom-select" name="id_barang" required>
                            <option value="">--Pilih Bahan Baku--</option>
                            <?php foreach ($barang as $value) : ?>
                                <option value="<?= $value['id_barang']; ?>"><?= $value['nama_barang']; ?> (Stok saat ini: <?= $value['stock_toko']; ?> <?= $value['satuan']; ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Tanggal Masuk</label>
                        <input type="date" class="form-control" name="tanggal" value="<?= date('Y-m-d'); ?>" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Jumlah Masuk</label>
                        <input type="number" class="form-control" name="jumlah" placeholder="Contoh: 50" required min="1">
                        <small class="text-info">*Jumlah ini akan ditambahkan ke total Stok Toko.</small>
                    </div>

                    <div class="form-group col-md-12">
                        <label>Keterangan (Opsional)</label>
                        <textarea class="form-control" name="keterangan" rows="3" placeholder="Contoh: Stok dari pabrik baru"></textarea>
                    </div>

                </div>
        </div>
        <div class="card-footer text-md-right">
            <a href="<?= base_url('owner/stokmasuk'); ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Stok</button>
        </div>
        </form>
    </div>
</div>
