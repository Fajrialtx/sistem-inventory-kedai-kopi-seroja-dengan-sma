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
    function get_data_penjualan_harian($id_produk, $jumlah_hari, $tgl_eksekusi = null)
    {
        $this->db->select('penjualan.tgl_penjualan, SUM(detail_penjualan.jumlah) as total_penjualan');
        $this->db->from('detail_penjualan');
        $this->db->join('penjualan', 'penjualan.id_penjualan = detail_penjualan.id_penjualan', 'left');
        $this->db->where('detail_penjualan.id_produk', $id_produk);
        if ($tgl_eksekusi) {
            $this->db->where('penjualan.tgl_penjualan <', $tgl_eksekusi);
        }
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
    function hitung_sma($id_produk, $periode, $tgl_eksekusi = null)
    {
        // Ambil data penjualan harian, ambil lebih banyak untuk kalkulasi SMA
        $data_harian = $this->get_data_penjualan_harian($id_produk, $periode + 10, $tgl_eksekusi);

        $hasil = [];
        $jumlah_data = count($data_harian);

        foreach ($data_harian as $key => $value) {
            $item = [
                'tgl_penjualan' => $value['tgl_penjualan'],
                'total_penjualan' => (int) $value['total_penjualan'],
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

        // Hitung Error (MAD, MSE, MAPE) untuk mengukur akurasi
        $mad = null;
        $mse = null;
        $mape = null;
        $error_count = 0;
        $error_abs_sum = 0;
        $error_squared_sum = 0;
        $error_percentage_sum = 0;

        foreach ($hasil as $item) {
            // Hitung Error hanya jika SMA ada
            if ($item['sma'] !== null && $item['total_penjualan'] !== null) {
                $aktual = $item['total_penjualan'];
                $pred = $item['sma'];
                $error = abs($aktual - $pred);

                $error_abs_sum += $error;
                $error_squared_sum += ($error * $error);
                if ($aktual > 0) {
                    $error_percentage_sum += ($error / $aktual) * 100;
                }
                $error_count++;
            }
        }

        if ($error_count > 0) {
            $mad = round($error_abs_sum / $error_count, 2);
            $mse = round($error_squared_sum / $error_count, 2);
            $mape = round($error_percentage_sum / $error_count, 2);
        }

        return [
            'data' => $hasil,
            'prediksi' => $prediksi,
            'mad' => $mad,
            'mse' => $mse,
            'mape' => $mape,
            'periode' => $periode
        ];
    }

    // =========================================================================
    // FUNGSI BARU: Peramalan Semua Produk Sekaligus
    // =========================================================================

    /**
     * Menghitung SMA untuk SEMUA produk sekaligus dengan 3 periode (3, 5, 7)
     * 
     * @return array Hasil peramalan per produk dengan ketiga periode
     */
    function hitung_sma_semua_produk($tgl_eksekusi = null)
    {
        $produk_list = $this->get_semua_produk();
        $periodes = [3, 5, 7];
        $hasil_semua = [];

        foreach ($produk_list as $produk) {
            $item = [
                'id_produk' => $produk['id_produk'],
                'nama_produk' => $produk['nama_produk'],
                'kategori_produk' => $produk['kategori_produk'],
                'periodes' => []
            ];

            foreach ($periodes as $periode) {
                $sma = $this->hitung_sma($produk['id_produk'], $periode, $tgl_eksekusi);
                $item['periodes'][$periode] = [
                    'prediksi' => $sma['prediksi'],
                    'mad' => $sma['mad'],
                    'mse' => $sma['mse'],
                    'mape' => $sma['mape'],
                    'data' => $sma['data']
                ];
            }

            $hasil_semua[] = $item;
        }

        return $hasil_semua;
    }

    /**
     * Simpan hasil peramalan ke database (batch insert)
     * 
     * @param array $hasil_semua Hasil dari hitung_sma_semua_produk()
     * @param string $tgl_eksekusi Tanggal eksekusi peramalan
     * @return bool
     */
    function simpan_hasil_peramalan($hasil_semua, $tgl_eksekusi)
    {
        $periodes = [3, 5, 7];
        $batch_data = [];

        foreach ($hasil_semua as $produk) {
            foreach ($periodes as $periode) {
                $batch_data[] = [
                    'id_produk' => $produk['id_produk'],
                    'tgl_eksekusi' => $tgl_eksekusi,
                    'periode' => $periode,
                    'prediksi' => $produk['periodes'][$periode]['prediksi'],
                    'mad' => $produk['periodes'][$periode]['mad'],
                    'mse' => $produk['periodes'][$periode]['mse'],
                    'mape' => $produk['periodes'][$periode]['mape'],
                ];
            }
        }

        if (!empty($batch_data)) {
            return $this->db->insert_batch('hasil_peramalan', $batch_data);
        }
        return false;
    }

    /**
     * Cek apakah peramalan untuk tanggal tertentu sudah ada
     * 
     * @param string $tgl_eksekusi
     * @return bool
     */
    function cek_peramalan_exists($tgl_eksekusi)
    {
        $this->db->where('tgl_eksekusi', $tgl_eksekusi);
        return $this->db->count_all_results('hasil_peramalan') > 0;
    }

    /**
     * Ambil tanggal eksekusi peramalan terbaru (hanya yang di-generate hari ini)
     * 
     * @return string|null
     */
    function get_tgl_terbaru()
    {
        $this->db->select('tgl_eksekusi');
        $this->db->where('DATE(created_at)', date('Y-m-d'));
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('hasil_peramalan');
        $row = $query->row_array();
        return $row ? $row['tgl_eksekusi'] : null;
    }

    /**
     * Ambil riwayat peramalan (grouped by tgl_eksekusi)
     * 
     * @return array
     */
    function get_riwayat_peramalan()
    {
        $this->db->select('tgl_eksekusi, COUNT(DISTINCT id_produk) as jumlah_produk, MIN(created_at) as created_at');
        $this->db->group_by('tgl_eksekusi');
        $this->db->order_by('tgl_eksekusi', 'DESC');
        $query = $this->db->get('hasil_peramalan');
        return $query->result_array();
    }

    /**
     * Ambil riwayat peramalan TANPA yang terbaru
     * 
     * @return array
     */
    function get_riwayat_tanpa_terbaru()
    {
        $tgl_terbaru = $this->get_tgl_terbaru();

        $this->db->select('tgl_eksekusi, COUNT(DISTINCT id_produk) as jumlah_produk, MIN(created_at) as created_at');
        if ($tgl_terbaru) {
            $this->db->where('tgl_eksekusi !=', $tgl_terbaru);
        }
        $this->db->group_by('tgl_eksekusi');
        $this->db->order_by('tgl_eksekusi', 'DESC');
        $query = $this->db->get('hasil_peramalan');
        return $query->result_array();
    }

    /**
     * Ambil detail hasil peramalan per tanggal eksekusi
     * Menampilkan semua produk dengan hasil 3 periode
     * 
     * @param string $tgl_eksekusi
     * @return array
     */
    function get_detail_peramalan($tgl_eksekusi)
    {
        $this->db->select('hasil_peramalan.*, produk.nama_produk, produk.kategori_produk, (SELECT SUM(dp.jumlah) FROM detail_penjualan dp JOIN penjualan p ON dp.id_penjualan = p.id_penjualan WHERE p.tgl_penjualan = hasil_peramalan.tgl_eksekusi AND dp.id_produk = hasil_peramalan.id_produk) as aktual');
        $this->db->from('hasil_peramalan');
        $this->db->join('produk', 'produk.id_produk = hasil_peramalan.id_produk', 'left');
        $this->db->where('tgl_eksekusi', $tgl_eksekusi);
        $this->db->order_by('produk.nama_produk', 'ASC');
        $this->db->order_by('hasil_peramalan.periode', 'ASC');
        $query = $this->db->get();
        $raw = $query->result_array();

        // Restructure: group by produk, each with 3 periods
        $grouped = [];
        foreach ($raw as $row) {
            $id = $row['id_produk'];
            if (!isset($grouped[$id])) {
                $grouped[$id] = [
                    'id_produk' => $id,
                    'nama_produk' => $row['nama_produk'],
                    'kategori_produk' => $row['kategori_produk'],
                    'aktual' => $row['aktual'] !== null ? $row['aktual'] : 0,
                    'periodes' => []
                ];
            }
            $grouped[$id]['periodes'][$row['periode']] = [
                'prediksi' => $row['prediksi'],
                'mad' => $row['mad'],
                'mse' => $row['mse'],
                'mape' => $row['mape']
            ];
        }

        return array_values($grouped);
    }

    /**
     * Hapus hasil peramalan berdasarkan tanggal eksekusi
     * 
     * @param string $tgl_eksekusi
     * @return bool
     */
    function hapus_peramalan($tgl_eksekusi)
    {
        $this->db->where('tgl_eksekusi', $tgl_eksekusi);
        $this->db->delete('hasil_peramalan');
        return $this->db->affected_rows() > 0;
    }
}
