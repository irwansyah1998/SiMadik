<?php
// ob_start();
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor($this->session->userdata('NamaGuru'));
$pdf->setTitle($APPNAME[0]['NamaInstansi']);
$pdf->setSubject('Data Username dan Password Guru');
$pdf->setKeywords('Username, Data, Guru');

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
// set font
$pdf->setFont('helvetica', 'B', 12);

// add a page
$pdf->AddPage();

$pdf->Write(0, "Data Username Dan Password\n", '', 0, 'C', true, 0, false, false, 0);

$pdf->setFont('helvetica', '', 10);

// -----------------------------------------------------------------------------

$pdf->setFont('helvetica', '', 8);
// Table with rowspans and THEAD
// width total 630
$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2">
<thead>
 <tr style="background-color:#D2B48C;">
  <td width="50" align="center"><b>Nomor</b></td>
  <td width="280" align="center"><b>Nama Guru</b></td>
  <td width="175" align="center"><b>Username</b></td>
  <td width="125" align="center"><b>Password</b></td>
 </tr>
</thead>
EOD;

if ($tabel!==false) {
	$no=1;
	foreach ($tabel as $tb) {
$tbl.= <<<EOD
<tbody>
 <tr>
	<td width="50" align="center">$no</td>
	<td width="280" align="center">$tb->NamaGuru</td>
	<td width="175" align="center">$tb->UsrGuru</td>
	<td width="125" align="center">$tb->PassGuru</td>
 </tr>
</tbody>
EOD;
$no++;
	}
}

$tbl.=<<<EOD
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output('JurnalMengajar_'.$this->session->userdata('NamaGuru').'.pdf', 'I');
// $pdf->Output('Laporan Pembayaran '.$NamaSiswa.'('.$NisSiswa.') ('.date('H.i.s_m.d.Y').').pdf', 'I');
//============================================================+
// END OF FILE
//============================================================+

?>