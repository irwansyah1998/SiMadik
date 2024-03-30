<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'libraries/PhpSpreadsheet/autoload.php';

class PDFPrint extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_PdfPrint');
		$this->load->helper(array('form', 'url', 'cookie'));
		$this->load->library('Pdf');
		// Load library PHPExcel
	}


	public function Keuangan($fungsi=null,$nis=null)
    {
    	if ($this->session->userdata('Status') !== "Login") {
			redirect(base_url("User_login"));
		} else {
			if ($fungsi=='pdf' && $nis!==null) {
				$where = array('tb_siswa.NisSiswa' => $nis );
				$where2 = array('keuangan_spp_bayar.NisSiswa' => $nis );
				$content['DataBayar'] = $this->M_PdfPrint->ReadBayarSpp($where2);
				$content['DataSiswa'] = $this->M_PdfPrint->AmbilDataSiswaWali($where);
				$content['APPNAME'] = $this->M_PdfPrint->APPNAMEarr();

				$this->load->view('halaman/export/keuangan/SPPPDF',$content);
			}
		}
    }

}
