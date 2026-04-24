<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Mresep extends CI_Model
{

    /**
     * Tampilkan semua resep untuk produk tertentu (JOIN barang untuk info nama & satuan)
     */
    function tampil_resep($id_produk)
    {
        $this->db->select('resep_produk.*, barang.nama_barang, barang.satuan, barang.stock_toko');
        $this->db->from('resep_produk');
        $this->db->join('barang', 'barang.id_barang = resep_produk.id_barang', 'left');
        $this->db->where('resep_produk.id_produk', $id_produk);
        $this->db->order_by('barang.nama_barang', 'ASC');
        $ambil = $this->db->get();
        return $ambil->result_array();
    }

    /**
     * Simpan satu baris resep
     */
    function simpan_resep($data)
    {
        // Cek apakah bahan sudah ada di resep produk ini
        $this->db->where('id_produk', $data['id_produk']);
        $this->db->where('id_barang', $data['id_barang']);
        $existing = $this->db->get('resep_produk')->row_array();

        if ($existing) {
            return 'duplikat';
        }

        $this->db->insert('resep_produk', $data);
        return $this->db->affected_rows() > 0 ? 'sukses' : 'gagal';
    }

    /**
     * Hapus satu baris resep
     */
    function hapus_resep($id_resep)
    {
        $this->db->where('id_resep', $id_resep);
        $this->db->delete('resep_produk');
    }

    /**
     * Hapus semua resep untuk produk tertentu
     */
    function hapus_resep_by_produk($id_produk)
    {
        $this->db->where('id_produk', $id_produk);
        $this->db->delete('resep_produk');
    }

    /**
     * Tampilkan semua barang untuk dropdown
     */
    function tampil_semua_barang()
    {
        $this->db->order_by('nama_barang', 'ASC');
        $ambil = $this->db->get('barang');
        return $ambil->result_array();
    }

    /**
     * Kurangi stok bahan baku berdasarkan resep produk
     * Dipanggil saat penjualan
     *
     * @param int $id_produk
     * @param int $jumlah_terjual jumlah produk yang dijual
     */
    function kurangi_bahan_baku($id_produk, $jumlah_terjual)
    {
        $resep = $this->tampil_resep($id_produk);

        foreach ($resep as $bahan) {
            $pengurangan = $bahan['jumlah_pakai'] * $jumlah_terjual;

            // Kurangi stock_toko di tabel barang
            $this->db->where('id_barang', $bahan['id_barang']);
            $barang = $this->db->get('barang')->row_array();

            if ($barang) {
                $stok_baru = (float)$barang['stock_toko'] - $pengurangan;
                if ($stok_baru < 0) $stok_baru = 0;

                $this->db->where('id_barang', $bahan['id_barang']);
                $this->db->update('barang', ['stock_toko' => $stok_baru]);
            }
        }
    }

    /**
     * Kembalikan stok bahan baku berdasarkan resep produk
     * Dipanggil saat hapus penjualan
     *
     * @param int $id_produk
     * @param int $jumlah_terjual jumlah produk yang dikembalikan
     */
    function kembalikan_bahan_baku($id_produk, $jumlah_terjual)
    {
        $resep = $this->tampil_resep($id_produk);

        foreach ($resep as $bahan) {
            $penambahan = $bahan['jumlah_pakai'] * $jumlah_terjual;

            // Tambah stock_toko di tabel barang
            $this->db->where('id_barang', $bahan['id_barang']);
            $barang = $this->db->get('barang')->row_array();

            if ($barang) {
                $stok_baru = (float)$barang['stock_toko'] + $penambahan;

                $this->db->where('id_barang', $bahan['id_barang']);
                $this->db->update('barang', ['stock_toko' => $stok_baru]);
            }
        }
    }
}
