<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'libraries/PhpSpreadsheet/autoload.php';

class User_walikelas extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_UserCek');
		$this->load->helper(array('form', 'url', 'cookie'));
		$this->load->library('Pdf');
		
	}

	private function convertDate($date_str)
	{
		$timestamp = strtotime($date_str); // Mengonversi tanggal ke UNIX timestamp
		return $formatted_date = date('Y-m-d', $timestamp); // Mengonversi timestamp ke format Y-m-d
	}

	public function WKAbsen($fungsi = null, $nis = null)
	{
		if ($this->session->userdata('Status') !== "Login") {
			redirect(base_url("User_login"));
		} else {
			$Data002 = array(
				'IDGuru' => $this->session->userdata('IDGuru'),
				'KodeGuru' => $this->session->userdata('KodeGuru'),
				'NamaGuru' => $this->session->userdata('NamaGuru'),
				'UsrGuru' => $this->session->userdata('UsrGuru'),
				'KodeMapel' => $this->session->userdata('KodeMapel'),
				'IDHak' => $this->session->userdata('IDHak'),
				'IDAjaran' => $this->session->userdata('IDjaran'),
				'IDSemester' => $this->session->userdata('IDSemester')
			);
			$Data003 = array(
				'UsrGuru' => $this->session->userdata('UsrGuru'),
				'aktif' => 'WKAbsen'
			);

			if (isset($_POST['CariData']) && $_POST['CariData'] == 'FilterData' ) {
				$content['TampilData']=true;
				$data = array();
				// Membuang karakter "[TglFilter] => " di awal string
				$dateRange = str_replace(" ", "", $_POST['TglFilter']);

				// Memisahkan tanggal dengan delimiter " - "
				$betwen = explode("-", $dateRange);
				$startDate = new DateTime($betwen[0]);
				$endDate = new DateTime($betwen[1]);
				$where2 = array(
					'tb_guru.IDGuru' => $this->session->userdata('IDGuru'),
					'tb_kelas.IDKelas' => $_POST['IDKelas'],
					'absensi_siswa_mapel.TglAbsensi >=' => $this->convertDate($betwen[0]),
					'absensi_siswa_mapel.TglAbsensi <=' => $this->convertDate($betwen[1])
				);
				while ($startDate <= $endDate) {
				    $data[] = $startDate->format('Y-m-d');
				    $startDate->modify('+1 day');
				}
				$content['RekapAbsenTanggal']=$data;
				$content['RekapAbsen'] = $this->M_UserCek->ReadRekapAbsen($where2);
				
				$dimana[0] = array(
				    'tb_kelas.IDGuru' => $this->session->userdata('IDGuru'),
				    'tb_kelas.IDKelas' => $_POST['IDKelas']
				);
				$content['tabel'] = $this->M_UserCek->DataKelasCustom($dimana[0]);
				// print_r($content['DataKelasByWaliKelas']);
				
				// print_r($content['RekapAbsen']);
				// print_r($betwen);
				// print_r($data);
				// print_r($_POST);
			}

			$dimana[1] = array(
				    'IDGuru' => $this->session->userdata('IDGuru')
				);
			$Data003['SISTEM'] = $this->M_UserCek->APPNAME();
			$Data003['HakAkses'] = $this->M_UserCek->DataHakakses();
			$Data003['IDHak'] = $this->session->userdata('IDHak');
        	$Data003['Fitur'] = $this->M_UserCek->FiturSistem();
			$Data004['ButuhTabel'] = TRUE;
			$Data004['ButuhForm'] = TRUE;
			$content['datatahun'] = $this->M_UserCek->AmbilTahun();
			$content['datakelas'] = $this->M_UserCek->DataKelasAmbilWhere($dimana[1]);
			$Dmn = array('tb_kelas.IDGuru' => $this->session->userdata('IDGuru') );
			$content['DataKelasByWaliKelas'] = $this->M_UserCek->DataKelasBy($Dmn);
			$this->load->view('halaman/template/001', $Data004);
			$this->load->view('halaman/template/002(UPPER)', $Data002);
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003);
			$this->load->view('halaman/content/halamanSistem/walikelas/DataMurid_Absensi', $content);
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004);
		}
	}

	public function WKNilai($fungsi = null,$kelas = null, $nis = null)
	{
		if ($this->session->userdata('Status') !== "Login") {
			redirect(base_url("User_login"));
		} else {
			$halaman=0;
			if ($fungsi!==null && $fungsi=='Rekapitulasi' && $nis!==null && $kelas!==null) {
				$halaman=2;
				$where = array(
					'tb_kelas.IDGuru' => $this->session->userdata('IDGuru'),
					'tb_kelas.IDKelas' => $kelas,
					'tb_siswa.NisSiswa' => $nis,
					'nilai_mapel.NisSiswa' => $nis,
					'jadwal_kelas_mapel.IDAjaran' => $this->session->userdata('IDAjaran'),
					'report_semester.IDSemester' => $this->session->userdata('IDSemester')
				);
				$content['NisSiswa']=$nis;
				$content['tabel'] = $this->M_UserCek->ReadDataSiswaMapelGuruMapelNilaiSemesterAjaran($where);
				// print_r($content['tabel']);
			}
			$Data002 = array(
				'IDGuru' => $this->session->userdata('IDGuru'),
				'KodeGuru' => $this->session->userdata('KodeGuru'),
				'NamaGuru' => $this->session->userdata('NamaGuru'),
				'UsrGuru' => $this->session->userdata('UsrGuru'),
				'KodeMapel' => $this->session->userdata('KodeMapel'),
				'IDHak' => $this->session->userdata('IDHak'),
				'IDAjaran' => $this->session->userdata('IDjaran'),
				'IDSemester' => $this->session->userdata('IDSemester')
			);
			$Data003 = array(
				'UsrGuru' => $this->session->userdata('UsrGuru'),
				'aktif' => 'WKNilai'
			);

			if (isset($_POST['CariData']) && $_POST['CariData'] == 'FilterData' ) {
				$content['TampilData']=true;
				
				$dimana = array(
				    'tb_kelas.IDGuru' => $this->session->userdata('IDGuru'),
				    'tb_kelas.IDKelas' => $_POST['IDKelas']
				);
				$content['tabel'] = $this->M_UserCek->DataKelasCustom($dimana);
				
			}

			$dimana[1] = array(
				    'IDGuru' => $this->session->userdata('IDGuru')
				);
			$Data003['SISTEM'] = $this->M_UserCek->APPNAME();
			$Data003['IDHak'] = $this->session->userdata('IDHak');
			$Data003['HakAkses'] = $this->M_UserCek->DataHakakses();
        	$Data003['Fitur'] = $this->M_UserCek->FiturSistem();
			$Data004['ButuhTabel'] = TRUE;
			$Data004['ButuhForm'] = TRUE;
			$content['datatahun'] = $this->M_UserCek->AmbilTahun();
			$content['datakelas'] = $this->M_UserCek->DataKelasAmbilWhere($dimana[1]);
			$Dmn = array('tb_kelas.IDGuru' => $this->session->userdata('IDGuru') );
			$content['DataKelasByWaliKelas'] = $this->M_UserCek->DataKelasBy($Dmn);
			$this->load->view('halaman/template/001', $Data004);
			$this->load->view('halaman/template/002(UPPER)', $Data002);
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003);
			if ($halaman==0) {
				$this->load->view('halaman/content/halamanSistem/walikelas/DataMurid_Nilai', $content);
			}elseif ($halaman==2) {
				$this->load->view('halaman/content/halamanSistem/walikelas/DataMurid_NilaiDetail', $content);
			}
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004);
		}
	}

	public function NilaiAkhir($fungsi=null,$NisSiswa=null)
	{
		if ($this->session->userdata('Status') !== "Login") {
			redirect(base_url("User_login"));
		} else {
			if ($fungsi!==null && $fungsi=='Simpan' && $NisSiswa!==null) {
				if (count($_POST)>0) {
					$datatersimpan=0;
					$no=0;
					foreach ($_POST as $key => $value) {
						$IDNilaiMapel[$no]=$key;
						$Nilai[$no]=$value;
						$no++;
					}
					for ($i=0; $i < count($IDNilaiMapel); $i++) { 
						$where = array('IDNilaiMapel' => $IDNilaiMapel[$i]);
						$DataMasuk = array('NilaiAkhir' => $Nilai[$i] );
						$this->M_UserCek->UpdateNilaiSiswa($where,$DataMasuk);
						$datatersimpan++;
					}
				}

				if ($datatersimpan>0) {
					$cari = array('NisSiswa' => $NisSiswa );
					foreach ($this->M_UserCek->DataKelasCustom($cari) as $key) {
						$IDKelas=$key->IDKelas;
					}
					$this->session->set_flashdata('toastr_success', $datatersimpan.' Matapelajaran Telah Disimpan Nilainya!');
					redirect(base_url("User_walikelas/WKNilai/Rekapitulasi/".$IDKelas.'/'.$NisSiswa));

				}
			}
		}
	}

	public function WKPelanggaran($fungsi=null,$NisSiswa=null) {
        if ($this->session->userdata('Status') !== "Login") {
            redirect(base_url("User_login"));
        } else {
        	if ($fungsi==null) {
				if (isset($_POST)) {
	            	if (isset($_POST['CariKelas'])&&$_POST['CariKelas']=='WaliKelas') {
	            		$content['TampilData']=true;
	            		$where = array('kl.IDKelas' => $this->input->post('IDKelas') );
	            		$content['DataPelanggaran']=$this->M_UserCek->RekapSkoringKelas($where);
	            		// print_r($content['DataPelanggaran']);
	            	}
	            }
	            $halaman=0;
        	}elseif ($fungsi=='Detail') {
	            $halaman=1;
	            $where = array(
	            	'NisSiswa' => $NisSiswa,
	            	'StatusBK' => 'Konfirmasi'
	            );
                $content['RekapIndividu']=$this->M_UserCek->RekapSkoringIndividuBy($where);
        		
        	}
			$Data002 = array(
				'IDGuru' => $this->session->userdata('IDGuru'),
				'KodeGuru' => $this->session->userdata('KodeGuru'),
				'NamaGuru' => $this->session->userdata('NamaGuru'),
				'UsrGuru' => $this->session->userdata('UsrGuru'),
				'KodeMapel' => $this->session->userdata('KodeMapel'),
				'IDHak' => $this->session->userdata('IDHak'),
				'IDAjaran' => $this->session->userdata('IDjaran'),
				'IDSemester' => $this->session->userdata('IDSemester')
			);
			$Data003 = array(
				'UsrGuru' => $this->session->userdata('UsrGuru'),
				'aktif' => 'WKPelanggaran'
			);

			

			$dimana[1] = array(
				    'IDGuru' => $this->session->userdata('IDGuru')
				);
        	$Data003['Fitur'] = $this->M_UserCek->FiturSistem();
			$Data003['SISTEM'] = $this->M_UserCek->APPNAME();
			$Data003['HakAkses'] = $this->M_UserCek->DataHakakses();
			$Data003['IDHak'] = $this->session->userdata('IDHak');
			$Data004['ButuhTabel'] = TRUE;
			$Data004['ButuhForm'] = TRUE;
			$content['datatahun'] = $this->M_UserCek->AmbilTahun();
			$content['datakelas'] = $this->M_UserCek->DataKelasAmbilWhere($dimana[1]);
			$Dmn = array('tb_kelas.IDGuru' => $this->session->userdata('IDGuru') );
			$content['DataKelasByWaliKelas'] = $this->M_UserCek->DataKelasBy($Dmn);
			$this->load->view('halaman/template/001', $Data004);
			$this->load->view('halaman/template/002(UPPER)', $Data002);
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003);
			// Melakukan pengecekan fungsi yang akan dilakukan
            if ($halaman==0) {
				$this->load->view('halaman/content/halamanSistem/walikelas/DataMurid_Pelanggaran', $content);
            }elseif ($halaman==1) {
				$this->load->view('halaman/content/halamanSistem/walikelas/DataMurid_Pelanggaran_Detail', $content);
            }
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004);
		}
	}

	public function AmbilAbsensiMurid()
	{
	    // Mendapatkan data dari POST request
	    $nisSiswa = $this->input->post('nisSiswa');
	    $tanggal = $this->input->post('tanggal');
	    $where = array(
	        'absensi_siswa_mapel.NisSiswa' => $nisSiswa,
	        'absensi_siswa_mapel.TglAbsensi' => $tanggal
	    );
	    $data = $this->M_UserCek->ReadSiswaAbsensiSS($where);

	    // Kembalikan data dalam format JSON
	    $this->output
	        ->set_content_type('application/json')
	        ->set_output(json_encode($data));
	}


}
