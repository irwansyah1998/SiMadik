<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Membuat objek PhpSpreadsheet
$spreadsheet = new Spreadsheet();


// Sheet pertama
$sheet1 = $spreadsheet->getActiveSheet();
// Menambahkan judul kolom
$sheet1->setTitle('Data Kelas');
$sheet1->setCellValue('A1', 'No');
$sheet1->setCellValue('B1', 'Kode Kelas');
$sheet1->setCellValue('C1', 'Kode Tahun');
$sheet1->setCellValue('D1', 'Nomor Induk Guru (Wali Kelas)');
$sheet1->setCellValue('E1', 'Nama Guru (Wali Kelas)');
$sheet1->setCellValue('F1', 'Ruangan Kelas');

// Sheet kedua
$sheet2 = $spreadsheet->createSheet();
$sheet2->setTitle('Keterangan Guru'); // Judul sheet kedua
$sheet2->setCellValue('A1', 'Nomor Induk Guru');
$sheet2->setCellValue('B1', 'Nama Guru');

// Mengatur lebar kolom sesuai dengan panjang konten (sheet satu)
$columnWidthsSheet1 = array(
    'A' => 10,
    'B' => 28,
    'C' => 28,
    'D' => 28,
    'E' => 28,
    'F' => 28
);

foreach ($columnWidthsSheet1 as $column => $width) {
    $sheet1->getColumnDimension($column)->setWidth($width);
}

// Mengatur lebar kolom sesuai dengan panjang konten (sheet kedua)
$columnWidthsSheet2 = array(
    'A' => 40,
    'B' => 30,
    // ...
);

foreach ($columnWidthsSheet2 as $column => $width) {
    $sheet2->getColumnDimension($column)->setWidth($width);
}

// Menyusun data ke dalam format Excel
$row1 = 2;
$no = 1;
if ($DataKelas !== false) {
    foreach ($DataKelas as $item) {
        $spreadsheet->getActiveSheet()->setCellValue('A' . $row1, $no);
        $spreadsheet->getActiveSheet()->setCellValue('B' . $row1, $item['KodeKelas']);
        $spreadsheet->getActiveSheet()->setCellValue('C' . $row1, $item['KodeTahun']);
        $spreadsheet->getActiveSheet()->setCellValueExplicit('D' . $row1, $item['NomorIndukGuru'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet()->setCellValue('E' . $row1, $item['NamaGuru']);
        $spreadsheet->getActiveSheet()->setCellValue('F' . $row1, $item['RuanganKelas']);
        $row1++;
        $no++;
    }
}

// Menyusun data ke dalam format Excel (sheet kedua)
$row2 = 2;
foreach ($Keterangan as $item2) {
    // ...
    $sheet2->setCellValueExplicit('A' . $row2, $item2['NomorIndukGuru'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    $sheet2->setCellValue('B' . $row2, $item2['NamaGuru']);
    // ...
    $row2++;
}

// Mengatur semua kolom agar berada di tengah (sheet pertama)
$lastColumnSheet1 = 'H';
$sheet1->getStyle('A1:' . $lastColumnSheet1 . ($row1 - 1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

// Mengatur semua kolom agar berada di tengah (sheet kedua)
$lastColumnSheet2 = 'B';
$sheet2->getStyle('A1:' . $lastColumnSheet2 . ($row2 - 1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

// Membuat file Excel
$filename = 'DataKelasAll.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
?>
