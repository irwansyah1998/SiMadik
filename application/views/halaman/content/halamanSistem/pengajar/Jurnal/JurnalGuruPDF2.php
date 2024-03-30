<?php
// ob_start();
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor($this->session->userdata('NamaGuru'));
$pdf->setTitle($APPNAME[0]['NamaInstansi']);
$pdf->setSubject('Jurnal Guru ' . $this->session->userdata('NamaGuru'));
$pdf->setKeywords('Jurnal, Mengajar, Guru, ' . $this->session->userdata('NamaGuru') . ', Laporan');

$customstring = $APPNAME[0]['Alamat'] . "\nNomor HP : +" . $APPNAME[0]['NomorWA'];
$logo = $APPNAME[0]['Logo']; // Sesuaikan dengan path logo Anda
$logoWidth = 20; // Ganti dengan lebar yang sesuai
$pdf->setHeaderData($logo, $logoWidth, $APPNAME[0]['NamaInstansi'], $customstring);

// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once (dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}
// set font
$pdf->setFont('helvetica', 'B', 12);

// add a page
$pdf->AddPage();
$pdf->setPrintHeader(false); // Disable header for subsequent pages

// ---------------------------------------------------------
$pdf->Write(0, "Jurnal Mengajar\n", '', 0, 'C', true, 0, false, false, 0);

// -----------------------------------------------------------------------------
$pdf->setFont('helvetica', '', 10);

foreach ($DataGuru as $DG) {
    $NamaGuru=$DG->NamaGuru;
    $NamaMapel=$DG->NamaMapel;
    $NIG=$DG->NomorIndukGuru;
}
foreach ($DataKelas as $DK) {
    $KodeKelas = $DK->KodeKelas;
}
foreach ($DataSemester as $DS) {
    $NamaSemester = $DS->NamaSemester;
}
foreach ($DataAjaran as $DA) {
    $KodeAjaran = $DA->KodeAjaran;
}
$tbl = <<<EOD
		<table>
		    <tr>
		        <td>Nama Guru</td>
		        <td align="center">:</td>
		        <td align="right">$NamaGuru</td>
		    </tr>
		    <tr>
		        <td>Mata Pelajaran</td>
		        <td align="center">:</td>
		        <td align="right">$NamaMapel</td>
		    </tr>
		    <tr>
		        <td>Kelas</td>
		        <td align="center">:</td>
		        <td align="right">$KodeKelas</td>
		    </tr>
		    <tr>
		        <td>Semester</td>
		        <td align="center">:</td>
		        <td align="right">$NamaSemester</td>
		    </tr>
		    <tr>
		        <td>Tahun Ajaran</td>
		        <td align="center">:</td>
		        <td align="right">$KodeAjaran</td>
		    </tr>
		</table>
		EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------





$pdf->setFont('helvetica', '', 8);



// -----------------------------------------------------------------------------
$widthMateri = 100;
$widthrelatif = 75;


$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2">
<thead>
    <tr style="background-color:#f0d6d1;">
        <td rowspan="2" width="75" align="center"><b>Hari Tanggal</b></td>
EOD;

if ($Fitur['Waktu'] == 'Nyala') {
    $tbl .= <<<EOD
        <td rowspan="2" width="50" align="center"><b>Waktu</b></td>
EOD;
    $widthrelatif = $widthrelatif - 50;
}
if ($Fitur['JamKe'] == 'Nyala') {
    $tbl .= <<<EOD
        <td rowspan="2" width="25" align="center"><b>Jam Ke</b></td>
EOD;
    $widthrelatif = $widthrelatif - 25;
}
$widthMateri = $widthMateri + $widthrelatif;
$tbl .= <<<EOD
        <td rowspan="2" width="$widthMateri" align="center"><b>Materi Pokok</b></td>
        <td rowspan="2" width="75" align="center"><b>Kegiatan Pembelajaran</b></td>
        <td rowspan="2" width="100" align="center"><b>Rencana Tindak Lanjut</b></td>
        <td rowspan="2" width="100" align="center"><b>Gambar</b></td>
        <td width="100" align="center"><b>Kehadiran Siswa</b></td>
    </tr>
    <tr>
        <td width="23.5" align="center" style="background-color:#ADFF2F;">M</td>
        <td width="23.5" align="center" style="background-color:#FFFFE0;">I</td>
        <td width="23.5" align="center" style="background-color:#87CEEB;">S</td>
        <td width="23.5" align="center" style="background-color:#FF4500;">A</td>
    </tr>
</thead>
<tbody>
EOD;
$JumlahSeluruhdata = 0;
if ($DataJurnal !== false) {
    foreach ($DataJurnal as $DJ) {
        $tbl .= <<<EOD
    <tr>
        <td width="75" align="center">$DJ->NamaHari, $DJ->TanggalJurnal</td>
EOD;

        if ($Fitur['Waktu'] == 'Nyala') {
            $tbl .= <<<EOD
        <td width="50" align="center">$DJ->MulaiJampel s.d $DJ->AkhirJampel</td>
EOD;
        }
        if ($Fitur['JamKe'] == 'Nyala') {
            $tbl .= <<<EOD
        <td width="25" align="center">$DJ->JamKe</td>
EOD;
        }
        if ($DJ->KendalaFoto !== null) {
            $gambar1 = FCPATH . 'file/data/gambar/laporanjurnal/' . $DJ->KendalaFoto;
        } else {
            $gambar1 = '';
        }

        $MMasuk = 0;
        $MIjin = 0;
        $MURIDMASUK = '';
        $MURIDIJIN = '';
        $MSakit = 0;
        $MURIDSAKIT = '';
        $MAlpha = 0;
        $MURIDAlpha = '';
        foreach ($DataAbsenJurnal as $DAJ) {
            if ($DJ->TanggalJurnal == $DAJ->TglAbsensi && $DJ->IDJamPel == $DAJ->IDJamPel && $DAJ->MISA == 'M') {
                $MMasuk++;
                $MURIDMASUK .= $MMasuk . '. ' . $DAJ->NamaSiswa . ', ';
            }
            if ($DJ->TanggalJurnal == $DAJ->TglAbsensi && $DJ->IDJamPel == $DAJ->IDJamPel && $DAJ->MISA == 'I') {
                $MIjin++;
                $MURIDIJIN .= $MIjin . '. ' . $DAJ->NamaSiswa . ', ';
            }
            if ($DJ->TanggalJurnal == $DAJ->TglAbsensi && $DJ->IDJamPel == $DAJ->IDJamPel && $DAJ->MISA == 'S') {
                $MSakit++;
                $MURIDSAKIT .= $MSakit . '. ' . $DAJ->NamaSiswa . ', ';
            }
            if ($DJ->TanggalJurnal == $DAJ->TglAbsensi && $DJ->IDJamPel == $DAJ->IDJamPel && $DAJ->MISA == 'A') {
                $MAlpha++;
                $MURIDAlpha .= $MAlpha . '. ' . $DAJ->NamaSiswa . ', ';
            }
        }

        $tbl .= <<<EOD
        <td width="$widthMateri" align="left">$DJ->MateriPokok</td>
        <td width="75" align="left">$DJ->Kegiatan</td>
        <td width="100" align="left">$DJ->TindakLanjut</td>
        <td width="100" align="center"><img src="$gambar1" height="50" alt="Gambar 1" style="position: absolute; top: 25mm; left: 140mm;"></td>
        <td width="23.5" align="center">$MMasuk</td>
        <td width="23.5" align="center">$MIjin</td>
        <td width="23.5" align="center">$MSakit</td>
        <td width="23.5" align="center">$MAlpha</td>
    </tr>
    EOD;
        $JumlahSeluruhdata++;
    }
}
$tbl .= <<<EOD
</tbody>
</table>
EOD;




$pdf->writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------

// Table with rowspans and THEAD
$TGLPRINT = date("d M Y");
$NamaKepala = $APPNAME[0]['NamaKepala'];
$NIPKepala = $APPNAME[0]['NIPKepala'];
$ttd = FCPATH . 'file/data/gambar/' . $APPNAME[0]['Foto'];
$tbl = <<<EOD
<table>
    <tbody>
     <tr>
          <td align="center" ><b>Mengetahui,</b></td>
          <td align="center" ><b>$TGLPRINT</b></td>
     </tr>
     <tr>
          <td align="center" ><b>Kepala Sekolah,</b></td>
          <td align="center" ><b>Guru Pengajar,</b></td>
     </tr>
     <tr>
EOD;
$tbl .= <<<EOD
    <td align="center" ><img src="$ttd" height="125" alt="Gambar 1" style="position: absolute; top: 25mm; left: 140mm;"></td>
              <td align="center" ></td>
    EOD;
$tbl .= <<<EOD
</tr>
     <tr>
          <td align="center" ><b>$NamaKepala</b></td>
          <td align="center" ><b>$NamaGuru</b></td>
     </tr>
     <tr>
          <td align="center" ><i>NIP.$NIPKepala</i></td>
          <td align="center" ><i>NIP.$NIG</i></td>
     </tr>
    </tbody>
</table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output('JurnalMengajar_' . $this->session->userdata('NamaGuru') . '.pdf', 'I');
// $pdf->Output('Laporan Pembayaran '.$NamaSiswa.'('.$NisSiswa.') ('.date('H.i.s_m.d.Y').').pdf', 'I');
//============================================================+
// END OF FILE
//============================================================+

?>