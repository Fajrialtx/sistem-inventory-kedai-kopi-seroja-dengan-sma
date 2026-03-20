<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Mpenjualan extends CI_Model
{

    function tampil_penjualan()
    {
        $this->db->select('tgl_penjualan, SUM(total_pendapatan) as pendapatan_harian, COUNT(id_penjualan) as jumlah_transaksi');
        $this->db->group_by('tgl_penjualan');
        $this->db->order_by('tgl_penjualan', 'DESC');
        $ambil = $this->db->get('penjualan');
        return $ambil->result_array();
    }

    function tampil_penjualan_by_tanggal($tanggal)
    {
        $this->db->select('p.*, u.nama as nama_kasir');
        $this->db->from('penjualan p');
        $this->db->join('user_petugas u', 'p.id_user = u.id_user', 'left');
        $this->db->where('p.tgl_penjualan', $tanggal);
        $this->db->order_by('p.created_at', 'DESC');
        $ambil = $this->db->get();
        return $ambil->result_array();
    }

    function detail_transaksi($id_penjualan)
    {
        $this->db->select('dp.*, pr.nama_produk, pr.kategori_produk');
        $this->db->from('detail_penjualan dp');
        $this->db->join('produk pr', 'dp.id_produk = pr.id_produk', 'left');
        $this->db->where('dp.id_penjualan', $id_penjualan);
        $ambil = $this->db->get();
        return $ambil->result_array();
    }

    function simpan_penjualan($data_penjualan, $data_detail)
    {
        $this->db->trans_start();

        // 1. Simpan header penjualan
        $this->db->insert('penjualan', $data_penjualan);
        $id_penjualan = $this->db->insert_id();

        // 2. Simpan detail dan kurangi stok
        $this->load->model('Mproduk');
        foreach ($data_detail as $item) {
            $item['id_penjualan'] = $id_penjualan;
            $this->db->insert('detail_penjualan', $item);

            // Kurangi stok produk
            $this->Mproduk->kurangi_stok($item['id_produk'], $item['jumlah']);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return 'gagal';
        } else {
            return 'sukses';
        }
    }

    function hapus_penjualan($id_penjualan)
    {
        $this->db->trans_start();

        // 1. Ambil detail untuk kembalikan stok
        $detail = $this->detail_transaksi($id_penjualan);
        $this->load->model('Mproduk');
        
        foreach ($detail as $item) {
            // Kembalikan stok
            $this->Mproduk->tambah_stok($item['id_produk'], $item['jumlah']);
        }

        // 2. Hapus penjualan (detail akan terhapus otomatis by cascade di db)
        $this->db->where('id_penjualan', $id_penjualan);
        $this->db->delete('penjualan');

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    function total_pendapatan_hari($tanggal)
    {
        $this->db->select_sum('total_pendapatan');
        $this->db->where('tgl_penjualan', $tanggal);
        $ambil = $this->db->get('penjualan');
        $hasil = $ambil->row_array();
        return empty($hasil['total_pendapatan']) ? 0 : $hasil['total_pendapatan'];
    }
}
