<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Peramalan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mperamalan');
        $this->load->model('Mproduk');
        if (!$this->session->userdata("owner")) {
            $this->session->set_flashdata('pesan', 'Anda harus login');
            redirect('', 'refresh');
        }
    }

    /**
     * Halaman utama: form + hasil terbaru + riwayat lama
     */
    public function index()
    {
        $data['title'] = 'Peramalan Penjualan Produk';
        $data['role'] = 'owner';

        // Ambil peramalan terbaru
        $tgl_terbaru = $this->Mperamalan->get_tgl_terbaru();
        $data['tgl_terbaru'] = $tgl_terbaru;
        $data['terbaru'] = $tgl_terbaru ? $this->Mperamalan->get_detail_peramalan($tgl_terbaru) : [];

        // Ambil riwayat tanpa yang terbaru
        $data['riwayat'] = $this->Mperamalan->get_riwayat_tanpa_terbaru();

        $this->load->view('header', $data);
        $this->load->view('owner/navbar', $data);
        $this->load->view('owner/peramalan/dataperamalan', $data);
        $this->load->view('footer');
    }

    /**
     * Proses hitung SMA semua produk
     */
    public function hitung()
    {
        $tgl_eksekusi = $this->input->post('tgl_eksekusi');

        if (empty($tgl_eksekusi)) {
            $this->session->set_flashdata('gagal', 'Pilih tanggal eksekusi terlebih dahulu!');
            redirect('owner/peramalan', 'refresh');
        }

        if ($this->Mperamalan->cek_peramalan_exists($tgl_eksekusi)) {
            $this->session->set_flashdata('gagal', 'Peramalan untuk tanggal ' . date('d/m/Y', strtotime($tgl_eksekusi)) . ' sudah pernah dihitung!');
            redirect('owner/peramalan', 'refresh');
        }

        // Lakukan peramalan untuk SEMUA produk (3, 5, dan 7 hari) menggunakan tgl_eksekusi sebagai batas akhir data historis
        $hasil_semua = $this->Mperamalan->hitung_sma_semua_produk($tgl_eksekusi);
        $simpan = $this->Mperamalan->simpan_hasil_peramalan($hasil_semua, $tgl_eksekusi);

        if ($simpan) {
            $this->session->set_flashdata('sukses', 'Peramalan berhasil dihitung dan disimpan untuk tanggal ' . date('d/m/Y', strtotime($tgl_eksekusi)));
        } else {
            $this->session->set_flashdata('gagal', 'Gagal menyimpan hasil peramalan!');
        }

        redirect('owner/peramalan', 'refresh');
    }

    /**
     * Halaman detail peramalan (untuk riwayat lama)
     */
    public function detail($tgl_eksekusi = null)
    {
        if (empty($tgl_eksekusi)) {
            redirect('owner/peramalan', 'refresh');
        }

        $detail = $this->Mperamalan->get_detail_peramalan($tgl_eksekusi);

        if (empty($detail)) {
            $this->session->set_flashdata('gagal', 'Data peramalan tidak ditemukan!');
            redirect('owner/peramalan', 'refresh');
        }

        $data['title'] = 'Detail Peramalan - ' . date('d/m/Y', strtotime($tgl_eksekusi));
        $data['tgl_eksekusi'] = $tgl_eksekusi;
        $data['detail'] = $detail;
        $data['role'] = 'owner';

        $this->load->view('header', $data);
        $this->load->view('owner/navbar', $data);
        $this->load->view('owner/peramalan/detail_peramalan', $data);
        $this->load->view('footer');
    }

    /**
     * Halaman grafik per produk
     */
    public function grafik($tgl_eksekusi = null, $id_produk = null)
    {
        if (empty($tgl_eksekusi) || empty($id_produk)) {
            redirect('owner/peramalan', 'refresh');
        }

        $produk = $this->Mproduk->detail_produk($id_produk);
        if (empty($produk)) {
            $this->session->set_flashdata('gagal', 'Produk tidak ditemukan!');
            redirect('owner/peramalan', 'refresh');
        }

        // Ambil data penjualan harian untuk grafik
        $data_penjualan = $this->Mperamalan->get_data_penjualan_harian($id_produk, 17);

        // Ambil hasil prediksi per periode
        $detail_all = $this->Mperamalan->get_detail_peramalan($tgl_eksekusi);
        $prediksi_produk = null;
        foreach ($detail_all as $d) {
            if ($d['id_produk'] == $id_produk) {
                $prediksi_produk = $d;
                break;
            }
        }

        $data['title'] = 'Grafik Peramalan - ' . $produk['nama_produk'];
        $data['tgl_eksekusi'] = $tgl_eksekusi;
        $data['produk'] = $produk;
        $data['data_penjualan'] = $data_penjualan;
        $data['prediksi'] = $prediksi_produk;
        $data['role'] = 'owner';

        $this->load->view('header', $data);
        $this->load->view('owner/navbar', $data);
        $this->load->view('owner/peramalan/grafik_produk', $data);
        $this->load->view('footer');
    }

    /**
     * Hapus peramalan berdasarkan tanggal eksekusi
     */
    public function hapus($tgl_eksekusi = null)
    {
        if (empty($tgl_eksekusi)) {
            redirect('owner/peramalan', 'refresh');
        }

        $hapus = $this->Mperamalan->hapus_peramalan($tgl_eksekusi);

        if ($hapus) {
            $this->session->set_flashdata('sukses', 'Data peramalan berhasil dihapus!');
        } else {
            $this->session->set_flashdata('gagal', 'Gagal menghapus data peramalan!');
        }

        redirect('owner/peramalan', 'refresh');
    }
}
