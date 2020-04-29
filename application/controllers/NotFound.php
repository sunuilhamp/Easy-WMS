<?php

defined('BASEPATH') or exit('No direct script access allowed');

class NotFound extends MY_Controller
{   
    public function index()
    {
        $this->output->set_status_header('404');
        $this->load->view('pages/404/index');
    }
}

/* End of file NotFound.php */
