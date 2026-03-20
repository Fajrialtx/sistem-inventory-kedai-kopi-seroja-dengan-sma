<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Mperamalan extends CI_Model
{

    /**
     * Mengambil daftar semua produk
     */
    function get_semua_produk()
    {
        $this->db->where('status', 'Tersedia');
        $this->db->order_by('nama_produk', 'ASC');
        $ambil = $this->db->get('produk');
        return $ambil->result_array();
    }

    /**
     * Mengambil data penjualan harian per produk untuk N hari terakhir
     * Mengelompokkan berdasarkan tanggal dan menjumlahkan item terjual per hari
     */
    function get_data_penjualan_harian($id_produk, $jumlah_hari)
    {
        $this->db->select('penjualan.tgl_penjualan, SUM(detail_penjualan.jumlah) as total_penjualan');
        $this->db->from('detail_penjualan');
        $this->db->join('penjualan', 'penjualan.id_penjualan = detail_penjualan.id_penjualan', 'left');
        $this->db->where('detail_penjualan.id_produk', $id_produk);
        $this->db->group_by('penjualan.tgl_penjualan');
        $this->db->order_by('penjualan.tgl_penjualan', 'DESC');
        $this->db->limit($jumlah_hari);

        $query = $this->db->get();
        $result = $query->result_array();

        // Balik urutan agar dari tanggal terlama ke terbaru
        return array_reverse($result);
    }

    /**
     * Menghitung Single Moving Average
     * 
     * Rumus: F(t+1) = (X(t) + X(t-1) + ... + X(t-n+1)) / n
     * 
     * @param int $id_produk ID produk
     * @param int $periode Jumlah periode (3, 5, atau 7 hari)
     * @return array Data penjualan, perhitungan SMA per periode, dan prediksi
     */
    function hitung_sma($id_produk, $periode)
    {
        // Ambil data penjualan harian, ambil lebih banyak untuk kalkulasi SMA
        $data_harian = $this->get_data_penjualan_harian($id_produk, $periode + 10);

        $hasil = [];
        $jumlah_data = count($data_harian);

        foreach ($data_harian as $key => $value) {
            $item = [
                'tgl_penjualan' => $value['tgl_penjualan'],
                'total_penjualan' => (int)$value['total_penjualan'],
                'sma' => null
            ];

            // Hitung SMA jika sudah cukup data (mulai dari index ke-$periode)
            if ($key >= $periode) {
                $sum = 0;
                for ($i = $key - $periode; $i < $key; $i++) {
                    $sum += $data_harian[$i]['total_penjualan'];
                }
                $item['sma'] = (int) round($sum / $periode);
            }

            $hasil[] = $item;
        }

        // Hitung prediksi untuk hari berikutnya
        $prediksi = null;
        if ($jumlah_data >= $periode) {
            $sum = 0;
            for ($i = $jumlah_data - $periode; $i < $jumlah_data; $i++) {
                $sum += $data_harian[$i]['total_penjualan'];
            }
            $prediksi = (int) round($sum / $periode);
        }

        // Hitung MAD (Mean Absolute Deviation) untuk mengukur akurasi
        $mad = null;
        $error_count = 0;
        $error_sum = 0;
        foreach ($hasil as $item) {
            // Hitung MAD hanya jika SMA ada
            if ($item['sma'] !== null) {
                $error_sum += abs($item['total_penjualan'] - $item['sma']);
                $error_count++;
            }
        }
        
        if ($error_count > 0) {
            $mad = round($error_sum / $error_count, 2);
        }

        return [
            'data' => $hasil,
            'prediksi' => $prediksi,
            'mad' => $mad,
            'periode' => $periode
        ];
    }
}
