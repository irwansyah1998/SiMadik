<?php
if (!defined('BASEPATH'))
	exit ('No direct script access allowed');

require_once APPPATH . 'libraries/PhpSpreadsheet/autoload.php';

class User_pengajar extends CI_Controller
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

	private function ubahFormatNomor($nomor)
	{
		if ($nomor !== null) {
			// Hapus semua karakter selain angka
			$nomor = preg_replace("/[^0-9]/", "", $nomor);

			// Periksa apakah nomor dimulai dengan "0" dan panjangnya adalah 12 digit
			if (strlen($nomor) == 12 && substr($nomor, 0, 1) == '0') {
				// Ganti "0" di awal dengan "62"
				$nomor = '62' . substr($nomor, 1);
			}

			return $nomor;
		} else {
			return $nomor = '+628111127735';
		}
	}



	private function SENDINGWA($ISIPESAN, $WATUJUAN)
	{
		$this->load->model('M_WhatsApp');
		$Data003['SISTEM'] = $this->M_UserCek->APPNAME();
		foreach ($Data003['SISTEM'] as $DS3) {
			$NWA = $DS3->NomorWA;
			$NII = $DS3->NamaInstansi;
		}
		$where2 = array(
			'whatsapp_number' => $NWA,
			'status' => 'CONNECTED'
		);
		$Ambil = $this->M_WhatsApp->ReadDataSessionsConnectedBy($where2);
		$WACEK = '';
		if ($Ambil !== false) {
			foreach ($Ambil as $DWA) {
				$WA['whatsapp_number'] = $DWA->whatsapp_number;
				$WA['api_key'] = $DWA->api_key;
			}
			$url = 'https://whatsapp.' . str_replace('https://', '', base_url()) . 'api/send-message';
			$data = [
				"api_key" => $WA['api_key'],
				"receiver" => $this->ubahFormatNomor($WATUJUAN),
				"data" => [
					"message" => $ISIPESAN . $NII . "\n\n*_Pesan ini dibuat secara otomatis, anda tidak perlu membalas pesan ini_"
				]
			];
			$ch = curl_init($url);
			// Set pilihan cURL
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
			curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			// Eksekusi request
			$response = curl_exec($ch);
			// Tutup cURL session
			curl_close($ch);
			# code...
			$WACEK = true;
		} else {
			$WACEK = false;
		}
		// Kelola hasil respons
		// if ($response === FALSE) {
		//     $data 'Gagal melakukan permintaan ke API';
		// } else {
		//     echo 'Respon dari API: ' . $response;
		// }
		return $WACEK;
	}

	function Absensi($kelas = null, $tgl = null, $jampel = null)
	{
		// Memeriksa apakah pengguna telah login sebagai admin
		if ($this->session->userdata('Status') !== "Login") {
			redirect(base_url("User_login"));
		} else {
			if ($this->input->post('IDMapel')) {
				$data_session = array(
					'IDMapel' => $this->input->post('IDMapel')
				);
				$this->session->set_userdata($data_session);
			}
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
				'aktif' => 'Absensi'
			);


			// Mengambil data dari model untuk ditampilkan dalam tampilan
			$Data003['SISTEM'] = $this->M_UserCek->APPNAME();
			$Data003['HakAkses'] = $this->M_UserCek->DataHakakses();
			$Data003['IDHak'] = $this->session->userdata('IDHak');
			$Data004['ButuhTabel'] = TRUE;
			$Data003['Fitur'] = $this->M_UserCek->FiturSistem();
			$Data004['ButuhForm'] = TRUE;

			$where[0] = array(
				'jadwal_kelas_mapel.IDMapel' => $this->session->userdata('IDMapel'),
				'jadwal_kelas_mapel.IDGuru' => $this->session->userdata('IDGuru'),
				'jadwal_kelas_mapel.IDAjaran' => $this->session->userdata('IDAjaran')
			);
			$where[1] = array(
				'IDMapel' => $this->session->userdata('IDMapel')
			);
			$where[2] = array(
				'IDSemester' => $this->session->userdata('IDSemester')
			);
			$where[3] = array(
				'IDAjaran' => $this->session->userdata('IDAjaran')
			);

			$where1 = array(
				'tg.KodeGuru' => $this->session->userdata('KodeGuru'),
				'tg.UsrGuru' => $this->session->userdata('UsrGuru')
			);

			// Mengambil data dari model untuk ditampilkan dalam tampilan
			$content['MapelGuru'] = $this->M_UserCek->GuruMengajar($where1);
			$content['datatahun'] = $this->M_UserCek->AmbilTahun();
			$content['datakelas'] = $this->M_UserCek->ReadJadwalKelasMapelby($where[0]);
			$content['datatahunajaran'] = $this->M_UserCek->AmbilTahunAjaran();
			$content['datasemester'] = $this->M_UserCek->AmbilSemester();
			$content['dataHariJampel'] = $this->M_UserCek->ReadHariJam();


			$MapelPengajar = $this->M_UserCek->DataMataPelajaranCek($where[1]);
			if ($MapelPengajar !== false) {
				foreach ($MapelPengajar as $MP) {
					$content['NamaMapel'] = $MP->NamaMapel;
				}
			}

			$Semester = $this->M_UserCek->AmbilSemesterby($where[2]);
			if ($Semester !== false) {
				foreach ($Semester as $Sm) {
					$content['NamaSemester'] = $Sm->NamaSemester;
				}
			}

			$KodeAjaran = $this->M_UserCek->DataTahunAjaranWhere($where[3]);
			if ($KodeAjaran !== false) {
				foreach ($KodeAjaran as $KA) {
					$content['KodeAjaran'] = $KA->KodeAjaran;
				}
			}

			if ($this->input->post('AbsenData') && $this->input->post('AbsenData') == 'Kelas') {
				if ($this->input->post('IDMapel')) {
					$data_session = array(
						'IDMapel' => $this->input->post('IDMapel')
					);
					$this->session->set_userdata($data_session);
				}
				$DataGuruMasuk = array(
					'IDKelasMapel' => $this->input->post('IDKelasMapel'),
					'IDJamPel' => $this->input->post('IDJamPel'),
					'TglAbsensi' => $this->convertDate($this->input->post('TglAbsensi')),
					'IDGuru' => $this->session->userdata('IDGuru'),
					'JamAbsen' => date("H:i:s"),
					'IDSemester' => $this->session->userdata('IDSemester'),
					'IDAjaran' => $this->session->userdata('IDAjaran')
				);
				$this->M_UserCek->AbsenMasukGuru($DataGuruMasuk);
				$hitung = 0;
				$jumlahDataMasuk = 0;
				$DataMasuk = array();
				$Dmn = array();
				$MISA = array('M' => 0, 'I' => 0, 'S' => 0, 'A' => 0);

				foreach ($this->input->post() as $key => $value) {
					if ($hitung > 6) {
						$DataMasuk[$jumlahDataMasuk] = array(
							'NisSiswa' => $key,
							'MISA' => $value
						);
						$jumlahDataMasuk++;
					}
					$hitung++;
				}
				for ($i = 0; $i < count($DataMasuk); $i++) {
					$Dmn[$i]['IDKelasMapel'] = $this->input->post('IDKelasMapel');
					$Dmn[$i]['TglAbsensi'] = $this->convertDate($this->input->post('TglAbsensi'));
					$Dmn[$i]['NisSiswa'] = $DataMasuk[$i]['NisSiswa'];
					$Dmn[$i]['IDJamPel'] = $this->input->post('IDJamPel');
					$DataMasuk[$i]['IDKelasMapel'] = $this->input->post('IDKelasMapel');
					$DataMasuk[$i]['TglAbsensi'] = $this->convertDate($this->input->post('TglAbsensi'));
					$DataMasuk[$i]['IDJamPel'] = $this->input->post('IDJamPel');

					$CekAbsen = $this->M_UserCek->ReadAbsensi($Dmn[$i]);
					$Dmn2 = array('tb_siswa.NisSiswa' => $Dmn[$i]['NisSiswa']);
					$AmbilDataSiswa = $this->M_UserCek->getSiswaWithOrtuByArr($Dmn2);


					if ($CekAbsen == false) {
						if ($DataMasuk[$i]['MISA'] == 'M') {
							$MISA['M']++;
							$DataMasuk[$i]['JamMasuk'] = date("H:i:s");
						} elseif ($DataMasuk[$i]['MISA'] == 'I') {
							$MISA['I']++;
							$Pesan = "[PEMBERITAHUAN!!!]\nKepada Bapak/Ibu " . $AmbilDataSiswa[0]['NamaOrtu'] . ",\nKami ingin memberi tahu Anda bahwa \n*_" . $AmbilDataSiswa[0]['NamaSiswa'] . "_*\n tidak bisa mengikuti Kegiatan sekolah hari ini dikarenakan \n*_Ijin_*.\n Kami memastikan bahwa langkah-langkah yang diperlukan telah diambil dan akan memberi tahu Anda tentang perkembangan lebih lanjut.\n\nTerima kasih atas pemahaman dan kerjasama Anda.\n\nSalam,\n";
							$this->SENDINGWA($Pesan, $AmbilDataSiswa[0]['NomorHP']);
							$PesanWK = "<<<SISTEM PEMBERITAHUAN!!!>>>\nNama Siswa : \n*_" . $AmbilDataSiswa[0]['NamaSiswa'] . "_*\nKeterangan : \n*_Ijin_*\nTanggal : \n*_" . date("d-m-Y") . "_*\n\nSistem Notifikasi Wali Kelas ";
							$this->SENDINGWA($PesanWK, $AmbilDataSiswa[0]['NomorHPGuru']);
						} elseif ($DataMasuk[$i]['MISA'] == 'S') {
							$MISA['S']++;
							$Pesan = "[PEMBERITAHUAN!!!]\nKepada Bapak/Ibu " . $AmbilDataSiswa[0]['NamaOrtu'] . ",\nKami ingin memberi tahu Anda bahwa \n*_" . $AmbilDataSiswa[0]['NamaSiswa'] . "_*\n tidak bisa mengikuti Kegiatan sekolah hari ini dikarenakan \n*_Sakit_*.\n Kami memastikan bahwa langkah-langkah yang diperlukan telah diambil dan akan memberi tahu Anda tentang perkembangan lebih lanjut.\n\nTerima kasih atas pemahaman dan kerjasama Anda.\n\nSalam,\n";
							$this->SENDINGWA($Pesan, $AmbilDataSiswa[0]['NomorHP']);
							$PesanWK = "<<<SISTEM PEMBERITAHUAN!!!>>>\nNama Siswa : \n*_" . $AmbilDataSiswa[0]['NamaSiswa'] . "_*\nKeterangan : \n*_Sakit_*\nTanggal : \n*_" . date("d-m-Y") . "_*\n\nSistem Notifikasi Wali Kelas ";
							$this->SENDINGWA($PesanWK, $AmbilDataSiswa[0]['NomorHPGuru']);
						} elseif ($DataMasuk[$i]['MISA'] == 'A') {
							$MISA['A']++;
							$Pesan = "[PEMBERITAHUAN!!!]\nKepada Bapak/Ibu " . $AmbilDataSiswa[0]['NamaOrtu'] . ",\nKami ingin memberi tahu Anda bahwa \n*_" . $AmbilDataSiswa[0]['NamaSiswa'] . "_*\n tidak bisa mengikuti Kegiatan sekolah hari ini, saat ini siswa dinyatakan \n*_Tanpa Keterangan_*.\n Kami memastikan bahwa langkah-langkah yang diperlukan telah diambil dan akan memberi tahu Anda tentang perkembangan lebih lanjut.\n\nTerima kasih atas pemahaman dan kerjasama Anda.\n\nSalam,\n";
							$this->SENDINGWA($Pesan, $AmbilDataSiswa[0]['NomorHP']);
							$PesanWK = "<<<SISTEM PEMBERITAHUAN!!!>>>\nNama Siswa : \n*_" . $AmbilDataSiswa[0]['NamaSiswa'] . "_*\nKeterangan : \n*_Tanpa Keterangan_*\nTanggal : \n*_" . date("d-m-Y") . "_*\n\nSistem Notifikasi Wali Kelas ";
							$this->SENDINGWA($PesanWK, $AmbilDataSiswa[0]['NomorHPGuru']);
						}
						$this->M_UserCek->InsertAbsensi($DataMasuk[$i]);

					} else {
						if ($DataMasuk[$i]['MISA'] == 'M') {
							$MISA['M']++;

						} elseif ($DataMasuk[$i]['MISA'] == 'I') {
							$MISA['I']++;
							$DataMasuk[$i]['JamMasuk'] = null;
							$Pesan = "[PEMBERITAHUAN!!!]\nKepada Bapak/Ibu " . $AmbilDataSiswa[0]['NamaOrtu'] . ",\nKami ingin memberitahu Anda bahwa \n*_" . $AmbilDataSiswa[0]['NamaSiswa'] . "_*\n tidak hadir di sekolah karena \n*_Ijin_*.\n Terima kasih atas partisipasi dan kerjasama Anda dalam memastikan kehadiran siswa.\nJika ada pertanyaan lebih lanjut atau informasi yang perlu disampaikan, jangan ragu untuk menghubungi kami.\nTerima kasih,\n";
							$this->SENDINGWA($Pesan, $AmbilDataSiswa[0]['NomorHP']);
							$PesanWK = "<<<SISTEM PEMBERITAHUAN!!!>>>\nNama Siswa : \n*_" . $AmbilDataSiswa[0]['NamaSiswa'] . "_*\nKeterangan : \n*_Ijin_*\nTanggal : \n*_" . date("d-m-Y") . "_*\n\nSistem Notifikasi Wali Kelas ";
							$this->SENDINGWA($PesanWK, $AmbilDataSiswa[0]['NomorHPGuru']);
						} elseif ($DataMasuk[$i]['MISA'] == 'S') {
							$MISA['S']++;
							$DataMasuk[$i]['JamMasuk'] = null;
							$Pesan = "[PEMBERITAHUAN!!!]\nKepada Bapak/Ibu " . $AmbilDataSiswa[0]['NamaOrtu'] . ",\nKami ingin memberitahu Anda bahwa \n*_" . $AmbilDataSiswa[0]['NamaSiswa'] . "_*\n tidak hadir di sekolah karena \n*_Sakit_*.\n Terima kasih atas partisipasi dan kerjasama Anda dalam memastikan kehadiran siswa.\nJika ada pertanyaan lebih lanjut atau informasi yang perlu disampaikan, jangan ragu untuk menghubungi kami.\nTerima kasih,\n";
							$this->SENDINGWA($Pesan, $AmbilDataSiswa[0]['NomorHP']);
							$PesanWK = "<<<SISTEM PEMBERITAHUAN!!!>>>\nNama Siswa : \n*_" . $AmbilDataSiswa[0]['NamaSiswa'] . "_*\nKeterangan : \n*_Sakit_*\nTanggal : \n*_" . date("d-m-Y") . "_*\n\nSistem Notifikasi Wali Kelas ";
							$this->SENDINGWA($PesanWK, $AmbilDataSiswa[0]['NomorHPGuru']);
						} elseif ($DataMasuk[$i]['MISA'] == 'A') {
							$MISA['A']++;
							$DataMasuk[$i]['JamMasuk'] = null;
							$Pesan = "[PEMBERITAHUAN!!!]\nKepada Bapak/Ibu " . $AmbilDataSiswa[0]['NamaOrtu'] . ",\nKami ingin memberitahu Anda bahwa \n*_" . $AmbilDataSiswa[0]['NamaSiswa'] . "_*\n tidak hadir di sekolah saat ini siswa dinyatakan \n*_Tanpa Keterangan_*.\n Terima kasih atas partisipasi dan kerjasama Anda dalam memastikan kehadiran siswa.\nJika ada pertanyaan lebih lanjut atau informasi yang perlu disampaikan, jangan ragu untuk menghubungi kami.\nTerima kasih,\n";
							$this->SENDINGWA($Pesan, $AmbilDataSiswa[0]['NomorHP']);
							$PesanWK = "<<<SISTEM PEMBERITAHUAN!!!>>>\nNama Siswa : \n*_" . $AmbilDataSiswa[0]['NamaSiswa'] . "_*\nKeterangan : \n*_Tanpa Keterangan_*\nTanggal : \n*_" . date("d-m-Y") . "_*\n\nSistem Notifikasi Wali Kelas ";
							$this->SENDINGWA($PesanWK, $AmbilDataSiswa[0]['NomorHPGuru']);
						}
						$this->M_UserCek->UpdateAbsensi($Dmn[$i], $DataMasuk[$i]);
					}

				}

				$content['TampilkanData'] = TRUE;
				$where[4] = array('tb_kelas.KodeKelas' => $this->input->post('KodeKelas'));
				$content['DataSiswa'] = $this->M_UserCek->DataMuridAmbil($where[4]);
				$DataKelas = $this->M_UserCek->DataKelasWhereArr($where[4]);
				$where[5] = array(
					'jadwal_kelas_mapel.IDMapel' => $this->session->userdata('IDMapel'),
					'jadwal_kelas_mapel.IDGuru' => $this->session->userdata('IDGuru'),
					'jadwal_kelas_mapel.IDAjaran' => $this->session->userdata('IDAjaran'),
					'jadwal_kelas_mapel.IDKelas' => $DataKelas[0]['IDKelas']
				);
				$content['KelasMapel'] = $this->M_UserCek->ReadJadwalKelasMapelby($where[5]);
				$nang = array(
					'IDJamPel' => $this->input->post('IDJamPel'),
					'IDKelasMapel' => $this->input->post('IDKelasMapel'),
					'TglAbsensi' => $this->convertDate($this->input->post('TglAbsensi'))
				);
				$content['DataAbsenSiswa'] = $this->M_UserCek->ReadSiswaAbsensi($nang);
				$nang2 = array('IDJamPel' => $this->input->post('IDJamPel'));
				$content['JamPelajaran'] = $this->M_UserCek->AmbilJamPelajaranBy($nang2);
			}

			if ($this->input->post('AbsenData') !== null && $this->input->post('AbsenData') == 'Update') {
				if ($this->input->post('IDMapel')) {
					$data_session = array(
						'IDMapel' => $this->input->post('IDMapel')
					);
					$this->session->set_userdata($data_session);
				}
				$hitung = 0;
				$jumlahDataMasuk = 0;
				$DataMasuk = array();
				$Dmn = array();
				$MISA = array('M' => 0, 'I' => 0, 'S' => 0, 'A' => 0, );
				foreach ($this->input->post() as $key => $value) {
					if ($hitung > 5) {
						$DataMasuk = array(
							'NisSiswa' => $key,
							'MISA' => $value
						);
						$jumlahDataMasuk++;
					}
					$hitung++;
				}
				$Dmn['IDKelasMapel'] = $this->input->post('IDKelasMapel');
				$Dmn['TglAbsensi'] = $this->convertDate($this->input->post('TglAbsensi'));
				$Dmn['NisSiswa'] = $DataMasuk['NisSiswa'];
				$Dmn['IDJamPel'] = $this->input->post('IDJamPel');
				$DataMasuk['IDKelasMapel'] = $this->input->post('IDKelasMapel');
				$DataMasuk['TglAbsensi'] = $this->convertDate($this->input->post('TglAbsensi'));
				$CekAbsen = $this->M_UserCek->ReadAbsensiArr($Dmn);
				$Dmn2 = array('tb_siswa.NisSiswa' => $Dmn['NisSiswa']);
				$AmbilDataSiswa = $this->M_UserCek->getSiswaWithOrtuByArr($Dmn2);
				if ($DataMasuk['MISA'] == 'M') {
					$MISA['M']++;
					$DataMasuk['JamMasuk'] = date("H:i:s");
					$Pesan = "[PEMBERITAHUAN!!!]\nKepada Bapak/Ibu " . $AmbilDataSiswa[0]['NamaOrtu'] . ",\nKami ingin memberitahu Anda bahwa \n*_" . $AmbilDataSiswa[0]['NamaSiswa'] . "_*\n telah hadir di sekolah. Terima kasih atas partisipasi dan kerjasama Anda dalam memastikan kehadiran siswa.\nJika ada pertanyaan lebih lanjut atau informasi yang perlu disampaikan, jangan ragu untuk menghubungi kami.\nTerima kasih,\n";
					$this->SENDINGWA($Pesan, $AmbilDataSiswa[0]['NomorHP']);
					$PesanWK = "<<<SISTEM PEMBERITAHUAN!!!>>>\nNama Siswa : \n*_" . $AmbilDataSiswa[0]['NamaSiswa'] . "_*\nKeterangan : \n*_Telah Masuk_*\nTanggal : \n*_" . date("d-m-Y") . "_*\n\nSistem Notifikasi Wali Kelas ";
					$this->SENDINGWA($PesanWK, $AmbilDataSiswa[0]['NomorHPGuru']);
				} elseif ($DataMasuk['MISA'] == 'I') {
					$MISA['I']++;
					$DataMasuk['JamMasuk'] = null;
					$Pesan = "[PEMBERITAHUAN!!!]\nKepada Bapak/Ibu " . $AmbilDataSiswa[0]['NamaOrtu'] . ",\nKami ingin memberitahu Anda bahwa \n*_" . $AmbilDataSiswa[0]['NamaSiswa'] . "_*\n tidak hadir di sekolah karena \n*_Ijin_*.\n Terima kasih atas partisipasi dan kerjasama Anda dalam memastikan kehadiran siswa.\nJika ada pertanyaan lebih lanjut atau informasi yang perlu disampaikan, jangan ragu untuk menghubungi kami.\nTerima kasih,\n";
					$this->SENDINGWA($Pesan, $AmbilDataSiswa[0]['NomorHP']);
					$PesanWK = "<<<SISTEM PEMBERITAHUAN!!!>>>\nNama Siswa : \n*_" . $AmbilDataSiswa[0]['NamaSiswa'] . "_*\nKeterangan : \n*_Ijin_*\nTanggal : \n*_" . date("d-m-Y") . "_*\n\nSistem Notifikasi Wali Kelas ";
					$this->SENDINGWA($PesanWK, $AmbilDataSiswa[0]['NomorHPGuru']);
				} elseif ($DataMasuk['MISA'] == 'S') {
					$MISA['S']++;
					$DataMasuk['JamMasuk'] = null;
					$Pesan = "[PEMBERITAHUAN!!!]\nKepada Bapak/Ibu " . $AmbilDataSiswa[0]['NamaOrtu'] . ",\nKami ingin memberitahu Anda bahwa \n*_" . $AmbilDataSiswa[0]['NamaSiswa'] . "_*\n tidak hadir di sekolah karena \n*_Sakit_*.\n Terima kasih atas partisipasi dan kerjasama Anda dalam memastikan kehadiran siswa.\nJika ada pertanyaan lebih lanjut atau informasi yang perlu disampaikan, jangan ragu untuk menghubungi kami.\nTerima kasih,\n";
					$this->SENDINGWA($Pesan, $AmbilDataSiswa[0]['NomorHP']);
					$PesanWK = "<<<SISTEM PEMBERITAHUAN!!!>>>\nNama Siswa : \n*_" . $AmbilDataSiswa[0]['NamaSiswa'] . "_*\nKeterangan : \n*_Sakit_*\nTanggal : \n*_" . date("d-m-Y") . "_*\n\nSistem Notifikasi Wali Kelas ";
					$this->SENDINGWA($PesanWK, $AmbilDataSiswa[0]['NomorHPGuru']);
				} elseif ($DataMasuk['MISA'] == 'A') {
					$MISA['A']++;
					$DataMasuk['JamMasuk'] = null;
					$Pesan = "[PEMBERITAHUAN!!!]\nKepada Bapak/Ibu " . $AmbilDataSiswa[0]['NamaOrtu'] . ",\nKami ingin memberitahu Anda bahwa \n*_" . $AmbilDataSiswa[0]['NamaSiswa'] . "_*\n Untuk saat ini sistem kami menyatakan \n*_Tanpa Keterangan_*.\n Terima kasih atas partisipasi dan kerjasama Anda dalam memastikan kehadiran siswa.\nJika ada pertanyaan lebih lanjut atau informasi yang perlu disampaikan, jangan ragu untuk menghubungi kami.\nTerima kasih,\n";
					$this->SENDINGWA($Pesan, $AmbilDataSiswa[0]['NomorHP']);
					$PesanWK = "<<<SISTEM PEMBERITAHUAN!!!>>>\nNama Siswa : \n*_" . $AmbilDataSiswa[0]['NamaSiswa'] . "_*\nKeterangan : \n*_Tanpa Keterangan_*\nTanggal : \n*_" . date("d-m-Y") . "_*\n\nSistem Notifikasi Wali Kelas ";
					$this->SENDINGWA($PesanWK, $AmbilDataSiswa[0]['NomorHPGuru']);
				}

				$this->M_UserCek->UpdateAbsensi($Dmn, $DataMasuk);

				$content['TampilkanData'] = TRUE;
				$where[4] = array('tb_kelas.KodeKelas' => $this->input->post('KodeKelas'));
				$content['DataSiswa'] = $this->M_UserCek->DataMuridAmbil($where[4]);
				$DataKelas = $this->M_UserCek->DataKelasWhereArr($where[4]);
				$where[5] = array(
					'jadwal_kelas_mapel.IDMapel' => $this->session->userdata('IDMapel'),
					'jadwal_kelas_mapel.IDGuru' => $this->session->userdata('IDGuru'),
					'jadwal_kelas_mapel.IDAjaran' => $this->session->userdata('IDAjaran'),
					'jadwal_kelas_mapel.IDKelas' => $DataKelas[0]['IDKelas']
				);
				$content['KelasMapel'] = $this->M_UserCek->ReadJadwalKelasMapelby($where[5]);
				$nang = array(
					'IDJamPel' => $this->input->post('IDJamPel'),
					'IDKelasMapel' => $this->input->post('IDKelasMapel'),
					'TglAbsensi' => $this->convertDate($this->input->post('TglAbsensi'))
				);
				$content['DataAbsenSiswa'] = $this->M_UserCek->ReadSiswaAbsensi($nang);
				$nang2 = array('IDJamPel' => $this->input->post('IDJamPel'));
				$content['JamPelajaran'] = $this->M_UserCek->AmbilJamPelajaranBy($nang2);
			}

			if ($this->input->post('CariData') && $this->input->post('CariData') == 'Kelas') {
				$data_session = array(
					'IDMapel' => $this->input->post('IDMapel')
				);

				$content['TampilkanData'] = TRUE;
				$where[4] = array('tb_kelas.KodeKelas' => $this->input->post('KodeKelas'));
				$content['DataSiswa'] = $this->M_UserCek->DataMuridAmbil($where[4]);
				$DataKelas = $this->M_UserCek->DataKelasWhereArr($where[4]);
				$where[5] = array(
					'jadwal_kelas_mapel.IDMapel' => $this->input->post('IDMapel'),
					'jadwal_kelas_mapel.IDGuru' => $this->session->userdata('IDGuru'),
					'jadwal_kelas_mapel.IDAjaran' => $this->session->userdata('IDAjaran'),
					'jadwal_kelas_mapel.IDKelas' => $DataKelas[0]['IDKelas']
				);
				$content['KelasMapel'] = $this->M_UserCek->ReadJadwalKelasMapelby($where[5]);
				foreach ($content['KelasMapel'] as $key) {
					$IDKelasMapel = $key->IDKelasMapel;
				}
				$nang = array(
					'IDJamPel' => $this->input->post('IDJamPel'),
					'IDKelasMapel' => $IDKelasMapel,
					'TglAbsensi' => $this->convertDate($this->input->post('TglAbsensi'))
				);
				$content['DataAbsenSiswa'] = $this->M_UserCek->ReadSiswaAbsensi($nang);
				$nang2 = array('IDJamPel' => $this->input->post('IDJamPel'));
				$content['JamPelajaran'] = $this->M_UserCek->AmbilJamPelajaranBy($nang2);

			}

			// Memuat tampilan template dan komponen tampilan
			$this->load->view('halaman/template/001', $Data004);
			$this->load->view('halaman/template/002(UPPER)', $Data002);
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003);

			// Memuat tampilan view untuk daftar absensi
			$this->load->view('halaman/content/halamanSistem/pengajar/tabelabsensi', $content);
			// Memuat tampilan view footer
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004);
		}
	}
	public function AbsensiKelasServerSide()
	{
		// Ambil nilai IDMapel, IDGuru, dan IDAjaran dari permintaan POST
		$IDMapel = $this->input->post('IDMapel');
		$IDGuru = $this->encryption->decrypt($this->input->post('IDGuru'));
		$IDAjaran = $this->encryption->decrypt($this->input->post('IDAjaran'));

		// Set array where sesuai dengan nilai-nilai yang didapat dari POST
		$where = array(
			'jadwal_kelas_mapel.IDMapel' => $IDMapel,
			'jadwal_kelas_mapel.IDGuru' => $IDGuru,
			'jadwal_kelas_mapel.IDAjaran' => $IDAjaran
		);

		// Panggil model untuk membaca data kelas
		$Data = $this->M_UserCek->ReadJadwalKelasMapelby($where);

		// Kembalikan data dalam format JSON
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($Data));
	}
	function AbsensiExcellDownload($fungsi = null)
	{
		if ($fungsi == 'Review') {

		}

	}

	function AbsensiJurnal($kelas = null, $tgl = null, $jampel = null)
	{
		// Memeriksa apakah pengguna telah login sebagai admin
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
				'aktif' => 'Absensi'
			);

			// Mengambil data dari model untuk ditampilkan dalam tampilan
			$Data003['SISTEM'] = $this->M_UserCek->APPNAME();
			$Data003['IDHak'] = $this->session->userdata('IDHak');
			$Data003['HakAkses'] = $this->M_UserCek->DataHakakses();
			$Data003['Fitur'] = $this->M_UserCek->FiturSistem();
			$Data004['ButuhTabel'] = TRUE;
			$Data004['ButuhForm'] = TRUE;

			$where[0] = array(
				'jadwal_kelas_mapel.IDMapel' => $this->session->userdata('IDMapel'),
				'jadwal_kelas_mapel.IDGuru' => $this->session->userdata('IDGuru'),
				'jadwal_kelas_mapel.IDAjaran' => $this->session->userdata('IDAjaran')
			);
			$where[1] = array(
				'IDMapel' => $this->session->userdata('IDMapel')
			);
			$where[2] = array(
				'IDSemester' => $this->session->userdata('IDSemester')
			);
			$where[3] = array(
				'IDAjaran' => $this->session->userdata('IDAjaran')
			);

			// Mengambil data dari model untuk ditampilkan dalam tampilan
			$content['datatahun'] = $this->M_UserCek->AmbilTahun();
			$content['datakelas'] = $this->M_UserCek->ReadJadwalKelasMapelby($where[0]);
			$content['datatahunajaran'] = $this->M_UserCek->AmbilTahunAjaran();
			$content['datasemester'] = $this->M_UserCek->AmbilSemester();
			$content['dataHariJampel'] = $this->M_UserCek->ReadHariJam();

			// print_r($this->session->userdata());

			$MapelPengajar = $this->M_UserCek->DataMataPelajaranCek($where[1]);
			foreach ($MapelPengajar as $MP) {
				$content['NamaMapel'] = $MP->NamaMapel;
			}
			$Semester = $this->M_UserCek->AmbilSemesterby($where[2]);
			foreach ($Semester as $Sm) {
				$content['NamaSemester'] = $Sm->NamaSemester;
			}
			$KodeAjaran = $this->M_UserCek->DataTahunAjaranWhere($where[3]);
			foreach ($KodeAjaran as $KA) {
				$content['KodeAjaran'] = $KA->KodeAjaran;
			}

			if ($this->input->post('CariData') !== null && $this->input->post('CariData') == 'Jurnal') {
				$data_session = array(
					'IDMapel' => $this->input->post('IDMapel')
				);
				$this->session->set_userdata($data_session);
				$DMN[0] = array('tb_kelas.KodeKelas' => $this->input->post('KodeKelas'));
				$DATAKelas = $this->M_UserCek->DataKelasWhereArr($DMN[0]);
				$DMN[1] = array(
					'IDKelasMapel' => $this->input->post('IDKelasMapel'),
					'IDGuru' => $this->session->userdata('IDGuru'),
					'IDAjaran' => $this->session->userdata('IDAjaran'),
					'IDSemester' => $this->session->userdata('IDSemester'),
					'IDJamPel' => $this->input->post('IDJamPel'),
					'IDKelas' => $DATAKelas[0]['IDKelas'],
					'IDMapel' => $this->session->userdata('IDMapel'),
					'TanggalJurnal' => $this->convertDate($this->input->post('TglAbsensi'))
				);
				// print_r($DMN[1]);
				$content['TampilkanJurnal'] = $this->M_UserCek->ReadJurnalGuru($DMN[1]);
				$content['TampilkanData'] = TRUE;
				$where[4] = array('tb_kelas.KodeKelas' => $this->input->post('KodeKelas'));
				$content['DataSiswa'] = $this->M_UserCek->DataMuridAmbil($where[4]);
				$DataKelas = $this->M_UserCek->DataKelasWhereArr($where[4]);
				$where[5] = array(
					'jadwal_kelas_mapel.IDMapel' => $this->session->userdata('IDMapel'),
					'jadwal_kelas_mapel.IDGuru' => $this->session->userdata('IDGuru'),
					'jadwal_kelas_mapel.IDAjaran' => $this->session->userdata('IDAjaran'),
					'jadwal_kelas_mapel.IDKelas' => $DataKelas[0]['IDKelas']
				);

				$content['KelasMapel'] = $this->M_UserCek->ReadJadwalKelasMapelby($where[5]);
				foreach ($content['KelasMapel'] as $key) {
					$IDKelasMapel = $key->IDKelasMapel;
				}
				$nang = array(
					'IDJamPel' => $this->input->post('IDJamPel'),
					'IDKelasMapel' => $IDKelasMapel,
					'TglAbsensi' => $this->convertDate($this->input->get('TglAbsensi'))
				);
				$content['DataAbsenSiswa'] = $this->M_UserCek->ReadSiswaAbsensi($nang);
				$nang2 = array('IDJamPel' => $this->input->post('IDJamPel'));
				$content['JamPelajaran'] = $this->M_UserCek->AmbilJamPelajaranBy($nang2);
			}

			if ($this->input->post('JurnalData') != null && $this->input->post('JurnalData') == 'Masuk') {

				// Konfigurasi unggahan file
				$config['upload_path'] = './file/data/gambar/laporanjurnal/';
				$config['allowed_types'] = 'png|jpg|jpeg';
				$config['max_size'] = 4096;
				$config['overwrite'] = true;
				$config['file_name'] = $this->session->userdata('IDGuru') . $_POST['IDJamPel'] . $this->convertDate($this->input->post('TglAbsensi')) . time();
				$config['encrypt_name'] = true;
				$this->load->library('upload', $config);
				if ($this->upload->do_upload('KendalaFoto') && $this->upload->do_upload('PenyelesaianFoto')) {
					if ($this->upload->do_upload('KendalaFoto')) {
						// Mengonversi gambar ke format JPG
						$upload_data[0] = $this->upload->data();
						$Foto1 = true;

					} else {
						$Foto1 = false;
					}

					if ($this->upload->do_upload('PenyelesaianFoto')) {
						$upload_data[1] = $this->upload->data();
						$Foto2 = true;

					} else {
						$Foto2 = false;
					}

					if ($Foto1 == true && $Foto2 == true) {
						$Sing[0] = array('tb_kelas.KodeKelas' => $_POST['KodeKelas']);
						$AmbilKelas = $this->M_UserCek->DataKelasWhereArr($Sing[0]);
						$Sing[1] = array(
							'IDKelasMapel' => $_POST['IDKelasMapel'],
							'IDGuru' => $this->session->userdata('IDGuru'),
							'IDAjaran' => $this->session->userdata('IDAjaran'),
							'IDSemester' => $this->session->userdata('IDSemester'),
							'IDJamPel' => $_POST['IDJamPel'],
							'IDKelas' => $AmbilKelas[0]['IDKelas'],
							'IDMapel' => $this->session->userdata('IDMapel'),
							'TanggalJurnal' => $this->convertDate($this->input->post('TglAbsensi'))
						);
						$CekData = $this->M_UserCek->ReadJurnalGuru($Sing[1]);
						$DataMasuk = array(
							'IDKelasMapel' => $this->input->post('IDKelasMapel'),
							'IDGuru' => $this->session->userdata('IDGuru'),
							'IDAjaran' => $this->session->userdata('IDAjaran'),
							'IDSemester' => $this->session->userdata('IDSemester'),
							'IDJamPel' => $this->input->post('IDJamPel'),
							'IDKelas' => $AmbilKelas[0]['IDKelas'],
							'IDMapel' => $this->session->userdata('IDMapel'),
							'KendalaFoto' => $upload_data[0]['file_name'],
							'PenyelesaianFoto' => $upload_data[1]['file_name'],
							'TanggalJurnal' => $this->convertDate($this->input->post('TglAbsensi')),
							'KendalaKet' => $this->input->post('KendalaKeterangan'),
							'PenyelesaianKet' => $this->input->post('PenyelesaianKeterangan'),
							'MateriPokok' => $this->input->post('MateriPokok'),
							'InPenKom' => $this->input->post('InPenKom'),
							'Kegiatan' => $this->input->post('Kegiatan'),
							'Penilaian' => $this->input->post('Penilaian'),
							'TindakLanjut' => $this->input->post('TindakLanjut')
						);
						if ($CekData == false) {
							$this->M_UserCek->InsertJurnalGuru($DataMasuk);
						} else {
							foreach ($CekData as $CD) {
								$YoIki = array('IDJurnal' => $CD->IDJurnal);
								if (!is_dir('./file/data/gambar/laporanjurnal/' . $CD->KendalaFoto)) {
									if (file_exists('./file/data/gambar/laporanjurnal/' . $CD->KendalaFoto)) {
										unlink('./file/data/gambar/laporanjurnal/' . $CD->KendalaFoto);
									}
								}
								if (!is_dir('./file/data/gambar/laporanjurnal/' . $CD->PenyelesaianFoto)) {
									if (file_exists('./file/data/gambar/laporanjurnal/' . $CD->PenyelesaianFoto)) {
										unlink('./file/data/gambar/laporanjurnal/' . $CD->PenyelesaianFoto);
									}
								}
							}
							$this->M_UserCek->UpdateJurnalGuru($YoIki, $DataMasuk);
						}
					} else {
						if ($Foto1 == false) {
							unlink($upload_data[1]['full_path']);
							$this->session->set_flashdata('toastr_warning', 'Foto/gambar kendala tidak benar!');
						}
						if ($Foto2 == false) {
							unlink($upload_data[0]['full_path']);
							$this->session->set_flashdata('toastr_warning', 'Foto/gambar Penyelesaian tidak benar!');
						}
					}
				} else {
					$Sing[0] = array('tb_kelas.KodeKelas' => $this->input->post('KodeKelas'));
					$AmbilKelas = $this->M_UserCek->DataKelasWhereArr($Sing[0]);
					$Sing[1] = array(
						'IDKelasMapel' => $this->input->post('IDKelasMapel'),
						'IDGuru' => $this->session->userdata('IDGuru'),
						'IDSemester' => $this->session->userdata('IDSemester'),
						'IDAjaran' => $this->session->userdata('IDAjaran'),
						'IDJamPel' => $this->input->post('IDJamPel'),
						'IDKelas' => $AmbilKelas[0]['IDKelas'],
						'IDMapel' => $this->session->userdata('IDMapel'),
						'TanggalJurnal' => $this->convertDate($this->input->post('TglAbsensi')),
					);
					$CekData = $this->M_UserCek->ReadJurnalGuru($Sing[1]);
					$DataMasuk = array(
						'IDKelasMapel' => $this->input->post('IDKelasMapel'),
						'IDGuru' => $this->session->userdata('IDGuru'),
						'IDSemester' => $this->session->userdata('IDSemester'),
						'IDAjaran' => $this->session->userdata('IDAjaran'),
						'IDJamPel' => $this->input->post('IDJamPel'),
						'IDKelas' => $AmbilKelas[0]['IDKelas'],
						'IDMapel' => $this->session->userdata('IDMapel'),
						'KendalaFoto' => null,
						'PenyelesaianFoto' => null,
						'TanggalJurnal' => $this->convertDate($this->input->post('TglAbsensi')),
						'KendalaKet' => $this->input->post('KendalaKeterangan'),
						'PenyelesaianKet' => $this->input->post('PenyelesaianKeterangan'),
						'MateriPokok' => $this->input->post('MateriPokok'),
						'InPenKom' => $this->input->post('InPenKom'),
						'Kegiatan' => $this->input->post('Kegiatan'),
						'Penilaian' => $this->input->post('Penilaian'),
						'TindakLanjut' => $this->input->post('TindakLanjut')
					);
					if ($CekData == false) {
						$this->M_UserCek->InsertJurnalGuru($DataMasuk);
					} else {
						foreach ($CekData as $CD) {
							$YoIki = array('IDJurnal' => $CD->IDJurnal);
							if ($CD->KendalaFoto !== null || $CD->KendalaFoto !== '') {
								if (!is_dir('./file/data/gambar/laporanjurnal/' . $CD->KendalaFoto)) {
									if (file_exists('./file/data/gambar/laporanjurnal/' . $CD->KendalaFoto)) {
										unlink('./file/data/gambar/laporanjurnal/' . $CD->KendalaFoto);
									}
								}
							}

							if ($CD->PenyelesaianFoto !== null || $CD->PenyelesaianFoto !== '') {
								if (!is_dir('./file/data/gambar/laporanjurnal/' . $CD->PenyelesaianFoto)) {
									if (file_exists('./file/data/gambar/laporanjurnal/' . $CD->PenyelesaianFoto)) {
										unlink('./file/data/gambar/laporanjurnal/' . $CD->PenyelesaianFoto);
									}
								}
							}
						}
						$this->M_UserCek->UpdateJurnalGuru($YoIki, $DataMasuk);
					}
				}

				$DMN[0] = array('tb_kelas.KodeKelas' => $this->input->post('KodeKelas'));
				$DATAKelas = $this->M_UserCek->DataKelasWhereArr($DMN[0]);
				$DMN[1] = array(
					'IDKelasMapel' => $_POST['IDKelasMapel'],
					'IDGuru' => $this->session->userdata('IDGuru'),
					'IDSemester' => $this->session->userdata('IDSemester'),
					'IDAjaran' => $this->session->userdata('IDAjaran'),
					'IDJamPel' => $_POST['IDJamPel'],
					'IDKelas' => $DATAKelas[0]['IDKelas'],
					'IDMapel' => $this->session->userdata('IDMapel')
				);
				$content['TampilkanJurnal'] = $this->M_UserCek->ReadJurnalGuru($DMN[1]);
				$content['TampilkanData'] = TRUE;
				$where[4] = array('tb_kelas.KodeKelas' => $_POST['KodeKelas']);
				$content['DataSiswa'] = $this->M_UserCek->DataMuridAmbil($where[4]);
				$DataKelas = $this->M_UserCek->DataKelasWhereArr($where[4]);
				$where[5] = array(
					'jadwal_kelas_mapel.IDMapel' => $this->session->userdata('IDMapel'),
					'jadwal_kelas_mapel.IDGuru' => $this->session->userdata('IDGuru'),
					'jadwal_kelas_mapel.IDAjaran' => $this->session->userdata('IDAjaran'),
					'jadwal_kelas_mapel.IDKelas' => $DataKelas[0]['IDKelas']
				);
				$content['KelasMapel'] = $this->M_UserCek->ReadJadwalKelasMapelby($where[5]);
				foreach ($content['KelasMapel'] as $key) {
					$IDKelasMapel = $key->IDKelasMapel;
				}
				$nang = array(
					'IDJamPel' => $_POST['IDJamPel'],
					'IDKelasMapel' => $IDKelasMapel,
					'TglAbsensi' => $this->convertDate($_POST['TglAbsensi'])
				);
				$content['DataAbsenSiswa'] = $this->M_UserCek->ReadSiswaAbsensi($nang);
				$nang2 = array('IDJamPel' => $this->input->post('IDJamPel'));
				$content['JamPelajaran'] = $this->M_UserCek->AmbilJamPelajaranBy($nang2);
			}


			// Memuat tampilan template dan komponen tampilan
			$this->load->view('halaman/template/001', $Data004);
			$this->load->view('halaman/template/002(UPPER)', $Data002);
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003);

			// Memuat tampilan view untuk daftar absensi
			$this->load->view('halaman/content/halamanSistem/pengajar/tabelabsensi_Jurnal', $content);
			// Memuat tampilan view footer
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004);
		}
	}
	function JurnalDownloadReview($fungsi = null)
	{
		if ($fungsi == 'Review') {
			$this->load->model('M_ExportImport');
			$IDGuru = $this->encryption->decrypt($this->input->get('IDGuru'));
			$IDSemester = $this->encryption->decrypt($this->input->get('IDSemester'));
			$IDAjaran = $this->encryption->decrypt($this->input->get('IDAjaran'));
			$IDMapel = $this->encryption->decrypt($this->input->get('IDMapel'));
			$IDKelas = $this->encryption->decrypt($this->input->get('IDKelas'));
			$IDJurnal = $this->encryption->decrypt($this->input->get('IDJurnal'));
			$IDJamPel = $this->encryption->decrypt($this->input->get('IDJamPel'));
			$where[0] = array(
				'tg.IDGuru' => $IDGuru,
				'tm.IDMapel' => $IDMapel
			);
			$where[1] = array(
				'IDKelas' => $IDKelas
			);
			$where[2] = array(
				'IDSemester' => $IDSemester
			);
			$where[3] = array(
				'IDAjaran' => $IDAjaran
			);
			$where[4] = array(
				'jurnal_guru_mapel.IDGuru' => $IDGuru,
				'jurnal_guru_mapel.IDSemester' => $IDSemester,
				'jurnal_guru_mapel.IDAjaran' => $IDAjaran,
				'jadwal_kelas_mapel.IDMapel' => $IDMapel,
				'jadwal_kelas_mapel.IDKelas' => $IDKelas,
				'jurnal_guru_mapel.IDJurnal' => $IDJurnal
			);
			$where[5] = array(
				'jkm.IDGuru' => $IDGuru,
				'jkm.IDAjaran' => $IDAjaran,
				'jkm.IDMapel' => $IDMapel,
				'jkm.IDKelas' => $IDKelas,
				'asm.IDJamPel' => $IDJamPel
			);
			$content['APPNAME'] = $this->M_ExportImport->APPNAMEarr();
			$content['DataGuru'] = $this->M_ExportImport->GuruMengajar($where[0]);
			$content['DataKelas'] = $this->M_ExportImport->DataKelasWhere($where[1]);
			$content['DataSemester'] = $this->M_UserCek->AmbilSemesterby($where[2]);
			$content['DataAjaran'] = $this->M_UserCek->DataTahunAjaranWhere($where[3]);
			$content['DataJurnal'] = $this->M_UserCek->ReadJurnalGuruBy($where[4]);
			$content['DataAbsenJurnal'] = $this->M_UserCek->JurnalAbsensiGuru($where[5]);
			$content['Fitur'] = array(
				'Waktu' => 'Nyala',
				'JamKe' => 'Nyala'
			);
			// print_r($where[5]);
			// print_r($content['DataKelas']);
			// print_r($content['DataAbsenJurnal']);
			$this->load->view('halaman/content/halamanSistem/pengajar/Jurnal/JurnalGuruPDFReview', $content);
		}

	}

	function Penilaian()
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
				'aktif' => 'Penilaian'
			);

			// Mengambil data dari model untuk ditampilkan dalam tampilan
			$Data003['Fitur'] = $this->M_UserCek->FiturSistem();
			$Data003['HakAkses'] = $this->M_UserCek->DataHakakses();
			$Data003['SISTEM'] = $this->M_UserCek->APPNAME();
			$Data003['IDHak'] = $this->session->userdata('IDHak');
			$Data004['ButuhTabel'] = TRUE;
			$Data004['ButuhForm'] = TRUE;

			$where[0] = array(
				'jadwal_kelas_mapel.IDMapel' => $this->session->userdata('IDMapel'),
				'jadwal_kelas_mapel.IDGuru' => $this->session->userdata('IDGuru'),
				'jadwal_kelas_mapel.IDAjaran' => $this->session->userdata('IDAjaran')
			);
			$where[1] = array(
				'IDMapel' => $this->session->userdata('IDMapel')
			);
			$where[2] = array(
				'IDSemester' => $this->session->userdata('IDSemester')
			);
			$where[3] = array(
				'IDAjaran' => $this->session->userdata('IDAjaran')
			);


			// Mengambil data dari model untuk ditampilkan dalam tampilan
			$content['datatahun'] = $this->M_UserCek->AmbilTahun();
			$content['datakelas'] = $this->M_UserCek->ReadJadwalKelasMapelby($where[0]);
			$content['datatahunajaran'] = $this->M_UserCek->AmbilTahunAjaran();
			$content['datasemester'] = $this->M_UserCek->AmbilSemester();


			$MapelPengajar = $this->M_UserCek->DataMataPelajaranCek($where[1]);
			if ($MapelPengajar !== false) {
				foreach ($MapelPengajar as $MP) {
					$content['NamaMapel'] = $MP->NamaMapel;
				}
			}
			$Semester = $this->M_UserCek->AmbilSemesterby($where[2]);
			if ($Semester !== false) {
				foreach ($Semester as $Sm) {
					$content['NamaSemester'] = $Sm->NamaSemester;
				}
			}
			$KodeAjaran = $this->M_UserCek->DataTahunAjaranWhere($where[3]);
			if ($KodeAjaran !== false) {
				foreach ($KodeAjaran as $KA) {
					$content['KodeAjaran'] = $KA->KodeAjaran;
				}
			}


			// Cari Data Kelas
			if ($this->input->post('CariData') != null && $this->input->post('CariData') == 'Kelas') {
				$content['TampilkanData'] = TRUE;
				$where[4] = array('tb_kelas.KodeKelas' => $this->input->post('KodeKelas'));
				$content['DataSiswa'] = $this->M_UserCek->DataMuridAmbil($where[4]);
				$DataKelas = $this->M_UserCek->DataKelasWhereArr($where[4]);
				$where[5] = array(
					'jadwal_kelas_mapel.IDMapel' => $this->session->userdata('IDMapel'),
					'jadwal_kelas_mapel.IDGuru' => $this->session->userdata('IDGuru'),
					'jadwal_kelas_mapel.IDAjaran' => $this->session->userdata('IDAjaran'),
					'jadwal_kelas_mapel.IDKelas' => $DataKelas[0]['IDKelas']
				);
				$where[6] = array(
					'jadwal_kelas_mapel.IDMapel' => $this->session->userdata('IDMapel'),
					'jadwal_kelas_mapel.IDGuru' => $this->session->userdata('IDGuru'),
					'jadwal_kelas_mapel.IDAjaran' => $this->session->userdata('IDAjaran'),
					'nilai_mapel_hari.IDSemester' => $this->session->userdata('IDSemester'),
					'jadwal_kelas_mapel.IDKelas' => $DataKelas[0]['IDKelas']
				);
				$where[7] = array(
					'jadwal_kelas_mapel.IDMapel' => $this->session->userdata('IDMapel'),
					'jadwal_kelas_mapel.IDGuru' => $this->session->userdata('IDGuru'),
					'nilai_mapel.IDSemester' => $this->session->userdata('IDSemester'),
					'jadwal_kelas_mapel.IDAjaran' => $this->session->userdata('IDAjaran'),
					'jadwal_kelas_mapel.IDKelas' => $DataKelas[0]['IDKelas']
				);
				$content['KelasMapel'] = $this->M_UserCek->ReadJadwalKelasMapelby($where[5]);
				$content['KelasMapelNilai'] = $this->M_UserCek->ReadNilaiBy($where[5]);
				$content['NilaiHari'] = $this->M_UserCek->ReadNilaHari($where[6]);
				$content['KelasMapelNilaiSiswa'] = $this->M_UserCek->ReadNilaHariSiswa($where[6]);
				$content['NilaiMapelSiswa'] = $this->M_UserCek->ReadNilaiSiswa($where[7]);
			}


			// Insert Nilai Kelas
			if ($this->input->post('InsertNilaiKelas') != null && $this->input->post('InsertNilaiKelas') == 'Masuk') {
				$DataMasuk = array();
				if ($this->input->post('NisSiswa') != null && count($this->input->post('NisSiswa')) > 0) {
					for ($i = 0; $i < count($this->input->post('NisSiswa')); $i++) {
						$DataMasuk[$i] = array(
							'NisSiswa' => $_POST['NisSiswa'][$i],
							'NilaiUTS' => $_POST['nilaiUTS'][$i],
							'NilaiUAS' => $_POST['nilaiUAS'][$i],
							'NilaiHarian' => $_POST['NilaiHari'][$i],
							'IDKelasMapel' => $_POST['IDKelasMapel'],
							'IDSemester' => $this->session->userdata('IDSemester')
						);
						$Nangndi[$i] = array(
							'nilai_mapel.NisSiswa' => $_POST['NisSiswa'][$i],
							'nilai_mapel.IDKelasMapel' => $_POST['IDKelasMapel'],
							'nilai_mapel.IDSemester' => $this->session->userdata('IDSemester')
						);
						$CekData = $this->M_UserCek->ReadNilaiSiswa($Nangndi[$i]);
						if ($CekData == false) {
							$this->M_UserCek->InsertNilaiSiswa($DataMasuk[$i]);
						} elseif ($CekData !== false) {
							$Nangndi2[$i] = array(
								'NisSiswa' => $_POST['NisSiswa'][$i],
								'IDKelasMapel' => $_POST['IDKelasMapel'],
								'IDSemester' => $this->session->userdata('IDSemester')
							);
							$this->M_UserCek->UpdateNilaiSiswa($Nangndi2[$i], $DataMasuk[$i]);
						}
					}
				}
				$content['TampilkanData'] = TRUE;
				$where[4] = array('tb_kelas.KodeKelas' => $_POST['KodeKelas']);
				$content['DataSiswa'] = $this->M_UserCek->DataMuridAmbil($where[4]);
				$DataKelas = $this->M_UserCek->DataKelasWhereArr($where[4]);
				$where[5] = array(
					'jadwal_kelas_mapel.IDMapel' => $this->session->userdata('IDMapel'),
					'jadwal_kelas_mapel.IDGuru' => $this->session->userdata('IDGuru'),
					'jadwal_kelas_mapel.IDAjaran' => $this->session->userdata('IDAjaran'),
					'jadwal_kelas_mapel.IDKelas' => $DataKelas[0]['IDKelas']
				);
				$where[6] = array(
					'jadwal_kelas_mapel.IDMapel' => $this->session->userdata('IDMapel'),
					'jadwal_kelas_mapel.IDGuru' => $this->session->userdata('IDGuru'),
					'nilai_mapel_hari.IDSemester' => $this->session->userdata('IDSemester'),
					'jadwal_kelas_mapel.IDAjaran' => $this->session->userdata('IDAjaran'),
					'jadwal_kelas_mapel.IDKelas' => $DataKelas[0]['IDKelas']
				);
				$where[7] = array(
					'jadwal_kelas_mapel.IDMapel' => $this->session->userdata('IDMapel'),
					'jadwal_kelas_mapel.IDGuru' => $this->session->userdata('IDGuru'),
					'nilai_mapel.IDSemester' => $this->session->userdata('IDSemester'),
					'jadwal_kelas_mapel.IDAjaran' => $this->session->userdata('IDAjaran'),
					'jadwal_kelas_mapel.IDKelas' => $DataKelas[0]['IDKelas']
				);
				$content['KelasMapel'] = $this->M_UserCek->ReadJadwalKelasMapelby($where[5]);
				$content['KelasMapelNilai'] = $this->M_UserCek->ReadNilaiBy($where[5]);
				$content['NilaiHari'] = $this->M_UserCek->ReadNilaHari($where[6]);
				$content['KelasMapelNilaiSiswa'] = $this->M_UserCek->ReadNilaHariSiswa($where[6]);
				$content['NilaiMapelSiswa'] = $this->M_UserCek->ReadNilaiSiswa($where[7]);
			}


			// Import dari excell
			if ($this->input->post('SecretPath') != null && $this->input->post('SecretPath') != '') {

				$content['TampilkanData'] = TRUE;
				$where[4] = array('tb_kelas.KodeKelas' => $this->input->post('KodeKelas'));
				$content['DataSiswa'] = $this->M_UserCek->DataMuridAmbil($where[4]);
				$DataKelas = $this->M_UserCek->DataKelasWhereArr($where[4]);

				$filePath = $this->encryption->decrypt($this->input->post('SecretPath'));
				if (file_exists($filePath)) {
					// File uploaded successfully, handle further processing if needed
					$file_path = $filePath;
					$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($file_path);
					$spreadsheet = $reader->load($file_path);
					// Menghitung jumlah sheet dalam file
					$sheetCount = $spreadsheet->getSheetCount();
					// Mengambil nama sheet
					$sheetNames = $spreadsheet->getSheetNames();
					$ImportWhere[0] = array(
						'IDKelas' => $DataKelas[0]['IDKelas'],
						'IDMapel' => $this->session->userdata('IDMapel'),
						'IDGuru' => $this->session->userdata('IDGuru'),
						'IDAjaran' => $this->session->userdata('IDAjaran'),
					);
					$JKM = $this->M_UserCek->ReadJadwalKelasMapelbyArray($ImportWhere[0]);
					$ImportWhere[1] = array(
						'jadwal_kelas_mapel.IDKelasMapel' => $JKM[0]['IDKelasMapel'],
						'nilai_mapel_hari.IDSemester' => $this->session->userdata('IDSemester')
					);
					// Cek Data Nilai Hari Jika Ada Hapus
					$CekDataNilaiHari = $this->M_UserCek->ReadNilaHari($ImportWhere[1]);
					if ($CekDataNilaiHari !== false) {
						$ImportWhere[2] = array(
							'IDKelasMapel' => $JKM[0]['IDKelasMapel'],
							'IDSemester' => $this->session->userdata('IDSemester')
						);
						$this->M_UserCek->DeleteNilaHari($ImportWhere[2]);
					}

					// Memasukkan Data Nilai Hari
					for ($i = 0; $i < $sheetCount; $i++) {
						if ($i < $sheetCount - 2) {
							$worksheet = $spreadsheet->getSheet($i);
							$DATA = $worksheet->toArray();
							$ImportWhere[3][$i] = array(
								'IDSemester' => $this->session->userdata('IDSemester'),
								'IDKelasMapel' => $JKM[0]['IDKelasMapel'],
								'NamaNilai' => $DATA[0][2],
								'KodeNilai' => $sheetNames[$i],
								'Keterangan' => $DATA[1][2]
							);
							$this->M_UserCek->InsertNilaHari($ImportWhere[3][$i]);
							$ImportWhere[4][$i] = array(
								'nilai_mapel_hari.IDSemester' => $this->session->userdata('IDSemester'),
								'jadwal_kelas_mapel.IDKelasMapel' => $JKM[0]['IDKelasMapel'],
								'nilai_mapel_hari.NamaNilai' => $DATA[0][2],
								'nilai_mapel_hari.KodeNilai' => $sheetNames[$i],
								'nilai_mapel_hari.Keterangan' => $DATA[1][2]
							);
							$ImportWhere[5][$i] = $this->M_UserCek->ReadNilaHariArr($ImportWhere[4][$i]);

							// Data Nilai Harian Masuk
							$iii = 0;
							$a = 6;
							for ($ii = 0; $ii < 1; ) {
								if (($DATA[$a][1] == null || $DATA[$a][1] == '') || ($DATA[$a][2] == null || $DATA[$a][2] == '')) {
									$ii++;
								} else {
									$ImportWhere[6][$iii] = array(
										'NisSiswa' => $DATA[$a][1],
										'Nilai' => $DATA[$a][3],
										'IDNilaiHari' => $ImportWhere[5][$i][0]['IDNilaiHari']
									);
									$this->M_UserCek->InsertNilaHariSiswa($ImportWhere[6][$iii]);
									$iii++;
								}
								$a++;
							}
						} elseif ($i == $sheetCount - 2) {
							// Data Nilai UTS Masuk
							$worksheet = $spreadsheet->getSheet($i);
							$DATA = $worksheet->toArray();
							$iii = 0;
							$a = 6;
							for ($ii = 0; $ii < 1; ) {
								if (($DATA[$a][1] == null || $DATA[$a][1] == '') || ($DATA[$a][2] == null || $DATA[$a][2] == '')) {
									$ii++;
								} else {
									$ImportWhere[7][$iii] = array(
										'IDKelasMapel' => $JKM[0]['IDKelasMapel'],
										'IDSemester' => $this->session->userdata('IDSemester'),
										'NisSiswa' => $DATA[$a][1],
										'NilaiUTS' => $DATA[$a][3]
									);
									$worksheet2 = $spreadsheet->getSheet($sheetCount - 1);
									$DATA2 = $worksheet2->toArray();
									$b = 6;
									for ($iiii = 0; $iiii < 1; ) {
										if (($DATA2[$b][1] == null || $DATA2[$b][1] == '') || ($DATA2[$b][2] == null || $DATA2[$b][2] == '')) {
											$iiii++;
										} else {
											if ($DATA2[$b][1] == $DATA2[$a][1]) {
												$ImportWhere[7][$iii]['NilaiUAS'] = $DATA2[$b][3];
											}
										}
										$b++;
									}
									$this->M_UserCek->InsertNilaiSiswa($ImportWhere[7][$iii]);
									$iii++;
								}
								$a++;
							}
						}
					}
					// print_r($ImportWhere[7]);

				}


				$where[5] = array(
					'jadwal_kelas_mapel.IDMapel' => $this->session->userdata('IDMapel'),
					'jadwal_kelas_mapel.IDGuru' => $this->session->userdata('IDGuru'),
					'jadwal_kelas_mapel.IDAjaran' => $this->session->userdata('IDAjaran'),
					'jadwal_kelas_mapel.IDKelas' => $DataKelas[0]['IDKelas']
				);
				$where[6] = array(
					'jadwal_kelas_mapel.IDMapel' => $this->session->userdata('IDMapel'),
					'jadwal_kelas_mapel.IDGuru' => $this->session->userdata('IDGuru'),
					'jadwal_kelas_mapel.IDAjaran' => $this->session->userdata('IDAjaran'),
					'nilai_mapel_hari.IDSemester' => $this->session->userdata('IDSemester'),
					'jadwal_kelas_mapel.IDKelas' => $DataKelas[0]['IDKelas']
				);
				$where[7] = array(
					'jadwal_kelas_mapel.IDMapel' => $this->session->userdata('IDMapel'),
					'jadwal_kelas_mapel.IDGuru' => $this->session->userdata('IDGuru'),
					'nilai_mapel.IDSemester' => $this->session->userdata('IDSemester'),
					'jadwal_kelas_mapel.IDAjaran' => $this->session->userdata('IDAjaran'),
					'jadwal_kelas_mapel.IDKelas' => $DataKelas[0]['IDKelas']
				);
				$content['KelasMapel'] = $this->M_UserCek->ReadJadwalKelasMapelby($where[5]);
				$content['KelasMapelNilai'] = $this->M_UserCek->ReadNilaiBy($where[5]);
				$content['NilaiHari'] = $this->M_UserCek->ReadNilaHari($where[6]);
				$content['KelasMapelNilaiSiswa'] = $this->M_UserCek->ReadNilaHariSiswa($where[6]);
				$content['NilaiMapelSiswa'] = $this->M_UserCek->ReadNilaiSiswa($where[7]);
			}


			// Memuat tampilan template dan komponen tampilan
			$this->load->view('halaman/template/001', $Data004);
			$this->load->view('halaman/template/002(UPPER)', $Data002);
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003);

			$this->load->view('halaman/content/halamanSistem/pengajar/penilaian', $content);

			// Menampilkan bagian akhir tampilan
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004);
		}
	}

	public function PenilaianExcell()
	{
		if ($this->session->userdata('Status') !== "Login") {
			redirect(base_url("User_login"));
		} else {
			$KodeKelas = $this->input->get('KodeKelas');
			$KELAS = $this->M_UserCek->DataKelasByArr(array('KodeKelas' => $KodeKelas));
			$this->load->model('M_ExportImport');
			$where[4] = array('tb_kelas.IDKelas' => $KELAS[0]['IDKelas']);
			$content['DataSiswa'] = $this->M_UserCek->DataMuridAmbil($where[4]);
			$DataKelas = $this->M_ExportImport->DataKelasWhereArr($where[4]);
			$where[5] = array(
				'jadwal_kelas_mapel.IDMapel' => $this->session->userdata('IDMapel'),
				'jadwal_kelas_mapel.IDGuru' => $this->session->userdata('IDGuru'),
				'jadwal_kelas_mapel.IDAjaran' => $this->session->userdata('IDAjaran'),
				'jadwal_kelas_mapel.IDKelas' => $DataKelas[0]['IDKelas']
			);
			$where[6] = array(
				'jadwal_kelas_mapel.IDMapel' => $this->session->userdata('IDMapel'),
				'jadwal_kelas_mapel.IDGuru' => $this->session->userdata('IDGuru'),
				'nilai_mapel_hari.IDSemester' => $this->session->userdata('IDSemester'),
				'jadwal_kelas_mapel.IDAjaran' => $this->session->userdata('IDAjaran'),
				'jadwal_kelas_mapel.IDKelas' => $DataKelas[0]['IDKelas']
			);
			$where[7] = array(
				'jadwal_kelas_mapel.IDMapel' => $this->session->userdata('IDMapel'),
				'jadwal_kelas_mapel.IDGuru' => $this->session->userdata('IDGuru'),
				'nilai_mapel.IDSemester' => $this->session->userdata('IDSemester'),
				'jadwal_kelas_mapel.IDAjaran' => $this->session->userdata('IDAjaran'),
				'jadwal_kelas_mapel.IDKelas' => $DataKelas[0]['IDKelas']
			);
			$content['KelasMapel'] = $this->M_ExportImport->ReadJadwalKelasMapelbyArr($where[5]);
			$content['KelasMapelNilai'] = $this->M_ExportImport->ReadNilaiByArr($where[5]);
			$content['NilaiHari'] = $this->M_ExportImport->ReadNilaHariArr($where[6]);
			$content['KelasMapelNilaiSiswa'] = $this->M_UserCek->ReadNilaHariSiswa($where[6]);
			$content['NilaiMapelSiswa'] = $this->M_UserCek->ReadNilaiSiswa($where[7]);
			$IDAjaran = array('IDAjaran' => $this->session->userdata('IDAjaran'));
			$content['TahunAjaran'] = $this->M_UserCek->DataTahunAjaranWhereArr($IDAjaran);
			$IDMapel = array('IDMapel' => $this->session->userdata('IDMapel'));
			$content['MataPelajaran'] = $this->M_UserCek->DataMataPelajaranCekArr($IDMapel);
			$IDSemester = array('IDSemester' => $this->session->userdata('IDSemester'));
			$content['Semester'] = $this->M_UserCek->AmbilSemesterbyArr($IDSemester);
			$this->load->view('halaman/content/halamanSistem/pengajar/ExportImport/NilaiExport', $content);
		}
	}
	public function PenilaianImport()
	{
		$Token = $this->input->post('Token');
		$KodeKelas = $this->input->post('KodeKelas');
		$IDTahun = $this->input->post('IDTahun');
		$IDKelasMapel = $this->input->post('IDKelasMapel');
		$Cari = array('tg.UsrGuru' => $this->encryption->decrypt($Token));
		$Cek = $this->M_UserCek->GuruMengajar($Cari);
		if ($Cek != false) {
			// Handle file upload
			$config['upload_path'] = './application/uploads/';
			$config['allowed_types'] = 'xls|xlsx';
			$config['max_size'] = 2048;
			$config['overwrite'] = true;
			$config['file_name'] = 'DataNilaiSementara' . $this->session->userdata('UsrGuru');

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('file')) {
				// File uploaded successfully, handle further processing if needed
				$upload_data = $this->upload->data();
				$file_path = $upload_data['full_path'];
				$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($file_path);
				$spreadsheet = $reader->load($file_path);
				// Menghitung jumlah sheet dalam file
				$sheetCount = $spreadsheet->getSheetCount();
				$Salah = 0;
				$kelas = null;
				$MuridAll = array(
					'Nilai' => 0,
					'Data' => 0
				);
				for ($i = 0; $i < $sheetCount; $i++) {
					$hitungmurid = 0;
					$worksheet = $spreadsheet->getSheet($i);
					// Atau, jika Anda ingin menggunakan nama sheet, Anda bisa gunakan:
					// $worksheet = $spreadsheet->getSheetByName('NamaSheet');
					$data = $worksheet->toArray();

					$a = 6;
					if ($i < $sheetCount - 2) {
						if ($data[0][0] != 'Nama Nilai' || $data[1][0] != 'Keterangan' || $data[5][0] != 'No' || $data[5][1] != 'NIS' || $data[5][2] != 'Nama Siswa' || $data[5][3] != 'Nilai') {
							$Salah++;
						}

						for ($ii = 0; $ii < 1; ) {
							if (($data[$a][1] == null || $data[$a][1] == '') || ($data[$a][2] == null || $data[$a][2] == '')) {
								$ii++;
							} else {
								if ($kelas == null) {
									$Dmn = array('tb_siswa.NisSiswa' => $data[6][1]);
									$DKelas = $this->M_UserCek->DataMuridAmbilArr($Dmn);
									$kelas = $DKelas[0]['KodeKelas'];
								}
								$hitungmurid++;
								$MuridAll['Data']++;
								if ($data[$a][3] == null || $data[$a][3] == '') {
									$MuridAll['Nilai']++;
								}
							}
							$a++;
						}
					} elseif ($i == $sheetCount - 2) {
						if ($data[0][0] != 'Nama Nilai' || $data[1][0] != 'Keterangan' || $data[5][0] != 'No' || $data[5][1] != 'NIS' || $data[5][2] != 'Nama Siswa' || $data[5][3] != 'Nilai') {
							$Salah++;
						}

						for ($ii = 0; $ii < 1; ) {
							if (($data[$a][1] == null || $data[$a][1] == '') || ($data[$a][2] == null || $data[$a][2] == '')) {
								$ii++;
							} else {
								if ($kelas == null) {
									$Dmn = array('tb_siswa.NisSiswa' => $data[6][1]);
									$DKelas = $this->M_UserCek->DataMuridAmbilArr($Dmn);
									$kelas = $DKelas[0]['KodeKelas'];
								}
								$hitungmurid++;
								$MuridAll['Data']++;
								if ($data[$a][3] == null || $data[$a][3] == '') {
									$MuridAll['Nilai']++;
								}
							}
							$a++;
						}
					} elseif ($i == $sheetCount - 1) {
						if ($data[0][0] != 'Nama Nilai' || $data[1][0] != 'Keterangan' || $data[5][0] != 'No' || $data[5][1] != 'NIS' || $data[5][2] != 'Nama Siswa' || $data[5][3] != 'Nilai') {
							$Salah++;
						}

						for ($ii = 0; $ii < 1; ) {
							if (($data[$a][1] == null || $data[$a][1] == '') || ($data[$a][2] == null || $data[$a][2] == '')) {
								$ii++;
							} else {
								if ($kelas == null) {
									$Dmn = array('tb_siswa.NisSiswa' => $data[6][1]);
									$DKelas = $this->M_UserCek->DataMuridAmbilArr($Dmn);
									$kelas = $DKelas[0]['KodeKelas'];
								}
								$hitungmurid++;
								$MuridAll['Data']++;
								if ($data[$a][3] == null || $data[$a][3] == '') {
									$MuridAll['Nilai']++;
								}
							}
							$a++;
						}
					}
				}

				if ($Salah == 0) {
					$response = array(
						'status' => 'success',
						'path' => $this->encryption->encrypt($upload_data['full_path']),
						'message' => 'File Diunggah!',
						'Kosong' => $MuridAll['Nilai'],
						'Kelas' => $kelas,
						'jumlahNH' => $sheetCount - 2,
						'jumlahMrd' => $hitungmurid,
						'data' => $data
					);
				} elseif ($Salah > 0) {
					$response = array(
						'status' => 'error',
						'Kosong' => '!Error',
						'message' => 'Format Tidak Sesuai!',
						'Kelas' => '!Error',
						'jumlahNH' => '!Error',
						'jumlahMrd' => '!Error',
						'data' => ''
					);
				}

			} else {
				// Error in file upload
				$response = array(
					'status' => 'error',
					'message' => 'File Tidak Sesuai!',
					'Kelas' => '!Error',
					'jumlahNH' => '!Error',
					'jumlahMrd' => '!Error',
					'data' => ''
				);
			}

			// Return JSON response
			$this->output->set_content_type('application/json')->set_output(json_encode($response));
		}
	}


	function PenilaianHarian()
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
				'aktif' => 'Penilaian'
			);

			// Mengambil data dari model untuk ditampilkan dalam tampilan
			$Data003['SISTEM'] = $this->M_UserCek->APPNAME();
			$Data003['HakAkses'] = $this->M_UserCek->DataHakakses();
			$Data003['IDHak'] = $this->session->userdata('IDHak');
			$Data004['ButuhTabel'] = TRUE;
			$Data003['Fitur'] = $this->M_UserCek->FiturSistem();
			$Data004['ButuhForm'] = TRUE;

			$where[0] = array(
				'jadwal_kelas_mapel.IDMapel' => $this->session->userdata('IDMapel'),
				'jadwal_kelas_mapel.IDGuru' => $this->session->userdata('IDGuru'),
				'jadwal_kelas_mapel.IDAjaran' => $this->session->userdata('IDAjaran')
			);
			$where[1] = array(
				'IDMapel' => $this->session->userdata('IDMapel')
			);
			$where[2] = array(
				'IDSemester' => $this->session->userdata('IDSemester')
			);
			$where[3] = array(
				'IDAjaran' => $this->session->userdata('IDAjaran')
			);


			// Mengambil data dari model untuk ditampilkan dalam tampilan
			$content['datatahun'] = $this->M_UserCek->AmbilTahun();
			$content['datakelas'] = $this->M_UserCek->ReadJadwalKelasMapelby($where[0]);
			$content['datatahunajaran'] = $this->M_UserCek->AmbilTahunAjaran();
			$content['datasemester'] = $this->M_UserCek->AmbilSemester();


			$MapelPengajar = $this->M_UserCek->DataMataPelajaranCek($where[1]);
			foreach ($MapelPengajar as $MP) {
				$content['NamaMapel'] = $MP->NamaMapel;
			}
			$Semester = $this->M_UserCek->AmbilSemesterby($where[2]);
			foreach ($Semester as $Sm) {
				$content['NamaSemester'] = $Sm->NamaSemester;
			}
			$KodeAjaran = $this->M_UserCek->DataTahunAjaranWhere($where[3]);
			foreach ($KodeAjaran as $KA) {
				$content['KodeAjaran'] = $KA->KodeAjaran;
			}


			if ($this->input->get('CariData') != null && $this->input->get('CariData') == 'NilaiHari') {
				$content['TampilkanData'] = TRUE;
				$where[4] = array('tb_kelas.KodeKelas' => $this->input->get('KodeKelas'));
				$content['DataSiswa'] = $this->M_UserCek->DataMuridAmbil($where[4]);
				$DataKelas = $this->M_UserCek->DataKelasWhereArr($where[4]);
				$where[5] = array(
					'jadwal_kelas_mapel.IDMapel' => $this->session->userdata('IDMapel'),
					'jadwal_kelas_mapel.IDGuru' => $this->session->userdata('IDGuru'),
					'jadwal_kelas_mapel.IDAjaran' => $this->session->userdata('IDAjaran'),
					'jadwal_kelas_mapel.IDKelas' => $DataKelas[0]['IDKelas']
				);
				$where[6] = array(
					'jadwal_kelas_mapel.IDMapel' => $this->session->userdata('IDMapel'),
					'jadwal_kelas_mapel.IDGuru' => $this->session->userdata('IDGuru'),
					'nilai_mapel_hari.IDSemester' => $this->session->userdata('IDSemester'),
					'jadwal_kelas_mapel.IDAjaran' => $this->session->userdata('IDAjaran'),
					'jadwal_kelas_mapel.IDKelas' => $DataKelas[0]['IDKelas']
				);
				$content['KelasMapel'] = $this->M_UserCek->ReadJadwalKelasMapelby($where[5]);
				$content['KelasMapelNilai'] = $this->M_UserCek->ReadNilaiBy($where[5]);
				$content['NilaiHari'] = $this->M_UserCek->ReadNilaHari($where[6]);
				$content['KelasMapelNilaiSiswa'] = $this->M_UserCek->ReadNilaHariSiswa($where[6]);

			}

			if ($this->input->get('InsertNilaiHarian') != null && $this->input->get('InsertNilaiHarian') == 'Tambah') {
				if ($this->input->get('IDNilaiHari') != null && count($this->input->get('IDNilaiHari')) > 0) {
					for ($i = 0; $i < count($this->input->get('IDNilaiHari')); $i++) {
						$IDNilaiHari = $this->input->get('IDNilaiHari');
						$NamaNilai = $this->input->get('NamaNilai');
						$KodeNilai = $this->input->get('KodeNilai');
						$Keterangan = $this->input->get('Keterangan');
						if ($IDNilaiHari[$i] == 'na') {
							$DataMasuk[$i] = array(
								'NamaNilai' => $NamaNilai[$i],
								'KodeNilai' => $KodeNilai[$i],
								'Keterangan' => $Keterangan[$i],
								'IDKelasMapel' => $this->input->get('IDKelasMapel'),
								'IDSemester' => $this->session->userdata('IDSemester')
							);
							$this->M_UserCek->InsertNilaHari($DataMasuk[$i]);
						} elseif ($IDNilaiHari[$i] !== 'na') {
							$Nang[$i] = array('IDNilaiHari' => $IDNilaiHari[$i]);
							$DataMasuk[$i] = array(
								'NamaNilai' => $NamaNilai[$i],
								'KodeNilai' => $KodeNilai[$i],
								'Keterangan' => $Keterangan[$i],
								'IDKelasMapel' => $this->input->get('IDKelasMapel'),
								'IDSemester' => $this->session->userdata('IDSemester')
							);
							$this->M_UserCek->UpdateNilaHari($Nang[$i], $DataMasuk[$i]);
						}
					}
				}
				$content['TampilkanData'] = TRUE;
				$where[4] = array('tb_kelas.KodeKelas' => $this->input->get('KodeKelas'));
				$content['DataSiswa'] = $this->M_UserCek->DataMuridAmbil($where[4]);
				$DataKelas = $this->M_UserCek->DataKelasWhereArr($where[4]);
				$where[5] = array(
					'jadwal_kelas_mapel.IDMapel' => $this->session->userdata('IDMapel'),
					'jadwal_kelas_mapel.IDGuru' => $this->session->userdata('IDGuru'),
					'jadwal_kelas_mapel.IDAjaran' => $this->session->userdata('IDAjaran'),
					'jadwal_kelas_mapel.IDKelas' => $DataKelas[0]['IDKelas']
				);
				$where[6] = array(
					'jadwal_kelas_mapel.IDMapel' => $this->session->userdata('IDMapel'),
					'jadwal_kelas_mapel.IDGuru' => $this->session->userdata('IDGuru'),
					'nilai_mapel_hari.IDSemester' => $this->session->userdata('IDSemester'),
					'jadwal_kelas_mapel.IDAjaran' => $this->session->userdata('IDAjaran'),
					'jadwal_kelas_mapel.IDKelas' => $DataKelas[0]['IDKelas']
				);
				$content['KelasMapel'] = $this->M_UserCek->ReadJadwalKelasMapelby($where[5]);
				$content['KelasMapelNilai'] = $this->M_UserCek->ReadNilaiBy($where[5]);
				$content['NilaiHari'] = $this->M_UserCek->ReadNilaHari($where[6]);
				$content['KelasMapelNilaiSiswa'] = $this->M_UserCek->ReadNilaHariSiswa($where[6]);

			}

			if ($this->input->get('NilaiKelasHarian') != null && $this->input->get('NilaiKelasHarian') == 'Masuk') {
				if ($this->input->get('NilaiKelasHarian') != null && count($this->input->get('NisSiswa')) > 0) {

					$NISSiswa = $this->input->get('NisSiswa');

					for ($i = 0; $i < count($NISSiswa); $i++) {
						$cek = 0;
						$data = 0;
						foreach ($this->input->get() as $key => $value) {
							if ($cek > 4) {
								$DataMasuk[$i][$data] = array(
									'IDNilaiHari' => $key,
									'Nilai' => $value[$i],
									'NisSiswa' => $NISSiswa[$i]
								);
								$Nangndi = array(
									'nilai_mapel_hari_siswa.NisSiswa' => $DataMasuk[$i][$data]['NisSiswa'],
									'nilai_mapel_hari_siswa.IDNilaiHari' => $DataMasuk[$i][$data]['IDNilaiHari']

								);
								$CekData = $this->M_UserCek->ReadNilaHariSiswa($Nangndi);
								if ($CekData !== false) {
									$this->M_UserCek->UpdateNilaHariSiswa($Nangndi, $DataMasuk[$i][$data]);
								} elseif ($CekData == false) {
									$this->M_UserCek->InsertNilaHariSiswa($DataMasuk[$i][$data]);
								}
								$data++;
							}
							$cek++;
						}
					}

				}
				$content['TampilkanData'] = TRUE;
				$where[4] = array('tb_kelas.KodeKelas' => $this->input->get('KodeKelas'));
				$content['DataSiswa'] = $this->M_UserCek->DataMuridAmbil($where[4]);
				$DataKelas = $this->M_UserCek->DataKelasWhereArr($where[4]);
				$where[5] = array(
					'jadwal_kelas_mapel.IDMapel' => $this->session->userdata('IDMapel'),
					'jadwal_kelas_mapel.IDGuru' => $this->session->userdata('IDGuru'),
					'jadwal_kelas_mapel.IDAjaran' => $this->session->userdata('IDAjaran'),
					'jadwal_kelas_mapel.IDKelas' => $DataKelas[0]['IDKelas']
				);
				$where[6] = array(
					'nilai_mapel_hari.IDSemester' => $this->session->userdata('IDSemester'),
					'jadwal_kelas_mapel.IDMapel' => $this->session->userdata('IDMapel'),
					'jadwal_kelas_mapel.IDGuru' => $this->session->userdata('IDGuru'),
					'jadwal_kelas_mapel.IDAjaran' => $this->session->userdata('IDAjaran'),
					'jadwal_kelas_mapel.IDKelas' => $DataKelas[0]['IDKelas']
				);
				$content['KelasMapel'] = $this->M_UserCek->ReadJadwalKelasMapelby($where[5]);
				$content['KelasMapelNilai'] = $this->M_UserCek->ReadNilaiBy($where[5]);
				$content['NilaiHari'] = $this->M_UserCek->ReadNilaHari($where[6]);
				$content['KelasMapelNilaiSiswa'] = $this->M_UserCek->ReadNilaHariSiswa($where[6]);
			}

			if ($this->input->get('NilaiKelasHarian') != null && $this->input->get('NilaiKelasHarian') == 'Hapus') {
				if ($this->input->get('NilaiKelasHarian') == 'Hapus') {
					$Nangndi = array('IDNilaiHari' => $this->input->get('IDNilaiHari'));
					$this->M_UserCek->DeleteNilaHari($Nangndi);

				}
				$content['TampilkanData'] = TRUE;
				$where[4] = array('tb_kelas.KodeKelas' => $this->input->get('KodeKelas'));
				$content['DataSiswa'] = $this->M_UserCek->DataMuridAmbil($where[4]);
				$DataKelas = $this->M_UserCek->DataKelasWhereArr($where[4]);
				$where[5] = array(
					'jadwal_kelas_mapel.IDMapel' => $this->session->userdata('IDMapel'),
					'jadwal_kelas_mapel.IDGuru' => $this->session->userdata('IDGuru'),
					'jadwal_kelas_mapel.IDAjaran' => $this->session->userdata('IDAjaran'),
					'jadwal_kelas_mapel.IDKelas' => $DataKelas[0]['IDKelas']
				);
				$where[6] = array(
					'nilai_mapel_hari.IDSemester' => $this->session->userdata('IDSemester'),
					'jadwal_kelas_mapel.IDMapel' => $this->session->userdata('IDMapel'),
					'jadwal_kelas_mapel.IDGuru' => $this->session->userdata('IDGuru'),
					'jadwal_kelas_mapel.IDAjaran' => $this->session->userdata('IDAjaran'),
					'jadwal_kelas_mapel.IDKelas' => $DataKelas[0]['IDKelas']
				);
				$content['KelasMapel'] = $this->M_UserCek->ReadJadwalKelasMapelby($where[5]);
				$content['KelasMapelNilai'] = $this->M_UserCek->ReadNilaiBy($where[5]);
				$content['NilaiHari'] = $this->M_UserCek->ReadNilaHari($where[6]);
				$content['KelasMapelNilaiSiswa'] = $this->M_UserCek->ReadNilaHariSiswa($where[6]);
			}

			// Memuat tampilan template dan komponen tampilan
			$this->load->view('halaman/template/001', $Data004);
			$this->load->view('halaman/template/002(UPPER)', $Data002);
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003);

			$this->load->view('halaman/content/halamanSistem/pengajar/penilaian_harian', $content);

			// Menampilkan bagian akhir tampilan
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004);
		}
	}


	function Jurnal()
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
				'aktif' => 'Jurnal'
			);

			// Mengambil data dari model untuk ditampilkan dalam tampilan
			$Data003['SISTEM'] = $this->M_UserCek->APPNAME();
			$Data003['IDHak'] = $this->session->userdata('IDHak');
			$Data003['HakAkses'] = $this->M_UserCek->DataHakakses();
			$Data003['Fitur'] = $this->M_UserCek->FiturSistem();
			$Data004['ButuhTabel'] = TRUE;
			$Data004['ButuhForm'] = TRUE;

			$where[0] = array(
				'jadwal_kelas_mapel.IDMapel' => $this->session->userdata('IDMapel'),
				'jadwal_kelas_mapel.IDGuru' => $this->session->userdata('IDGuru'),
				'jadwal_kelas_mapel.IDAjaran' => $this->session->userdata('IDAjaran')
			);
			$where[1] = array(
				'IDMapel' => $this->session->userdata('IDMapel')
			);
			$where[2] = array(
				'IDSemester' => $this->session->userdata('IDSemester')
			);
			$where[3] = array(
				'IDAjaran' => $this->session->userdata('IDAjaran')
			);


			// Mengambil data dari model untuk ditampilkan dalam tampilan
			$content['datatahun'] = $this->M_UserCek->AmbilTahun();
			$content['datakelas'] = $this->M_UserCek->ReadJadwalKelasMapelby($where[0]);
			$content['datatahunajaran'] = $this->M_UserCek->AmbilTahunAjaran();
			$content['datasemester'] = $this->M_UserCek->AmbilSemester();


			$MapelPengajar = $this->M_UserCek->DataMataPelajaranCek($where[1]);
			if ($MapelPengajar !== false) {
				foreach ($MapelPengajar as $MP) {
					$content['NamaMapel'] = $MP->NamaMapel;
				}
			}
			$Semester = $this->M_UserCek->AmbilSemesterby($where[2]);
			if ($Semester !== false) {
				foreach ($Semester as $Sm) {
					$content['NamaSemester'] = $Sm->NamaSemester;
				}
			}
			$KodeAjaran = $this->M_UserCek->DataTahunAjaranWhere($where[3]);
			if ($KodeAjaran !== false) {
				foreach ($KodeAjaran as $KA) {
					$content['KodeAjaran'] = $KA->KodeAjaran;
				}
			}
			$DMN[0] = array(
				'jurnal_guru_mapel.IDGuru' => $this->session->userdata('IDGuru'),
				'jurnal_guru_mapel.IDMapel' => $this->session->userdata('IDMapel')
			);
			$content['JurnalGuruData'] = $this->M_UserCek->ReadJurnalGuruGroupBy($DMN[0]);


			// Memuat tampilan template dan komponen tampilan
			$this->load->view('halaman/template/001', $Data004);
			$this->load->view('halaman/template/002(UPPER)', $Data002);
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003);

			$this->load->view('halaman/content/halamanSistem/pengajar/jurnal_guru', $content);

			// Menampilkan bagian akhir tampilan
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004);
		}
	}
	function JurnalDownload($fungsi = null, $IDGuru = null, $IDKelas = null, $IDMapel = null, $IDSemester = null, $IDAjaran = null)
	{
		if ($this->session->userdata('Status') !== "Login") {
			redirect(base_url("User_login"));
		} else {
			if ($fungsi == 'Download' && $IDGuru == $this->session->userdata('IDGuru') && $IDKelas !== null && $IDMapel !== null) {
				$this->load->model('M_ExportImport');
				$where[0] = array(
					'tg.IDGuru' => $this->session->userdata('IDGuru'),
					'tm.IDMapel' => $IDMapel
				);
				$where[1] = array(
					'IDKelas' => $IDKelas
				);
				$where[2] = array(
					'IDSemester' => $IDSemester
				);
				$where[3] = array(
					'IDAjaran' => $IDAjaran
				);
				$where[4] = array(
					'jurnal_guru_mapel.IDGuru' => $this->session->userdata('IDGuru'),
					'jurnal_guru_mapel.IDSemester' => $this->session->userdata('IDSemester'),
					'jurnal_guru_mapel.IDAjaran' => $IDAjaran,
					'jadwal_kelas_mapel.IDMapel' => $IDMapel,
					'jadwal_kelas_mapel.IDKelas' => $IDKelas,
				);
				$where[5] = array(
					'jkm.IDGuru' => $this->session->userdata('IDGuru'),
					'jkm.IDAjaran' => $IDAjaran,
					'jkm.IDMapel' => $IDMapel,
					'jkm.IDKelas' => $IDKelas
				);
				$content['APPNAME'] = $this->M_ExportImport->APPNAMEarr();
				$content['DataGuru'] = $this->M_ExportImport->GuruMengajar($where[0]);
				$content['DataKelas'] = $this->M_ExportImport->DataKelasWhere($where[1]);
				$content['DataSemester'] = $this->M_UserCek->AmbilSemesterby($where[2]);
				$content['DataAjaran'] = $this->M_UserCek->DataTahunAjaranWhere($where[3]);
				$content['DataJurnal'] = $this->M_UserCek->ReadJurnalGuruBy($where[4]);
				$content['DataAbsenJurnal'] = $this->M_UserCek->JurnalAbsensiGuru($where[5]);
				$content['Fitur'] = array(
					'Waktu' => 'Mati',
					'JamKe' => 'Mati'
				);
				if ($this->input->post('Fitur') !== null) {
					$DataPOST = $this->input->post('Fitur');
					for ($i = 0; $i < count($DataPOST); $i++) {
						if ($DataPOST[$i] == 'Waktu') {
							$content['Fitur']['Waktu'] = 'Nyala';
						} elseif ($DataPOST[$i] == 'JamKe') {
							$content['Fitur']['JamKe'] = 'Nyala';
						}
					}
				}

				// print_r($content['DataAbsenJurnal']);
				$this->load->view('halaman/content/halamanSistem/pengajar/Jurnal/JurnalGuruPDF2', $content);
			}
		}
	}

	function RekapitulasiJurnal($halaman = null)
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
				'aktif' => 'RekapitulasiJurnal'
			);

			// Mengambil data dari model untuk ditampilkan dalam tampilan
			$Data003['SISTEM'] = $this->M_UserCek->APPNAME();
			$Data003['HakAkses'] = $this->M_UserCek->DataHakakses();
			$Data003['IDHak'] = $this->session->userdata('IDHak');
			$Data003['Fitur'] = $this->M_UserCek->FiturSistem();
			$Data004['ButuhTabel'] = TRUE;
			$Data004['ButuhForm'] = TRUE;

			$where[0] = array(
				'jadwal_kelas_mapel.IDMapel' => $this->session->userdata('IDMapel'),
				'jadwal_kelas_mapel.IDGuru' => $this->session->userdata('IDGuru'),
				'jadwal_kelas_mapel.IDAjaran' => $this->session->userdata('IDAjaran')
			);
			$where[1] = array(
				'IDMapel' => $this->session->userdata('IDMapel')
			);
			$where[2] = array(
				'IDSemester' => $this->session->userdata('IDSemester')
			);
			$where[3] = array(
				'IDAjaran' => $this->session->userdata('IDAjaran')
			);


			// Mengambil data dari model untuk ditampilkan dalam tampilan
			$content['datatahun'] = $this->M_UserCek->AmbilTahun();
			$content['datakelas'] = $this->M_UserCek->ReadJadwalKelasMapelby($where[0]);
			$content['datatahunajaran'] = $this->M_UserCek->AmbilTahunAjaran();
			$content['datasemester'] = $this->M_UserCek->AmbilSemester();


			$MapelPengajar = $this->M_UserCek->DataMataPelajaranCek($where[1]);
			if ($MapelPengajar !== false) {
				foreach ($MapelPengajar as $MP) {
					$content['NamaMapel'] = $MP->NamaMapel;
				}
			}
			$Semester = $this->M_UserCek->AmbilSemesterby($where[2]);
			if ($Semester !== false) {
				foreach ($Semester as $Sm) {
					$content['NamaSemester'] = $Sm->NamaSemester;
				}
			}
			$KodeAjaran = $this->M_UserCek->DataTahunAjaranWhere($where[3]);
			if ($KodeAjaran !== false) {
				foreach ($KodeAjaran as $KA) {
					$content['KodeAjaran'] = $KA->KodeAjaran;
				}
			}
			$DMN[0] = array(
				'jurnal_guru_mapel.IDGuru' => $this->session->userdata('IDGuru'),
				'jurnal_guru_mapel.IDMapel' => $this->session->userdata('IDMapel')
			);
			$DMN[2] = array(
				'tg.KodeGuru' => $this->session->userdata('KodeGuru'),
				'tg.UsrGuru' => $this->session->userdata('UsrGuru')
			);
			$where2 = array('gm.IDGuru' => $this->session->userdata('IDGuru'));
			$content['MapelGuru'] = $this->M_UserCek->GuruMengajar($DMN[2]);



			// Memuat tampilan template dan komponen tampilan
			$this->load->view('halaman/template/001', $Data004);
			$this->load->view('halaman/template/002(UPPER)', $Data002);
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003);
			if ($halaman == null) {
				$this->load->view('halaman/content/halamanSistem/pengajar/RekapJurnalGuru', $content);
			} else {
				$DMN[1] = array(
					'jurnal_guru_mapel.IDJurnal' => $this->input->get('IDJurnal'),
					'jurnal_guru_mapel.IDGuru' => $this->session->userdata('IDGuru')
				);
				$content['TampilkanJurnal'] = $this->M_UserCek->ReadJurnalGuruBy($DMN[1]);
				$this->load->view('halaman/content/halamanSistem/pengajar/RekapJurnalGuru_Edit', $content);
			}

			// Menampilkan bagian akhir tampilan
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004);
		}
	}
	public function JurnalAmbilData()
	{
		$draw = $this->input->post('draw');
		$start = $this->input->post('start');
		$length = $this->input->post('length');
		$order = $this->input->post('order')[0];
		$searchValue = $this->input->post('search')['value'];
		$IDMapel = $this->input->post('IDMapel');

		$DMN = array(
			'jadwal_kelas_mapel.IDGuru' => $this->encryption->decrypt($this->input->post('IDGuru')),
			'jurnal_guru_mapel.IDMapel' => $IDMapel
		);

		$data = $this->M_UserCek->RiwayatJurnalSS($DMN, $start, $length, $order, $searchValue);
		// Filter data jika diterapkan
		$filtered_data = $this->filterJurnalData($data, $searchValue);

		// Jumlah total data sebelum diterapkan filter
		$total_records = $this->M_UserCek->RiwayatJurnalNumber($DMN);

		// Jumlah total data setelah diterapkan filter
		$total_filtered_records = count($filtered_data);

		// Ambil data sesuai dengan limit dan offset yang diberikan oleh DataTables
		$data_to_show = array_slice($filtered_data, $start, $length);

		$result = array(
			"draw" => $draw,
			"recordsTotal" => $total_records,
			"recordsFiltered" => $total_records,
			"data" => $data
		);

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($result));
	}
	private function filterJurnalData($data, $searchValue)
	{
		// Filter berdasarkan nilai pencarian
		if (!empty ($searchValue)) {
			$filtered_data = array_filter($data, function ($item) use ($searchValue) {
				return strpos($item->TglAbsensi, $searchValue) !== false ||
					strpos($item->MateriPokok, $searchValue) !== false ||
					strpos($item->Kegiatan, $searchValue) !== false;
			});
		} else {
			$filtered_data = $data;
		}

		return $filtered_data;
	}

	public function RekapitulasiJurnalCRUD()
	{
		if ($this->session->userdata('Status') !== "Login") {
			redirect(base_url("User_login"));
		} else {
			if ($this->input->post('JurnalData') != null && $this->input->post('JurnalData') == 'Masuk') {
				// Konfigurasi unggahan file
				$config['upload_path'] = './file/data/gambar/laporanjurnal/';
				$config['allowed_types'] = 'png|jpg|jpeg';
				$config['max_size'] = 4096;
				$config['overwrite'] = true;
				$config['file_name'] = $this->session->userdata('IDGuru') . $_POST['IDJamPel'] . $this->convertDate($this->input->post('TglAbsensi')) . time();
				$config['encrypt_name'] = true;
				$this->load->library('upload', $config);
				if ($this->upload->do_upload('KendalaFoto') && $this->upload->do_upload('PenyelesaianFoto')) {
					if ($this->upload->do_upload('KendalaFoto')) {
						// Mengonversi gambar ke format JPG
						$upload_data[0] = $this->upload->data();
						$Foto1 = true;

					} else {
						$Foto1 = false;
					}

					if ($this->upload->do_upload('PenyelesaianFoto')) {
						$upload_data[1] = $this->upload->data();
						$Foto2 = true;

					} else {
						$Foto2 = false;
					}

					if ($Foto1 == true && $Foto2 == true) {
						$Sing[0] = array('tb_kelas.KodeKelas' => $_POST['KodeKelas']);
						$AmbilKelas = $this->M_UserCek->DataKelasWhereArr($Sing[0]);
						$Sing[1] = array(
							'IDJurnal' => $this->input->post('IDJurnal')
						);
						$CekData = $this->M_UserCek->ReadJurnalGuru($Sing[1]);
						$DataMasuk = array(
							'KendalaFoto' => $upload_data[0]['file_name'],
							'PenyelesaianFoto' => $upload_data[1]['file_name'],
							'TanggalJurnal' => $this->convertDate($this->input->post('TglAbsensi')),
							'KendalaKet' => $this->input->post('KendalaKeterangan'),
							'PenyelesaianKet' => $this->input->post('PenyelesaianKeterangan'),
							'MateriPokok' => $this->input->post('MateriPokok'),
							'InPenKom' => $this->input->post('InPenKom'),
							'Kegiatan' => $this->input->post('Kegiatan'),
							'Penilaian' => $this->input->post('Penilaian'),
							'TindakLanjut' => $this->input->post('TindakLanjut')
						);
						if ($CekData == false) {
							$this->M_UserCek->InsertJurnalGuru($DataMasuk);
						} else {
							foreach ($CekData as $CD) {
								$YoIki = array('IDJurnal' => $CD->IDJurnal);
								if (!is_dir('./file/data/gambar/laporanjurnal/' . $CD->KendalaFoto)) {
									if (file_exists('./file/data/gambar/laporanjurnal/' . $CD->KendalaFoto)) {
										unlink('./file/data/gambar/laporanjurnal/' . $CD->KendalaFoto);
									}
								}
								if (!is_dir('./file/data/gambar/laporanjurnal/' . $CD->PenyelesaianFoto)) {
									if (file_exists('./file/data/gambar/laporanjurnal/' . $CD->PenyelesaianFoto)) {
										unlink('./file/data/gambar/laporanjurnal/' . $CD->PenyelesaianFoto);
									}
								}
							}
							$this->M_UserCek->UpdateJurnalGuru($YoIki, $DataMasuk);
							redirect(base_url("User_pengajar/RekapitulasiJurnal/Edit?IDJurnal=" . $this->input->post('IDJurnal')));
						}
					} else {
						if ($Foto1 == false) {
							unlink($upload_data[1]['full_path']);
							$this->session->set_flashdata('toastr_warning', 'Foto/gambar kendala tidak benar!');
						}
						if ($Foto2 == false) {
							unlink($upload_data[0]['full_path']);
							$this->session->set_flashdata('toastr_warning', 'Foto/gambar Penyelesaian tidak benar!');
						}
						redirect(base_url("User_pengajar/RekapitulasiJurnal/Edit?IDJurnal=" . $this->input->post('IDJurnal')));
					}
				} else {
					$Sing[0] = array('tb_kelas.KodeKelas' => $this->input->post('KodeKelas'));
					$AmbilKelas = $this->M_UserCek->DataKelasWhereArr($Sing[0]);
					$Sing[1] = array(
						'IDJurnal' => $this->input->post('IDJurnal')
					);
					$CekData = $this->M_UserCek->ReadJurnalGuru($Sing[1]);
					$DataMasuk = array(
						'KendalaFoto' => null,
						'PenyelesaianFoto' => null,
						'KendalaKet' => $this->input->post('KendalaKeterangan'),
						'PenyelesaianKet' => $this->input->post('PenyelesaianKeterangan'),
						'MateriPokok' => $this->input->post('MateriPokok'),
						'InPenKom' => $this->input->post('InPenKom'),
						'Kegiatan' => $this->input->post('Kegiatan'),
						'Penilaian' => $this->input->post('Penilaian'),
						'TindakLanjut' => $this->input->post('TindakLanjut')
					);
					if ($CekData == false) {
						$this->M_UserCek->InsertJurnalGuru($DataMasuk);
						redirect(base_url("User_pengajar/RekapitulasiJurnal/Edit?IDJurnal=" . $this->input->post('IDJurnal')));
					} else {
						foreach ($CekData as $CD) {
							$YoIki = array('IDJurnal' => $CD->IDJurnal);
							if ($CD->KendalaFoto !== null || $CD->KendalaFoto !== '') {
								if (!is_dir('./file/data/gambar/laporanjurnal/' . $CD->KendalaFoto)) {
									if (file_exists('./file/data/gambar/laporanjurnal/' . $CD->KendalaFoto)) {
										unlink('./file/data/gambar/laporanjurnal/' . $CD->KendalaFoto);
									}
								}
							}

							if ($CD->PenyelesaianFoto !== null || $CD->PenyelesaianFoto !== '') {
								if (!is_dir('./file/data/gambar/laporanjurnal/' . $CD->PenyelesaianFoto)) {
									if (file_exists('./file/data/gambar/laporanjurnal/' . $CD->PenyelesaianFoto)) {
										unlink('./file/data/gambar/laporanjurnal/' . $CD->PenyelesaianFoto);
									}
								}
							}
						}
						$this->M_UserCek->UpdateJurnalGuru($YoIki, $DataMasuk);
						$this->session->set_flashdata('toastr_success', 'Data Berhasil disimpan!');
						redirect(base_url("User_pengajar/RekapitulasiJurnal/Edit?IDJurnal=" . $this->input->post('IDJurnal')));
					}
				}
			}
		}
	}

	public function RekapAbsensi()
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
				'aktif' => 'Absensi'
			);


			// Mengambil data dari model untuk ditampilkan dalam tampilan
			$Data003['SISTEM'] = $this->M_UserCek->APPNAME();
			$Data003['HakAkses'] = $this->M_UserCek->DataHakakses();
			$Data003['IDHak'] = $this->session->userdata('IDHak');
			$Data004['ButuhTabel'] = TRUE;
			$Data003['Fitur'] = $this->M_UserCek->FiturSistem();
			$Data004['ButuhForm'] = TRUE;

			$where[0] = array(
				'jadwal_kelas_mapel.IDMapel' => $this->session->userdata('IDMapel'),
				'jadwal_kelas_mapel.IDGuru' => $this->session->userdata('IDGuru'),
				'jadwal_kelas_mapel.IDAjaran' => $this->session->userdata('IDAjaran')
			);
			$where[1] = array(
				'IDMapel' => $this->session->userdata('IDMapel')
			);
			$where[2] = array(
				'IDSemester' => $this->session->userdata('IDSemester')
			);
			$where[3] = array(
				'IDAjaran' => $this->session->userdata('IDAjaran')
			);

			$where1 = array(
				'tg.KodeGuru' => $this->session->userdata('KodeGuru'),
				'tg.UsrGuru' => $this->session->userdata('UsrGuru')
			);

			// Mengambil data dari model untuk ditampilkan dalam tampilan
			$content['MapelGuru'] = $this->M_UserCek->GuruMengajar($where1);
			$content['datatahun'] = $this->M_UserCek->AmbilTahun();
			$content['datakelas'] = $this->M_UserCek->ReadJadwalKelasMapelby($where[0]);
			$content['datatahunajaran'] = $this->M_UserCek->AmbilTahunAjaran();
			$content['datasemester'] = $this->M_UserCek->AmbilSemester();
			$content['dataHariJampel'] = $this->M_UserCek->ReadHariJam();
			// Memuat tampilan template dan komponen tampilan
			$this->load->view('halaman/template/001', $Data004);
			$this->load->view('halaman/template/002(UPPER)', $Data002);
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003);
			
			$this->load->view('halaman/template/OnDevelop', $content);

			// Menampilkan bagian akhir tampilan
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004);
		}
	}

}