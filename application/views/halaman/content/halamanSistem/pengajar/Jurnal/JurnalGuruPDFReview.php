<?php
// ob_start();
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Output HTML content untuk PDF
ob_start();

// set document information
$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor($APPNAME[0]['NamaInstansi']);
$pdf->setTitle($APPNAME[0]['NamaInstansi']);
$pdf->setSubject('Jurnal Guru Review');
$pdf->setKeywords('Jurnal, Mengajar, Guru, '.$APPNAME[0]['NamaInstansi'].', Laporan');

$customstring = $APPNAME[0]['Alamat']."\nNomor HP : +".$APPNAME[0]['NomorWA'];
$logo = $APPNAME[0]['Logo']; // Sesuaikan dengan path logo Anda
$logoWidth = 20; // Ganti dengan lebar yang sesuai
$pdf->setHeaderData($logo, $logoWidth, $APPNAME[0]['NamaInstansi'], $customstring);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

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
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
	
$JumlahSeluruhdata=0;
$ToatlDataTerhitung=count($DataJurnal)-1;
if ($DataJurnal!==false) {
	foreach ($DataJurnal as $DJ) {

		// set font
		$pdf->setFont('helvetica', 'B', 12);

		// add a page
		$pdf->AddPage();
		$pdf->setPrintHeader(false); // Disable header for subsequent pages
		$pdf->Write(0, "Jurnal Mengajar\n", '', 0, 'C', true, 0, false, false, 0);

		// -----------------------------------------------------------------------------
		$pdf->setFont('helvetica', '', 10);

		foreach ($DataGuru as $DG) {
			$NamaGuru=$DG->NamaGuru;
			$NamaMapel=$DG->NamaMapel;
			$NIG=$DG->NomorIndukGuru;
		}
		foreach ($DataKelas as $DK) {
			$KodeKelas=$DK->KodeKelas;
		}
		foreach ($DataSemester as $DS) {
			$NamaSemester=$DS->NamaSemester;
		}
		foreach ($DataAjaran as $DA) {
			$KodeAjaran=$DA->KodeAjaran;
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
	$widthMateri=125;
	$widthrelatif=75;


$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2">
<thead>
    <tr style="background-color:#f0d6d1;">
        <td width="75" align="center"><b>Hari Tanggal</b></td>
EOD;

if ($Fitur['Waktu'] == 'Nyala') {
    $tbl .= <<<EOD
        <td width="50" align="center"><b>Waktu</b></td>
EOD;
$widthrelatif=$widthrelatif-50;
}
if ($Fitur['JamKe'] == 'Nyala') {
    $tbl .= <<<EOD
        <td width="25" align="center"><b>Jam Ke</b></td>
EOD;
$widthrelatif=$widthrelatif-25;
}
$widthMateri=$widthMateri+$widthrelatif;
$tbl .= <<<EOD
        <td width="$widthMateri" align="center"><b>Materi Pokok</b></td>
        <td width="125" align="center"><b>Indikator Pencapaian Kompetensi</b></td>
        <td width="125" align="center"><b>Kegiatan Pembelajaran</b></td>
        <td width="100" align="center"><b>Penilaian</b></td>
    </tr>
</thead>
<tbody>
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
$tbl .= <<<EOD
        <td width="$widthMateri" align="left">$DJ->MateriPokok</td>
        <td width="125" align="left">$DJ->InPenKom</td>
        <td width="125" align="left">$DJ->Kegiatan</td>
        <td width="100" align="left">$DJ->Penilaian</td>
    </tr>
</tbody>
</table>
EOD;




			$pdf->writeHTML($tbl, true, false, false, false, '');

			// -----------------------------------------------------------------------------
			$MMasuk=0;
			$MIjin=0;
			$MURIDMASUK='';
			$MURIDIJIN='';
			$MSakit=0;
			$MURIDSAKIT='';
			$MAlpha=0;
			$MURIDAlpha='';
			foreach ($DataAbsenJurnal as $DAJ) {
				if ($DJ->TanggalJurnal==$DAJ->TglAbsensi && $DJ->IDJamPel==$DAJ->IDJamPel && $DAJ->MISA=='M') {
					$MMasuk++;
					$MURIDMASUK.=$MMasuk.'. '.$DAJ->NamaSiswa.', ';
				}
				if ($DJ->TanggalJurnal==$DAJ->TglAbsensi && $DJ->IDJamPel==$DAJ->IDJamPel && $DAJ->MISA=='I') {
					$MIjin++;
					$MURIDIJIN.=$MIjin.'. '.$DAJ->NamaSiswa.', ';
				}
				if ($DJ->TanggalJurnal==$DAJ->TglAbsensi && $DJ->IDJamPel==$DAJ->IDJamPel && $DAJ->MISA=='S') {
					$MSakit++;
					$MURIDSAKIT.=$MSakit.'. '.$DAJ->NamaSiswa.', ';
				}
				if ($DJ->TanggalJurnal==$DAJ->TglAbsensi && $DJ->IDJamPel==$DAJ->IDJamPel && $DAJ->MISA=='A') {
					$MAlpha++;
					$MURIDAlpha.=$MAlpha.'. '.$DAJ->NamaSiswa.', ';
				}
			}

			// Table with rowspans and THEAD
			$tbl = <<<EOD
			<table border="1" cellpadding="2" cellspacing="2">
			<thead>
			 <tr style="background-color:#f0d6d1;">
			  <td width="500" colspan="2" align="center"><b>Catatan Kehadiran Peserta Didik</b></td>
			  <td width="135" align="center"><b>Rencana Tindak Lanjut</b></td>
			 </tr>
			</thead>
			<tbody>
			 <tr>
			  	<td width="50" align="center"><b>Hadir</b></td>
				<td width="450" ><i><b>$MURIDMASUK</b></i></td>
			  	<td width="135" rowspan="4" align="center">$DJ->TindakLanjut</td>
			 </tr>
			 <tr>
			  	<td width="50" align="center"><b>Sakit</b></td>
				<td width="450" ><b><i>$MURIDSAKIT</i></b></td>
			 </tr>
			 <tr>
			  	<td width="50" align="center"><b>Ijin</b></td>
				<td width="450" ><b><i>$MURIDIJIN</i></b></td>
			 </tr>
			 <tr>
			  	<td width="50" align="center"><b>Absen</b></td>
				<td width="450" ><b><i>$MURIDAlpha</i></b></td>
			 </tr>
			</tbody>
			</table>
			EOD;

			$pdf->writeHTML($tbl, true, false, false, false, '');

			// -----------------------------------------------------------------------------
			if ($DJ->KendalaFoto!==null) {
				$gambar1=FCPATH . 'file/data/gambar/laporanjurnal/'.$DJ->KendalaFoto;
			}else{
				$gambar1='';
			}

			if ($DJ->PenyelesaianFoto!==null) {
				$gambar2=FCPATH . 'file/data/gambar/laporanjurnal/'.$DJ->PenyelesaianFoto;
			}else{
				$gambar2='';
			}
			// Table with rowspans and THEAD
			$tbl = <<<EOD
			<table border="1" cellpadding="2" cellspacing="2">
			<thead>
			 <tr style="background-color:#f0d6d1;">
			  <td width="550" colspan="2" align="center"><b>Kondisi Kelas</b></td>
			  <td width="85" align="center"><b>Paraf Atasan Langsung</b></td>
			 </tr>
			</thead>
			<tbody>
			 <tr>
			  	<td width="275" align="center"><b>Kendala</b></td>
				<td width="275" align="center"><b>Penyelesaian</b></td>
			  	<td width="85" rowspan="3" align="center"></td>
			 </tr>
			 <tr>
			  	<td width="275" align="center">$DJ->KendalaKet</td>
				<td width="275" align="center">$DJ->Penyelesaianket</td>
			 </tr>
			 <tr>
			  	<td width="275" align="center"><img src="$gambar1" height="200" alt="Gambar 1" style="position: absolute; top: 25mm; left: 140mm;"></td>
			  	<td width="275" align="center"><img src="$gambar2" height="200" alt="Gambar 1" style="position: absolute; top: 25mm; left: 140mm;"></td>
			 </tr>
			</tbody>
			</table>
			EOD;

        	$pdf->AddPage();
			$pdf->writeHTML($tbl, true, false, false, false, '');
			if ($JumlahSeluruhdata==$ToatlDataTerhitung) {
				// Table with rowspans and THEAD
				$TGLPRINT=date("d M Y");
				$NamaKepala = $APPNAME[0]['NamaKepala'];
				$NIPKepala = $APPNAME[0]['NIPKepala'];
				$ttd=FCPATH . 'file/data/gambar/'.$APPNAME[0]['Foto'];
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
				if ($DJ->Status=='Konfirmasi') {
					$tbl.=<<<EOD
					<td align="center" ><img src="$ttd" height="125" alt="Gambar 1" style="position: absolute; top: 25mm; left: 140mm;"></td>
						  	<td align="center" ></td>
					EOD;
				}else{
					$tbl.=<<<EOD
					<td align="center" height="125" ></td>
					<td align="center" ></td>
					EOD;
				}
				$tbl.=<<<EOD
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
			}
			// Add a page break before this table (starting on a new page)
			// -----------------------------------------------------------------------------
			$pdf->setPrintHeader(true); // Mengaktifkan header
			$JumlahSeluruhdata++;
	}
}

$htmlContentForPdf = ob_get_clean();

//Close and output PDF document
$pdf->Output('JurnalMengajar_Review.pdf', 'I');
// $pdf->Output('Laporan Pembayaran '.$NamaSiswa.'('.$NisSiswa.') ('.date('H.i.s_m.d.Y').').pdf', 'I');
//============================================================+
// END OF FILE
//============================================================+

echo $htmlContentForPdf;

?>