<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mstokmasuk extends CI_Model
{
    public function tampil_stok_group()
    {
        $this->db->select('tanggal, COUNT(id_stokmasuk) as jumlah_item');
        $this->db->group_by('tanggal');
        $this->db->order_by('tanggal', 'DESC');
        $ambil = $this->db->get('stok_masuk');
        return $ambil->result_array();
    }

    public function tampil_stok_by_tanggal($tanggal)
    {
        $this->db->join('barang', 'barang.id_barang = stok_masuk.id_barang', 'left');
        $this->db->join('user_petugas', 'user_petugas.id_user = stok_masuk.id_user', 'left');
        $this->db->where('tanggal', $tanggal);
        $this->db->order_by('id_stokmasuk', 'DESC');
        $ambil = $this->db->get('stok_masuk');
        return $ambil->result_array();
    }

    public function tambah_stok($inputan)
    {
        $id_user = $this->session->userdata('owner') ? $this->session->userdata('owner')['id_user'] : $this->session->userdata('store')['id_user'];
        // 1. Insert into stok_masuk table
        $data = [
            'id_barang' => $inputan['id_barang'],
            'id_user'   => $id_user,
            'tanggal'   => $inputan['tanggal'],
            'jumlah'    => $inputan['jumlah'],
            'keterangan'=> $inputan['keterangan']
        ];
        $this->db->insert('stok_masuk', $data);

        // 2. Update the barang table to add stock
        // get current stock
        $this->db->where('id_barang', $inputan['id_barang']);
        $barang = $this->db->get('barang')->row_array();
        
        $current_stock = (int)$barang['stock_toko'];
        $new_stock = $current_stock + (int)$inputan['jumlah'];

        $this->db->where('id_barang', $inputan['id_barang']);
        $this->db->update('barang', ['stock_toko' => $new_stock]);
    }

    public function hapus_stok($id_stokmasuk)
    {
        // 1. Get the deleted stock amount
        $this->db->where('id_stokmasuk', $id_stokmasuk);
        $stok_masuk = $this->db->get('stok_masuk')->row_array();

        if ($stok_masuk) {
            $id_barang = $stok_masuk['id_barang'];
            $jumlah = (int)$stok_masuk['jumlah'];

            // 2. Reduce the stock from the barang table
            $this->db->where('id_barang', $id_barang);
            $barang = $this->db->get('barang')->row_array();
            
            if ($barang) {
                $current_stock = (int)$barang['stock_toko'];
                $new_stock = $current_stock - $jumlah;
                if ($new_stock < 0) $new_stock = 0; // prevent negative stock theoretically
                
                $this->db->where('id_barang', $id_barang);
                $this->db->update('barang', ['stock_toko' => $new_stock]);
            }

            // 3. Delete from stok_masuk
            $this->db->where('id_stokmasuk', $id_stokmasuk);
            $this->db->delete('stok_masuk');
        }
    }
}
