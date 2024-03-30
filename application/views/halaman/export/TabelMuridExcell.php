<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Membuat objek PhpSpreadsheet
$spreadsheet = new Spreadsheet();

// Membuat spreadsheet aktif
$spreadsheet->setActiveSheetIndex(0);

// Menambahkan judul kolom
$spreadsheet->getActiveSheet()->setCellValue('A1', 'No');
$spreadsheet->getActiveSheet()->setCellValue('B1', 'Nomor Induk Siswa');
$spreadsheet->getActiveSheet()->setCellValue('C1', 'NISN');
$spreadsheet->getActiveSheet()->setCellValue('D1', 'Kode Kelas');
$spreadsheet->getActiveSheet()->setCellValue('E1', 'Nama Siswa');
$spreadsheet->getActiveSheet()->setCellValue('F1', 'Jenis Kelamin');
$spreadsheet->getActiveSheet()->setCellValue('G1', 'Nama Ayah');
$spreadsheet->getActiveSheet()->setCellValue('H1', 'Nama Ibu');
$spreadsheet->getActiveSheet()->setCellValue('I1', 'Tanggal Lahir');
$spreadsheet->getActiveSheet()->setCellValue('J1', 'Tempat Lahir');
$spreadsheet->getActiveSheet()->setCellValue('K1', 'Tanggal Masuk');
$spreadsheet->getActiveSheet()->setCellValue('L1', 'Tanggal Keluar');
$spreadsheet->getActiveSheet()->setCellValue('M1', 'Status');

// Mengatur lebar kolom sesuai dengan panjang konten
$columnWidths = array(
    'A' => 10,
    'B' => 24,
    'C' => 24,
    'D' => 24,
    'E' => 24,
    'F' => 24,
    'G' => 24,
    'H' => 24,
    'I' => 24,
    'J' => 24,
    'K' => 24,
    'L' => 24,
    'M' => 24
);

foreach ($columnWidths as $column => $width) {
    $spreadsheet->getActiveSheet()->getColumnDimension($column)->setWidth($width);
}

// Menyusun data ke dalam format Excel
$row = 2;
$no = 1;
if ($DataMurid!=false) {
foreach ($DataMurid as $item) {
    $spreadsheet->getActiveSheet()->setCellValue('A' . $row, $no);
    $spreadsheet->getActiveSheet()->setCellValueExplicit('B' . $row, $item['NisSiswa'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    $spreadsheet->getActiveSheet()->setCellValueExplicit('C' . $row, $item['NISNSiswa'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    $spreadsheet->getActiveSheet()->setCellValue('D' . $row, $item['KodeKelas']);
    $spreadsheet->getActiveSheet()->setCellValue('E' . $row, $item['NamaSiswa']);
    $spreadsheet->getActiveSheet()->setCellValue('F' . $row, $item['GenderSiswa']);
    $spreadsheet->getActiveSheet()->setCellValue('G' . $row, $item['AyahSiswa']);
    $spreadsheet->getActiveSheet()->setCellValue('H' . $row, $item['IbuSiswa']);
    $spreadsheet->getActiveSheet()->setCellValue('I' . $row, $item['TglLhrSiswa']);
    $spreadsheet->getActiveSheet()->setCellValue('J' . $row, $item['TmptLhrSiswa']);
    $spreadsheet->getActiveSheet()->setCellValue('K' . $row, $item['TGLMasuk']);
    $spreadsheet->getActiveSheet()->setCellValue('L' . $row, $item['TGLKeluar']);
    $spreadsheet->getActiveSheet()->setCellValue('M' . $row, $item['Status']);
    $row++;
    $no++;
}
}

// Mengatur semua kolom agar berada di tengah
$lastColumn = 'L';
$spreadsheet->getActiveSheet()->getStyle('A1:' . $lastColumn . ($row - 1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

// Membuat file Excel
$filename = 'DataMuridAll.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

?>