<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Unit_model extends MY_Model 
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
                'rules' => 'trim|required|is_unique[satuan.nama]',
                'errors' => [
                    'required'  => '<h6>%s harus diisi.</h6>',
                    'is_unique' => '<h6>%s sudah terdaftar.</h6>'
                ]
            ]
        ];

        return $validationRules;
    }

    /**
     * Melakukan insert satuan baru ke db
     */
    public function run($input)
    {
        $data = ['nama' => $input->nama];
        $this->create($data);
        return true;
    }
}

/* End of file Unit_model.php */
