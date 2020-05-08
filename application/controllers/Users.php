<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Kontroller list user
 */
class Users extends MY_Controller 
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
        
        $data['title']              = 'Easy WMS - List Staff';
        $data['breadcrumb_title']   = 'List Staff';
        $data['breadcrumb_path']    = 'Manajemen Staff / List Staff';
        $data['content']            = $this->users->paginate($page)->get();
        $data['total_rows']         = $this->users->count();
        $data['pagination']         = $this->users->makePagination(base_url('users'), 2, $data['total_rows']);
        $data['page']               = 'pages/users/index';
        
        $this->view($data);
    }

    public function search($page = null)
    {
        if (isset($_POST['keyword'])) {
            $this->session->set_userdata('keyword', $this->input->post('keyword'));
        }

        $keyword = $this->session->userdata('keyword');

        if (empty($keyword)) {
            redirect(base_url('users'));
        }

        $keyword = $this->session->userdata('keyword');

        $data['title']              = 'Easy WMS - Cari Staff';
        $data['breadcrumb_title']   = "Daftar Staff";
        $data['breadcrumb_path']    = "Daftar Staff / Cari / $keyword";
        $data['content']            = $this->users->paginate($page)
                                        ->like('nama', $keyword)
                                        ->orLike('ktp', $keyword)
                                        ->orLike('email', $keyword)
                                        ->paginate($page)
                                        ->get();
        $data['total_rows']         = $this->users->like('nama', $keyword)
                                        ->orLike('ktp', $keyword)
                                        ->orLike('email', $keyword)
                                        ->count();
        $data['pagination']         = $this->users->makePagination(base_url('users/search'), 3, $data['total_rows']);
        $data['page']               = 'pages/users/index';

        $this->view($data);
    }

    /**
     * Edit data user oleh admin
     */
    public function edit($id)
    {
        if ($this->session->userdata('id_user') != 'id_user' && $this->session->userdata('role') != 'admin') {
            $this->session->set_flashdata('error', 'Akses edit ditolak!');
            redirect(base_url('home'));
        }

        $data['content'] = $this->users->where('id', $id)->first();

        if (!$data['content']) {
            $this->session->set_flashdata('warning', 'Maaf data tidak ditemukan');
            redirect(base_url('users'));
        }

        if (!$_POST) {
            $data['input'] = $data['content'];
        } else {
            $data['input'] = (object) $this->input->post(null, true);

            if ($data['input']->password !== '') {
                // Jika password tidak kosong, berati user mengubah password lalu encrypt
                $data['input']->password = hashEncrypt($data['input']->password);
            } else {
                // Jika tidak kosong berati user tidak mengubah password
                $data['input']->password = $data['content']->password;
            }
        }

        if (!$this->users->validate()) {
            $data['title']              = 'Easy WMS - Edit Staff';
            $data['page']               = 'pages/users/edit';
            $data['breadcrumb_title']   = 'Edit Data Staff';
            $data['breadcrumb_path']    = "Manajemen Staff / Edit Data Staff / " . $data['input']->nama;

            return $this->view($data);
        }

        if ($this->users->where('id', $id)->update($data['input'])) {   // Update data
            $this->session->set_flashdata('success', 'Data berhasil diubah');
        } else {
            $this->session->set_flashdata('error', 'Oops! Terjadi suatu kesalahan');
        }

        redirect(base_url('users'));
    }

    public function unique_email()
    {
        $email      = $this->input->post('email');
        $id    = $this->input->post('id');
        $user       = $this->users->where('email', $email)->first(); // Akan terisi jika terdapat email yang sama

        if ($user) {
            if ($id == $user->id) {  // Keperluan edit tidak perlu ganti email, jadi tidak masalah
                return true;
            }

            // Jika terdapat suatu nilai pada $user, berikan pesan error pertanda email sudah ada di db
            $this->load->library('form_validation');
            $this->form_validation->set_message('unique_email', '%s sudah digunakan');
            return false;
        }

        return true;
    }

    public function unique_ktp()
    {
        $ktp        = $this->input->post('ktp');
        $id         = $this->input->post('id');
        $user       = $this->users->where('ktp', $ktp)->first();

        if ($user) {
            if ($id == $user->id) {  // Keperluan edit tidak perlu ganti ktp, jadi tidak masalah
                return true;
            }

            // Jika terdapat suatu nilai pada $user, berikan pesan error pertanda ktp sudah ada di db
            $this->load->library('form_validation');
            $this->form_validation->set_message('unique_ktp', '%s sudah digunakan');
            return false;
        }

        return true;
    }
}

/* End of file Users.php */
