<!-- breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('owner/penjualan'); ?>">Data Penjualan</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
    </ol>
</nav>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-8">
                <h4 class="m-0 font-weight-bold text-primary"><i class="fas fa-list mr-2"></i><?= $title; ?></h4>
            </div>
            <div class="col-md-4 text-md-right mt-2 mt-md-0">
                <h5 class="m-0 font-weight-bold text-success">Total: Rp <?= number_format($total_pendapatan, 0, ',', '.'); ?></h5>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Waktu Transaksi</th>
                        <th>Kasir</th>
                        <th>Item Terjual</th>
                        <th>Total Belanja</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($penjualan as $key => $value) : ?>
                        <tr>
                            <td><?= $key + 1; ?></td>
                            <td><?= date('H:i:s', strtotime($value['created_at'])); ?></td>
                            <td><?= $value['nama_kasir']; ?></td>
                            <td>
                                <ul class="pl-3 mb-0">
                                    <?php foreach ($value['detail'] as $dt) : ?>
                                        <li><?= $dt['nama_produk']; ?> (<?= $dt['jumlah']; ?> x Rp <?= number_format($dt['harga_satuan'], 0, ',', '.'); ?>) = Rp <?= number_format($dt['subtotal'], 0, ',', '.'); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </td>
                            <td><strong>Rp <?= number_format($value['total_pendapatan'], 0, ',', '.'); ?></strong></td>
                            <td class="text-center">
                                <a href="" class="btn btn-danger btn-sm btn-hapus" idnya="<?= $value['id_penjualan']; ?>" title="Hapus Transaksi">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <hr>
        <div class="text-right">
            <a href="<?= base_url('owner/penjualan'); ?>" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

<!-- hapus data -->
<script>
    $(document).ready(function() {
        $(".btn-hapus").on("click", function(e) {
            e.preventDefault();
            var idnya = $(this).attr("idnya");
            swal({
                    title: "Apakah kamu yakin ?",
                    text: "menghapus transaksi ini? Stok produk akan dikembalikan.",
                    icon: "warning",
                    buttons: ["Batal", "Hapus Transaksi!"],
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: 'post',
                            url: "<?= base_url("owner/penjualan/hapus"); ?>",
                            data: 'id=' + idnya,
                            success: function() {
                                swal("Transaksi berhasil dihapus & stok dikembalikan!", {
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
