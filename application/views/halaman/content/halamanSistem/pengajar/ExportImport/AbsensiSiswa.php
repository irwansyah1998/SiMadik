<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

// Membuat objek PhpSpreadsheet
$spreadsheet = new Spreadsheet();
$alignmentStyle = [
    'horizontal' => Alignment::HORIZONTAL_CENTER,
    'vertical' => Alignment::VERTICAL_CENTER,
];

// Sheet pertama
$sheet1 = $spreadsheet->getActiveSheet();
$sheet1->setTitle('Data Absensi Kelas');
$sheet1->setCellValue('A1:A2', 'No');
$sheet1->setCellValueExplicit('B1:B2', 'Nomor Induk Siswa', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
$sheet1->setCellValueExplicit('C1:C2', 'Nama Siswa', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
$sheet1->setCellValue('D1', 'Tanggal');
$sheet1->setCellValue('D2', 'Jam');

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



// Menyusun data ke dalam format Excel (sheet pertama)
$row1 = 2;
$no = 1;
if ($DataMurid!==false) {
    foreach ($DataMurid as $item) {
        $sheet1->setCellValue('A' . $row1, $no);
        $sheet1->setCellValueExplicit('B' . $row1, $item['NisSiswa'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet1->setCellValueExplicit('C' . $row1, $item['NamaSiswa'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet1->setCellValue('D' . $row1, $item['KodeGuru']);
        $row1++;
        $no++;
    }
}



if ($DataGuru!==false) {
    // Mengatur semua kolom agar berada di tengah (sheet pertama)
    $lastColumnSheet1 = 'H';
    $sheet1->getStyle('A1:' . $lastColumnSheet1 . ($row1 - 1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
}

// Membuat file Excel
$filename = 'DataGuruAll.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
?>
