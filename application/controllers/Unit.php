<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Kontroller Tambah Satuan
 */
class Unit extends MY_Controller 
{
    public function __construct()
    {
        parent::__construct();
        
        $is_login = $this->session->userdata('is_login');

        if (!$is_login) {
            $this->session->set_flashdata('warning', 'Anda belum login');
            redirect(base_url('login'));
        }
    }

    public function index($page = null)
    {
        if ($this->session->userdata('role') != 'admin') { 
            $this->session->set_flashdata('warning', 'Anda tidak memiliki akses');
            redirect(base_url('home'));
            return;
        }

        if (!$_POST) {
            $input = (object) $this->unit->getDefaultValues();
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->unit->validate()) {     // Jika validasi gagal maka arahkan ke form register lagi
            $data['title'] = 'Tambah Satuan';
            $data['input'] = $input;
            $data['page']  = 'pages/unit/index';
            $data['breadcrumb_title'] = 'Tambah Satuan';
            $data['breadcrumb_path']  = 'Manajemen Barang / Tambah Satuan';

            return $this->view($data);
        }

        // Input data
        if ($this->unit->run($input)) {
            $this->session->set_flashdata('success', 'Satuan berhasil ditambahkan');
            redirect(base_url('unit'));
        } else {
            $this->session->set_flashdata('error', 'Oops terjadi suatu kesalahan');
            redirect(base_url('unit'));
        }
    }

    public function reset()
    {
        redirect(base_url('unit'));
    }
}

/* End of file Unit.php */
