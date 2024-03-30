<?php
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Export to Excel');
        $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->AddPage();

        // Buat tabel data di sini
        $html = '<table border="1">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Kode Guru</th>
                            <th>Nama Guru</th>
                            <th>Nomor Induk Guru</th>
                            <th>Kode Mata Pelajaran</th>
                        </tr>
                    </thead>
                    <tbody>';

        foreach ($DataGuru as $row) {
            $html .= '<tr>
                        <td>' . $row->UsrGuru . '</td>
                        <td>' . $row->KodeGuru . '</td>
                        <td>' . $row->NamaGuru . '</td>
                        <td>' . $row->NomorIndukGuru . '</td>
                        <td>' . $row->KodeMapel . '</td>
                    </tr>';
        }

        $html .= '</tbody></table>';

        $pdf->writeHTML($html, true, false, false, false, '');

        $pdf->Output('export_excel.pdf', 'D'); // 'I' untuk tampil di browser, 'D' untuk download

?>