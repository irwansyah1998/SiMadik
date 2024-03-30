<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Membuat objek PhpSpreadsheet
$spreadsheet = new Spreadsheet();


// Sheet pertama
$sheet1 = $spreadsheet->getActiveSheet();
// Menambahkan judul kolom
$sheet1->setTitle('Mata Pelajaran');
$sheet1->setCellValue('A1', 'No');
$sheet1->setCellValue('B1', 'Kode Mata Pelajaran');
$sheet1->setCellValue('C1', 'Nama Mata Pelajaran');

// Mengatur lebar kolom sesuai dengan panjang konten (sheet satu)
$columnWidthsSheet1 = array(
    'A' => 10,
    'B' => 28,
    'C' => 28
);

foreach ($columnWidthsSheet1 as $column => $width) {
    $sheet1->getColumnDimension($column)->setWidth($width);
}


// Menyusun data ke dalam format Excel
$row1 = 2;
$no = 1;
if ($DataMapel !== false) {
    foreach ($DataMapel as $item) {
        $spreadsheet->getActiveSheet()->setCellValue('A' . $row1, $no);
        $spreadsheet->getActiveSheet()->setCellValue('B' . $row1, $item['KodeMapel']);
        $spreadsheet->getActiveSheet()->setCellValue('C' . $row1, $item['NamaMapel']);
        $row1++;
        $no++;
    }
}

// Mengatur semua kolom agar berada di tengah (sheet pertama)
$lastColumnSheet1 = 'C';
$sheet1->getStyle('A1:' . $lastColumnSheet1 . ($row1 - 1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

// Membuat file Excel
$filename = 'DataMataPelajaranAll.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
?>
