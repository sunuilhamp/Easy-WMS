<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cartout_model extends MY_Model 
{
    public $table = 'keranjang_keluar';

    /**
     * Validasi Stok; untuk membandingkan kuantitas barang yang ada di 
     * tabel keranjang_keluar dengan kuantitas barang yang ada di tabel barang
     * Ini dilakukan agar user tidak mengurangi barang hingga minus
     */
    public function validateStock()
    {
        $valid   = true;
        $id_user = $this->session->userdata('id_user');
        $cart    = $this->where('id_user', $id_user)->get();
        
        foreach ($cart as $row) {
            $this->table = 'barang';
            $barang      = $this->where('id', $row->id_barang)->first();       
            
            if (($barang->qty - $row->qty) < 0) {
                $this->session->set_flashdata("qty_cartout_$row->id", "Stock hanya ada $barang->qty");
                $valid = false;
            }

            $this->table = 'keranjang_keluar';
        }

        return $valid;
    }
}

/* End of file Cartout_model.php */
