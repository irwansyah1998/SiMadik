<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


require_once APPPATH . 'libraries/PhpSpreadsheet/autoload.php';

class PhpSpreadsheet
{
    public function __construct()
    {
        log_message('debug', 'PhpSpreadsheet Class Initialized');
    }

    public function createSpreadsheet()
    {
        // Buat objek Spreadsheet dan lakukan operasi lainnya
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        // Contoh penggunaan:
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Hello World!');

        // Kembalikan objek Spreadsheet yang telah dibuat
        return $spreadsheet;
    }
}
