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

if ($NilaiHari !== false) {
    for ($i = 0; $i < count($NilaiHari) + 2; $i++) {
        if ($i < count($NilaiHari)) {
            $sheet[$i] = ($i == 0) ? $spreadsheet->getActiveSheet() : $spreadsheet->createSheet();

            $sheet[$i]->setTitle($NilaiHari[$i]['KodeNilai']);
            $sheet[$i]->mergeCells('A1:B1');
            $sheet[$i]->setCellValue('A1', 'Nama Nilai');
            $sheet[$i]->getStyle('A1:B1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet[$i]->getStyle('A1:B1')->applyFromArray(['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'D3D3D3']], 'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]]);


            $sheet[$i]->mergeCells('C1:D1');
            $sheet[$i]->setCellValue('C1', $NilaiHari[$i]['NamaNilai']);
            $sheet[$i]->getStyle('C1:D1')->applyFromArray(['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'D3D3D3']], 'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]]);
            $sheet[$i]->getStyle('C1:D1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet[$i]->mergeCells('A2:B3');
            $sheet[$i]->setCellValue('A2', 'Keterangan');
            $alignmentStyle = [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ];
            

            $sheet[$i]->mergeCells('C2:D3');
            $sheet[$i]->setCellValue('C2', $NilaiHari[$i]['Keterangan']);
            $alignmentStyle = [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ];

            $sheet[$i]->getStyle('A1:D3')->getAlignment()->applyFromArray($alignmentStyle);
            $sheet[$i]->getStyle('A1:D3')->applyFromArray(['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'D3D3D3']], 'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]]);
        } else {
            $sheet[$i] = $spreadsheet->createSheet();
            if ($i == count($NilaiHari)) {
                $sheet[$i]->setTitle('UTS');
                $NamaNilai='Ujian Tengah Semester';
                $Keterangan='Nilai Ujian Tengah Semester';
            }elseif ($i == count($NilaiHari) + 1) {
                $sheet[$i]->setTitle('UAS');
                $NamaNilai='Ujian Akhir Semester';
                $Keterangan='Nilai Ujian Akhir Semester';
            }
            $sheet[$i]->mergeCells('A1:B1');
            $sheet[$i]->setCellValue('A1', 'Nama Nilai');
            $sheet[$i]->getStyle('A1:B1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet[$i]->getStyle('A1:B1')->applyFromArray(['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'D3D3D3']], 'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]]);


            $sheet[$i]->mergeCells('C1:D1');
            $sheet[$i]->setCellValue('C1', $NamaNilai);
            $sheet[$i]->getStyle('C1:D1')->applyFromArray(['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'D3D3D3']], 'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]]);
            $sheet[$i]->getStyle('C1:D1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet[$i]->mergeCells('A2:B3');
            $sheet[$i]->setCellValue('A2', 'Keterangan');
            $alignmentStyle = [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ];
            

            $sheet[$i]->mergeCells('C2:D3');
            $sheet[$i]->setCellValue('C2', $Keterangan);
            $alignmentStyle = [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ];

            $sheet[$i]->getStyle('A1:D3')->getAlignment()->applyFromArray($alignmentStyle);
            $sheet[$i]->getStyle('A1:D3')->applyFromArray(['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'D3D3D3']], 'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]]);
        }
        $sheet[$i]->setCellValue('A6', 'No');
        $sheet[$i]->setCellValue('B6', 'NIS', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet[$i]->setCellValue('C6', 'Nama Siswa', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet[$i]->setCellValue('D6', 'Nilai');

        $headerColumns = ['A', 'B', 'C', 'D'];

        foreach ($headerColumns as $column) {
            $sheet[$i]->getStyle($column . '6')->applyFromArray([
                'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'D3D3D3']],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ]);
            $sheet[$i]->getStyle($column . '6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }
        
    }
}

if ($NilaiHari !== false) {
        for ($i = 0; $i < count($NilaiHari) + 2; $i++) {
            if ($i < count($NilaiHari)) {
                // Mengatur lebar kolom sesuai dengan panjang konten (sheet pertama)
                $columnWidthsSheet[$i] = [
                    'A' => 8,
                    'B' => 24,
                    'C' => 48,
                    'D' => 10,
                ];

                foreach ($columnWidthsSheet[$i] as $column => $width) {
                    $sheet[$i]->getColumnDimension($column)->setWidth($width);
                }

                $no = 0;
                foreach ($DataSiswa as $tb) {
                    $no++;
                    $sheet[$i]->setCellValue('A' . (6 + $no), $no);
                    $sheet[$i]->setCellValue('B' . (6 + $no), $tb->NisSiswa, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    $sheet[$i]->setCellValue('C' . (6 + $no), $tb->NamaSiswa);

                    if ($KelasMapelNilaiSiswa !== false) {
                        foreach ($KelasMapelNilaiSiswa as $KMNS) {
                            if ($KMNS->NisSiswa == $tb->NisSiswa && $KMNS->IDNilaiHari == $NilaiHari[$i]['IDNilaiHari']) {
                                $sheet[$i]->setCellValue('D' . (6 + $no), $KMNS->Nilai);
                            }
                        }
                    }

                    $sheet[$i]->getStyle('A' . (6 + $no) . ':C' . (99 + $no))->getAlignment()->applyFromArray($alignmentStyle);
                    $sheet[$i]->getStyle('A' . (6 + $no) . ':C' . (99 + $no))->applyFromArray([
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'E7EFF1']],
                        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                    ]);

                    $sheet[$i]->getStyle('D' . (6 + $no) . ':D' . (99 + $no))->getAlignment()->applyFromArray($alignmentStyle);
                    $sheet[$i]->getStyle('D' . (6 + $no) . ':D' . (99 + $no))->applyFromArray([
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'B0F63E']],
                        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                    ]);
                }
            }elseif ($i >= count($NilaiHari)) {
                $columnWidthsSheet[$i] = [
                'A' => 8,
                'B' => 24,
                'C' => 48,
                'D' => 10,
                ];

                foreach ($columnWidthsSheet[$i] as $column => $width) {
                    $sheet[$i]->getColumnDimension($column)->setWidth($width);
                }

                $no=0;
                foreach ($DataSiswa as $tb) {
                    $no++;
                    $sheet[$i]->setCellValue('A' . (6 + $no), $no);
                    $sheet[$i]->setCellValue('B' . (6 + $no), $tb->NisSiswa, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    $sheet[$i]->setCellValue('C' . (6 + $no), $tb->NamaSiswa);
                    if ($i == count($NilaiHari)) {
                        if ($NilaiMapelSiswa !== false) {
                            foreach ($NilaiMapelSiswa as $NMS) {
                                if ($tb->NisSiswa==$NMS->NisSiswa) {
                                    $sheet[$i]->setCellValue('D' . (6 + $no), $NMS->NilaiUTS);
                                }
                            }
                        }
                    }elseif ($i == count($NilaiHari)+1) {
                        if ($NilaiMapelSiswa !== false) {
                            foreach ($NilaiMapelSiswa as $NMS) {
                                if ($tb->NisSiswa==$NMS->NisSiswa) {
                                    $sheet[$i]->setCellValue('D' . (6 + $no), $NMS->NilaiUAS);
                                }
                            }
                        }
                    }

                    $sheet[$i]->getStyle('A' . (6 + $no) . ':C' . (99 + $no))->getAlignment()->applyFromArray($alignmentStyle);
                    $sheet[$i]->getStyle('A' . (6 + $no) . ':C' . (99 + $no))->applyFromArray([
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'E7EFF1']],
                        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                    ]);

                    $sheet[$i]->getStyle('D' . (6 + $no) . ':D' . (99 + $no))->getAlignment()->applyFromArray($alignmentStyle);
                    $sheet[$i]->getStyle('D' . (6 + $no) . ':D' . (99 + $no))->applyFromArray([
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'B0F63E']],
                        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                    ]);
                }
            }
        }
    }

    // Membuat file Excel
    $filename = 'Data_Nilai_' . $MataPelajaran[0]['KodeMapel'] . '_' . $this->input->get('KodeKelas') . '_' . $Semester[0]['NamaSemester'] . '(' . $TahunAjaran[0]['TahunAwal'] . '-' . $TahunAjaran[0]['TahunAkhir'] . ')' . '.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
?>