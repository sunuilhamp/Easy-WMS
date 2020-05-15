<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Catatan Masuk
 */
class Inputs extends MY_Controller 
{
    private $id_user;

    public function __construct()
    {
        parent::__construct();
        
        $this->id_user  = $this->session->userdata('id_user');
        $is_login       = $this->session->userdata('is_login');

        if (!$is_login) {
            $this->session->set_flashdata('warning', 'Anda belum login');
            redirect(base_url('login'));
            return;
        }
    }

    public function index($page = null)
    {
        $this->session->unset_userdata('keyword');
        $this->session->unset_userdata('time');
        
        $data['title']              = 'Easy WMS - List Barang Masuk';
        $data['breadcrumb_title']   = 'List Barang Masuk';
        $data['breadcrumb_path']    = 'Barang Masuk / List Barang Masuk';
        $data['content']            = $this->inputs->select([
                'barang_masuk.id', 'user.nama', 
                'barang_masuk.waktu', 'barang_masuk.total_harga'
            ])
            ->join('user')
            ->orderBy('barang_masuk.waktu', 'DESC')
            ->paginate($page)
            ->get();
        $data['total_rows'] = $this->inputs->count();
        $data['pagination'] = $this->inputs->makePagination(base_url('inputs'), 2, $data['total_rows']);
        $data['page']       = 'pages/inputs/index';
        
        $this->view($data);
    }

    /**
     * Fungsi search berdasarkan id_barang_masuk / nama staff
     */
    public function search($page = null)
    {
        if (isset($_POST['keyword'])) {
            $this->session->set_userdata('keyword', $this->input->post('keyword'));
        }

        $this->session->unset_userdata('time');
        $keyword = $this->session->userdata('keyword');

        if (empty($keyword)) {
            redirect(base_url('inputs'));
        }

        $data['title']              = 'Easy WMS - List Barang Masuk';
        $data['breadcrumb_title']   = "List Barang Masuk";
        $data['breadcrumb_path']    = "Barang Masuk / List Penjualan / Cari / $keyword";
        $data['content']            = $this->inputs->select([
                'barang_masuk.id', 'user.nama', 
                'barang_masuk.waktu', 'barang_masuk.total_harga'
            ])
            ->join('user')
            ->like('barang_masuk.id', $keyword)
            ->orLike('user.nama', $keyword)
            ->paginate($page)
            ->get();
        $data['total_rows'] = $this->inputs->join('user')
            ->like('barang_masuk.id', $keyword)
            ->orLike('user.nama', $keyword)
            ->count();
        $data['pagination'] = $this->inputs->makePagination(base_url('inputs/search'), 3, $data['total_rows']);
        $data['page']       = 'pages/inputs/index';

        $this->view($data);
    }

    /**
     * Fungsi search berdasarkan waktu
     */
    public function search_time($page = null)
    {
        if (isset($_POST['time'])) {
            $this->session->set_userdata('time', $this->input->post('time'));
        }

        $this->session->unset_userdata('keyword');
        $time = $this->session->userdata('time');

        if (empty($time)) {
            redirect(base_url('inputs'));
        }

        $data['title']              = 'Easy WMS - List Barang Masuk';
        $data['breadcrumb_title']   = "List Barang Masuk";
        $data['breadcrumb_path']    = "Barang Masuk / List Barang Masuk / Filter / $time";
        $data['content']            = $this->inputs->select([
                'barang_masuk.id', 'user.nama', 
                'barang_masuk.waktu', 'barang_masuk.total_harga'
            ])
            ->join('user')
            ->like('DATE(barang_masuk.waktu)', date('Y-m-d', strtotime($time)))
            ->paginate($page)
            ->get();
        $data['total_rows'] = $this->inputs->join('user')
            ->like('DATE(barang_masuk.waktu)', date('Y-m-d', strtotime($time)))
            ->count();
        $data['pagination'] = $this->inputs->makePagination(base_url('inputs/search_time'), 3, $data['total_rows']);
        $data['page']       = 'pages/inputs/index';

        $this->view($data);
    }

    public function detail($id_barang_masuk)
    {
        $data['title']              = 'Easy WMS - Detail Barang Masuk';
        $data['breadcrumb_title']   = "Detail Barang Masuk";
        $data['breadcrumb_path']    = "Barang Masuk / List Barang Masuk / Detail Barang Masuk / $id_barang_masuk";
        $data['page']               = 'pages/inputs/detail';

        $data['barang_masuk']  = $this->inputs->select([
                'user.id AS id_user', 'user.nama',
                'barang_masuk.id AS id_barang_masuk', 'barang_masuk.waktu'
            ])
            ->join('user')
            ->where('barang_masuk.id', $id_barang_masuk)
            ->where('barang_masuk.id_user', $this->id_user)
            ->first();

        $this->inputs->table = 'barang_masuk_detail';
        $data['list_barang'] = $this->inputs->select([
                'barang_masuk_detail.qty', 'barang_masuk_detail.subtotal',
                'barang.id_satuan', 'barang.nama', 'barang.harga',
            ])
            ->join('barang')
            ->where('barang_masuk_detail.id_barang_masuk', $id_barang_masuk)
            ->get();

        $this->view($data);
    }
}

/* End of file Inputs.php */
