<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stokmasuk extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mbarang');
        $this->load->model('Mstokmasuk');
        $this->load->model('Muser');
        if (!$this->session->userdata("store")) {
            $this->session->set_flashdata('pesan', 'Anda harus login');
            redirect('', 'refresh');
        }
    }

    public function index()
    {
        $data['stokmasuk'] = $this->Mstokmasuk->tampil_stok_group();
        $data['title'] = 'Data Stok Masuk';
        $this->load->view('header', $data);
        $this->load->view('store/navbar', $data);
        $this->load->view('store/stokmasuk/datastok', $data);
        $this->load->view('footer');
    }

    public function detail($tanggal)
    {
        $data['stokmasuk'] = $this->Mstokmasuk->tampil_stok_by_tanggal($tanggal);
        $data['tanggal'] = $tanggal;
        $data['title'] = 'Detail Stok Masuk: ' . date('d F Y', strtotime($tanggal));
        
        $this->load->view('header', $data);
        $this->load->view('store/navbar', $data);
        $this->load->view('store/stokmasuk/detailstok', $data);
        $this->load->view('footer');
    }

    public function tambah()
    {
        $this->form_validation->set_rules('id_barang', 'Bahan Baku', 'required');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric');

        $inputan = $this->input->post();

        if ($this->form_validation->run() == TRUE) {
            $this->Mstokmasuk->tambah_stok($inputan);
            $this->session->set_flashdata('pesan', 'Data stok masuk berhasil ditambah!');
            redirect('store/stokmasuk', 'refresh');
        } else {
            $data['gagal'] = validation_errors();
        }

        $data['barang'] = $this->Mbarang->tampil_barang();
        $data['title'] = 'Tambah Stok Masuk';
        $this->load->view('header', $data);
        $this->load->view('store/navbar', $data);
        $this->load->view('store/stokmasuk/tambahstok', $data);
        $this->load->view('footer');
    }

    public function hapus()
    {
        $idnya = $this->input->post("id");
        $this->Mstokmasuk->hapus_stok($idnya);
    }
}
