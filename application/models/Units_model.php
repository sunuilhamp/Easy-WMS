<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends MY_Model 
{
    public function getDefaultValues()
    {
        return [
            'nama' => ''
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
                    'valid_email' => '<h6>%s harus email yang valid.</h6>'
                ]
            ],
            [
                'field' => 'telefon',
                'label' => 'Nomor Telefon',
                'rules' => 'trim|required',
                'errors' => [
                    'required' => '<h6>%s harus diisi.</h6>'
                ]
            ]
        ];

        return $validationRules;
    }
}

/* End of file User_model.php */
