<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'libraries/PhpSpreadsheet/autoload.php';

class User_halaman extends CI_Controller
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

	private function HariIni()
	{
		// Set zona waktu sesuai dengan kebutuhan
		// date_default_timezone_set('Asia/Jakarta');

		// Mendapatkan indeks hari (0 = Minggu, 1 = Senin, dst.)
		$indeksHari = date('w');

		// Daftar nama hari dalam bahasa Indonesia
		$namaHariIndonesia = [
			'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'
		];

		// Mendapatkan nama hari dalam bahasa Indonesia
		$namaHari = $namaHariIndonesia[$indeksHari];

		return $namaHari;
	}


	public function index($halaman = null, $IDSurat = null)
	{
		// Admin

		// Memeriksa apakah sesi 'Status' telah diatur sebagai "Login"
		if ($this->session->userdata('Status') !== "Login") {
			// Jika belum login, arahkan kembali ke halaman login
			redirect(base_url("User_login"));
		} else {
			// Jika sudah login, lanjutkan eksekusi berikutnya

			// Menyiapkan data yang diperlukan untuk header bagian atas
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

			// Menyiapkan data yang diperlukan untuk sidebar
			$Data003 = array(
				'UsrGuru' => $this->session->userdata('UsrGuru'),
				'aktif' => 'Dashboard'
			);

			// Mengambil informasi nama sistem dari model dan menambahkannya ke data sidebar
			$Data003['SISTEM'] = $this->M_UserCek->APPNAME();
			// Mengambil informasi ID hak akses pengguna dan menambahkannya ke data sidebar
			$Data003['Fitur'] = $this->M_UserCek->FiturSistem();
			$Data003['HakAkses'] = $this->M_UserCek->DataHakakses();
			$Data003['IDHak'] = $this->session->userdata('IDHak');


			// Menyiapkan data yang diperlukan untuk konten halaman
			$Data004['ButuhTabel'] = TRUE;
			$Data004['ButuhForm'] = TRUE;

			// Mengambil informasi jumlah murid, guru, dan kelas dari model dan menambahkannya ke data konten
			$content['Jumlah_Murid'] = $this->M_UserCek->DataMuridAmbilAllNumber();
			if ($this->M_UserCek->DataGuruAmbilAllNumber() !== false) {
				$content['Jumlah_Guru'] = $this->M_UserCek->DataGuruAmbilAllNumber();
			} else {
				$content['Jumlah_Guru'] = 0;
			}
			$content['Jumlah_Staff'] = $this->M_UserCek->DataStaffAmbilAllNumber() - $this->M_UserCek->DataGuruAmbilAllNumber();
			$content['Jumlah_Kelas'] = $this->M_UserCek->DataKelasAmbilAllNumber();
			$content['TahunAjaran'] = $this->M_UserCek->AmbilTahunAjaranLimit(3);
			$content['Semester'] = $this->M_UserCek->AmbilSemesterlimit(2);
			$where1 = array(
				'tg.KodeGuru' => $this->session->userdata('KodeGuru'),
				'tg.UsrGuru' => $this->session->userdata('UsrGuru')
			);
			$where2 = array('gm.IDGuru' => $this->session->userdata('IDGuru'));
			$content['MapelGuru'] = $this->M_UserCek->GuruMengajar($where1);
			$content['JadwalGuru'] = $this->M_UserCek->AmbilDataJadwal($where2);
			$where[0] = array(
				'condition_1' => array('sd.KategoriSurat' => 'Semua', 'sd.status' => 'Terkirim', 'sd.Sampah' => 'Tidak'), // Kondisi pertama
				'condition_2' => array('sd.KategoriSurat' => 'khusus', 'sd.FilterKategori' => 'Guru', 'sd.status' => 'Terkirim', 'sd.Sampah' => 'Tidak') // Kondisi kedua
			);
			$content['DataSuratDigital'] = $this->M_UserCek->SuratDigitalRead($where[0]);


			// 27 januari 2024 || vita rahmada
			$DMN[1] = array(
				'tb_guru.IDGuru' => $this->session->userdata('IDGuru')
			);
			$content['TampilkanJurnal'] = $this->M_UserCek->RiwayatJurnal($DMN[1]);

			// Memuat tampilan berdasarkan template dan data yang telah disiapkan
			$this->load->view('halaman/template/001', $Data004); // Template bagian atas
			$this->load->view('halaman/template/002(UPPER)', $Data002); // Template bagian header
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003); // Template bagian sidebar
			if ($halaman == null) {
				$this->load->view('halaman/content/dashboard', $content); // Konten halaman dashboard
			} elseif ($halaman == 'Informasi' && $IDSurat) {
				$where[1] = array(
					'sd.IDSurat' => $IDSurat
				);
				$content['DataSuratDigitalDetail'] = $this->M_UserCek->SuratDigitalRead($where[1]);
				$this->load->view('halaman/content/halamanSistem/Ahalaman/DashboardInfo', $content); // Konten halaman dashboard
			}
			
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004); // Template bagian bawah
		}
	}

	public function CRUDIndex()
	{
		if ($this->session->userdata('Status') !== "Login") {
			// Jika belum login, arahkan kembali ke halaman login
			redirect(base_url("User_login"));
		} else {
			if ($this->input->post() != null) {
				if ($this->input->post('Pengaturan') != null && $this->input->post('Pengaturan') == 'Pengguna') {
					$DataSesi = array(
						'NamaGuru' => $this->session->userdata('NamaGuru'),
						'UsrGuru' => $this->session->userdata('UsrGuru'),
						'IDMapel' => $_POST['IDMapel'],
						'KodeMapel' => $this->session->userdata('KodeMapel'),
						'IDHak' => $this->session->userdata('IDHak'),
						'IDAjaran' => $_POST['TahunAjaran'],
						'IDSemester' => $_POST['Semester'],
						'Status' => 'Login'
					);
					$this->session->set_userdata($DataSesi);
					$where[0] = array('IDMapel' => $_POST['IDMapel']);
					$where[1] = array('IDSemester' => $_POST['Semester']);
					$where[2] = array('IDAjaran' => $_POST['TahunAjaran']);
					$Mapel = $this->M_UserCek->DataMataPelajaranCek($where[0]);
					$Semester = $this->M_UserCek->AmbilSemesterby($where[1]);
					$TahunAjaran = $this->M_UserCek->DataTahunAjaranWhere($where[2]);
					foreach ($Mapel as $MP) {
						$NamaMapel = $MP->NamaMapel;
					}
					foreach ($Semester as $S) {
						$NamaSemester = $S->NamaSemester;
					}
					foreach ($TahunAjaran as $TA) {
						$KodeAjaran = $TA->KodeAjaran;
					}
					$this->session->set_flashdata('toastr_success', 'Berhasil Merubah Pengaturan!<br>Anda Sekarang Guru <b>' . $NamaMapel . '</b><br><b>' . $NamaSemester . '</b><br>Tahun Ajaran <b>' . $KodeAjaran . '</b>');
					redirect(base_url("User_halaman"));
				}
			}
		}
	}

	public function LaporPelanggaran()
	{
		if ($this->session->userdata('Status') !== "Login") {
			redirect(base_url("User_login"));
		} else {
			// Data yang diambil dari sesi untuk digunakan dalam tampilan
			$Data002 = array(
				'KodeGuru' => $this->session->userdata('KodeGuru'),
				'NamaGuru' => $this->session->userdata('NamaGuru'),
				'UsrGuru' => $this->session->userdata('UsrGuru'),
				'KodeMapel' => $this->session->userdata('KodeMapel'),
				'IDHak' => $this->session->userdata('IDHak'),
				'IDAjaran' => $this->session->userdata('IDjaran')
			);

			// Data untuk tampilan sidebar
			$Data003 = array(
				'UsrGuru' => $this->session->userdata('UsrGuru'),
				'aktif' => 'LaporPelanggaran'
			);

			// Mengambil data dari model untuk ditampilkan dalam tampilan
			$Data003['Fitur'] = $this->M_UserCek->FiturSistem();
			$Data003['SISTEM'] = $this->M_UserCek->APPNAME();
			$Data003['HakAkses'] = $this->M_UserCek->DataHakakses();
			$Data003['IDHak'] = $this->session->userdata('IDHak');
			$Data004['ButuhTabel'] = TRUE;
			$Data004['ButuhForm'] = TRUE;

			// Mengambil data dari model untuk ditampilkan dalam tampilan
			$content['datatahun'] = $this->M_UserCek->AmbilTahun();
			$content['datakelas'] = $this->M_UserCek->DataKelasAmbil();
			$content['datasiswa'] = $this->M_UserCek->DataMuridOnly();
			$content['kodemapel'] = $this->session->userdata('KodeMapel');
			$content['kodeguru'] = $this->session->userdata('KodeGuru');
			$content['datatahunajaran'] = $this->M_UserCek->AmbilTahunAjaran();
			$content['datasemester'] = $this->M_UserCek->AmbilSemester();


			// Memuat tampilan template dan komponen tampilan
			$this->load->view('halaman/template/001', $Data004);
			$this->load->view('halaman/template/002(UPPER)', $Data002);
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003);
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			if ($this->input->post('CariData') !== null) {
				if ($_POST['CariData'] == 'Siswa') {
					$content['CariData'] = $this->input->post('CariData');
					$where = array('NisSiswa' => $this->input->post('NisSiswa'));
					$content['DataSiswaCari'] = $this->M_UserCek->DataMuridNis($where);
					$content['JenisPelanggaran'] = $this->M_UserCek->ReadJenisPelanggaran();
				}
			}
			$this->load->view('halaman/content/lapor_siswa', $content);

			// Menampilkan bagian akhir tampilan
			$this->load->view('halaman/template/004', $Data004);
		}
	}

	public function LaporPelanggaranCRUD()
	{
		if ($this->session->userdata('Status') !== "Login") {
			redirect(base_url("User_login"));
		} else {
			if ($this->input->post('Data') !== null) {
				if ($this->input->post('Data') == 'Lapor') {
					if (!empty($_FILES['FotoPelanggaran']['name'])) {
						// print_r($_POST);
						// Konfigurasi unggahan file
						$config['upload_path']          = './file/data/gambar/gambarpelanggaran/';
						$config['allowed_types'] 		= 'png|jpg|jpeg';
						$config['max_size']             = 8192;
						$config['overwrite']			= true;
						$config['file_name']			= $this->input->post('NisSiswa') . time();
						$config['encrypt_name']			= true;
						$this->load->library('upload', $config);
						if ($this->upload->do_upload('FotoPelanggaran')) {
							$upload_data = $this->upload->data();
							$where = array('UsrGuru' => $this->session->userdata('UsrGuru'));
							foreach ($this->M_UserCek->DataGuruWhere($where) as $key) {
								$IDGuru = $key->IDGuru;
							}

							$DataMasuk = array(
								'NisSiswa' => $this->input->post('NisSiswa'),
								'IDJenis' => $this->input->post('IDJenis'),
								'Keterangan' => $this->input->post('Keterangan'),
								'TglLapor' => $this->convertDate($this->input->post('TglLapor')),
								'File' => 'file/data/gambar/gambarpelanggaran/' . $upload_data['file_name'],
								'IDGuru' => $IDGuru,
								'StatusBk' => 'Baru'
							);
							// print_r($DataMasuk);
							$this->M_UserCek->InsertLaporPelanggaran($DataMasuk);
							$this->session->set_flashdata('toastr_success', 'Berhasil Melaporkan!');
							redirect(base_url("User_halaman/LaporPelanggaran"));
						} else {
							// $error = $this->upload->display_errors();
							// echo "Error: " . $error;
							// error_log('Upload Error: ' . $this->upload->display_errors());
							$this->session->set_flashdata('toastr_warning', 'Periksa Kembail File Yang Diupload!');
							redirect(base_url("User_halaman/LaporPelanggaran"));
						}
					}
				}
			}
		}
	}

	public function UserProfile($jenis = null, $id = null)
	{
		// Memeriksa apakah sesi 'Status' telah diatur sebagai "Login"
		if ($this->session->userdata('Status') !== "Login") {
			// Jika belum login, arahkan kembali ke halaman login
			redirect(base_url("User_login"));
		} else {
			// Jika sudah login, lanjutkan eksekusi berikutnya

			// Menyiapkan data yang diperlukan untuk header bagian atas
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

			// Menyiapkan data yang diperlukan untuk sidebar
			$Data003 = array(
				'UsrGuru' => $this->session->userdata('UsrGuru'),
				'aktif' => 'UserProfile'
			);

			// Mengambil informasi nama sistem dari model dan menambahkannya ke data sidebar
			$Data003['SISTEM'] = $this->M_UserCek->APPNAME();
			// Mengambil informasi ID hak akses pengguna dan menambahkannya ke data sidebar
			$Data003['Fitur'] = $this->M_UserCek->FiturSistem();
			$Data003['HakAkses'] = $this->M_UserCek->DataHakakses();
			$Data003['IDHak'] = $this->session->userdata('IDHak');


			// Menyiapkan data yang diperlukan untuk konten halaman
			$Data004['ButuhTabel'] = TRUE;
			$Data004['ButuhForm'] = TRUE;
			$content = array();

			$where = array('IDGuru' => $this->session->userdata('IDGuru'));
			$content['DataGuru'] = $this->M_UserCek->DataGuruWhere($where);

			if ($jenis == 'DataUpdate' && $this->input->post('IDGuru')) {
				$DataMasuk = array(
					'UsrGuru' => $this->input->post('UsrGuru'),
					'KodeGuru' => $this->input->post('KodeGuru'),
					'NamaGuru' => $this->input->post('NamaGuru'),
					'NomorHP' => $this->input->post('NomorHP'),
					'NomorIndukGuru' => $this->input->post('NomorIndukGuru'),
					'PassGuru' => $this->input->post('PassGuru')
				);

				$cek = $this->input->post('IDGuru');
				if ($this->M_UserCek->DataGuruCekWhere($DataMasuk, $cek) === true) {
					$where['IDGuru'] = $this->input->post('IDGuru');
					$this->M_UserCek->DataGuruUpdate($DataMasuk, $where);
					$data = $this->M_UserCek->DataGuruAmbilWhere($where);
					foreach ($data as $g) {
						$session = array(
							'IDGuru' => $g->IDGuru,
							'NamaGuru' => $g->NamaGuru,
							'NIGuru' => $g->NomorIndukGuru,
							'UsrGuru' => $g->UsrGuru,
							'KodeGuru' => $g->KodeGuru
						);
					}
					// print_r($session);
					$this->session->set_userdata($session);

					$this->session->set_flashdata('toastr_success', 'Berhasil Mengedit Data!');

					redirect(base_url("User_halaman/UserProfile"));
				} else {
					$this->session->set_flashdata('toastr_info', 'Anda Memasukkan Data Yang Sama!');

					redirect(base_url("User_halaman/UserProfile"));
				}
			}

			// Memuat tampilan berdasarkan template dan data yang telah disiapkan
			$this->load->view('halaman/template/001', $Data004); // Template bagian atas
			$this->load->view('halaman/template/002(UPPER)', $Data002); // Template bagian header
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003); // Template bagian sidebar
			$this->load->view('halaman/content/halamanSistem/Ahalaman/User_Profil', $content); // Konten halaman dashboard
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004); // Template bagian bawah
		}
	}
}
