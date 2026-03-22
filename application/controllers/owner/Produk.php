<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Produk extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mproduk');
        if (!$this->session->userdata("owner")) {
            $this->session->set_flashdata('pesan', 'Anda harus login');
            redirect('', 'refresh');
        }
    }

    public function index()
    {
        $kategori = $this->input->get('kategori');

        $data['title'] = 'Menu Produk';
        if (!empty($kategori) && in_array($kategori, ['Makanan', 'Minuman'])) {
            $data['produk'] = $this->Mproduk->tampil_produk_by_kategori($kategori);
            $data['kategori_aktif'] = $kategori;
        } else {
            $data['produk'] = $this->Mproduk->tampil_produk();
            $data['kategori_aktif'] = 'Semua';
        }

        $data['total_makanan'] = $this->Mproduk->hitung_makanan();
        $data['total_minuman'] = $this->Mproduk->hitung_minuman();

        $this->load->view('header', $data);
        $this->load->view('owner/navbar', $data);
        $this->load->view('owner/produk/dataproduk', $data);
        $this->load->view('footer');
    }

    public function tambah()
    {
        $this->form_validation->set_rules('nama_produk', 'Nama Produk', 'required');
        $this->form_validation->set_rules('kategori_produk', 'Kategori', 'required');
        $this->form_validation->set_rules('harga', 'Harga', 'required|numeric');
        $this->form_validation->set_rules('quantity', 'Quantity', 'required|numeric');

        $inputan = $this->input->post();

        if ($this->form_validation->run() == TRUE) {
            $data = [
                'nama_produk' => $inputan['nama_produk'],
                'kategori_produk' => $inputan['kategori_produk'],
                'harga' => $inputan['harga'],
                'quantity' => $inputan['quantity'],
                'deskripsi' => $inputan['deskripsi'],
                'status' => $inputan['status']
            ];

            // Upload gambar jika ada
            if (!empty($_FILES['gambar']['name'])) {
                $config['upload_path'] = FCPATH . 'assets/img/produk/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size'] = 2048;
                $config['file_name'] = 'produk_' . time();

                // Buat folder jika belum ada
                if (!is_dir($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                }

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('gambar')) {
                    $data['gambar'] = $this->upload->data('file_name');
                }
            }

            $query = $this->Mproduk->simpan_produk($data);
            if ($query == 'sukses') {
                $this->session->set_flashdata('pesan', 'Produk berhasil ditambah!');
                redirect('owner/produk', 'refresh');
            } else {
                $this->session->set_flashdata('gagal', 'Gagal menambah produk!');
            }
        } else {
            $data['gagal'] = validation_errors();
        }

        $data['title'] = 'Tambah Produk';
        $this->load->view('header', $data);
        $this->load->view('owner/navbar', $data);
        $this->load->view('owner/produk/tambahproduk', $data);
        $this->load->view('footer');
    }

    public function ubah($id_produk)
    {
        $inputan = $this->input->post();

        if ($inputan) {
            $this->form_validation->set_rules('nama_produk', 'Nama Produk', 'required');
            $this->form_validation->set_rules('kategori_produk', 'Kategori', 'required');
            $this->form_validation->set_rules('harga', 'Harga', 'required|numeric');
            $this->form_validation->set_rules('quantity', 'Quantity', 'required|numeric');

            if ($this->form_validation->run() == TRUE) {
                $data = [
                    'nama_produk' => $inputan['nama_produk'],
                    'kategori_produk' => $inputan['kategori_produk'],
                    'harga' => $inputan['harga'],
                    'quantity' => $inputan['quantity'],
                    'deskripsi' => $inputan['deskripsi'],
                    'status' => $inputan['status']
                ];

                // Upload gambar baru jika ada
                if (!empty($_FILES['gambar']['name'])) {
                    $config['upload_path'] = FCPATH . 'assets/img/produk/';
                    $config['allowed_types'] = 'jpg|jpeg|png|gif';
                    $config['max_size'] = 2048;
                    $config['file_name'] = 'produk_' . time();

                    if (!is_dir($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, true);
                    }

                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('gambar')) {
                        // Hapus gambar lama
                        $produk_lama = $this->Mproduk->detail_produk($id_produk);
                        if (!empty($produk_lama['gambar'])) {
                            $path_lama = FCPATH . 'assets/img/produk/' . $produk_lama['gambar'];
                            if (file_exists($path_lama)) {
                                unlink($path_lama);
                            }
                        }
                        $data['gambar'] = $this->upload->data('file_name');
                    }
                }

                $query = $this->Mproduk->ubah_produk($data, $id_produk);
                if ($query == 'sukses') {
                    $this->session->set_flashdata('pesan', 'Produk berhasil diubah!');
                    redirect('owner/produk', 'refresh');
                }
            }
            $data['gagal'] = validation_errors();
        }

        $data['dataproduk'] = $this->Mproduk->detail_produk($id_produk);
        $data['title'] = 'Ubah Produk';

        $this->load->view('header', $data);
        $this->load->view('owner/navbar', $data);
        $this->load->view('owner/produk/editproduk', $data);
        $this->load->view('footer');
    }

    public function hapus()
    {
        $idnya = $this->input->post("id");
        $this->Mproduk->hapus_produk($idnya);
    }
}
