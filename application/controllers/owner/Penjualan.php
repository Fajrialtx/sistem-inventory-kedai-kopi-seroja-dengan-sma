<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mpenjualan');
        $this->load->model('Mproduk');
        if (!$this->session->userdata("owner")) {
            $this->session->set_flashdata('pesan', 'Anda harus login');
            redirect('', 'refresh');
        }
    }

    public function index()
    {
        $data['title'] = 'Data Penjualan Harian';
        $data['penjualan'] = $this->Mpenjualan->tampil_penjualan();

        $this->load->view('header', $data);
        $this->load->view('owner/navbar', $data);
        $this->load->view('owner/penjualan/datapenjualan', $data);
        $this->load->view('footer');
    }

    public function detail($tanggal)
    {
        $data['title'] = 'Detail Penjualan: ' . date('d F Y', strtotime($tanggal));
        $data['tanggal'] = $tanggal;
        $data['penjualan'] = $this->Mpenjualan->tampil_penjualan_by_tanggal($tanggal);
        $data['total_pendapatan'] = $this->Mpenjualan->total_pendapatan_hari($tanggal);

        // Ambil rincian item tiap transaksi
        foreach ($data['penjualan'] as $key => $value) {
            $data['penjualan'][$key]['detail'] = $this->Mpenjualan->detail_transaksi($value['id_penjualan']);
        }

        $this->load->view('header', $data);
        $this->load->view('owner/navbar', $data);
        $this->load->view('owner/penjualan/detailpenjualan', $data);
        $this->load->view('footer');
    }

    public function tambah()
    {
        $inputan = $this->input->post();

        if ($inputan) {
            // Validasi input
            if (empty($inputan['id_produk']) || count($inputan['id_produk']) == 0) {
                $this->session->set_flashdata('gagal', 'Harap masukkan minimal 1 produk');
                redirect('owner/penjualan/tambah', 'refresh');
            }

            $owner = $this->session->userdata("owner");
            
            // Siapkan header penjualan
            $data_penjualan = [
                'id_user' => $owner['id_user'],
                'tgl_penjualan' => $inputan['tgl_penjualan'],
                'total_pendapatan' => 0 // Akan diupdate nanti
            ];

            // Siapkan detail penjualan
            $data_detail = [];
            $total_pendapatan = 0;
            $error_stok = false;
            $pesan_error = '';

            for ($i = 0; $i < count($inputan['id_produk']); $i++) {
                $id_produk = $inputan['id_produk'][$i];
                $jumlah = (int)$inputan['jumlah'][$i];
                
                if (empty($id_produk) || $jumlah <= 0) continue;

                // Cek stok produk
                $produk = $this->Mproduk->detail_produk($id_produk);
                if ($produk['quantity'] < $jumlah) {
                    $error_stok = true;
                    $pesan_error .= "Stok " . $produk['nama_produk'] . " tidak mencukupi (Sisa: " . $produk['quantity'] . ").<br>";
                    continue;
                }

                $harga_satuan = $produk['harga'];
                $subtotal = $harga_satuan * $jumlah;
                $total_pendapatan += $subtotal;

                $data_detail[] = [
                    'id_produk' => $id_produk,
                    'jumlah' => $jumlah,
                    'harga_satuan' => $harga_satuan,
                    'subtotal' => $subtotal
                ];
            }

            if ($error_stok || count($data_detail) == 0) {
                $this->session->set_flashdata('gagal', $pesan_error != '' ? $pesan_error : 'Tidak ada produk valid yang dimasukkan');
                redirect('owner/penjualan/tambah', 'refresh');
            }

            // Update total
            $data_penjualan['total_pendapatan'] = $total_pendapatan;

            // Simpan ke database
            $query = $this->Mpenjualan->simpan_penjualan($data_penjualan, $data_detail);
            
            if ($query == 'sukses') {
                $this->session->set_flashdata('pesan', 'Penjualan berhasil dicatat!');
                redirect('owner/penjualan', 'refresh');
            } else {
                $this->session->set_flashdata('gagal', 'Gagal mencatat penjualan!');
            }
        }

        $data['title'] = 'Tambah Penjualan';
        $data['produk'] = $this->Mproduk->tampil_produk_tersedia();

        $this->load->view('header', $data);
        $this->load->view('owner/navbar', $data);
        $this->load->view('owner/penjualan/tambahpenjualan', $data);
        $this->load->view('footer');
    }

    public function hapus()
    {
        $idnya = $this->input->post("id");
        $this->Mpenjualan->hapus_penjualan($idnya);
    }
}
