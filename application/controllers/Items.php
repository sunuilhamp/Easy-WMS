<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller List Barang
 */
class Items extends MY_Controller 
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

    public function index($page = null)
    {
        $this->session->unset_userdata('keyword');

        $data['title']              = 'Easy WMS - List Barang';
        $data['breadcrumb_title']   = "List Barang";
        $data['breadcrumb_path']    = 'Pendataan Barang / List Barang';
        $data['content']            = $this->items->paginate($page)->get();
        $data['total_rows']         = $this->items->count();
        $data['pagination']         = $this->items->makePagination(base_url('items'), 2, $data['total_rows']);
        $data['page']               = 'pages/items/index';

        // print_r($data['content']); exit;

        $this->view($data);
    }

    /**
     * Klasifikasi berdasarkan satuan barang
     * Param 1: satuan barang
     * Param 2: nilai pagination
     */
    public function unit($unit, $page = null)
    {  
        $this->session->unset_userdata('keyword');

        $data['title']              = 'Easy WMS - List Barang';
        $data['breadcrumb_title']   = "List Barang";
        $data['breadcrumb_path']    = 'Pendataan Barang / Tipe / ' . ucfirst($unit);
        $data['content']            = $this->items->paginate($page)->where('satuan', $unit)->get();
        $data['total_rows']         = $this->items->where('satuan', $unit)->count();
        $data['pagination']         = $this->items->makePagination(
            base_url("items/unit/$unit"), 4, $data['total_rows']
        );
        $data['page']               = 'pages/items/index';

        $this->view($data);
    }

    public function search($page = null)
    {
        if (isset($_POST['keyword'])) {
            $this->session->set_userdata('keyword', $this->input->post('keyword'));
        }

        $keyword = $this->session->userdata('keyword');

        if (empty($keyword)) {
            redirect(base_url('items'));
        }

        $data['title']              = 'Easy WMS - List Barang';
        $data['breadcrumb_title']   = "List Barang";
        $data['breadcrumb_path']    = "Pendataan Barang / Search / $keyword";
        $data['content']            = $this->items->paginate($page)->like('nama', $keyword)->get();
        $data['total_rows']         = $this->items->like('nama', $keyword)->count();
        $data['pagination']         = $this->items->makePagination(
            base_url('items/search'), 3, $data['total_rows']
        );
        $data['page']               = 'pages/items/index';

        $this->view($data);
    }
}

/* End of file Items.php */
