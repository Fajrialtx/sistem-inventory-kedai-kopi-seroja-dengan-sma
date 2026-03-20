<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Peramalan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mperamalan');
        $this->load->model('Mproduk');
        if (!$this->session->userdata("store")) {
            $this->session->set_flashdata('pesan', 'Anda harus login');
            redirect('', 'refresh');
        }
    }

    public function index()
    {
        $data['title'] = 'Peramalan Penjualan Produk';
        $data['produk'] = $this->Mperamalan->get_semua_produk();
        $data['hasil'] = null;

        $this->load->view('header', $data);
        $this->load->view('store/navbar', $data);
        $this->load->view('store/peramalan/dataperamalan', $data);
        $this->load->view('footer');
    }

    public function hitung()
    {
        $id_produk = $this->input->post('id_produk');
        $periode = $this->input->post('periode');

        if (empty($id_produk) || empty($periode)) {
            $this->session->set_flashdata('gagal', 'Pilih produk dan periode terlebih dahulu!');
            redirect('store/peramalan', 'refresh');
        }

        $data['title'] = 'Hasil Peramalan Penjualan';
        $data['produk'] = $this->Mperamalan->get_semua_produk();
        $data['hasil'] = $this->Mperamalan->hitung_sma($id_produk, $periode);
        $data['produk_dipilih'] = $this->Mproduk->detail_produk($id_produk);
        $data['periode_dipilih'] = $periode;
        $data['id_produk_dipilih'] = $id_produk;

        $this->load->view('header', $data);
        $this->load->view('store/navbar', $data);
        $this->load->view('store/peramalan/dataperamalan', $data);
        $this->load->view('footer');
    }
}
