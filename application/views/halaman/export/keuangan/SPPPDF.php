<?php
function pasangbulan($angka){
    switch ($angka) {
        case 1:
            return "Januari";
            break;
        case 2:
            return "Februari";
            break;
        case 3:
            return "Maret";
            break;
        case 4:
            return "April";
            break;
        case 5:
            return "Mei";
            break;
        case 6:
            return "Juni";
            break;
        case 7:
            return "Juli";
            break;
        case 8:
            return "Agustus";
            break;
        case 9:
            return "September";
            break;
        case 10:
            return "Oktober";
            break;
        case 11:
            return "November";
            break;
        case 12:
            return "Desember";
            break;
        default:
            return "Bulan tidak valid";
    }
}
foreach ($DataSiswa as $DS) {
	$IDSiswa=$DS->IDSiswa;
	$NamaSiswa=$DS->NamaSiswa;
	$NisSiswa=$DS->NisSiswa;
	$TglLhrSiswa=convertDate($DS->TglLhrSiswa);
	$TmptLhrSiswa=$DS->TmptLhrSiswa;
}
 function convertDate($date_str)
	{
		$timestamp = strtotime($date_str); // Mengonversi tanggal ke UNIX timestamp
		return $formatted_date = date('d-m-Y', $timestamp); // Mengonversi timestamp ke format Y-m-d
	}
  function formatRupiah($angka) {
    $rupiah = number_format($angka, 2, ',', '.');
    return $rupiah;
  }

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor('Nicola Asuni');
$pdf->setTitle($APPNAME[0]['NamaInstansi']);
$pdf->setSubject('Laporan Pembayaran '.$NamaSiswa.' ('.$NisSiswa.')');
$pdf->setKeywords('TCPDF, PDF, example, test, guide');

$customstring=$APPNAME[0]['Alamat']."\nNomor HP : +".$APPNAME[0]['NomorWA'];
$logo = $APPNAME[0]['Logo']; // Sesuaikan dengan path logo Anda
$logoWidth = 20; // Ganti dengan lebar yang sesuai
$pdf->setHeaderData($logo, $logoWidth , $APPNAME[0]['NamaInstansi'], $customstring);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->setHeaderMargin(PDF_MARGIN_HEADER);
$pdf->setFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

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

$pdf->Write(0, "Laporan Pembayaran\n", '', 0, 'C', true, 0, false, false, 0);

$pdf->setFont('helvetica', '', 10);

// -----------------------------------------------------------------------------
$tbl = <<<EOD
<table cellspacing="0" cellpadding="0" border="0">
    <tr>
        <td><b>Nomor Induk Siswa</b></td>
        <td align="center"><b>:</b></td>
        <td align="right"><b>$NisSiswa</b></td>
    </tr>
    <tr>
        <td><b>Nama Siswa</b></td>
        <td align="center"><b>:</b></td>
        <td align="right"><b>$NamaSiswa</b></td>
    </tr>
    <tr>
        <td><b>Tempat/Tanggal Lahir</b></td>
        <td align="center"><b>:</b></td>
        <td align="right"><b>$TmptLhrSiswa / $TglLhrSiswa</b></td>
    </tr>

</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------

$pdf->setFont('helvetica', '', 8);
// Table with rowspans and THEAD
// width total 630
$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2">
<thead>
 <tr style="background-color:#D2B48C;">
  <td width="125" align="center"><b>Bulan/Tahun</b></td>
  <td width="125" align="center"><b>Tanggal Bayar</b></td>
  <td width="175" align="center"><b>Jumlah Bayar</b></td>
  <td width="125" align="center"><b>Bag. Keuangan</b></td>
  <td width="80" align="center"><b>Status</b></td>
 </tr>
</thead>
EOD;

if ($DataBayar!==false) {
	foreach ($DataBayar as $DB) {
		$BayarBulan=pasangbulan($DB->BayarBulan);
		$RiwayatBayar='Rp. '.formatRupiah($DB->RiwayatBayar);
$tbl.= <<<EOD
<tbody>
 <tr>
	<td width="125" align="center">$BayarBulan/$DB->BayarTahun</td>
	<td width="125" align="center">$DB->TglBayar</td>
	<td width="175" align="center">$RiwayatBayar</td>
	<td width="125" align="center">$DB->NamaGuru</td>
	<td width="80" align="center">$DB->Keterangan</td>
 </tr>
</tbody>
EOD;
	}
}

$tbl.=<<<EOD
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------

// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output('Laporan Pembayaran '.$NamaSiswa.'('.$NisSiswa.') ('.date('H.i.s_m.d.Y').').pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
