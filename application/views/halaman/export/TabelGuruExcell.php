<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Membuat objek PhpSpreadsheet
$spreadsheet = new Spreadsheet();

// Sheet pertama
$sheet1 = $spreadsheet->getActiveSheet();
$sheet1->setTitle('Data Guru');
$sheet1->setCellValue('A1', 'No');
$sheet1->setCellValueExplicit('B1', 'Nomor Induk Guru', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
$sheet1->setCellValueExplicit('C1', 'Username Guru', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
$sheet1->setCellValue('D1', 'Kode Guru');
$sheet1->setCellValue('E1', 'Nama Guru');
$sheet1->setCellValue('F1', 'Password');
$sheet1->setCellValue('G1', 'Hak Akses');
$sheet1->setCellValue('H1', 'Mapel');
$sheet1->setCellValue('I1', 'Nomor WhatsApp');
// ...

// Sheet kedua
$sheet2 = $spreadsheet->createSheet();
$sheet2->setTitle('Keterangan Hak Akses'); // Judul sheet kedua
$sheet2->setCellValue('A1', 'IDHak');
$sheet2->setCellValue('B1', 'Nama Hak');
// ...

// Sheet ketiga
$sheet3 = $spreadsheet->createSheet();
$sheet3->setTitle('Keterangan Mapel'); // Judul sheet kedua
$sheet3->setCellValue('A1', 'IDMapel');
$sheet3->setCellValue('B1', 'Nama Mapel');
// ...

// Mengatur lebar kolom sesuai dengan panjang konten (sheet pertama)
$columnWidthsSheet1 = array(
    'A' => 10,
    'B' => 24,
    'C' => 24,
    'D' => 24,
    'E' => 24,
    'F' => 24,
    'G' => 24,
    'H' => 24,
    'I' => 24
);

foreach ($columnWidthsSheet1 as $column => $width) {
    $sheet1->getColumnDimension($column)->setWidth($width);
}

// Mengatur lebar kolom sesuai dengan panjang konten (sheet kedua)
$columnWidthsSheet2 = array(
    'A' => 15,
    'B' => 30,
    // ...
);

foreach ($columnWidthsSheet2 as $column => $width) {
    $sheet2->getColumnDimension($column)->setWidth($width);
}

// Mengatur lebar kolom sesuai dengan panjang konten (sheet ketiga)
$columnWidthsSheet3 = array(
    'A' => 15,
    'B' => 30,
    // ...
);

foreach ($columnWidthsSheet3 as $column => $width) {
    $sheet3->getColumnDimension($column)->setWidth($width);
}

// Menyusun data ke dalam format Excel (sheet pertama)
$row1 = 2;
$no = 1;
if ($DataGuru!==false) {
    foreach ($DataGuru as $item) {
        // ...
        $sheet1->setCellValue('A' . $row1, $no);
        $sheet1->setCellValueExplicit('B' . $row1, $item['NomorIndukGuru'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet1->setCellValueExplicit('C' . $row1, $item['UsrGuru'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet1->setCellValue('D' . $row1, $item['KodeGuru']);
        $sheet1->setCellValue('E' . $row1, $item['NamaGuru']);
        $sheet1->setCellValue('F' . $row1, $item['PassGuru']);
        $sheet1->setCellValue('G' . $row1, $item['IDHak']);
        $mapel='';

        $mapelArray = [];
        if ($DataMapelGuru!==false) {
            foreach ($DataMapelGuru as $dmg) {
                if ($item['IDGuru'] == $dmg['IDGuru']) {
                    $mapelArray[] = $dmg['IDMapel'];
                }
            }
        }

        // Menggunakan implode untuk menggabungkan IDMapel dengan '//'
        $mapel = implode('//', $mapelArray);
        
        $sheet1->setCellValue('H' . $row1, $mapel);
        $sheet1->setCellValue('I' . $row1, $item['NomorHP']);
        // ...
        $row1++;
        $no++;
    }
}


// Menyusun data ke dalam format Excel (sheet kedua)
$row2 = 2;
if ($Keterangan!==false) {
    foreach ($Keterangan as $item2) {
        // ...
        $sheet2->setCellValue('A' . $row2, $item2['IDHak']);
        $sheet2->setCellValue('B' . $row2, $item2['NamaHak']);
        // ...
        $row2++;
    }
}

// Menyusun data ke dalam format Excel (sheet ketiga)
$row3 = 2;
if ($Keterangan2!==false) {
    foreach ($Keterangan2 as $item3) {
        // ...
        $sheet3->setCellValue('A' . $row3, $item3['IDMapel']);
        $sheet3->setCellValue('B' . $row3, $item3['NamaMapel']);
        // ...
        $row3++;
    }
}

if ($DataGuru!==false) {
    // Mengatur semua kolom agar berada di tengah (sheet pertama)
    $lastColumnSheet1 = 'H';
    $sheet1->getStyle('A1:' . $lastColumnSheet1 . ($row1 - 1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
}

if ($Keterangan!==false) {
    // Mengatur semua kolom agar berada di tengah (sheet kedua)
    $lastColumnSheet2 = 'B';
    $sheet2->getStyle('A1:' . $lastColumnSheet2 . ($row2 - 1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
}

if ($Keterangan2!==false) {
    // Mengatur semua kolom agar berada di tengah (sheet ketiga)
    $lastColumnSheet3 = 'B';
    $sheet3->getStyle('A1:' . $lastColumnSheet3 . ($row3 - 1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
}

// Membuat file Excel
$filename = 'DataGuruAll.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
?>
