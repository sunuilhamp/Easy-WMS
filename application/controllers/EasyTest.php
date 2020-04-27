<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class EasyTest extends CI_Controller {
    

    public function index()
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . 'vendor/autoload.php';
        
        $current_time = time();
        $convert_current_time = $date = str_replace(':', '/', date('d:m:Y', $current_time));

        $id = "123455671";
        $mpdf = new \Mpdf\Mpdf();

        $mpdf->SetHTMLHeader('<img src="' . base_url('assets/design/header.png') . '">');
        $html=
            '<div>
                <br><br><br><br><br><br><br>
                <h1 align="center">Invoice Bukti Pengeluaran Barang</h1><br>
                <p>No Id Transaksi  : '.$id.'</p>
                <p>Ditunjukan Untuk : PT Indah Jaya</p>
                <p>Tanggal          : '.$convert_current_time.'</p>


                <table border="1">
                <tr>
                    <th style="width:40px" align="center">No</th>
                    <th style="width:110px" align="center">ID Transaksi</th>
                    <th style="width:110px" align="center">Tanggal Masuk</th>
                    <th style="width:110px" align="center">Tanggal Keluar</th>
                    <th style="width:130px" align="center">Lokasi</th>
                    <th style="width:140px" align="center">Kode Barang</th>
                    <th style="width:140px" align="center">Nama Barang</th>
                    <th style="width:80px" align="center">Satuan</th>
                    <th style="width:80px" align="center">Jumlah</th>
                </tr>';


                $no = 1;
                //   foreach($data as $d):
                    $html .= '<tr>';
                    $html .= '<td align="center">1</td>';
                    $html .= '<td align="center">1234</td>';
                    $html .= '<td align="center">dummy</td>';
                    $html .= '<td align="center">dummy</td>';
                    $html .= '<td align="center">dummy</td>';
                    $html .= '<td align="center">dummy</td>';
                    $html .= '<td align="center">dummy</td>';
                    $html .= '<td align="center">dummy</td>';
                    $html .= '<td align="center">dummy</td>';
                    $html .= '</tr>';

                    $html .= '<tr>';
                    $html .= '<td align="center" colspan="8"><b>Total</b></td>';
                    $html .= '<td align="center">dummy</td>';
                    $html .= '</tr>';
                    $no++;
                // endforeach;


                $html .='
                    </table><br>
                    <h6>Mengetahui</h6><br><br><br>
                    <h6>Admin</h6>
                </div>';
        $mpdf->WriteHTML($html);
        $mpdf->Output("example.pdf", "I");
    }

}

/* End of file Controllername.php */
