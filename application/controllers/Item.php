<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Controller Tambah Barang
 */
class Item extends MY_Controller
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
        // print_r(getSuppliers()); exit;

        if (!$_POST) {
            $input = (object) $this->item->getDefaultValues();
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->item->validate()) {
            $data['title'] = 'Easy WMS - Register Barang';
            $data['input'] = $input;
            $data['page']  = 'pages/item/index';
            $data['breadcrumb_title'] = 'Register Barang';
            $data['breadcrumb_path']  = 'Barang Masuk / Register Barang';

            return $this->view($data);
        }

        // Input data
        if ($this->item->run($input)) {
            $this->session->set_flashdata('success', 'Barang berhasil ditambahkan');
            redirect(base_url('item'));
        } else {
            $this->session->set_flashdata('error', 'Oops terjadi suatu kesalahan');
            redirect(base_url('item'));
        }
    }

    public function reset()
    {
        redirect(base_url('item'));
    }
}

/* End of file Item.php */
