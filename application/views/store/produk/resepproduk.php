<!-- breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('store/produk'); ?>">Menu Produk</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
    </ol>
</nav>

<!-- Info Produk -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-flask mr-2"></i><?= $title; ?>
                </h4>
            </div>
            <div class="col-auto">
                <span class="badge badge-<?= ($dataproduk['kategori_produk'] == 'Makanan') ? 'success' : 'info'; ?> px-3 py-2">
                    <i class="fas <?= ($dataproduk['kategori_produk'] == 'Makanan') ? 'fa-utensils' : 'fa-coffee'; ?> mr-1"></i>
                    <?= $dataproduk['kategori_produk']; ?>
                </span>
                <span class="badge badge-primary px-3 py-2 ml-1">
                    Rp <?= number_format($dataproduk['harga'], 0, ',', '.'); ?>
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Daftar Bahan Baku Resep -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h5 class="m-0 font-weight-bold text-dark">
            <i class="fas fa-list-ul mr-2"></i>Daftar Bahan Baku
        </h5>
    </div>
    <div class="card-body">
        <?php if (count($resep) > 0) : ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Nama Bahan Baku</th>
                            <th width="150">Jumlah Pakai</th>
                            <th width="120">Satuan</th>
                            <th width="130">Stok Tersedia</th>
                            <th width="80">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resep as $key => $r) : ?>
                            <tr>
                                <td class="text-center"><?= $key + 1; ?></td>
                                <td><strong><?= $r['nama_barang']; ?></strong></td>
                                <td class="text-center">
                                    <span class="font-weight-bold text-primary"><?= rtrim(rtrim(number_format($r['jumlah_pakai'], 2, ',', '.'), '0'), ','); ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-secondary"><?= $r['satuan']; ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-<?= ((float)$r['stock_toko'] > 10) ? 'success' : (((float)$r['stock_toko'] > 0) ? 'warning' : 'danger'); ?>">
                                        <?= $r['stock_toko']; ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="" class="btn btn-danger btn-sm btn-hapus-resep" idnya="<?= $r['id_resep']; ?>" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <div class="text-center py-4">
                <i class="fas fa-flask fa-3x text-gray-300 mb-3"></i>
                <p class="text-muted">Belum ada bahan baku yang ditambahkan ke resep produk ini.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Form Tambah Bahan Baku -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h5 class="m-0 font-weight-bold text-success">
            <i class="fas fa-plus-circle mr-2"></i>Tambah Bahan Baku ke Resep
        </h5>
    </div>
    <div class="card-body">
        <form method="post" action="<?= base_url('store/produk/tambah_resep/' . $dataproduk['id_produk']); ?>">
            <div class="row align-items-end">
                <div class="col-md-5">
                    <div class="form-group mb-md-0">
                        <label for="id_barang" class="font-weight-bold">Bahan Baku <span class="text-danger">*</span></label>
                        <select name="id_barang" id="id_barang" class="form-control" required>
                            <option value="">-- Pilih Bahan Baku --</option>
                            <?php foreach ($barang as $b) : ?>
                                <option value="<?= $b['id_barang']; ?>"><?= $b['nama_barang']; ?> (<?= $b['satuan']; ?>) — Stok: <?= $b['stock_toko']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-md-0">
                        <label for="jumlah_pakai" class="font-weight-bold">Jumlah Pakai (per 1 produk) <span class="text-danger">*</span></label>
                        <input type="number" name="jumlah_pakai" id="jumlah_pakai" class="form-control" placeholder="Contoh: 20" step="0.01" min="0.01" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-success btn-block">
                        <i class="fas fa-plus mr-1"></i>Tambah Bahan
                    </button>
                </div>
            </div>
            <small class="form-text text-muted mt-2">
                <i class="fas fa-info-circle mr-1"></i>
                Jumlah pakai menggunakan satuan yang sama dengan bahan baku (Gram/Kilogram/Liter).
                Contoh: Jika bahan "Kopi" satuannya Gram, masukkan 20 artinya 20 gram per 1 produk.
            </small>
        </form>
    </div>
</div>

<!-- Tombol Kembali -->
<div class="mb-4">
    <a href="<?= base_url('store/produk'); ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left mr-1"></i>Kembali ke Daftar Produk
    </a>
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
            timer: 3000,
        });
    </script>
<?php endif; ?>

<!-- hapus resep -->
<script>
    $(document).ready(function() {
        $(".btn-hapus-resep").on("click", function(e) {
            e.preventDefault();
            var idnya = $(this).attr("idnya");
            swal({
                    title: "Apakah kamu yakin?",
                    text: "Menghapus bahan baku ini dari resep",
                    icon: "warning",
                    buttons: ["Batal", "Hapus!"],
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: 'post',
                            url: "<?= base_url("store/produk/hapus_resep"); ?>",
                            data: 'id=' + idnya,
                            success: function() {
                                swal("Bahan baku berhasil dihapus dari resep!", {
                                    icon: "success",
                                    button: true
                                }).then((oke) => {
                                    if (oke) {
                                        location.reload();
                                    }
                                });
                            }
                        })
                    }
                });
        })
    })
</script>
