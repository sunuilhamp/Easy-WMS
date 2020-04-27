<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Supplier_model extends MY_Model {
    
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
                    'rules' => 'trim|required'
                ],
                [
                    'field' => 'email',
                    'label' => 'E-Mail',
                    'rules' => 'trim|required|valid_email|is_unique[supplier.email]',
                    'errors' => [
                        'is_unique' => '<h6>%s sudah digunakan.</h6>'
                    ]
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
                ]
            ];

            return $validationRules;
        }

        /**
         * Melakukan insert user baru ke db
         */
        public function run($input)
        {
            $data = [
                'nama'      => $input->nama,
                'email'     => strtolower($input->email),
                'telefon'   => $input->telefon,
                'alamat'   => $input->alamat,
                'status'      => 'aktif'
            ];

            $this->create($data);

            return true;
        }
    
    }
    
    /* End of file Supplier_model.php */
    