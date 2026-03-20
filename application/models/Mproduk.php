<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Mproduk extends CI_Model
{

    function tampil_produk()
    {
        $this->db->order_by('kategori_produk', 'ASC');
        $this->db->order_by('nama_produk', 'ASC');
        $ambil = $this->db->get('produk');
        return $ambil->result_array();
    }

    function tampil_produk_by_kategori($kategori)
    {
        $this->db->where('kategori_produk', $kategori);
        $this->db->order_by('nama_produk', 'ASC');
        $ambil = $this->db->get('produk');
        return $ambil->result_array();
    }

    function detail_produk($id_produk)
    {
        $this->db->where('id_produk', $id_produk);
        $ambil = $this->db->get('produk');
        return $ambil->row_array();
    }

    function simpan_produk($data)
    {
        $this->db->insert('produk', $data);
        return $this->db->affected_rows() > 0 ? 'sukses' : 'gagal';
    }

    function ubah_produk($data, $id_produk)
    {
        $this->db->where('id_produk', $id_produk);
        $this->db->update('produk', $data);
        return $this->db->affected_rows() >= 0 ? 'sukses' : 'gagal';
    }

    function hapus_produk($id_produk)
    {
        // Ambil data gambar sebelum dihapus
        $produk = $this->detail_produk($id_produk);
        if (!empty($produk['gambar'])) {
            $path = FCPATH . 'assets/img/produk/' . $produk['gambar'];
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $this->db->where('id_produk', $id_produk);
        $this->db->delete('produk');
    }

    function hitung_produk()
    {
        return $this->db->count_all('produk');
    }

    function hitung_makanan()
    {
        $this->db->where('kategori_produk', 'Makanan');
        return $this->db->count_all_results('produk');
    }

    function hitung_minuman()
    {
        $this->db->where('kategori_produk', 'Minuman');
        return $this->db->count_all_results('produk');
    }

    function kurangi_stok($id_produk, $jumlah)
    {
        $this->db->set('quantity', 'quantity - ' . (int)$jumlah, FALSE);
        $this->db->where('id_produk', $id_produk);
        $this->db->update('produk');
    }

    function tambah_stok($id_produk, $jumlah)
    {
        $this->db->set('quantity', 'quantity + ' . (int)$jumlah, FALSE);
        $this->db->where('id_produk', $id_produk);
        $this->db->update('produk');
    }

    function tampil_produk_tersedia()
    {
        $this->db->where('status', 'Tersedia');
        $this->db->where('quantity >', 0);
        $this->db->order_by('nama_produk', 'ASC');
        $ambil = $this->db->get('produk');
        return $ambil->result_array();
    }
}
