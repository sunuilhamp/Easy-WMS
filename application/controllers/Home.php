<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Dashboard
 */
class Home extends MY_Controller 
{
    public function __construct()
    {
        parent::__construct();
        
        $is_login = $this->session->userdata('is_login');

        if (!$is_login) {
            $this->session->set_flashdata('warning', 'Anda belum login');
            redirect(base_url('login'));
            return;
        }
    }

    public function index()
    {
        $nama = $this->session->userdata('nama');

        $data['title']              = 'Easy WMS - Dashboard';
        $data['breadcrumb_title']   = "Hallo $nama 😊";
        $data['breadcrumb_path']    = 'Home / Dashboard';
        $data['barang_masuk']       = $this->home->select([
                                        'barang_masuk.id', 'user.nama', 
                                        'barang_masuk.waktu'
                                    ])
                                    ->join('user')
                                    ->orderBy('barang_masuk.waktu', 'DESC')
                                    ->limit(5)
                                    ->get();
        $this->home->table          = "barang_keluar";
        $data['barang_keluar']      = $this->home->select([
                                        'barang_keluar.id', 'user.nama', 
                                        'barang_keluar.waktu'
                                    ])
                                    ->join('user')
                                    ->orderBy('barang_keluar.waktu', 'DESC')
                                    ->limit(5)
                                    ->get();
        $data['page']               = 'pages/home/index';
        
        $this->view($data);
    }
}

/* End of file Home.php */
