<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Keranjang Keluar
 */
class Cartout extends MY_Controller 
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

        $data['title']              = 'Easy WMS - Keranjang Keluar';
        $data['breadcrumb_title']   = "Keranjang Keluar";
        $data['breadcrumb_path']    = 'Barang Keluar / Keranjang Keluar';
        $data['page']               = 'pages/cartout/index';
        $data['content']            = $this->cartout->select([
                'barang.id AS id_barang', 'barang.nama', 'barang.harga',
                'barang.id_satuan', 'keranjang_keluar.id AS id', 
                'keranjang_keluar.qty AS qty_barang_keluar'
            ])
            ->where('keranjang_keluar.id_user', $this->id_user)
            ->join('barang')
            ->get();

        $this->view($data);
    }

    /**
     * Menampung barang yang akan dikurangi kuantitasnya
     */
    public function add()
    {
        if (!$_POST || $this->input->post('qty_keluar') < 1) {
            $this->session->set_flashdata('error', 'Kuantitas tidak boleh kosong');
            redirect(base_url('items'));
            return;
        }
        
        $input = (object) $this->input->post(null, true);

        // Mengambil data barang yang dipilih
        $this->cartout->table = 'barang';
        $barang = $this->cartout->where('id', $input->id_barang)->first();

        // Mekanisme penambahan kuantitas
        // Ambil suatu barang di keranjang untuk dicek apakah barang tersebut sudah dimasukan
        $this->cartout->table = 'keranjang_keluar';
        $cart = $this->cartout->where('id_barang', $input->id_barang)
                             ->where('id_user', $this->id_user)
                             ->first();

        if ($cart) {    // Jika ternyata sudah dimasukan user, maka update cart
            $data = ['qty' => $cart->qty + $input->qty_keluar];

            // Update data
            if ($this->cartout->where('id', $cart->id)
                              ->where('id_user', $this->id_user)
                              ->update($data)
            ) {
                $this->session->set_flashdata('success', 'Kuantitas berhasil diubah');
            } else {
                $this->session->set_flashdata('error', 'Oops! Terjadi kesalahan');
            }

            redirect(base_url('cartout'));
            return;
        }

        // --- Insert cart baru ---
        $data = [
            'id_user'   => $this->id_user,
            'id_barang' => $input->id_barang,
            'qty'       => $input->qty_keluar
        ];

        if ($this->cartout->create($data)) {   // Jika insert berhasil
            $this->session->set_flashdata('success', 'Barang berhasil dimasukan ke keranjang');
        } else {
            $this->session->set_flashdata('error', 'Oops! Terjadi kesalahan');
        }

        redirect(base_url('cartout'));
    }

    /**
     * Update kuantitas di keranjang belanja
     */
    public function update()
    {
        if (!$_POST || $this->input->post('qty_barang_keluar') < 1) {
            $this->session->set_flashdata('error', 'Kuantitas tidak boleh kosong');
            redirect(base_url('cartout'));
        }

        $id = $this->input->post('id');
        $id_barang = $this->input->post('id_barang');

        // Mengambil data dari keranjang
        $data['content'] = $this->cartout->where('id_barang', $id_barang)
                                         ->where('id', $id)
                                         ->first();

        if (!$data['content']) {
            $this->session->set_flashdata('warning', 'Data tidak ditemukan');
            redirect(base_url('cartout'));
        }

        $data['input'] = (object) $this->input->post(null, true);

        // Update kuantitas
        $cart = ['qty' => $data['input']->qty_barang_keluar];

        if ($this->cartout->where('id', $id)
                         ->where('id_barang', $id_barang)
                         ->where('id_user', $this->id_user)
                         ->update($cart)
        ) {
            // Jika update berhasil
            $this->session->set_flashdata('success', 'Kuantitas berhasil diubah');
        } else {
            $this->session->set_flashdata('error', 'Oops! Terjadi kesalahan');
        }

        redirect(base_url('cartout'));
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

        if (!$this->cartout->where('id', $id)->first()) {  // Jika cart tidak ditemukan
            $this->session->set_flashdata('warning', 'Maaf data tidak ditemukan');
            redirect(base_url('cartout'));
        }

        if ($this->cartout->where('id', $id)->delete()) {  // Jika penghapusan cart berhasil
            $this->session->set_flashdata('success', '1 Barang berhasil dikeluarkan dari keranjang');
        } else {
            $this->session->set_flashdata('error', 'Oops, terjadi suatu kesalahan');
        }

        redirect(base_url('cartout'));
    }

    /**
     * Menghapus seluruh isi keranjang
     */
    public function drop()
    {
        if (!$_POST) {
            $this->session->set_flashdata('error', 'Aksi ditolak');
            redirect(base_url('cartout'));
        }

        if ($this->cartout->where('id_user', $this->id_user)->count() < 1) {
            $this->session->set_flashdata('warning', 'Tidak ada barang di dalam keranjang');
            redirect(base_url('cartout'));
        }

        // Hapus seluruh isi keranjang dari user
        $this->cartout->where('id_user', $this->id_user)->delete();

        // Jika tabel keranjang dari seluruh user kosong, reset autoincrement id keranjang
        if ($this->cartout->count() < 1) { 
            $this->cartout->resetIndex();
        }

        $this->session->set_flashdata('success', 'Keranjang keluar anda telah dibersihkan');

        redirect(base_url('cartout'));
    }

    /**
     * Fungsi tombol checkout
     * Fungsi ini memasukan informasi pengeluaran barang ke tabel 'barang_keluar' 
     * dan memindahkan list keranjang keluar ke tabel 'barang_keluar_detail'
     */
    public function checkout()
    {
        if (!isset($this->id_user)) {
            $this->session->set_flashdata('error', 'Akses checkout ditolak!');
            redirect(base_url('home'));
        }

        // Cek apakah user memiliki barang keluar yang pending di keranjang
        $inputCartCount = $this->cartout->where('id_user', $this->id_user)->count();
        
        if (!$inputCartCount) {
            $this->session->set_flashdata('warning', 'Tidak ada barang yang akan dikeluarkan!');
            redirect(base_url('cartout'));
        }

        // Menyiapkan insert table barang_keluar
        $data['id_user']      = $this->id_user;
        $this->cartout->table = 'barang_keluar';

        // Jika insert barang_keluar berhasil, siapkan insert lagi ke dalam barang_keluar_detail
        if ($id_barang_keluar = $this->cartout->create($data)) { 
            // Ambil list keranjang user
            $cart = $this->db->where('id_user', $this->id_user) 
                             ->get('keranjang_keluar')
                             ->result_array();

            // Modifikasi tiap cart
            foreach ($cart as $row) {
                $row['id_barang_keluar'] = $id_barang_keluar;
                unset($row['id'], $row['id_user']);                 // Hapus kolom tidak penting
                $this->db->insert('barang_keluar_detail', $row);    // Insert ke tabel barang_keluar_detail
            }

            $this->db->delete('keranjang_keluar', ['id_user' => $this->id_user]);    // Hapus cart user sekarang

            $this->session->set_flashdata('success', 'Pengeluaran barang berhasil');

            $data['title']              = 'Checkout';
            $data['breadcrumb_title']   = "Checkout";
            $data['breadcrumb_path']    = 'Barang Keluar / Keranjang Keluar / Checkout';
            $data['page']               = 'pages/cartout/checkout';

            // Ambil data pengeluaran barang untuk ditampilkan di halaman checkout
            $this->table = 'barang_keluar';
            $data['barang_keluar']  = $this->cartout->select([
                    'user.id AS id_user', 'user.nama',
                    'barang_keluar.id AS id_barang_keluar', 'barang_keluar.waktu'
                ])
                ->join('user')
                ->where('barang_keluar.id', $id_barang_keluar)
                ->where('barang_keluar.id_user', $this->id_user)
                ->first();

            $this->cartout->table = 'barang_keluar_detail';
            $data['list_barang'] = $this->cartout->select([
                    'barang_keluar_detail.qty',
                    'barang.id_satuan', 'barang.nama',
                ])
                ->join('barang')
                ->where('barang_keluar_detail.id_barang_keluar', $id_barang_keluar)
                ->get();

            $this->view($data);
        } else {
            $this->session->set_flashdata('error', 'Oops! Terjadi kesalahan');
            $this->index();
        }
    }
}

/* End of file Cartout.php */
