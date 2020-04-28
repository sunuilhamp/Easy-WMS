<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Suppliers_model extends MY_Model
{
    protected $table = 'supplier';

    public function getDefaultValues()
    {
        return [
            'nama'      => '',
            'email'     => '',
            'telefon'   => '',
            'alamat'    => '',
            'status'    => ''
        ];
    }

    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'nama',
                'label' => 'Nama Lengkap',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'email',
                'label' => 'E-Mail',
                'rules' => 'trim|required|valid_email|callback_unique_email'
            ],
            [
                'field' => 'telefon',
                'label' => 'Nomor Telefon',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'alamat',
                'label' => 'Alamat',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'status',
                'label' => 'Status',
                'rules' => 'required'
            ]
        ];

        return $validationRules;
    }
}

/* End of file Suppliers_model.php */
