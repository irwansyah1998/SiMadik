<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'libraries/PhpSpreadsheet/autoload.php';

class User_custom extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_UserCek');
		$this->load->model('M_WhatsApp');
		$this->load->helper(array('form', 'url', 'cookie'));
		$this->load->library('Pdf');
	}

	public function JurnalPreview($IDHak=null,$IDGuru=null)
	{
		// Memeriksa apakah sesi 'Status' telah diatur sebagai "Login"
		if ($this->session->userdata('Status') !== "Login") {
			// Jika belum login, arahkan kembali ke halaman login
			redirect(base_url("User_login"));
		} else {
			// Jika sudah login, lanjutkan eksekusi berikutnya
			$Data003['HakAkses'] = $this->M_UserCek->DataHakakses();
			$Data003['aktif'] = null;
			$akses = array();

			// Menyiapkan data yang diperlukan untuk header bagian atas
			$Data002 = array(
				'KodeGuru' => $this->session->userdata('KodeGuru'),
				'NamaGuru' => $this->session->userdata('NamaGuru'),
				'UsrGuru' => $this->session->userdata('UsrGuru'),
				'KodeMapel' => $this->session->userdata('KodeMapel'),
				'IDHak' => $this->session->userdata('IDHak'),
				'IDAjaran' => $this->session->userdata('IDjaran')
			);
			$HAKAKSES=explode('//', $Data002['IDHak']);
			for ($i=0; $i < count($HAKAKSES); $i++) { 
				if ($IDHak==$HAKAKSES[$i]) {
					$akses['Halaman']=TRUE;
				}
			}
			foreach ($Data003['HakAkses'] as $D3HA) {
				if ($IDHak==$D3HA->IDHak) {
					$Data003['aktif'] = $D3HA->IDHak;
					$Data003['Halaman'] = 'JurnalPreview';
					$akses['NamaHalaman'] = $D3HA->NamaHak;
				}
			}

			// print_r($akses);


			// Menyiapkan data yang diperlukan untuk sidebar
			$Data003['Fitur'] = $this->M_UserCek->FiturSistem();
			$Data003['IDHak'] = $this->session->userdata('IDHak');
			$Data003['SISTEM'] = $this->M_UserCek->APPNAME();

			// Menyiapkan data yang diperlukan untuk konten halaman
			$Data004['ButuhTabel'] = TRUE;
			$Data004['ButuhForm'] = TRUE;

			// Mengambil data guru, hak akses, mata pelajaran dari model
			$content['hakakses'] = $this->M_UserCek->DataHakakses();
			$content['IDHak'] = $IDHak;
			$content['TabelMengajarMapel'] = $this->M_UserCek->ReadDataGuruMengajar();

			// Memuat tampilan berdasarkan template dan data yang telah disiapkan
			$this->load->view('halaman/template/001', $Data004); // Template bagian atas
			$this->load->view('halaman/template/002(UPPER)', $Data002); // Template bagian header
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003); // Template bagian sidebar
			
			$this->load->view('halaman/content/halamanSistem/Customize/JurnalKegiatan', $content); 
			
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004); // Template bagian bawah
		}
	}

	public function JurnalAdd($IDHak=null,$IDGuru=null)
	{
		// Memeriksa apakah sesi 'Status' telah diatur sebagai "Login"
		if ($this->session->userdata('Status') !== "Login") {
			// Jika belum login, arahkan kembali ke halaman login
			redirect(base_url("User_login"));
		} else {
			// Jika sudah login, lanjutkan eksekusi berikutnya
			$Data003['HakAkses'] = $this->M_UserCek->DataHakakses();
			$Data003['aktif'] = null;
			$akses = array();

			// Menyiapkan data yang diperlukan untuk header bagian atas
			$Data002 = array(
				'KodeGuru' => $this->session->userdata('KodeGuru'),
				'NamaGuru' => $this->session->userdata('NamaGuru'),
				'UsrGuru' => $this->session->userdata('UsrGuru'),
				'KodeMapel' => $this->session->userdata('KodeMapel'),
				'IDHak' => $this->session->userdata('IDHak'),
				'IDAjaran' => $this->session->userdata('IDjaran')
			);
			$HAKAKSES=explode('//', $Data002['IDHak']);
			for ($i=0; $i < count($HAKAKSES); $i++) { 
				if ($IDHak==$HAKAKSES[$i]) {
					$akses['Halaman']=TRUE;
				}
			}
			foreach ($Data003['HakAkses'] as $D3HA) {
				if ($IDHak==$D3HA->IDHak) {
					$Data003['aktif'] = $D3HA->IDHak;
					$Data003['Halaman'] = 'TambahJurnal';
					$akses['NamaHalaman'] = $D3HA->NamaHak;
				}
			}

			// print_r($akses);


			// Menyiapkan data yang diperlukan untuk sidebar
			$Data003['Fitur'] = $this->M_UserCek->FiturSistem();
			$Data003['IDHak'] = $this->session->userdata('IDHak');
			$Data003['SISTEM'] = $this->M_UserCek->APPNAME();

			// Menyiapkan data yang diperlukan untuk konten halaman
			$Data004['ButuhTabel'] = TRUE;
			$Data004['ButuhForm'] = TRUE;

			// Mengambil data guru, hak akses, mata pelajaran dari model
			$content['hakakses'] = $this->M_UserCek->DataHakakses();
			$content['IDHak'] = $IDHak;
			$content['TabelMengajarMapel'] = $this->M_UserCek->ReadDataGuruMengajar();

			// Memuat tampilan berdasarkan template dan data yang telah disiapkan
			$this->load->view('halaman/template/001', $Data004); // Template bagian atas
			$this->load->view('halaman/template/002(UPPER)', $Data002); // Template bagian header
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003); // Template bagian sidebar
			
			$this->load->view('halaman/content/halamanSistem/Customize/JurnalKegiatanAdd', $content); 
			
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004); // Template bagian bawah
		}
	}

}
