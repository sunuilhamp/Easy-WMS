<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cartin extends MY_Controller 
{
    private $id_user;

    public function __construct()
    {
        parent::__construct();
        
        $is_login       = $this->session->userdata('is_login');
        $this->id_user  = $this->session->userdata('id_user');

        if (!$is_login) {
            $this->session->set_flashdata('warning', 'Anda belum login');
            redirect(base_url('login'));
            return;
        }
    }

    public function index()
    {
        $this->session->unset_userdata('keyword');

        $data['title']              = 'Easy WMS - Keranjang Masuk';
        $data['breadcrumb_title']   = "Keranjang Masuk";
        $data['breadcrumb_path']    = 'Barang Masuk / Keranjang Masuk';
        $data['page']               = 'pages/cartin/index';
        $data['content']            = $this->cartin->select([
                'barang.id AS id_barang', 'barang.nama', 'barang.harga',
                'barang.id_satuan', 'keranjang_masuk.id AS id', 
                'keranjang_masuk.qty AS qty_barang_masuk', 'keranjang_masuk.subtotal'
            ])
            ->where('keranjang_masuk.id_user', $this->id_user)
            ->join('barang')
            ->get();

        $this->view($data);
    }

    /**
     * Menampung barang yang akan ditambah kuantitasnya
     */
    public function add()
    {
        if (!$_POST || $this->input->post('qty_masuk') < 1) {
            $this->session->set_flashdata('error', 'Kuantitas tidak boleh kosong');
            redirect(base_url('items'));
            return;
        }
        
        $input = (object) $this->input->post(null, true);

        // Mengambil data barang yang dipilih
        $this->cartin->table = 'barang';
        $barang = $this->cartin->where('id', $input->id_barang)->first();

        // Mekanisme penambahan kuantitas
        // Ambil suatu barang di keranjang untuk dicek apakah barang tersebut sudah dimasukan
        $this->cartin->table = 'keranjang_masuk';
        $cart = $this->cartin->where('id_barang', $input->id_barang)
                             ->where('id_user', $this->id_user)
                             ->first();

        $subtotal_penambahan = $barang->harga * $input->qty_masuk;

        if ($cart) {    // Jika ternyata sudah dimasukan user, maka update cart
            $data = [
                'qty'       => $cart->qty + $input->qty_masuk,
                'subtotal'  => $cart->subtotal + $subtotal_penambahan
            ];

            // Update data
            if ($this->cartin->where('id', $cart->id)
                             ->where('id_user', $this->id_user)
                             ->update($data)
            ) {
                $this->session->set_flashdata('success', 'Barang berhasil ditambahkan');
            } else {
                $this->session->set_flashdata('error', 'Oops! Terjadi kesalahan');
            }

            redirect(base_url('cartin'));
            return;
        }

        // --- Insert cart baru ---
        $data = [
            'id_user'   => $this->id_user,
            'id_barang' => $input->id_barang,
            'qty'       => $input->qty_masuk
        ];

        if ($this->cartin->create($data)) {   // Jika insert berhasil
            $this->session->set_flashdata('success', 'Barang berhasil dimasukan ke keranjang');
        } else {
            $this->session->set_flashdata('error', 'Oops! Terjadi kesalahan');
        }

        redirect(base_url('cartin'));
    }

    /**
     * Update kuantitas di keranjang belanja
     */
    public function update()
    {
        if (!$_POST || $this->input->post('qty_barang_masuk') < 1) {
            $this->session->set_flashdata('error', 'Kuantitas tidak boleh kosong');
            redirect(base_url('cartin'));
        }

        $id = $this->input->post('id_barang');
        $id_barang = $this->input->post('id_barang');

        // Mengambil data dari keranjang
        $data['content'] = $this->cartin->where('id_barang', $id_barang)
                                        ->where('id', $id)
                                        ->first();

        if (!$data['content']) {
            $this->session->set_flashdata('warning', 'Data tidak ditemukan');
            redirect(base_url('cartin'));
        }

        // Mengambil data barang yang dipilih, untuk mendapatkan harga barang
        $this->cartin->table = 'barang';
        $barang = $this->cartin->where('id', $data['content']->id_barang)->first();

        // Update subtotal
        $data['input'] = (object) $this->input->post(null, true);
        $subtotal_pembaharuan = $data['input']->qty_barang_masuk * $barang->harga;

        // Update data
        $cart = [
            'qty'      => $data['input']->qty_barang_masuk,
            'subtotal' => $subtotal_pembaharuan
        ];

        $this->cartin->table  = 'keranjang_masuk';
        if ($this->cartin->where('id', $id)
                         ->where('id_barang', $id_barang)
                         ->where('id_user', $this->id_user)
                         ->update($cart)
        ) {
            // Jika update berhasil
            $this->session->set_flashdata('success', 'Kuantitas berhasil diubah');
        } else {
            $this->session->set_flashdata('error', 'Oops! Terjadi kesalahan');
        }

        redirect(base_url('cartin'));
    }

    /**
     * Delete suatu cart di halaman cart
     */
    public function delete()
    {
        if (!$_POST) {
            // Jika diakses tidak dengan menggunakan method post, kembalikan ke home (forbidden)
            $this->session->set_flashdata('error', 'Akses pengeluaran barang dari keranjang ditolak!');
            redirect(base_url('home'));
        }

        $id = $this->input->post('id');

        if (!$this->cartin->where('id', $id)->first()) {  // Jika pesanan tidak ditemukan
            $this->session->set_flashdata('warning', 'Maaf data tidak ditemukan');
            redirect(base_url('cartin'));
        }

        if ($this->cartin->where('id', $id)->delete()) {  // Jika penghapusan pesanan berhasil
            $this->session->set_flashdata('success', '1 Barang berhasil dikeluarkan');
        } else {
            $this->session->set_flashdata('error', 'Oops, terjadi suatu kesalahan');
        }

        redirect(base_url('cartin'));
    }

    /**
     * Menghapus seluruh isi keranjang
     */
    public function drop()
    {
        if (!$_POST) {
            $this->session->set_flashdata('error', 'Aksi ditolak');
            redirect(base_url('cartin'));
        }

        if ($this->cartin->where('id_user', $this->id_user)->count() < 1) {
            $this->session->set_flashdata('warning', 'Tidak ada barang di dalam keranjang');
            redirect(base_url('cartin'));
        }

        // Hapus seluruh isi keranjang dari user
        $this->cartin->where('id_user', $this->id_user)->delete();

        // Jika tabel keranjang dari seluruh user kosong, reset autoincrement id keranjang
        if ($this->cartin->count() < 1) { 
            $this->cartin->resetIndex();
        }

        $this->session->set_flashdata('success', 'Keranjang masuk anda telah dibersihkan');

        redirect(base_url('cartin'));
    }

    /**
     * Fungsi ini memasukan informasi penjualan ke tabel 'penjualan' 
     * dan memindahkan list keranjang pesanan ke 'detail_penjualan'
     */
    public function checkout()
    {
        if (!isset($this->id_user)) {
            $this->session->set_flashdata('error', 'Akses checkout ditolak!');
            redirect(base_url('home'));
        }

        // Cek apakah user memiliki pesanan di keranjang
        $jumlahPesanan = $this->cartin->where('id_user', $this->id_user)->count();
        
        if (!$jumlahPesanan) {
            $this->session->set_flashdata('warning', 'Tidak ada pesanan!');
            redirect(base_url('home'));
        }

        if (!$this->cartin->validateStock()) { // Valdasi stok
            return $this->index();
        }

        // Menghitung total dari subtotal pesanan suatu user
        $total = $this->db->select_sum('subtotal_pesanan')
            ->where('id_user', $this->id_user)
            ->get('keranjang')
            ->row()                 // Select first row
            ->subtotal_pesanan;     // Select column subtotal_pesanan

        // Menyiapkan insert table penjualan
        $data['id_user'] = $this->id_user;

        // Jika insert penjualan berhasil, siapkan insert lagi ke dalam detail_penjualan
        $this->cartin->table = 'penjualan';
        if ($id_penjualan = $this->cartin->create($data)) { 
            // Ambil list pesanan yang telah dipesan user
            $cart = $this->db->where('id_user', $this->id_user) 
                             ->get('keranjang')
                             ->result_array();

            // Modifikasi tiap cart
            foreach ($cart as $row) {
                $row['id_penjualan'] = $id_penjualan;           // Tambah kolom id_order
                $row['qty_jual']     = $row['qty_pesanan'];
                unset($row['id_pesanan'], $row['id_user'], $row['qty_pesanan'], $row['subtotal_pesanan']);   // Hapus kolom tidak penting
                $this->db->insert('detail_penjualan', $row);    // Insert ke tabel detail_penjualan
            }

            $this->db->delete('keranjang', ['id_user' => $this->id_user]);    // Hapus cart user sekarang

            $this->session->set_flashdata('success', 'Data berhasil disimpan');

            $data['title']              = 'Checkout';
            $data['breadcrumb_title']   = "Checkout";
            $data['breadcrumb_path']    = 'Kasir / Keranjang Pesanan / Checkout';
            $data['page']               = 'pages/checkout/index';

            // Ambil data penjualan
            $this->table        = 'penjualan';
            $data['penjualan']  = $this->cartin->select([
                    'user.id_user', 'user.nama',
                    'penjualan.id_penjualan', 'penjualan.waktu_penjualan'
                ])
                ->join('user', $this->cartin->ACTION_ADD_JOIN)
                ->where('penjualan.id_penjualan', $id_penjualan)
                ->where('penjualan.id_user', $this->id_user)
                ->first();

            $this->cartin->table          = 'detail_penjualan';
            $data['list_pesanan'] = $this->cartin->select([
                    'detail_penjualan.qty_jual', 'detail_penjualan.subtotal_jual',
                    'stock_barang.nama_barang', 'stock_barang.harga_jual',
                ])
                ->join('stock_barang', $this->cartin->ACTION_TRIM_JOIN)
                ->where('detail_penjualan.id_penjualan', $id_penjualan)
                ->get();

            $this->view($data);

        } else {
            $this->session->set_flashdata('error', 'Oops! Terjadi kesalahan');
            $this->index();
        }
    }
}

/* End of file Cartin.php */
