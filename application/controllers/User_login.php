<?php

/**
 * 
 */
class User_login extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_UserCek');
		$this->load->helper('url');
		$this->load->helper('cookie');
		// $this->load->library('encryption');
	}

	public function index()
	{
		if (null !== ($this->session->userdata('Status'))) {
			if ($this->session->userdata('Status') == "Login") {
				redirect(base_url("User_login/aksi_login"));
			} elseif ($this->session->userdata('Status') == "WaliLogin") {
				redirect(base_url("Wali_Halaman"));
			}
		} else {
			$LoginData['SISTEM'] = $this->M_UserCek->APPNAME();
			$this->load->view('halaman/Login',$LoginData);
		}
	}

	public function aksi_login()
	{
		if ($this->session->userdata('Status') == "Login") {
			redirect(base_url("User_halaman"));
		}elseif ($this->session->userdata('Status') == "WaliLogin"){
			redirect(base_url("Wali_Halaman"));
		}else{
			$usrnm = $this->input->post('usrnm');
			$pswrd = $this->input->post('pswrd');
			$cek = $this->M_UserCek->cek_login($usrnm, $pswrd);
			if ($cek != false) {
				$TA = $this->M_UserCek->AmbilTahunAjaranSaatIni();
				if ($TA==false) {
					$TA= $this->M_UserCek->AmbilTahunAjaranlimit(1);
				}
				foreach ($TA as $a) {
					$IDAjaran = $a->IDAjaran;
				}
				$SM = $this->M_UserCek->AmbilSemesterSaatIni();
				if ($SM==false) {
					$SM= $this->M_UserCek->AmbilSemesterlimit(1);
				}
				foreach ($SM as $b) {
					$IDSemester = $b->IDSemester;
				}
				$where2 = array(
						'tg.UsrGuru' => $this->input->post('usrnm'),
						'tg.PassGuru' => $this->input->post('pswrd')
					);
				$GM = $this->M_UserCek->GuruMengajarlimit($where2);
				foreach ($GM as $c) {
					$IDMapel = $c->IDMapel;
				}
				foreach ($cek as $d) {
					$data_session = array(
						'IDGuru' => $d->IDGuru,
						'NamaGuru' => $d->NamaGuru,
						'NIGuru' => $d->NomorIndukGuru,
						'UsrGuru' => $d->UsrGuru,
						'KodeGuru' => $d->KodeGuru,
						'IDMapel' => $IDMapel,
						'IDHak' => $d->IDHak,
						'IDAjaran' => $IDAjaran,
						'IDSemester' => $IDSemester,
						'Status' => 'Login'
					);
				}
				$this->session->set_userdata($data_session);
				redirect(base_url("User_halaman"));
			} else {
				$LoginData = array('msg' => TRUE);
				$LoginData['SISTEM'] = $this->M_UserCek->APPNAME();
				$this->load->view('halaman/Login', $LoginData);
			}
		} 
	}

	public function aksi_logout()
	{
		$Halaman = '';
		if ($this->session->userdata('Status') == 'Login') {
			$Halaman = 'Sekolah';
		} elseif ($this->session->userdata('Status') == 'WaliLogin') {
			$Halaman = 'Wali';
		}
		$data_session = array(
			'NamaGuru' => '',
			'UsrGuru' => '',
			'KodeGuru' => '',
			'KodeMapel' => '',
			'IDHak' => '',
			'IDAjaran' => '',
			'IDSemester' => '',
			'Status' => 'Login'
		);
		$this->session->set_userdata($data_session);
		// delete_cookie("Perusahaan_Konveksi_COOKIES");
		$this->session->sess_destroy();
		if ($Halaman == 'Sekolah') {
			redirect(base_url('User_login'));
		} elseif ($Halaman == 'Wali') {
			redirect(base_url('User_login/Wali'));
		} else {
			redirect(base_url('User_login'));
		}
	}

	public function Wali()
	{
		if (null !== ($this->session->userdata('Status'))) {
			if ($this->session->userdata('Status') == "Login") {
				redirect(base_url("User_login/aksi_login"));
			} else {
				redirect(base_url("User_halaman/Wali"));
			}
		} else {
			$LoginData['SISTEM'] = $this->M_UserCek->APPNAME();
			$this->load->view('halaman/WaliLogin',$LoginData);
		}
	}

	public function waliAksi()
	{
		if ($this->session->userdata('Status') !== "Login" && $this->session->userdata('Status') !== "WaliLogin") {
			$usrnm = $this->input->post('usrnm');
			$pswrd = $this->input->post('pswrd');
			$cek = $this->M_UserCek->cek_walilogin($usrnm, $pswrd);
			if ($cek != false) {
				$data_session = array();
				foreach ($cek as $c) {
						$data_session['IDOrtu'] = $c->IDOrtu;
						$data_session['NamaOrtu'] = $c->NamaOrtu;
						$data_session['NisSiswa'] = $c->NisSiswa;
					
				}
				$where = array('NisSiswa' => $data_session['NisSiswa'] );
				$ambildatasiswa=$this->M_UserCek->DataMuridNis($where);
				if ($ambildatasiswa!==false) {
					foreach ($ambildatasiswa as $D) {
						$data_session['IDKelas']=$D->IDKelas;
						$data_session['KodeKelas']=$D->KodeKelas;
						$data_session['NamaWaliKelas']=$D->NamaGuru;
						$data_session['IDWaliKelas']=$D->IDGuru;
						$data_session['NamaSiswa']=$D->NamaSiswa;
					}
				}
				$data_session['Status'] = 'WaliLogin';
				$this->session->set_userdata($data_session);

				redirect(base_url("Wali_Halaman"));
			} else {
				$LoginData = array('msg' => TRUE);
				$LoginData['SISTEM'] = $this->M_UserCek->APPNAME();
				$this->load->view('halaman/WaliLogin', $LoginData);
			}
		} else {
			redirect(base_url("Wali_Halaman"));
		}
	}
}
