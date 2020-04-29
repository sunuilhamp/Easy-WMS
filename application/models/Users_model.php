<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends MY_Model 
{
    protected $table = 'user';

    public function getDefaultValues()
    {
        return [
            'nama'      => '',
            'email'     => '',
            'password'  => '',
            'telefon'   => '',
            'role'      => '',
            'status'    => '',
            'ktp'       => ''
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
                    'required'    => '<h6>%s harus diisi.</h6>',
                    'valid_email' => '<h6>%s harus berupa email yang valid.</h6>'
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
                'field' => 'ktp',
                'label' => 'Nomor KTP',
                'rules' => 'trim|required|callback_unique_ktp',
                'errors' => [
                    'required' => '<h6>%s harus diisi.</h6>'
                ]
            ],
            [
                'field' => 'status',
                'label' => 'Status',
                'rules' => 'required',
                'errors' => [
                    'required' => '<h6>%s harus diisi.</h6>'
                ]
            ],
            [
                'field' => 'role',
                'label' => 'Role',
                'rules' => 'required',
                'errors' => [
                    'required' => '<h6>%s harus diisi.</h6>'
                ]
            ]
        ];

        return $validationRules;
    }
}

/* End of file Users_model.php */
