<!-- breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
    </ol>
</nav>

<!-- Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row justify-content-between">
            <div class="col-md-6">
                <h4 class="m-0 font-weight-bold text-primary"><?= $title; ?></h4>
            </div>
            <div class="col-md-6 text-md-right mt-2 mt-md-0">
                <a href="<?= base_url('owner/bahanbaku/tambah') ?>" class="btn btn-primary btn-icon-split btn-sm">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Tambah</span>
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="custom-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($barang as $key => $value) : ?>
                        <tr>
                            <td><?= $key + 1; ?></td>
                            <td><?= $value['kode_barang']; ?></td>
                            <td><?= $value['nama_barang']; ?></td>
                            <td><?= $value['nama_kategori']; ?></td>
                            <td><?= $value['stock_toko'] . '  ' . $value['satuan']; ?></td>
                            <td>
                                <div class="text-center">
                                    <a href="<?= base_url('owner/bahanbaku/detail/' . $value['id_barang']) ?>" class="btn btn-info btn-icon-split btn-sm">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-info"></i>
                                        </span>
                                        <span class="text">Detail</span>
                                    </a>
                                    <a href="<?= base_url('owner/bahanbaku/ubah/' . $value['id_barang']) ?>" class="btn btn-warning btn-icon-split btn-sm">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                        <span class="text">Ubah</span>
                                    </a>
                                    <a href="" class="btn btn-danger btn-icon-split btn-sm btn-hapus" idnya="<?= $value['id_barang']; ?>">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                        <span class="text">Hapus</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- pesan berhasil  -->
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

<!-- Custom Table  -->
<script>
    $(document).ready(function() {
        $('#custom-table').DataTable({
            dom: "<'row'<'col-md-5'l><'col-md-3'B><'col-md-4'f>>" +
                "<'row'<'col-md-12'tr>>" +
                "<'row'<'col-md-5'i> <'col-md-7'p>>",
            buttons: [{
                    extend: 'print',
                    orientation: 'potrait',
                    pageSize: 'A4',
                    title: 'Permintaan Barang Masuk',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                },
                {
                    extend: 'excelHtml5',
                    orientation: 'potrait',
                    pageSize: 'A4',
                    title: 'Permintaan Barang Masuk',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    orientation: 'potrait',
                    pageSize: 'A4',
                    title: 'Permintaan Barang Masuk',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                }
            ]
        });
    });
</script>

<!-- hapus data -->
<script>
    $(document).ready(function() {
        $(".btn-hapus").on("click", function(e) {
            e.preventDefault();
            var idnya = $(this).attr("idnya");
            swal({
                    title: "Apakah kamu yakin ?",
                    text: "untuk menghapus data ini",
                    icon: "warning",
                    buttons: ["Batal", "Hapus Data!"],
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        //disini ajax hapus data
                        $.ajax({
                            type: 'post',
                            url: "<?= base_url("owner/bahanbaku/hapus"); ?>",
                            data: 'id=' + idnya,
                            success: function() {
                                swal("Data berhasil terhapus!", {
                                    icon: "success",
                                    button: true
                                }).then((oke) => {
                                    if (oke) {
                                        location = "<?= base_url("owner/bahanbaku/"); ?>"
                                    }
                                });
                            }
                        })
                    }
                });
        })
    })
</script>
