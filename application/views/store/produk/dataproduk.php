<!-- breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('store/beranda'); ?>">Beranda</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
    </ol>
</nav>

<!-- Statistik -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Produk</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_makanan + $total_minuman; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-list fa-2x text-gray-300"></i>
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
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Makanan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_makanan; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-utensils fa-2x text-gray-300"></i>
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
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Minuman</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_minuman; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-coffee fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-6">
                <h4 class="m-0 font-weight-bold text-primary"><i class="fas fa-book-open mr-2"></i><?= $title; ?></h4>
            </div>
            <div class="col-md-6 text-md-right mt-2 mt-md-0">
                <a href="<?= base_url('store/produk/tambah'); ?>" class="btn btn-primary btn-icon-split btn-sm">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Tambah Produk</span>
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <!-- Filter Kategori -->
        <div class="mb-3">
            <div class="btn-group" role="group">
                <a href="<?= base_url('store/produk'); ?>" class="btn btn-sm <?= ($kategori_aktif == 'Semua') ? 'btn-primary' : 'btn-outline-primary'; ?>">
                    <i class="fas fa-th-list mr-1"></i>Semua
                </a>
                <a href="<?= base_url('store/produk?kategori=Makanan'); ?>" class="btn btn-sm <?= ($kategori_aktif == 'Makanan') ? 'btn-success' : 'btn-outline-success'; ?>">
                    <i class="fas fa-utensils mr-1"></i>Makanan
                </a>
                <a href="<?= base_url('store/produk?kategori=Minuman'); ?>" class="btn btn-sm <?= ($kategori_aktif == 'Minuman') ? 'btn-info' : 'btn-outline-info'; ?>">
                    <i class="fas fa-coffee mr-1"></i>Minuman
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produk as $key => $value) : ?>
                        <tr>
                            <td><?= $key + 1; ?></td>
                            <td class="text-center" style="width: 80px;">
                                <?php if (!empty($value['gambar'])) : ?>
                                    <img src="<?= base_url('assets/img/produk/' . $value['gambar']); ?>" alt="<?= $value['nama_produk']; ?>" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                <?php else : ?>
                                    <div class="bg-light d-flex align-items-center justify-content-center rounded" style="width: 60px; height: 60px; margin: 0 auto;">
                                        <i class="fas <?= ($value['kategori_produk'] == 'Makanan') ? 'fa-utensils' : 'fa-coffee'; ?> text-gray-400"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?= $value['nama_produk']; ?></strong>
                                <?php if (!empty($value['deskripsi'])) : ?>
                                    <br><small class="text-muted"><?= substr($value['deskripsi'], 0, 50); ?><?= (strlen($value['deskripsi']) > 50) ? '...' : ''; ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($value['kategori_produk'] == 'Makanan') : ?>
                                    <span class="badge badge-success"><i class="fas fa-utensils mr-1"></i>Makanan</span>
                                <?php else : ?>
                                    <span class="badge badge-info"><i class="fas fa-coffee mr-1"></i>Minuman</span>
                                <?php endif; ?>
                            </td>
                            <td>Rp <?= number_format($value['harga'], 0, ',', '.'); ?></td>
                            <td class="text-center">
                                <span class="badge badge-<?= ($value['quantity'] > 10) ? 'primary' : (($value['quantity'] > 0) ? 'warning' : 'danger'); ?>">
                                    <?= $value['quantity']; ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <?php if ($value['status'] == 'Tersedia') : ?>
                                    <span class="badge badge-success">Tersedia</span>
                                <?php else : ?>
                                    <span class="badge badge-danger">Habis</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="<?= base_url('store/produk/ubah/' . $value['id_produk']); ?>" class="btn btn-warning btn-icon-split btn-sm">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-edit"></i>
                                    </span>
                                    <span class="text">Edit</span>
                                </a>
                                <a href="" class="btn btn-danger btn-icon-split btn-sm btn-hapus" idnya="<?= $value['id_produk']; ?>">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-trash"></i>
                                    </span>
                                    <span class="text">Hapus</span>
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

<!-- hapus data -->
<script>
    $(document).ready(function() {
        $(".btn-hapus").on("click", function(e) {
            e.preventDefault();
            var idnya = $(this).attr("idnya");
            swal({
                    title: "Apakah kamu yakin ?",
                    text: "untuk menghapus produk ini",
                    icon: "warning",
                    buttons: ["Batal", "Hapus Produk!"],
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: 'post',
                            url: "<?= base_url("store/produk/hapus"); ?>",
                            data: 'id=' + idnya,
                            success: function() {
                                swal("Produk berhasil terhapus!", {
                                    icon: "success",
                                    button: true
                                }).then((oke) => {
                                    if (oke) {
                                        location = "<?= base_url("store/produk"); ?>"
                                    }
                                });
                            }
                        })
                    }
                });
        })
    })
</script>
