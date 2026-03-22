<!-- breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('owner/produk'); ?>">Menu Produk</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
    </ol>
</nav>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h4 class="m-0 font-weight-bold text-primary"><i class="fas fa-edit mr-2"></i><?= $title; ?></h4>
    </div>
    <div class="card-body">
        <?php if (isset($gagal)) : ?>
            <div class="alert alert-danger"><?= $gagal; ?></div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('owner/produk/ubah/' . $dataproduk['id_produk']); ?>" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama_produk" class="font-weight-bold">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" name="nama_produk" id="nama_produk" class="form-control" value="<?= $dataproduk['nama_produk']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="kategori_produk" class="font-weight-bold">Kategori <span class="text-danger">*</span></label>
                        <select name="kategori_produk" id="kategori_produk" class="form-control" required>
                            <option value="Makanan" <?= ($dataproduk['kategori_produk'] == 'Makanan') ? 'selected' : ''; ?>>Makanan</option>
                            <option value="Minuman" <?= ($dataproduk['kategori_produk'] == 'Minuman') ? 'selected' : ''; ?>>Minuman</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="harga" class="font-weight-bold">Harga (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="harga" id="harga" class="form-control" value="<?= $dataproduk['harga']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="quantity" class="font-weight-bold">Quantity (Stok) <span class="text-danger">*</span></label>
                        <input type="number" name="quantity" id="quantity" class="form-control" value="<?= $dataproduk['quantity']; ?>" min="0" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status" class="font-weight-bold">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="Tersedia" <?= ($dataproduk['status'] == 'Tersedia') ? 'selected' : ''; ?>>Tersedia</option>
                            <option value="Habis" <?= ($dataproduk['status'] == 'Habis') ? 'selected' : ''; ?>>Habis</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi" class="font-weight-bold">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3"><?= $dataproduk['deskripsi']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="gambar" class="font-weight-bold">Gambar Produk</label>
                        <?php if (!empty($dataproduk['gambar'])) : ?>
                            <div class="mb-2">
                                <img src="<?= base_url('assets/img/produk/' . $dataproduk['gambar']); ?>" alt="<?= $dataproduk['nama_produk']; ?>" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                                <br><small class="text-muted">Gambar saat ini</small>
                            </div>
                        <?php endif; ?>
                        <div class="custom-file">
                            <input type="file" name="gambar" id="gambar" class="custom-file-input" accept="image/*">
                            <label class="custom-file-label" for="gambar">Pilih gambar baru...</label>
                        </div>
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah gambar. Format: JPG, PNG, GIF. Maks: 2MB</small>
                    </div>
                </div>
            </div>
            <hr>
            <div class="text-right">
                <a href="<?= base_url('owner/produk'); ?>" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Custom file input label -->
<script>
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>
