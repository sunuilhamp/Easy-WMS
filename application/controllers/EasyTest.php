<?php

use Mpdf\Mpdf;

require_once $_SERVER['DOCUMENT_ROOT'] . 'vendor/autoload.php';

$mpdf = new Mpdf();
$html = "<h1>Ini adalah Header</h1>";
$html .= "<p>Ini adalah paragraf</p>";
$mpdf->WriteHTML($html);
$mpdf->Output("example.pdf", "I");