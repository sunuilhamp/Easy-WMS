<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Units_model extends MY_Model 
{
    protected $table = 'satuan';
    
    public function getDefaultValues()
    {
        return ['nama' => ''];
    }

    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'nama',
                'label' => 'Nama Satuan',
                'rules' => 'trim|required|callback_unique_satuan',
                'errors' => [
                    'required' => '<h6>%s harus diisi.</h6>'
                ]
            ]
        ];

        return $validationRules;
    }
}

/* End of file Units_model.php */
