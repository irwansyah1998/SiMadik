<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/phpqrcode/qrlib.php';// Sesuaikan dengan lokasi PHP QR Code

class Phpqrcode
{
    public function __construct()
    {
        log_message('debug', 'PHP QR Code Class Initialized');
    }

    public function generateQRCode($data, $filename, $size = 4)
    {
        QRcode::png($data, $filename, 'H', $size, 2);
    }
}