<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Membuat objek PhpSpreadsheet
$spreadsheet = new Spreadsheet();

// Sheet pertama
$sheet1 = $spreadsheet->getActiveSheet();
$sheet1->setTitle('Data Wali Murid');
$sheet1->setCellValue('A1', 'Nomor Induk Siswa', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
$sheet1->setCellValue('B1', 'Username Wali Murid');
$sheet1->setCellValue('C1', 'Password Wali Murid');
$sheet1->setCellValue('D1', 'Nama Wali Murid');
$sheet1->setCellValue('E1', 'Nomor WhatsApp');
$sheet1->setCellValue('F1', 'Alamat');
// ...

// Sheet kedua
$sheet2 = $spreadsheet->createSheet();
$sheet2->setTitle('Data Murid');
$sheet2->setCellValue('A1', 'No');
$sheet2->setCellValue('B1', 'Nomor Induk Siswa', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
$sheet2->setCellValue('C1', 'NISN');
$sheet2->setCellValue('D1', 'Kode Kelas');
$sheet2->setCellValue('E1', 'Nama Siswa');
$sheet2->setCellValue('F1', 'Jenis Kelamin');
$sheet2->setCellValue('G1', 'Nama Ayah');
$sheet2->setCellValue('H1', 'Nama Ibu');
$sheet2->setCellValue('I1', 'Tanggal Lahir');
$sheet2->setCellValue('J1', 'Tempat Lahir');
$sheet2->setCellValue('K1', 'Tanggal Masuk');
$sheet2->setCellValue('L1', 'Tanggal Keluar');
$sheet2->setCellValue('M1', 'Status');
// ...

// Mengatur lebar kolom sesuai dengan panjang konten (sheet pertama)
$columnWidthsSheet1 = array(
    'A' => 24,
    'B' => 24,
    'C' => 24,
    'D' => 24,
    'E' => 24,
    'F' => 24
);

foreach ($columnWidthsSheet1 as $column => $width) {
    $sheet1->getColumnDimension($column)->setWidth($width);
}


// Mengatur lebar kolom sesuai dengan panjang konten (sheet kedua)
$columnWidthsSheet2 = array(
    
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

foreach ($columnWidthsSheet2 as $column => $width) {
    $sheet2->getColumnDimension($column)->setWidth($width);
}

// Menyusun data ke dalam format Excel (sheet pertama)
if ($DataWaliMurid!==false) {
    $row1 = 2;
    $no = 1;
    foreach ($DataWaliMurid as $item) {
        // ..
        $sheet1->setCellValueExplicit('A' . $row1, $item['NisSiswaSiswa'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet1->setCellValue('B' . $row1, $item['UsrOrtu']);
        $sheet1->setCellValue('C' . $row1, $item['PassOrtu']);
        $sheet1->setCellValue('D' . $row1, $item['NamaOrtu']);
        $sheet1->setCellValue('E' . $row1, $item['NomorHP']);
        $sheet1->setCellValue('F' . $row1, $item['Alamat']);

        // ...
        $row1++;
        $no++;
    }
}


// Menyusun data ke dalam format Excel (sheet kedua)
if ($DataMurid!==false) {
    $row2 = 2;
    $no = 1;
    foreach ($DataMurid as $item2) {
        // ...
        $sheet2->setCellValue('A' . $row2, $no);
        $sheet2->setCellValueExplicit('B' . $row2, $item2['NisSiswa'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet2->setCellValueExplicit('C' . $row2, $item2['NISNSiswa'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet2->setCellValue('D' . $row2, $item2['KodeKelas']);
        $sheet2->setCellValue('E' . $row2, $item2['NamaSiswa']);
        $sheet2->setCellValue('F' . $row2, $item2['GenderSiswa']);
        $sheet2->setCellValue('G' . $row2, $item2['AyahSiswa']);
        $sheet2->setCellValue('H' . $row2, $item2['IbuSiswa']);
        $sheet2->setCellValue('I' . $row2, $item2['TglLhrSiswa']);
        $sheet2->setCellValue('J' . $row2, $item2['TmptLhrSiswa']);
        $sheet2->setCellValue('K' . $row2, $item2['TGLMasuk']);
        $sheet2->setCellValue('L' . $row2, $item2['TGLKeluar']);
        $sheet2->setCellValue('M' . $row2, $item2['Status']);
        // ...
        $row2++;
        $no++;
    }
}

// Mengatur semua kolom agar berada di tengah (sheet pertama)
if ($DataWaliMurid!==false) {
    $lastColumnSheet1 = 'F';
    $sheet1->getStyle('A1:' . $lastColumnSheet1 . ($row1 - 1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
}
// Mengatur semua kolom agar berada di tengah (sheet kedua)
if ($DataMurid!==false) {
    $lastColumnSheet2 = 'M';
    $sheet2->getStyle('A1:' . $lastColumnSheet2 . ($row2 - 1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
}

// Membuat file Excel
$filename = 'DataWaliMuridAll.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
?>
