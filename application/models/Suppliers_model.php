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
            'telefon'  => '',
            'alamat'   => '',
        ];
    }

    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'nama',
                'label' => 'Nama Lengkap',
                'rules' => 'trim|required',
                'errors' => [
                    'required' => '<h6>%s harus diisi.</h6>'
                ]
            ],
            [
                'field' => 'email',
                'label' => 'E-Mail',
                'rules' => 'trim|required|valid_email|callback_unique_email',
                'errors' => [
                    'is_unique' => '<h6>%s sudah digunakan.</h6>'
                ]
            ],
            [
                'field' => 'telefon',
                'label' => 'Nomor Telefon',
                'rules' => 'trim|required',
                'errors' => [
                    'required' => '<h6>%s harus diisi.</h6>'
                ]
            ],
            [
                'field' => 'alamat',
                'label' => 'Alamat',
                'rules' => 'trim|required',
                'errors' => [
                    'required' => '<h6>%s harus diisi.</h6>'
                ]
            ]
        ];

        return $validationRules;
    }
}

/* End of file Suppliers_model.php */
