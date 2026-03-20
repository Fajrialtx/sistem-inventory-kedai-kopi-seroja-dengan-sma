<!-- breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('store/penjualan'); ?>">Data Penjualan</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
    </ol>
</nav>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h4 class="m-0 font-weight-bold text-primary"><i class="fas fa-plus-circle mr-2"></i><?= $title; ?></h4>
    </div>
    <div class="card-body">
        <?php if ($this->session->flashdata('gagal')) : ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('gagal'); ?></div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('store/penjualan/tambah'); ?>" id="form-penjualan">
            
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="font-weight-bold">Tanggal Penjualan <span class="text-danger">*</span></label>
                        <input type="date" name="tgl_penjualan" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                    </div>
                </div>
            </div>

            <h5 class="font-weight-bold text-gray-800 mb-3">Item Penjualan</h5>
            
            <div class="table-responsive mb-3">
                <table class="table table-bordered" id="tabel-item">
                    <thead class="bg-light">
                        <tr>
                            <th width="45%">Produk</th>
                            <th width="15%">Harga</th>
                            <th width="15%">Jumlah</th>
                            <th width="20%">Subtotal</th>
                            <th width="5%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="baris-item">
                            <td>
                                <select name="id_produk[]" class="form-control select-produk" required>
                                    <option value="">-- Pilih Produk --</option>
                                    <?php foreach ($produk as $p) : ?>
                                        <option value="<?= $p['id_produk']; ?>" data-harga="<?= $p['harga']; ?>" data-stok="<?= $p['quantity']; ?>">
                                            <?= $p['nama_produk']; ?> (Stok: <?= $p['quantity']; ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control input-harga" readonly value="0">
                            </td>
                            <td>
                                <input type="number" name="jumlah[]" class="form-control input-jumlah" min="1" value="1" required>
                            </td>
                            <td>
                                <input type="text" class="form-control input-subtotal font-weight-bold" readonly value="0">
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm btn-hapus-baris"><i class="fas fa-times"></i></button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">
                                <button type="button" class="btn btn-success btn-sm btn-tambah-baris"><i class="fas fa-plus mr-1"></i> Tambah Item</button>
                            </td>
                        </tr>
                        <tr class="bg-light">
                            <td colspan="3" class="text-right font-weight-bold">TOTAL BELANJA</td>
                            <td colspan="2">
                                <h4 class="font-weight-bold text-primary m-0" id="total-belanja">Rp 0</h4>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <hr>
            <div class="text-right">
                <a href="<?= base_url('store/penjualan'); ?>" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary" id="btn-simpan">
                    <i class="fas fa-save mr-1"></i>Simpan Penjualan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        
        // Fungsi format rupiah
        function formatRupiah(angka) {
            return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Fungsi hitung subtotal per baris
        function hitungSubtotal(baris) {
            var harga = baris.find('.select-produk option:selected').data('harga') || 0;
            var jumlah = baris.find('.input-jumlah').val() || 0;
            var subtotal = parseInt(harga) * parseInt(jumlah);
            
            baris.find('.input-harga').val(formatRupiah(harga));
            baris.find('.input-subtotal').val(formatRupiah(subtotal));
            
            hitungTotalBelanja();
        }

        // Fungsi hitung total belanja semua baris
        function hitungTotalBelanja() {
            var total = 0;
            $('.baris-item').each(function() {
                var harga = $(this).find('.select-produk option:selected').data('harga') || 0;
                var jumlah = $(this).find('.input-jumlah').val() || 0;
                total += parseInt(harga) * parseInt(jumlah);
            });
            $('#total-belanja').text(formatRupiah(total));
            
            // Disable simpan jika total 0
            if(total <= 0) {
                $('#btn-simpan').prop('disabled', true);
            } else {
                $('#btn-simpan').prop('disabled', false);
            }
        }

        // Event saat produk dipilih
        $(document).on('change', '.select-produk', function() {
            var baris = $(this).closest('.baris-item');
            var maxStok = $(this).find('option:selected').data('stok');
            
            // Set max jumlah sesuai stok
            if(maxStok) {
                baris.find('.input-jumlah').attr('max', maxStok);
                
                // Pastikan nilai tidak melebihi stok
                var valSaatIni = baris.find('.input-jumlah').val();
                if(parseInt(valSaatIni) > parseInt(maxStok)) {
                    baris.find('.input-jumlah').val(maxStok);
                }
            } else {
                baris.find('.input-jumlah').val(1);
            }
            
            hitungSubtotal(baris);
        });

        // Event saat jumlah diubah
        $(document).on('input', '.input-jumlah', function() {
            var baris = $(this).closest('.baris-item');
            var maxStok = baris.find('.select-produk option:selected').data('stok');
            var val = $(this).val();
            
            if(maxStok !== undefined && parseInt(val) > parseInt(maxStok)) {
                alert('Maksimal stok tersedia adalah ' + maxStok);
                $(this).val(maxStok);
            }
            
            hitungSubtotal(baris);
        });

        // Event hapus baris
        $(document).on('click', '.btn-hapus-baris', function() {
            var jumlahBaris = $('.baris-item').length;
            if (jumlahBaris > 1) {
                $(this).closest('.baris-item').remove();
                hitungTotalBelanja();
            } else {
                alert('Minimal harus ada 1 item produk!');
            }
        });

        // Event tambah baris
        $('.btn-tambah-baris').click(function() {
            var barisBaru = $('.baris-item:first').clone();
            
            // Reset nilai di baris baru
            barisBaru.find('.select-produk').val('');
            barisBaru.find('.input-harga').val('0');
            barisBaru.find('.input-jumlah').val('1');
            barisBaru.find('.input-subtotal').val('0');
            
            $('#tabel-item tbody').append(barisBaru);
            hitungTotalBelanja();
        });
        
        // Inisialisasi awal
        hitungTotalBelanja();
    });
</script>
