<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'libraries/PhpSpreadsheet/autoload.php';

class User_admin extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_UserCek');
		$this->load->model('M_WhatsApp');
		$this->load->helper(array('form', 'url', 'cookie'));
		$this->load->library('Pdf');
	}

	private function convertDate($date_str)
	{
		$timestamp = strtotime($date_str); // Mengonversi tanggal ke UNIX timestamp
		return $formatted_date = date('Y-m-d', $timestamp); // Mengonversi timestamp ke format Y-m-d
	}

	private function formatNomorTelepon($nomor_telepon)
	{
		// Hapus karakter awal '62' jika ada
		if (substr($nomor_telepon, 0, 2) === '62') {
			$nomor_telepon = substr($nomor_telepon, 2);
		}

		// Ubah format nomor telepon
		$nomor_telepon = preg_replace('/^(\d{4})(\d{4})(\d{4})$/', '$1-$2-$3', $nomor_telepon);

		// Tambahkan awalan '0' kembali
		$nomor_telepon = '0' . $nomor_telepon;

		return $nomor_telepon;
	}

	public function TabelTahunAjaran($fungsi = null, $eksekutor = null, $id = null)
	{
		if ($this->session->userdata('Status') !== "Login") {
			redirect(base_url("User_login"));
		} else {
			$Data002 = array(
				'KodeGuru' => $this->session->userdata('KodeGuru'),
				'NamaGuru' => $this->session->userdata('NamaGuru'),
				'UsrGuru' => $this->session->userdata('UsrGuru'),
				'KodeMapel' => $this->session->userdata('KodeMapel'),
				'IDHak' => $this->session->userdata('IDHak'),
				'IDAjaran' => $this->session->userdata('IDjaran')
			);
			$Data003['SISTEM'] = $this->M_UserCek->APPNAME();
			$Data003['aktif'] = 'TabelTahunAjaran';
			$Data003['HakAkses'] = $this->M_UserCek->DataHakakses();
			$Data003['IDHak'] = $this->session->userdata('IDHak');
			$Data003['Fitur'] = $this->M_UserCek->FiturSistem();
			$Data004['ButuhTabel'] = TRUE;
			$Data004['ButuhForm'] = TRUE;
			$content['TahunAjaran'] = $this->M_UserCek->AmbilTahunAjaran();
			$this->load->view('halaman/template/001', $Data004);
			$this->load->view('halaman/template/002(UPPER)', $Data002);
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003);
			if ($fungsi !== null) {
				if ($fungsi === 'EditUpdate') {
					if ($eksekutor === 'Hapus' && $id !== null) {
						$where = array(
							'IDAjaran' => $id
						);
						$this->M_UserCek->DeleteTahunAjaran($where);
						$this->session->set_flashdata('toastr_success', 'Data Berhasil dihapus!');
						redirect(base_url("User_admin/TabelTahunAjaran"));
					} elseif ($eksekutor === 'DataMasuk') {
						$where = array(
							'KodeAjaran' => $this->input->post('TahunAwal') . '/' . $this->input->post('TahunAkhir'),
							'TahunAwal' => $this->input->post('TahunAwal'),
							'TahunAkhir' => $this->input->post('TahunAkhir')
						);
						$cek = $this->M_UserCek->DataTahunAjaranWhere($where);
						if ($cek === FALSE) {
							$this->M_UserCek->InsertTahunAjaran($where);
							$this->session->set_flashdata('toastr_success', 'Data Berhasil dimasukkan!');
							redirect(base_url("User_admin/TabelTahunAjaran"));
						} else {
							$this->session->set_flashdata('toastr_info', 'Terdapat Data Yang Sama!');
							redirect(base_url("User_admin/TabelTahunAjaran"));
						}
					} elseif ($eksekutor === 'Aktifkan') {
						$where[0] = array($id);
						$where[1] = array('IDAjaran' => $id);
						$DataMasuk[0] = array('Status' => null);
						$DataMasuk[1] = array('Status' => 'Aktif');
						$this->M_UserCek->UbahTahunAjaranSelain($where[0], $DataMasuk[0]);
						$this->M_UserCek->UpdateTahunAjaran($where[1], $DataMasuk[1]);
						$DataTahun = $this->M_UserCek->AmbilTahunAjaranWhereArr($where[1]);
						$this->session->set_flashdata('toastr_success', 'Tahun Ajaran Saat Ini Diubah ke <b>' . $DataTahun[0]['KodeAjaran'] . '</b> !');
						redirect(base_url("User_admin/TabelTahunAjaran"));
					}
				}
			} else {
				$this->load->view('halaman/content/halamanSistem/admin/tabeltahunajaran', $content);
			}
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004);
		}
	}

	public function TabelSemester($fungsi = null, $eksekutor = null, $id = null)
	{
		if ($this->session->userdata('Status') !== "Login") {
			redirect(base_url("User_login"));
		} else {
			$Data002 = array(
				'KodeGuru' => $this->session->userdata('KodeGuru'),
				'NamaGuru' => $this->session->userdata('NamaGuru'),
				'UsrGuru' => $this->session->userdata('UsrGuru'),
				'KodeMapel' => $this->session->userdata('KodeMapel'),
				'IDHak' => $this->session->userdata('IDHak'),
				'IDAjaran' => $this->session->userdata('IDjaran')
			);
			$Data003['SISTEM'] = $this->M_UserCek->APPNAME();
			$Data003['aktif'] = 'TabelSemester';
			$Data003['HakAkses'] = $this->M_UserCek->DataHakakses();
			$Data003['IDHak'] = $this->session->userdata('IDHak');
			$Data003['Fitur'] = $this->M_UserCek->FiturSistem();
			$Data004['ButuhTabel'] = TRUE;
			$Data004['ButuhForm'] = TRUE;
			$content['AmbilSemester'] = $this->M_UserCek->AmbilSemester();
			$this->load->view('halaman/template/001', $Data004);
			$this->load->view('halaman/template/002(UPPER)', $Data002);
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003);
			if ($fungsi !== null && $fungsi === 'EditUpdate') {
				if ($eksekutor == 'DataMasuk') {
					if ($this->input->post() !== null) {
						$DataMasuk = array(
							'NamaSemester' => $this->input->post('NamaSemester'),
							'Penyebutan' => $this->input->post('Penyebutan')
						);
						$this->M_UserCek->InsertSemester($DataMasuk);
						$this->session->set_flashdata('toastr_success', 'Data berhasil ditambahkan!');
						redirect(base_url("User_admin/TabelSemester"));
					}
				} elseif ($eksekutor == 'Hapus' && $id !== null) {
					$where = array('IDSemester' => $id);
					$this->M_UserCek->DeleteSemester($where);
					$this->session->set_flashdata('toastr_success', 'Data berhasil dihapus!');
					redirect(base_url("User_admin/TabelSemester"));
				} elseif ($eksekutor == 'Aktifkan' && $id !== null) {
					$where[0] = array($id);
					$DataMasuk[0] = array('Status' => null);
					$where[1] = array('IDSemester' => $id);
					$DataMasuk[1] = array('Status' => 'Aktif');
					$this->M_UserCek->UbahSemesterSelain($where[0], $DataMasuk[0]);
					$this->M_UserCek->UpdateSemester($where[1], $DataMasuk[1]);
					$DataSemester = $this->M_UserCek->AmbilSemesterWhereArr($where[1]);
					$this->session->set_flashdata('toastr_success', 'Tahun Ajaran Saat Ini Diubah ke <b>' . $DataSemester[0]['NamaSemester'] . '</b> !');
					redirect(base_url("User_admin/TabelSemester"));
				}
			} else {
				$this->load->view('halaman/content/halamanSistem/admin/TabelSemester', $content);
			}
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004);
		}
	}

	public function TabelKelas($fungsi = null, $kode = null, $eksekusi = null)
	{
		// Admin
		if ($this->session->userdata('Status') !== "Login") {
			redirect(base_url("User_login"));
		} else {
			$Data002 = array(
				'KodeGuru' => $this->session->userdata('KodeGuru'),
				'NamaGuru' => $this->session->userdata('NamaGuru'),
				'UsrGuru' => $this->session->userdata('UsrGuru'),
				'KodeMapel' => $this->session->userdata('KodeMapel'),
				'IDHak' => $this->session->userdata('IDHak'),
				'IDAjaran' => $this->session->userdata('IDjaran')
			);
			$Data003['SISTEM'] = $this->M_UserCek->APPNAME();
			$Data003['IDHak'] = $this->session->userdata('IDHak');
			$Data003['aktif'] = 'TabelKelas';
			$Data003['HakAkses'] = $this->M_UserCek->DataHakakses();
			$Data003['Fitur'] = $this->M_UserCek->FiturSistem();
			$Data004['ButuhTabel'] = TRUE;
			$Data004['ButuhForm'] = TRUE;
			$content['tabel'] = $this->M_UserCek->DataKelas();
			$content['tahunkelas'] = $this->M_UserCek->AmbilTahun();
			$content['walikelas'] = $this->M_UserCek->DataGuruWaliOnly();
			$this->load->view('halaman/template/001', $Data004);
			$this->load->view('halaman/template/002(UPPER)', $Data002);
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003);
			if ($fungsi == null) {
				$this->load->view('halaman/content/halamanSistem/admin/tabelkelas', $content);
			} elseif ($fungsi === 'Kelas' && $kode !== null) {
				if ($eksekusi === null) {
					$where = array('IDKelas' => $kode);
					$content['murid'] = $this->M_UserCek->DataMuridAmbil($where);
					$Kelas = $this->M_UserCek->DataMuridAmbilArr($where);
					$content['kelas'] = $Kelas[0]['IDKelas'];
					$content['KodeKelas'] = $Kelas[0]['KodeKelas'];
					$this->load->view('halaman/content/halamanSistem/admin/tabelkelaswhere', $content);
				} elseif ($eksekusi === 'DataMasuk') {
					$DataMasuk = array(
						'NamaSiswa' => $this->input->post('NamaSiswa'),
						'NisSiswa' => $this->input->post('NisSiswa'),
						'GenderSiswa' => $this->input->post('GenderSiswa'),
						// 'KodeKelas' => $content['KodeKelas'],
						'AyahSiswa' => $this->input->post('AyahSiswa'),
						'IbuSiswa' => $this->input->post('IbuSiswa'),
						'TglLhrSiswa' => $this->input->post('TglLhrSiswa'),
						'TmptLhrSiswa' => $this->input->post('TmptLhrSiswa'),
						'NISNSiswa' => $this->input->post('NISNSiswa'),
						'TGLMasuk' => $this->input->post('TGLMasuk')
					);
					if ($this->M_UserCek->DataMuridCek($DataMasuk) == TRUE) {
						$this->M_UserCek->DataMuridInsert($DataMasuk);
						$this->session->set_flashdata('toastr_success', 'Data berhasil disimpan!');
						redirect(base_url("User_admin/TabelKelas/Kelas/" . $kode));
					} else {
						// Memuat tampilan view untuk input data murid jika terdapat data yang sama
						redirect(base_url("User_admin/TabelKelas/Kelas/" . $kode));
						$this->session->set_flashdata('toastr_info', 'Terdapat Data Yang Sama!');
					}
				} elseif ($eksekusi === 'DataUpdate') {
					// Memperbarui data murid berdasarkan inputan
					$DataMasuk = array(
						'NamaSiswa' => $this->input->post('NamaSiswa'),
						'NisSiswa' => $this->input->post('NisSiswa'),
						'GenderSiswa' => $this->input->post('GenderSiswa'),
						// 'KodeKelas' => $content['KodeKelas'],
						'AyahSiswa' => $this->input->post('AyahSiswa'),
						'IbuSiswa' => $this->input->post('IbuSiswa'),
						'TglLhrSiswa' => $this->input->post('TglLhrSiswa'),
						'TmptLhrSiswa' => $this->input->post('TmptLhrSiswa'),
						'NISNSiswa' => $this->input->post('NISNSiswa'),
						'TGLMasuk' => $this->input->post('TGLMasuk')
					);
					$cek = $this->input->post('IDSiswa');
					if ($this->M_UserCek->DataMuridCekWhere($DataMasuk, $cek) == TRUE) {
						$where = array('IDSiswa' => $this->input->post('IDSiswa'));
						$this->M_UserCek->DataMuridUpdate($where, $DataMasuk);
						$this->session->set_flashdata('toastr_success', 'Data Dengan Nama' . $this->input->post('NamaSiswa') . ' berhasil disimpan!');
						redirect(base_url("User_admin/TabelKelas/Kelas/" . $kode));
					} else {
						// Memuat tampilan view untuk input data murid jika terdapat data yang sama
						$content['kelas'] = $this->M_UserCek->DataKelasOnly();
						redirect(base_url("User_admin/TabelKelas/Kelas/" . $kode));
						$this->session->set_flashdata('toastr_info', 'Terdapat Data Yang Sama!');
					}
				}
			}
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004);
		}
	}

	public function KelasData($aksi = null, $id = null)
	{
		// Admin
		if ($this->session->userdata('Status') !== "Login") {
			redirect(base_url("User_login"));
		} else {
			if ($aksi !== null) {
				if ($aksi === 'DataMasuk') {
					$kodeKelas = $this->input->post('KodeKelas');
					if ($kodeKelas) {
						$data = array(
							'KodeKelas' => $this->input->post('KodeKelas'),
							'KodeTahun' => $this->input->post('KodeTahun'),
							'IDGuru' => $this->input->post('IDGuru'),
							'RuanganKelas' => $this->input->post('RuanganKelas')
						);
						$where = array('KodeKelas' => $kodeKelas);
						$cek = $this->M_UserCek->DataKelasWhere($where);
						if ($cek === FALSE) {
							$this->M_UserCek->DataKelasInsert($data);
							$this->session->set_flashdata('toastr_success', 'Data Berhasil Dimasukkan!');
							redirect(base_url("User_admin/TabelKelas"));
						} else {
							$this->session->set_flashdata('toastr_info', 'Anda Memasukkan Data Yang Sama!');
							redirect(base_url("User_admin/TabelKelas"));
						}
					}
				} elseif ($aksi == 'DataHapus') {
					$idKelas = $id;
					if ($idKelas !== null) {
						$where = array('IDKelas' => $idKelas);
						$this->M_UserCek->DataKelasHapus($where);
						$this->session->set_flashdata('toastr_success', 'Data Berhasil Dihapus!');
						redirect(base_url("User_admin/TabelKelas"));
					}
				} elseif ($aksi === 'DataUpdate') {
					$idKelas = $this->input->post('IDKelas');
					if ($idKelas) {
						$where = array('IDKelas' => $idKelas);
						$data = array(
							'KodeKelas' => $this->input->post('KodeKelas'),
							'KodeTahun' => $this->input->post('KodeTahun'),
							'IDGuru' => $this->input->post('IDGuru'),
							'RuanganKelas' => $this->input->post('RuanganKelas')
						);
						$this->M_UserCek->DataKelasUpdate($where, $data);
						$this->session->set_flashdata('toastr_success', 'Data Berhasil Diubah!');
						redirect(base_url("User_admin/TabelKelas"));
					}
				}
			}
		}
	}

	public function DataMuridServerSide()
	{
		// Mengambil token dari header permintaan
		$receivedToken = $this->input->get_request_header('Token', TRUE);

		// Mendekripsi token untuk mendapatkan IDGuru
		$decryptedIDGuru = $this->encryption->decrypt($receivedToken);

		// Memeriksa keberlanjutan proses berdasarkan IDGuru
		$where = array('IDGuru' => $decryptedIDGuru);
		$isAuthorized = $this->M_UserCek->DataGuruWhere($where);

		if ($isAuthorized !== false) {
			// Mendapatkan data dari model dengan pencarian
			$start = $this->input->get('start');
			$length = $this->input->get('length');
			$searchValue = $this->input->get('search')['value'];
			// $order = $this->input->post('order')[0];
			// Mengambil data dari model dengan parameter pencarian
			$data = $this->M_UserCek->DataMurid2($length, $start, $searchValue);

			// Filter data jika diterapkan
			$filtered_data = $this->filterData($data);

			// Jumlah total data setelah diterapkan filter
			$total_filtered_records = count($filtered_data);

			// Ambil data sesuai dengan limit dan offset yang diberikan oleh DataTables
			$data_to_show = array_slice($filtered_data, $start, $length);

			// Format data sesuai dengan kebutuhan DataTables
			$json_data = array(
				"draw" => intval($this->input->get('draw')),
				"recordsTotal" => $this->M_UserCek->JumlahDataMurid(),
				"recordsFiltered" => $total_filtered_records,
				"data" => $data_to_show
			);

			// Set output sebagai JSON
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($json_data));
		} else {
			// Tanggapan jika tidak diotorisasi
			$response = array('error' => 'Unauthorized');
			$response['Your_ipAddress'] = $_SERVER['REMOTE_ADDR'];
			$response['Your_userAgent'] = $_SERVER['HTTP_USER_AGENT'];
			$this->output
				->set_status_header(401)
				->set_content_type('application/json')
				->set_output(json_encode($response));
		}
	}

	private function filterData($data)
	{
		// Implementasikan logika filter data di sini
		// Misalnya, berdasarkan pencarian, filter berdasarkan kelas, dll.
		// Anda dapat menggunakan $this->input->get() untuk mendapatkan parameter filter dari DataTables
		// Contoh: $search_value = $this->input->get('search')['value'];

		// Contoh filter sederhana (berdasarkan nama siswa)
		// Ubah logika ini sesuai kebutuhan Anda
		// if (!empty($search_value)) {
		//     $filtered_data = array_filter($data, function ($item) use ($search_value) {
		//         return strpos($item->NamaSiswa, $search_value) !== false;
		//     });
		// } else {
		//     $filtered_data = $data;
		// }

		// Contoh filter sederhana di atas dapat disesuaikan dengan kebutuhan Anda
		// atau Anda dapat mengimplementasikan logika filter yang lebih kompleks di sini

		// Jika tidak ada filter, kembalikan data asli
		return $data;
	}



	public function TabelMurid($jenis = null, $id = null)
	{
		// Memeriksa apakah pengguna telah login sebagai admin
		if ($this->session->userdata('Status') !== "Login") {
			redirect(base_url("User_login"));
		} else {
			// Data yang akan digunakan untuk view
			$Data002 = array(
				'KodeGuru' => $this->session->userdata('KodeGuru'),
				'NamaGuru' => $this->session->userdata('NamaGuru'),
				'UsrGuru' => $this->session->userdata('UsrGuru'),
				'KodeMapel' => $this->session->userdata('KodeMapel'),
				'IDHak' => $this->session->userdata('IDHak'),
				'IDAjaran' => $this->session->userdata('IDjaran')
			);
			$Data003['SISTEM'] = $this->M_UserCek->APPNAME();
			$Data003['IDHak'] = $this->session->userdata('IDHak');
			$Data003['Fitur'] = $this->M_UserCek->FiturSistem();
			$Data003['aktif'] = 'TabelMurid';
			$Data003['HakAkses'] = $this->M_UserCek->DataHakakses();
			$Data004['ButuhTabel'] = TRUE;
			$Data004['ButuhForm'] = TRUE;

			// Mendapatkan data murid dan kelas
			$content['kelas'] = $this->M_UserCek->DataKelasOnly();
			$content['tabel'] = $this->M_UserCek->DataMurid();

			// Memuat tampilan view
			$this->load->view('halaman/template/001', $Data004);
			$this->load->view('halaman/template/002(UPPER)', $Data002);
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003);

			// Fungsi Halaman
			if ($jenis != null) {
				if ($jenis == 'Hapus') {
					if ($this->input->post('IDSiswa') !== null) {
						// Menghapus data murid berdasarkan ID
						$where = array('IDSiswa' => $this->input->post('IDSiswa'));
						$this->M_UserCek->DataMuridDelete($where);
						$this->session->set_flashdata('toastr_success', 'Data berhasil dihapus!');
						redirect(base_url("User_admin/TabelMurid"));
					}
				} elseif ($jenis == 'Insert') {
					// Memuat tampilan view untuk input data murid
					$content['kelas'] = $this->M_UserCek->DataKelasOnly();
					$this->load->view('halaman/content/halamanSistem/tabelmurid_insert', $content);
				} elseif ($jenis == 'DataUpdate') {
					// Memperbarui data murid berdasarkan inputan
					$DataMasuk = array(
						'NamaSiswa' => $this->input->post('NamaSiswa'),
						'NisSiswa' => $this->input->post('NisSiswa'),
						'GenderSiswa' => $this->input->post('GenderSiswa'),
						'KodeKelas' => $this->input->post('KodeKelas'),
						'AyahSiswa' => $this->input->post('AyahSiswa'),
						'IbuSiswa' => $this->input->post('IbuSiswa'),
						'TglLhrSiswa' => $this->input->post('TglLhrSiswa'),
						'TmptLhrSiswa' => $this->input->post('TmptLhrSiswa'),
						'NISNSiswa' => $this->input->post('NISNSiswa'),
						'TGLMasuk' => $this->input->post('TGLMasuk')

					);
					$cek = $this->input->post('IDSiswa');
					if ($this->M_UserCek->DataMuridCekWhere($DataMasuk, $cek) == TRUE) {
						$where = array('IDSiswa' => $this->input->post('IDSiswa'));
						$this->M_UserCek->DataMuridUpdate($where, $DataMasuk);
						$this->session->set_flashdata('toastr_success', 'Data Dengan Nama' . $this->input->post('NamaSiswa') . ' berhasil disimpan!');
						redirect(base_url("User_admin/TabelMurid"));
					} else {
						// Memuat tampilan view untuk input data murid jika terdapat data yang sama
						$content['kelas'] = $this->M_UserCek->DataKelasOnly();
						$this->load->view('halaman/content/halamanSistem/tabelmurid_insert', $content);
						$this->session->set_flashdata('toastr_info', 'Terdapat Data Yang Sama!');
					}
				} elseif ($jenis == 'DataMasuk') {
					$namaSiswa = $this->input->post('NamaSiswa');
					if ($namaSiswa) {
						$DataMasuk = array(
							'NamaSiswa' => $namaSiswa,
							'NisSiswa' => $this->input->post('NisSiswa'),
							'GenderSiswa' => $this->input->post('GenderSiswa'),
							'KodeKelas' => $this->input->post('KodeKelas'),
							'AyahSiswa' => $this->input->post('AyahSiswa'),
							'IbuSiswa' => $this->input->post('IbuSiswa'),
							'TglLhrSiswa' => $this->input->post('TglLhrSiswa'),
							'TmptLhrSiswa' => $this->input->post('TmptLhrSiswa'),
							'NISNSiswa' => $this->input->post('NISNSiswa'),
							'TGLMasuk' => $this->input->post('TGLMasuk'),
							'Wali' => 'Tidak'
						);
						if ($this->M_UserCek->DataMuridCek($DataMasuk) == TRUE) {
							$this->M_UserCek->DataMuridInsert($DataMasuk);
							$this->session->set_flashdata('toastr_success', 'Data berhasil disimpan!');
							redirect(base_url("User_admin/TabelMurid"));
						} else {
							$content['kelas'] = $this->M_UserCek->DataKelasOnly();
							$this->load->view('halaman/content/halamanSistem/tabelmurid_insert', $content);
							$this->session->set_flashdata('toastr_info', 'Terdapat Data Yang Sama!');
						}
					}
				} else {
					redirect(base_url("User_login"));
					exit;
				}
			} else {
				// Memuat tampilan view data murid
				$this->load->view('halaman/content/halamanSistem/admin/tabelmurid', $content);
			}

			// Memuat tampilan view footer
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004);
		}
	}
	public function ServerSide_MuridByID()
	{
		$where = array('IDSiswa' => $this->input->get('IDSiswa'));
		// $Data['message'] = 'success'; // Mengirimkan kriteria pencarian ke model
		$Data['Data'] = $this->M_UserCek->DataMuridAmbilArr($where); // Mengirimkan kriteria pencarian ke model

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($Data));
	}





	public function TabelMapel($fungsi = null, $kode = null)
	{
		// Admin
		if ($this->session->userdata('Status') !== "Login") {
			redirect(base_url("User_login"));
		} else {
			$Data002 = array(
				'KodeGuru' => $this->session->userdata('KodeGuru'),
				'NamaGuru' => $this->session->userdata('NamaGuru'),
				'UsrGuru' => $this->session->userdata('UsrGuru'),
				'KodeMapel' => $this->session->userdata('KodeMapel'),
				'IDHak' => $this->session->userdata('IDHak'),
				'IDAjaran' => $this->session->userdata('IDjaran')
			);
			$Data003['SISTEM'] = $this->M_UserCek->APPNAME();
			$Data003['IDHak'] = $this->session->userdata('IDHak');
			$Data003['Fitur'] = $this->M_UserCek->FiturSistem();
			$Data003['aktif'] = 'TabelMapel';
			$Data003['HakAkses'] = $this->M_UserCek->DataHakakses();
			$Data004['ButuhTabel'] = TRUE;
			$Data004['ButuhForm'] = TRUE;
			$content['TabelMapel'] = $this->M_UserCek->DataMataPelajaran();
			$this->load->view('halaman/template/001', $Data004);
			$this->load->view('halaman/template/002(UPPER)', $Data002);
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003);
			if ($fungsi === null) {
				$this->load->view('halaman/content/halamanSistem/admin/tabelmapel', $content);
			} elseif ($fungsi === 'DataMasuk') {
				$kodeMapel = $this->input->post('KodeMapel');
				if ($kodeMapel) {
					$where = array('KodeMapel' => $kodeMapel);
					$cek = $this->M_UserCek->DataMataPelajaranCek($where);
					if ($cek === FALSE) {
						$DataMasuk = array(
							'KodeMapel' => $kodeMapel,
							'NamaMapel' => $this->input->post('NamaMapel')
						);
						$this->M_UserCek->DataMataPelajaranInsert($DataMasuk);
						$this->session->set_flashdata('toastr_success', 'Data berhasil disimpan!');
						redirect(base_url("User_admin/TabelMapel"));
					} else {
						// $this->M_UserCek->DataMataPelajaranUpdate($where,$DataMasuk);
						$this->session->set_flashdata('toastr_info', 'Data yang dimasukkan telah ada!!');
						redirect(base_url("User_admin/TabelMapel"));
					}
				}
			} elseif ($fungsi === 'DataUpdate') {
				if ($this->input->post('IDMapel') !== null) {
					$where = array('IDMapel' => $this->input->post('IDMapel'));
					$DataMasuk = array(
						'KodeMapel' => $this->input->post('KodeMapel'),
						'NamaMapel' => $this->input->post('NamaMapel')
					);
					$this->M_UserCek->DataMataPelajaranUpdate($where, $DataMasuk);
					$this->session->set_flashdata('toastr_success', 'Data berhasil diubah!');
					redirect(base_url("User_admin/TabelMapel"));
				}
			} elseif ($fungsi === 'DataHapus' && $kode !== null) {
				$where = array('IDMapel' => $kode);
				$this->M_UserCek->DataMataPelajaranDelete($where);
				$this->session->set_flashdata('toastr_success', 'Data berhasil dihapus!');
				redirect(base_url("User_admin/TabelMapel"));
			}
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004);
		}
	}

	public function TabelGuru($jenis = null, $id = null)
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
				'KodeGuru' => $this->session->userdata('KodeGuru'),
				'NamaGuru' => $this->session->userdata('NamaGuru'),
				'UsrGuru' => $this->session->userdata('UsrGuru'),
				'KodeMapel' => $this->session->userdata('KodeMapel'),
				'IDHak' => $this->session->userdata('IDHak'),
				'IDAjaran' => $this->session->userdata('IDjaran')
			);

			// Menyiapkan data yang diperlukan untuk sidebar
			$Data003['Fitur'] = $this->M_UserCek->FiturSistem();
			$Data003['aktif'] = 'TabelGuru';
			$Data003['HakAkses'] = $this->M_UserCek->DataHakakses();
			$Data003['IDHak'] = $this->session->userdata('IDHak');
			$Data003['SISTEM'] = $this->M_UserCek->APPNAME();

			// Menyiapkan data yang diperlukan untuk konten halaman
			$Data004['ButuhTabel'] = TRUE;
			$Data004['ButuhForm'] = TRUE;

			// Mengambil data guru, hak akses, mata pelajaran dari model
			$content['tabel'] = $this->M_UserCek->DataGuru();
			$content['tabel2'] = $this->M_UserCek->DataHakakses();
			$content['mapel'] = $this->M_UserCek->DataMapel();
			$content['hakakses'] = $this->M_UserCek->DataHakakses();
			$content['TabelMengajarMapel'] = $this->M_UserCek->ReadDataGuruMengajar();

			// Memuat tampilan berdasarkan template dan data yang telah disiapkan
			$this->load->view('halaman/template/001', $Data004); // Template bagian atas
			$this->load->view('halaman/template/002(UPPER)', $Data002); // Template bagian header
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003); // Template bagian sidebar

			// Fungsi Halaman
			if ($jenis != null) {
				if ($jenis == 'Edit') {
					// Menyiapkan kondisi WHERE dan data Edit
					$Where = array('KodeGuru' => $id);
					$content['Edit'] = $this->M_UserCek->DataGuruWhere($Where);
					$Where2 = array('tb_guru.KodeGuru' => $id);
					$content['Mengajar'] = $this->M_UserCek->ReadDataGuruMengajarby($Where2);
					$this->load->view('halaman/content/halamanSistem/admin/tabelguru_edit', $content);
				} elseif ($jenis == 'DataUpdate') {
					// Menyiapkan data untuk update dan melakukan validasi
					if ($this->input->post('IDGuru') != null) {
						$DataMasuk = array(
							'UsrGuru' => $this->input->post('UsrGuru'),
							'KodeGuru' => $this->input->post('KodeGuru'),
							'NamaGuru' => $this->input->post('NamaGuru'),
							'NomorHP' => $this->input->post('NomorHP'),
							'KodeMapel' => null,
							'NomorIndukGuru' => $this->input->post('NomorIndukGuru'),
							'IDHak' => implode('//', $this->input->post('IDHak')),
							'PassGuru' => $this->input->post('PassGuru2')
						);
						$cek = $this->input->post('IDGuru');
						if ($this->M_UserCek->DataGuruCekWhere($DataMasuk, $cek) == TRUE) {
							$where['IDGuru'] = $this->input->post('IDGuru');
							$this->M_UserCek->DataGuruUpdate($DataMasuk, $where);
							$data = $this->M_UserCek->DataGuruAmbilWhere($where);
							foreach ($data as $g) {
								$IDGuru = $g->IDGuru;
							}
							$HitungMapel = count($this->input->post('IDMapel'));
							if ($this->input->post('IDMapel')[0] !== '0') {
								$where2 = array('tb_guru.IDGuru' => $this->input->post('IDGuru'));
								$CekMapel = $this->M_UserCek->ReadDataGuruMengajarby($where2);
								if ($CekMapel !== false) {
									$DataHapus = 0;
									$DataMasuk = 0;
									$DataAda = array();
									foreach ($CekMapel as $item) {
										$DataAda[] = $item->IDMapel;
									}
									$differences1 = array_diff($DataAda, $this->input->post('IDMapel'));
									$differences2 = array_diff($this->input->post('IDMapel'), $DataAda);

									if (empty($differences1) && empty($differences2)) {
									} else {
										if (!empty($differences1)) {
											foreach ($differences1 as $value) {
												$where3 = array(
													'IDGuru' => $this->input->post('IDGuru'),
													'IDMapel' => $value
												);
												$this->M_UserCek->DeleteDataMengajar($where3);
												$DataHapus++;
											}
										}
										if (!empty($differences2)) {
											foreach ($differences2 as $value) {
												$where3 = array(
													'IDGuru' => $this->input->post('IDGuru'),
													'IDMapel' => $value
												);
												$this->M_UserCek->InsertDataMengajar($where3);
												$DataMasuk++;
											}
										}
									}
									$this->session->set_flashdata('toastr_success', 'Memasukkan ' . $DataMasuk . ' Mata Pelajaran dan Menghapus ' . $DataHapus . ' Mata Pelajaran');
									redirect(base_url("User_admin/TabelGuru"));
								}
							} else {
								$where2 = array('IDGuru' => $this->input->post('IDGuru'));
								$this->M_UserCek->DeleteDataMengajar($where2);
								$this->session->set_flashdata('toastr_success', 'Berhasil Menetapkan sebagai bukan guru!');
								redirect(base_url("User_admin/TabelGuru"));
							}
						} else {
							$where['IDGuru'] = $this->input->post('IDGuru');
							$Data = $this->M_UserCek->DataGuruWhereArr($where);
							$this->session->set_flashdata('toastr_info', 'Terdapat Data Yang Sama!');
							redirect(base_url("User_admin/TabelGuru/Edit/" . $Data[0]['KodeGuru']));
						}
					}
				} elseif ($jenis == 'DataMasuk') {
					// Menyiapkan kondisi untuk memasukkan data baru (INSERT)
					$Data004['ButuhTabel'] = TRUE;
					if ($this->input->post('InsertData') && $this->input->post('InsertData') == 'Guru') {
						$where = array(
							'UsrGuru' => $this->input->post('UsrGuru'),
							'KodeGuru' => $this->input->post('KodeGuru'),
							'NamaGuru' => $this->input->post('NamaGuru'),
							'NomorIndukGuru' => $this->input->post('NomorIndukGuru')
						);
						if ($this->M_UserCek->DataGuruCek($where) == TRUE) {
							$DataMasuk = array(
								'UsrGuru' => $this->input->post('UsrGuru'),
								'KodeGuru' => $this->input->post('KodeGuru'),
								'NamaGuru' => $this->input->post('NamaGuru'),
								'NomorIndukGuru' => $this->input->post('NomorIndukGuru'),
								'IDHak' => implode('//', $this->input->post('IDHak')),
								'Status' => 0,
								'PassGuru' => $this->input->post('PassGuru2')
							);
							$this->M_UserCek->DataGuruInsert($DataMasuk);
							$data = $this->M_UserCek->DataGuruAmbilWhere($where);
							foreach ($data as $g) {
								$IDGuru = $g->IDGuru;
							}
							$hitung = count($this->input->post('IDMapel'));
							for ($i = 0; $i < $hitung; $i++) {
								$DataMasuk2 = array(
									'IDGuru' => $IDGuru,
									'IDMapel' => $this->input->post('IDMapel')[$i]
								);
								$this->M_UserCek->InsertDataMengajar($DataMasuk2);
								if ($i + 1 == $hitung) {
									$this->session->set_flashdata('toastr_success', 'Berhasil Menambah Data!');
									redirect(base_url("User_admin/TabelGuru"));
								}
							}
						} else {
							$this->load->view('halaman/content/halamanSistem/admin/tabelguru_add', $content);
							$this->session->set_flashdata('toastr_info', 'Terdapat Data Yang Sama!');
						}
					} else {
						redirect(base_url("User_admin/TabelGuru"));
					}
				} elseif ($jenis == 'TambahData') {

					$this->load->view('halaman/content/halamanSistem/admin/tabelguru_add', $content);
				} elseif ($jenis == 'Hapus' && $id !== null) {
					$where = array('IDGuru' => $id);
					$this->M_UserCek->DataGuruDelete($where);
					$this->session->set_flashdata('toastr_success', 'Berhasil Menghapus Data!');
					redirect(base_url("User_admin/TabelGuru"));
				} else {
					// Jika jenis tidak sesuai, arahkan kembali ke halaman login
					redirect(base_url("User_admin/TabelGuru"));
				}
			} else {
				// Menampilkan halaman tabel guru
				$this->load->view('halaman/content/halamanSistem/admin/tabelguru', $content);
			}
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004); // Template bagian bawah
		}
	}
	public function TabelGuruExcell()
	{
		// Query data dari model
		if ($this->session->userdata('Status') !== "Login") {
			redirect(base_url("User_login"));
		} else {
			$this->load->model('M_ExportImport');
			$content['DataGuru'] = $this->M_ExportImport->DataGuruAmbilArray();
			$content['DataMapelGuru'] = $this->M_ExportImport->ReadDataMengajarArray();
			$content['Keterangan'] = $this->M_ExportImport->DataHakaksesArray();
			$content['Keterangan2'] = $this->M_ExportImport->DataMapelArray();
			$this->load->view('halaman/export/TabelGuruExcell', $content);
		}
	}
	public function TabelGuruPDF()
	{
		// Memeriksa apakah sesi 'Status' telah diatur sebagai "Login"
		if ($this->session->userdata('Status') !== "Login") {
			// Jika belum login, arahkan kembali ke halaman login
			redirect(base_url("User_login"));
		} else {
			$this->load->model('M_ExportImport');
			$content['APPNAME'] = $this->M_ExportImport->APPNAMEarr();
			$content['tabel'] = $this->M_UserCek->DataGuruAmbil();
			$this->load->view('halaman/content/halamanSistem/admin/DataUser/DataUser', $content);
		}
	}

	public function WaliMurid($fungsi = null, $eksekusi = null, $id = null)
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
				'KodeGuru' => $this->session->userdata('KodeGuru'),
				'NamaGuru' => $this->session->userdata('NamaGuru'),
				'UsrGuru' => $this->session->userdata('UsrGuru'),
				'KodeMapel' => $this->session->userdata('KodeMapel'),
				'IDHak' => $this->session->userdata('IDHak'),
				'IDAjaran' => $this->session->userdata('IDjaran')
			);

			// Menyiapkan data yang diperlukan untuk sidebar
			$Data003['SISTEM'] = $this->M_UserCek->APPNAME();
			$Data003['Fitur'] = $this->M_UserCek->FiturSistem();
			$Data003['aktif'] = 'TabelOrtu';
			$Data003['HakAkses'] = $this->M_UserCek->DataHakakses();
			$Data003['IDHak'] = $this->session->userdata('IDHak');

			// Menyiapkan data yang diperlukan untuk konten halaman
			$Data004['ButuhTabel'] = TRUE;
			$Data004['ButuhForm'] = TRUE;

			// Mengambil data wali murid, tahun ajaran, kelas, dan murid dari model
			$content['WaliMurid'] = $this->M_UserCek->getSiswaWithOrtu();
			$content['DataTahun'] = $this->M_UserCek->AmbilTahun();
			$content['DataKelas'] = $this->M_UserCek->DataKelasAmbil();
			$where1 = array('Wali' => 'Tidak');
			$content['DataMurid'] = $this->M_UserCek->DataMuridBy($where1);

			// Memuat tampilan berdasarkan template dan data yang telah disiapkan
			$this->load->view('halaman/template/001', $Data004); // Template bagian atas
			$this->load->view('halaman/template/002(UPPER)', $Data002); // Template bagian header
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003); // Template bagian sidebar

			// Fungsi Halaman
			if ($fungsi === null) {
				// Menampilkan halaman tabel wali murid
				$this->load->view('halaman/content/halamanSistem/admin/tabelwalimurid', $content);
			} elseif ($fungsi === 'InputData' && $eksekusi === 'Save') {
				// Menyiapkan data masuk untuk input dan melakukan validasi
				if ($this->input->post()) {
					$DataMasuk = array(
						'NamaOrtu' => $this->input->post('NamaOrtu'),
						'NomorHP' => str_replace("-", "", $this->input->post('NomorHP')),
						'UsrOrtu' => $this->input->post('UsrOrtu'),
						'PassOrtu' => $this->input->post('PassOrtu1'),
						'NisSiswa' => $this->input->post('NisSiswa'),
						'Alamat' => $this->input->post('Alamat')
					);
					$where = array('UsrOrtu' => $this->input->post('UsrOrtu'));
					$cek = $this->M_UserCek->DataWaliMuridWhere($where);
					if ($cek === FALSE) {
						$where2 = array('NisSiswa' => $this->input->post('NisSiswa'));
						$update = array('Wali' => 'Ada');
						$this->M_UserCek->DataMuridUpdate($where2, $update);
						$this->M_UserCek->DataWaliInsert($DataMasuk);
						$this->session->set_flashdata('toastr_success', 'Berhasil Menambah Data!');
						redirect(base_url("User_admin/WaliMurid"));
					} else {
						// Redirect jika data yang sama ditemukan
						$this->session->set_flashdata('toastr_info', 'Anda Memasukkan Data Yang Sama!');
						redirect(base_url("User_admin/WaliMurid"));
					}
				}
			} elseif ($fungsi === 'InputData') {
				// Menampilkan halaman input data wali murid
				$this->load->view('halaman/content/halamanSistem/admin/tabelwalimurid_add', $content);
			} elseif ($fungsi === 'EditData' && $eksekusi === 'Edit' && $id !== null) {
				$where = array('tb_ortu.IDOrtu' => $id);
				$content['DataEdit'] = $this->M_UserCek->AmbilDataWaliSiswa($where);
				$this->load->view('halaman/content/halamanSistem/admin/tabelwalimurid_edit', $content);
			} elseif ($fungsi === 'UpdateData' && $eksekusi === 'Update') {
				if ($this->input->post()) {
					$DataMasuk = array(
						'NamaOrtu' => $this->input->post('NamaOrtu'),
						'NomorHP' => str_replace("-", "", $this->input->post('NomorHP')),
						'UsrOrtu' => $this->input->post('UsrOrtu'),
						'PassOrtu' => $this->input->post('PassOrtu1'),
						'NisSiswa' => $this->input->post('NisSiswa'),
						'Alamat' => $this->input->post('Alamat')
					);
					$where = array('UsrOrtu' => $this->input->post('UsrOrtu'));
					$where2 = $this->input->post('IDOrtu'); // 'IDOrtu' seharusnya digunakan sebagai $where2, bukan $where
					$cek = $this->M_UserCek->DataWaliMuridWhereAnd($where, $where2);

					if ($cek !== FALSE) {
						// Redirect jika data yang sama ditemukan
						$this->session->set_flashdata('toastr_info', 'Anda Memasukkan Data Yang Sama!');
						redirect(base_url("User_admin/WaliMurid/EditData/Edit/" . $this->input->post('IDOrtu')));
					} elseif ($cek === FALSE) {
						$where3 = array('NisSiswa' => $this->input->post('NisSiswa'));
						$update = array('Wali' => 'Ada');
						$this->M_UserCek->DataMuridUpdate($where3, $update);
						$this->M_UserCek->DataWaliUpdate($where2, $DataMasuk);
						$this->session->set_flashdata('toastr_success', 'Data Telah Dirubah!');
						redirect(base_url("User_admin/WaliMurid/"));
					}
				}
			} elseif ($fungsi === 'DeleteData' && $eksekusi === 'Delete') {
				if ($this->input->post()) {
					if ($this->input->post('IDOrtu')) {
						$where = array('IDOrtu' => $this->input->post('IDOrtu'));
						foreach ($this->M_UserCek->DataWaliMuridWhere($where) as $key) {
							$NisSiswa = $key->NisSiswa;
						}
						$where2 = array('NisSiswa' => $NisSiswa);
						$mutasi = array('Wali' => 'Tidak');
						$this->M_UserCek->DataMuridUpdate($where2, $mutasi);
						$this->M_UserCek->DataWaliDelete($where);
						$this->session->set_flashdata('toastr_success', 'Data Telah DiHapus!');
						redirect(base_url("User_admin/WaliMurid/"));
					}
				}
			}

			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004); // Template bagian bawah
		}
	}

	public function TabelTingkatan()
	{
		if ($this->session->userdata('Status') !== "Login") {
			// Jika belum login, arahkan kembali ke halaman login
			redirect(base_url("User_login"));
		} else {
			// Jika sudah login, lanjutkan eksekusi berikutnya

			// Menyiapkan data yang diperlukan untuk header bagian atas
			$Data002 = array(
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
				'aktif' => 'TabelTingkatan'
			);
			// Mengambil informasi nama sistem dari model dan menambahkannya ke data sidebar
			$Data003['SISTEM'] = $this->M_UserCek->APPNAME();
			// Mengambil informasi ID hak akses pengguna dan menambahkannya ke data sidebar
			$Data003['Fitur'] = $this->M_UserCek->FiturSistem();
			$Data003['IDHak'] = $this->session->userdata('IDHak');
			$Data003['HakAkses'] = $this->M_UserCek->DataHakakses();



			// Menyiapkan data yang diperlukan untuk konten halaman
			$Data004['ButuhTabel'] = TRUE;
			$Data004['ButuhForm'] = TRUE;

			// Mengambil informasi jumlah murid, guru, dan kelas dari model dan menambahkannya ke data konten
			$content['Jumlah_Murid'] = $this->M_UserCek->DataMuridAmbilAllNumber();
			$content['Jumlah_Guru'] = $this->M_UserCek->DataGuruAmbilAllNumber();
			$content['Jumlah_Staff'] = $this->M_UserCek->DataStaffAmbilAllNumber();
			$content['Jumlah_Kelas'] = $this->M_UserCek->DataKelasAmbilAllNumber();
			$content['TabelTingkat'] = $this->M_UserCek->AmbilTahun();

			// Memuat tampilan berdasarkan template dan data yang telah disiapkan
			$this->load->view('halaman/template/001', $Data004); // Template bagian atas
			$this->load->view('halaman/template/002(UPPER)', $Data002); // Template bagian header
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003); // Template bagian sidebar
			$this->load->view('halaman/content/halamanSistem/admin/tabeltingkat', $content);
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004); // Template bagian bawah
		}
	}

	public function TabelTingakatanCRUD()
	{
		if ($this->session->userdata('Status') !== "Login") {
			// Jika belum login, arahkan kembali ke halaman login
			redirect(base_url("User_login"));
		} else {
			if ($this->input->post()) {
				if ($this->input->post('InsertData') && $this->input->post('InsertData') == 'Tingkatan') {
					$DataMasuk = array(
						'KodeTahun' => $this->input->post('KodeTahun'),
						'PenyebutanTahun' => $this->input->post('Penyebutan'),
						'PenulisanTahun' => $this->input->post('Penulisan'),
						'Keterangan' => ''
					);
					$this->M_UserCek->InsertTahun($DataMasuk);
					$this->session->set_flashdata('toastr_success', 'Data Telah disimpan!');
					redirect(base_url("User_admin/TabelTingkatan"));
				} elseif ($this->input->post('HapusData') && $this->input->post('HapusData') == 'Tingkatan') {
					$where = array('IDTahun' => $this->input->post('IDTahun'));
					$this->M_UserCek->DeleteTahun($where);
					$this->session->set_flashdata('toastr_success', 'Data Telah dihapus!');
					redirect(base_url("User_admin/TabelTingkatan"));
				}
			}
		}
	}


	public function HariPembelajaran()
	{
		if ($this->session->userdata('Status') !== "Login") {
			// Jika belum login, arahkan kembali ke halaman login
			redirect(base_url("User_login"));
		} else {
			// Jika sudah login, lanjutkan eksekusi berikutnya

			// Menyiapkan data yang diperlukan untuk header bagian atas
			$Data002 = array(
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
				'aktif' => 'HariPembelajaran'
			);
			// Mengambil informasi nama sistem dari model dan menambahkannya ke data sidebar
			$Data003['SISTEM'] = $this->M_UserCek->APPNAME();
			// Mengambil informasi ID hak akses pengguna dan menambahkannya ke data sidebar
			$Data003['Fitur'] = $this->M_UserCek->FiturSistem();
			$Data003['IDHak'] = $this->session->userdata('IDHak');
			$Data003['HakAkses'] = $this->M_UserCek->DataHakakses();



			// Menyiapkan data yang diperlukan untuk konten halaman
			$Data004['ButuhTabel'] = TRUE;
			$Data004['ButuhForm'] = TRUE;

			// Mengambil informasi jumlah murid, guru, dan kelas dari model dan menambahkannya ke data konten
			$content['Jumlah_Murid'] = $this->M_UserCek->DataMuridAmbilAllNumber();
			$content['Jumlah_Guru'] = $this->M_UserCek->DataGuruAmbilAllNumber();
			$content['Jumlah_Staff'] = $this->M_UserCek->DataStaffAmbilAllNumber();
			$content['Jumlah_Kelas'] = $this->M_UserCek->DataKelasAmbilAllNumber();
			$content['TabelTingkat'] = $this->M_UserCek->AmbilTahun();

			$content['tabel'] = $this->M_UserCek->ReadHari();

			// Memuat tampilan berdasarkan template dan data yang telah disiapkan
			$this->load->view('halaman/template/001', $Data004); // Template bagian atas
			$this->load->view('halaman/template/002(UPPER)', $Data002); // Template bagian header
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003); // Template bagian sidebar
			$this->load->view('halaman/content/halamanSistem/admin/haripembelajaran', $content);
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004); // Template bagian bawah
		}
	}

	public function HariPembelajaranCRUD($fungsi = null)
	{
		if ($this->session->userdata('Status') !== "Login") {
			// Jika belum login, arahkan kembali ke halaman login
			redirect(base_url("User_login"));
		} else {
			if ($fungsi !== null) {
				if ($fungsi == 'DataMasuk') {
					$data = array(
						'UrutanKe' => $this->input->post('UrutanKe'),
						'KodeHari' => $this->input->post('KodeHari'),
						'NamaHari' => $this->input->post('NamaHari')
					);
					$this->M_UserCek->InsertHari($data);
					$this->session->set_flashdata('toastr_success', 'Data Berhasil ditambahkan!');
					redirect(base_url("User_admin/HariPembelajaran"));
				} elseif ($fungsi == 'DataUpdate') {
					if ($this->input->post('IDHari')) {
						$where = array('IDHari' => $this->input->post('IDHari'));
						$data = array(
							'UrutanKe' => $this->input->post('UrutanKe'),
							'KodeHari' => $this->input->post('KodeHari'),
							'NamaHari' => $this->input->post('NamaHari')
						);
						$this->M_UserCek->UpdateHari($data, $where);
						$this->session->set_flashdata('toastr_success', 'Data Berhasil diubah!');
						redirect(base_url("User_admin/HariPembelajaran"));
					}
				} elseif ($fungsi == 'DataHapus') {
					if ($this->input->post('IDHari')) {
						$where = array('IDHari' => $this->input->post('IDHari'));
						$this->M_UserCek->DeleteHari($where);
						$this->session->set_flashdata('toastr_success', 'Data Berhasil dihapus!');
						redirect(base_url("User_admin/HariPembelajaran"));
					}
				}
			}
		}
	}



	public function JamPembelajaran($fungsi = null, $id = null)
	{
		if ($this->session->userdata('Status') !== "Login") {
			// Jika belum login, arahkan kembali ke halaman login
			redirect(base_url("User_login"));
		} else {
			// Jika sudah login, lanjutkan eksekusi berikutnya

			// Menyiapkan data yang diperlukan untuk header bagian atas
			$Data002 = array(
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
				'aktif' => 'JamPembelajaran'
			);
			// Mengambil informasi nama sistem dari model dan menambahkannya ke data sidebar
			$Data003['SISTEM'] = $this->M_UserCek->APPNAME();
			// Mengambil informasi ID hak akses pengguna dan menambahkannya ke data sidebar
			$Data003['Fitur'] = $this->M_UserCek->FiturSistem();
			$Data003['IDHak'] = $this->session->userdata('IDHak');
			$Data003['HakAkses'] = $this->M_UserCek->DataHakakses();
			

			// Menyiapkan data yang diperlukan untuk konten halaman
			$Data004['ButuhTabel'] = TRUE;
			$Data004['ButuhForm'] = TRUE;

			// Mengambil informasi jumlah murid, guru, dan kelas dari model dan menambahkannya ke data konten
			$content['Jumlah_Murid'] = $this->M_UserCek->DataMuridAmbilAllNumber();
			$content['Jumlah_Guru'] = $this->M_UserCek->DataGuruAmbilAllNumber();
			$content['Jumlah_Staff'] = $this->M_UserCek->DataStaffAmbilAllNumber();
			$content['Jumlah_Kelas'] = $this->M_UserCek->DataKelasAmbilAllNumber();
			$content['TabelTingkat'] = $this->M_UserCek->AmbilTahun();
			$content['TabelHari'] = $this->M_UserCek->ReadHari();

			// Memuat tampilan berdasarkan template dan data yang telah disiapkan
			$this->load->view('halaman/template/001', $Data004); // Template bagian atas
			$this->load->view('halaman/template/002(UPPER)', $Data002); // Template bagian header
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003); // Template bagian sidebar

			if ($this->input->post('CariData') == 'HariJam') {
				if ($this->input->post('IDHari')) {
					$where = array('IDHari' => $this->input->post('IDHari'));
					$content['TabelJam'] = $this->M_UserCek->AmbilJamPelajaranBy($where);
				}
			} elseif ($fungsi == 'Detail' && $id !== null) {
				$where = array('IDHari' => $id);
				$content['TabelJam'] = $this->M_UserCek->AmbilJamPelajaranBy($where);
				$content['IDHari'] = $id;
			} else {
				$content['TabelJam'] = false;
			}

			$this->load->view('halaman/content/halamanSistem/admin/jampembelajaran', $content);
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004); // Template bagian bawah
		}
	}


	public function JamPembelajaranCRUD()
	{
		if ($this->session->userdata('Status') !== "Login") {
			// Jika belum login, arahkan kembali ke halaman login
			redirect(base_url("User_login"));
		} else {
			if ($this->input->post('JamPembelajaran') && $this->input->post('JamPembelajaran') == 'TambahData') {
				$updated = 0;
				$inserted = 0;
				if ($this->input->post('IDJamPel')) {
					$hitung = count($this->input->post('IDJamPel'));
					for ($i = 0; $i < $hitung; $i++) {
						$where = array('IDJamPel' => $this->input->post('IDJamPel')[$i]);
						$DataMasuk = array(
							'IDHari' => $this->input->post('IDHari'),
							'JamKe' => $this->input->post('JamKe')[$i],
							'MulaiJampel' => $this->input->post('MulaiJampel')[$i],
							'AkhirJampel' => $this->input->post('AkhirJampel')[$i]
						);
						$this->M_UserCek->UpdateJamPelajaran($where, $DataMasuk);
						$updated += 1;
					}
					if (count($this->input->post('MulaiJampel')) - $hitung > 0) {
						$hitung2 = $hitung + (count($this->input->post('MulaiJampel')) - $hitung);
						for ($i = $hitung; $i < $hitung2; $i++) {
							$DataMasuk = array(
								'IDHari' => $this->input->post('IDHari'),
								'JamKe' => $this->input->post('JamKe')[$i],
								'MulaiJampel' => $this->input->post('MulaiJampel')[$i],
								'AkhirJampel' => $this->input->post('AkhirJampel')[$i]
							);
							$this->M_UserCek->MasukJamPelajaran($DataMasuk);
							$inserted += 1;
						}
					}

					$this->session->set_flashdata('toastr_success', $updated . ' Data berhasil diubah!<br>' . $inserted . ' Data berhasil dimasukkan!<br>');
					redirect(base_url("User_admin/JamPembelajaran/Detail/" . $this->input->post('IDHari')));
				} else {
					if (count($this->input->post('MulaiJampel')) > 0) {
						$inserted = 0;
						$hitung = count($this->input->post('MulaiJampel'));
						for ($i = 0; $i < $hitung; $i++) {
							$DataMasuk = array(
								'IDHari' => $this->input->post('IDHari'),
								'JamKe' => $this->input->post('JamKe')[$i],
								'MulaiJampel' => $this->input->post('MulaiJampel')[$i],
								'AkhirJampel' => $this->input->post('AkhirJampel')[$i]
							);
							$this->M_UserCek->MasukJamPelajaran($DataMasuk);
							$inserted += 1;
						}
						$this->session->set_flashdata('toastr_success', $inserted . ' Data berhasil dimasukkan!<br>');
						redirect(base_url("User_admin/JamPembelajaran/Detail/" . $this->input->post('IDHari')));
					}
				}
			} elseif ($this->input->post('HapusData') && $this->input->post('HapusData') == 'JamPel') {
				$where = array('IDJamPel' => $this->input->post('IDJamPel'));
				$this->M_UserCek->DeleteJamPelajaran($where);
				$this->session->set_flashdata('toastr_success', $inserted . ' Data berhasil dihapus!<br>');
				redirect(base_url("User_admin/JamPembelajaran/Detail/" . $this->input->post('IDHari')));
			}
		}
	}
	public function JamPembelajaranAJAX()
	{
		if ($this->input->is_ajax_request()) {
			// Proses data yang diterima dari AJAX
			$CopyHari = $this->input->post('CopyHari');
			$hitung = count($CopyHari);
			$jamKe = $this->input->post('JamKe');
			$mulaiJampel = $this->input->post('MulaiJampel');
			$akhirJampel = $this->input->post('AkhirJampel');

			if (count($mulaiJampel) > 0) {
				$successCount = 0; // Jumlah data yang berhasil disimpan
				for ($i = 0; $i < $hitung; $i++) {
					for ($ii = 0; $ii < count($mulaiJampel); $ii++) {
						$DataMasuk = array(
							'IDHari' => $CopyHari[$i],
							'JamKe' => $jamKe[$ii],
							'MulaiJampel' => $mulaiJampel[$ii],
							'AkhirJampel' => $akhirJampel[$ii]
						);
						$result = $this->M_UserCek->MasukJamPelajaran($DataMasuk);
						$successCount++;
					}
				}

				// Cek apakah setidaknya satu data berhasil disimpan
				if ($successCount > 0) {
					$response = array('status' => 'success', 'message' => $successCount . ' data berhasil disalin.');
				} else {
					$response = array('status' => 'failed', 'message' => 'Tidak ada data yang disimpan atau terjadi kesalahan.');
				}
			} else {
				$response = array('status' => 'failed', 'message' => 'Data tidak lengkap atau terjadi kesalahan.');
			}

			// Kirim respons jika diperlukan
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($response));
		} else {
			show_404(); // Jika bukan permintaan AJAX, tampilkan error 404
		}
	}





	public function JadwalKelasMapel($fungsi = null, $IDKode = null)
	{
		if ($this->session->userdata('Status') !== "Login") {
			// Jika belum login, arahkan kembali ke halaman login
			redirect(base_url("User_login"));
		} else {
			// Jika sudah login, lanjutkan eksekusi berikutnya

			// Menyiapkan data yang diperlukan untuk header bagian atas
			$Data002 = array(
				'KodeGuru' 		=> $this->session->userdata('KodeGuru'),
				'NamaGuru' 		=> $this->session->userdata('NamaGuru'),
				'UsrGuru' 		=> $this->session->userdata('UsrGuru'),
				'KodeMapel' 	=> $this->session->userdata('KodeMapel'),
				'IDHak' 		=> $this->session->userdata('IDHak'),
				'IDAjaran' 		=> $this->session->userdata('IDjaran'),
				'IDSemester' 	=> $this->session->userdata('IDSemester')
			);
			// Menyiapkan data yang diperlukan untuk sidebar
			$Data003 = array(
				'UsrGuru' 	=> $this->session->userdata('UsrGuru'),
				'aktif' 	=> 'JadwalKelasMapel'
			);
			// Mengambil informasi nama sistem dari model dan menambahkannya ke data sidebar
			$Data003['SISTEM'] 	= $this->M_UserCek->APPNAME();
			// Mengambil informasi ID hak akses pengguna dan menambahkannya ke data sidebar
			$Data003['Fitur'] = $this->M_UserCek->FiturSistem();
			$Data003['HakAkses'] = $this->M_UserCek->DataHakakses();
			$Data003['IDHak'] 	= $this->session->userdata('IDHak');


			// Menyiapkan data yang diperlukan untuk konten halaman
			$Data004['ButuhTabel'] 	= TRUE;
			$Data004['ButuhForm'] 	= TRUE;

			// Mengambil informasi jumlah murid, guru, dan kelas dari model dan menambahkannya ke data konten
			$content['TabelTingkat'] 	= $this->M_UserCek->AmbilTahun();

			$content['TabelHari'] 				= $this->M_UserCek->ReadHari();
			$content['TabelKelas'] 				= $this->M_UserCek->DataKelas();
			$content['TabelMapel'] 				= $this->M_UserCek->DataMapel();
			$content['DataJampel'] 				= $this->M_UserCek->ReadJampel();
			$content['tabel2'] 					= $this->M_UserCek->DataHakakses();
			$content['TahunAjaran'] 			= $this->M_UserCek->AmbilTahunAjaran();
			$content['tabel'] 					= $this->M_UserCek->DataGuruPengajar();
			$content['TabelGuru'] 				= $this->M_UserCek->DataGuruPengajar();
			$content['DataMapelGuru'] 			= $this->M_UserCek->ReadDataGuruMengajar();
			$content['DataJadwalKelasMapel']	= $this->M_UserCek->ReadJadwalKelasMapel();


			// Memuat tampilan berdasarkan template dan data yang telah disiapkan
			$this->load->view('halaman/template/001', $Data004); // Template bagian atas
			$this->load->view('halaman/template/002(UPPER)', $Data002); // Template bagian header
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003); // Template bagian sidebar
			if ($fungsi == 'Detail' && $IDKode !== null) {
				$where1 = array('IDKelas' => $IDKode);
				$content['DataKelasBy'] = $this->M_UserCek->DataKelasWhere($where1);
				$content['DataGuruMengajar'] = $this->M_UserCek->ReadDataGuruMengajar();
				$content['IDKelasMapel'] = $IDKode;
				if ($this->input->get('IDAjaran') !== null && $this->input->get('Cari') == 'TahunAjaran') {
					$where2 = array(
						'jadwal_kelas_mapel.IDKelas' => $IDKode,
						'jadwal_kelas_mapel.IDAjaran' => $this->input->get('IDAjaran')
					);
					$content['TampilData'] = true;
					$content['DataMapelKelas'] = $this->M_UserCek->ReadJadwalKelasMapelby($where2);
				}
				$this->load->view('halaman/content/halamanSistem/admin/JadwalMengajarKelasMaPelDetail', $content);
			} else {
				$this->load->view('halaman/content/halamanSistem/admin/JadwalMengajarKelasMaPel', $content);
			}
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004); // Template bagian bawah
		}
	}
	public function JadwalKelasMapelCRUD()
	{
		if ($this->session->userdata('Status') !== "Login") {
			// Jika belum login, arahkan kembali ke halaman login
			redirect(base_url("User_login"));
		} else {
			if ($this->input->post('IDTahun') && $this->input->post('IDKelas')) {
				$JMLHKelas = count($this->input->post('IDKelas'));
				$JMLHMaPel = count($this->input->post('IDMapel'));
				$HitungKelas = 0;
				if ($JMLHKelas > 0) {
					for ($i = 0; $i < $JMLHKelas; $i++) {
						$where = array(
							'IDKelas' => $this->input->post('IDKelas')[$i],
							'IDAjaran' => $this->input->post('IDAjaran')
						);
						$CekJadwal = $this->M_UserCek->ReadJadwalKelasMapelbyArray($where);
						if ($CekJadwal !== false) {
							$DataHapus = 0;
							$DataMasuk = 0;
							if ($this->input->post('IDMapel') && !empty($this->input->post('IDMapel'))) {
								$DataAda = array();
								foreach ($CekJadwal as $item) {
									$DataAda[] = $item['IDMapel'];
								}

								$differences1 = array_diff($DataAda, $this->input->post('IDMapel'));
								$differences2 = array_diff($this->input->post('IDMapel'), $DataAda);

								if (empty($differences1) && empty($differences2)) {
									// No differences, no action needed
								} else {
									if (!empty($differences1)) {
										foreach ($differences1 as $diff) {
											$where2 = array(
												'IDKelas' => $this->input->post('IDKelas')[$i],
												'IDMapel' => $diff,
												'IDAjaran' => $this->input->post('IDAjaran')
											);
											$this->M_UserCek->DeleteJadwalKelasMapel($where2);
											$DataHapus++;
										}
									}
									if (!empty($differences2)) {
										foreach ($differences2 as $diff) {
											$where2 = array(
												'IDKelas' => $this->input->post('IDKelas')[$i],
												'IDMapel' => $diff,
												'IDAjaran' => $this->input->post('IDAjaran')
											);
											$this->M_UserCek->InsertJadwalKelasMapelby($where2);
											$DataMasuk++;
										}
									}
								}
								$HitungKelas++;
								if ($HitungKelas == $JMLHKelas) {
									$this->session->set_flashdata('toastr_success', 'Memasukkan ' . $DataMasuk . ' Mata Pelajaran dan Menghapus ' . $DataHapus . ' Mata Pelajaran Dari ' . $HitungKelas . ' Kelas');
									redirect(base_url("User_admin/JadwalKelasMapel"));
								}
							}
						} elseif ($CekJadwal == false) {
							$HitungMapel = 0;
							for ($ii = 0; $ii < $JMLHMaPel; $ii++) {
								$where2 = array(
									'IDKelas' => $this->input->post('IDKelas')[$i],
									'IDMapel' => $this->input->post('IDMapel')[$ii],
									'IDAjaran' => $this->input->post('IDAjaran')
								);
								$this->M_UserCek->InsertJadwalKelasMapelby($where2);
								$HitungMapel++;
							}
							$HitungKelas++;
							if ($HitungKelas == $JMLHKelas) {
								$this->session->set_flashdata('toastr_success', 'Memasukkan ' . $HitungMapel . ' Mata Pelajaran Ke Dalam ' . $HitungKelas . ' Kelas');
								redirect(base_url("User_admin/JadwalKelasMapel"));
							}
						}
					}
				}
			} else {
				$this->session->set_flashdata('toastr_warning', 'Anda belum memilih kelas!');
				redirect(base_url("User_admin/JadwalKelasMapel"));
			}
		}
	}


	public function JadwalKelasMapelGuruCRUD()
	{
		// Admin
		if ($this->session->userdata('Status') !== "Login") {
			redirect(base_url("User_login"));
		} else {
			if ($this->input->post('InputData') && $this->input->post('InputData') == 'GuruMapel') {
				$HitungJMLH = count($this->input->post('IDKelasMapel'));
				$HitungJMLH2 = count($this->input->post('IDGuru'));
				if ($HitungJMLH == $HitungJMLH2) {
					for ($i = 0; $i < $HitungJMLH; $i++) {
						$DataMasuk = array(
							'IDGuru' => $this->input->post('IDGuru')[$i]
						);
						$where = array('IDKelasMapel' => $this->input->post('IDKelasMapel')[$i]);
						$this->M_UserCek->UpdateJadwalKelasMapel($where, $DataMasuk);
					}
				}
				$this->session->set_flashdata('toastr_success', 'Berhasil Memperbarui Informasi!');
				redirect(base_url("User_admin/JadwalKelasMapel/Detail/" . $this->input->post('IDKelas')));
			}
		}
	}




	public function ProfileSekolah()
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
				'aktif' => 'ProfileSekolah'
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
			$content['Jumlah_Guru'] = $this->M_UserCek->DataGuruAmbilAllNumber();
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
			$content['ProfileSekolah'] = $this->M_UserCek->APPNAME();
			$content['NomorWA'] = $this->M_WhatsApp->ReadDataSessionsConnected();
			// Memuat tampilan berdasarkan template dan data yang telah disiapkan
			$this->load->view('halaman/template/001', $Data004); // Template bagian atas
			$this->load->view('halaman/template/002(UPPER)', $Data002); // Template bagian header
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003); // Template bagian sidebar
			$this->load->view('halaman/content/halamanSistem/admin/ProfileSekolah', $content); // Konten halaman dashboard
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004); // Template bagian bawah
		}
	}
	public function ProfileSekolahCRUD()
	{
		// Memeriksa apakah sesi 'Status' telah diatur sebagai "Login"
		if ($this->session->userdata('Status') !== "Login") {
			// Jika belum login, arahkan kembali ke halaman login
			redirect(base_url("User_login"));
		} else {
			if ($this->input->post('id') && $this->input->post('id') !== null) {
				$where = array('id' => $this->input->post('id'));

				if ($this->input->post('Input')) {
					// 29 Januari 2024 || vita rahmada
					if ($this->input->post('Input') == 'Data') {
						// Inisialisasi array untuk data masuk
						$DataMasuk = array(
							'NamaInstansi' => $this->input->post('NamaInstansi'),
							'NamaKepala' => $this->input->post('NamaKepala'),
							'NIPKepala' => $this->input->post('NIPKepala'),
							'Alamat' => $this->input->post('Alamat'),
							'visi' => $this->input->post('visi'),
							'misi' => $this->input->post('misi'),
							'Keterangan' => $this->input->post('Keterangan')
						);

						// Proses upload foto jika ada file yang diunggah
						if (!empty($_FILES['UploadFoto']['name'])) {
							// Konfigurasi upload foto
							$config['upload_path'] = './file/data/gambar/';
							$config['allowed_types'] = 'png'; // Hanya menerima file PNG
							$config['max_size'] = 2048; // Maksimum ukuran file (dalam kilobita)
							$config['overwrite'] = true; // Mengizinkan overwrite jika file dengan nama yang sama sudah ada
							$config['file_name'] = 'TandaTangan'; // Nama file yang akan disimpan di server
							$this->load->library('upload', $config);

							// Lakukan proses upload
							if ($this->upload->do_upload('UploadFoto')) {
								$upload_data = $this->upload->data();
								// Tambahkan nama file foto ke dalam data masuk
								$DataMasuk['Foto'] = $upload_data['file_name'];
							} else {
								// Jika proses upload gagal, set pesan kesalahan
								$this->session->set_flashdata('toastr_warning', 'Gagal Mengunggah Foto, Periksa Kembali File Yang Diunggah!');
								// Redirect ke halaman yang sesuai
								redirect(base_url("User_admin/ProfileSekolah"));
							}
						}

						// Lakukan update data dengan model yang sesuai
						$this->M_UserCek->APPNAMEUpdate($DataMasuk);

						// Set flashdata untuk pesan sukses
						$this->session->set_flashdata('toastr_success', 'Berhasil Memperbarui Informasi!');

						// Redirect ke halaman yang sesuai
						redirect(base_url("User_admin/ProfileSekolah"));
					} 
					elseif ($this->input->post('Input') == 'File') {
						if (!empty($_FILES['UploadLogo']['name'])) {
							$config['upload_path']          = './file/data/gambar/';
							$config['allowed_types']        = 'png|jpg|jpeg';
							$config['max_size']             = 2048;
							$config['overwrite']            = true;
							$config['file_name']            = 'Logo';
							$this->load->library('upload', $config);
							if ($this->upload->do_upload('UploadLogo')) {
								$upload_data = $this->upload->data();
								$DataMasuk = array(
									'Logo' => $upload_data['file_name']
								);
								$this->M_UserCek->APPNAMEUpdate($DataMasuk);
								$this->session->set_flashdata('toastr_success', 'Berhasil Mengubah Logo!');
								redirect(base_url("User_admin/ProfileSekolah"));
							} else {
								$this->session->set_flashdata('toastr_warning', 'Periksa Kembali File Yang Diunggah!');
								redirect(base_url("User_admin/ProfileSekolah"));
							}
						}
					} elseif ($this->input->post('Input') == 'WhatsApp') {
						$DataMasuk = array(
							'NomorWA' => $this->input->post('NomorWA')
						);
						$this->M_UserCek->APPNAMEUpdate($DataMasuk);
						$this->session->set_flashdata('toastr_success', 'Nomor WhatsApp yang digunakan adalah ' . $this->formatNomorTelepon($this->input->post('NomorWA')) . '!');
						redirect(base_url("User_admin/ProfileSekolah"));
					}
				}
			}
		}
	}


	public function JadwalGuruMengajar()
	{
		if ($this->session->userdata('Status') !== "Login") {
			// Jika belum login, arahkan kembali ke halaman login
			redirect(base_url("User_login"));
		} else {
			// Jika sudah login, lanjutkan eksekusi berikutnya

			// Menyiapkan data yang diperlukan untuk header bagian atas
			$Data002 = array(
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
				'aktif' => 'JadwalGuruMengajar'
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
			$content['Jumlah_Staff'] 			= $this->M_UserCek->DataStaffAmbilAllNumber();
			$content['Jumlah_Kelas'] 			= $this->M_UserCek->DataKelasAmbilAllNumber();
			$content['Jumlah_Murid'] 			= $this->M_UserCek->DataMuridAmbilAllNumber();
			$content['Jumlah_Guru'] 			= $this->M_UserCek->DataGuruAmbilAllNumber();
			$content['TabelTingkat'] 			= $this->M_UserCek->AmbilTahun();

			$content['TabelHari'] 				= $this->M_UserCek->ReadHari();
			$content['TabelKelas'] 				= $this->M_UserCek->DataKelas();
			$content['TabelMapel'] 				= $this->M_UserCek->DataMapel();
			$content['DataJampel'] 				= $this->M_UserCek->ReadJampel();
			$content['tabel2'] 					= $this->M_UserCek->DataHakakses();
			$content['tabel'] 					= $this->M_UserCek->DataGuruPengajar();
			$content['TabelGuru'] 				= $this->M_UserCek->DataGuruPengajar();
			$content['DataMapelGuru'] 			= $this->M_UserCek->ReadDataGuruMengajar();
			$content['DataJadwalKelasMapel']	= $this->M_UserCek->ReadJadwalKelasMapel();

			if ($this->input->post('CariData') && $this->input->post('CariData') == 'Jadwal') {
				$content['DataJadwal'] = 'Ada';
				$where = array(
					'jadwal_kelas_mapel.IDGuru' => $this->input->post('IDGuru'),
					'jadwal_kelas_mapel.IDMapel' => $this->input->post('IDMaPel')
				);
				$content['JadwalMapelGuru'] = $this->M_UserCek->ReadJadwalKelasMapelby($where);
				$where3 = array(
					'tg.IDGuru' => $this->input->post('IDGuru'),
					'tgm.IDMaPel' => $this->input->post('IDMaPel')
				);
				$ambilGuru = $this->M_UserCek->GuruMengajar($where3);
				foreach ($ambilGuru as $aG) {
					$content['NamaMaPel'] = $aG->NamaMapel;
					$content['NamaGuru'] = $aG->NamaGuru;
					$content['NomorIndukGuru'] = $aG->NomorIndukGuru;
					$content['IDGuru'] = $aG->IDGuru;
					$content['IDHari'] = $this->input->post('IDHari');
					$content['IDMaPel'] = $this->input->post('IDMaPel');
				}
				$where2 = array('tb_hari.IDHari' => $this->input->post('IDHari'));
				$content['JadwalJamPelajaran'] = $this->M_UserCek->ReadHariJamBy($where2);
			}

			// Memuat tampilan berdasarkan template dan data yang telah disiapkan
			$this->load->view('halaman/template/001', $Data004); // Template bagian atas
			$this->load->view('halaman/template/002(UPPER)', $Data002); // Template bagian header
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003); // Template bagian sidebar
			$this->load->view('halaman/content/halamanSistem/admin/JadwalGuruMengajar', $content);
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004); // Template bagian bawah
		}
	}
	public function JadwalGuruMengajarCRUD()
	{
		if ($this->session->userdata('Status') !== "Login") {
			// Jika belum login, arahkan kembali ke halaman login
			redirect(base_url("User_login"));
		} else {
			$IDGuru = $this->input->post('IDGuru');
			$IDMaPel = $this->input->post('IDMaPel');

			if ($IDGuru && $IDMaPel) {
				$datake = 0;
				$Masuk = 0;
				$where = array();
				$DataMasuk = array();
				$where2 = array();

				foreach ($_POST as $key => $value) {
					if ($datake < 2) {
						$where[$datake] = array(
							$key => $value
						);
					}
					if ($datake > 1) {
						$where2 = array(
							'IDGuru' => $where[0]['IDGuru'],
							'IDMaPel' => $where[1]['IDMaPel']
						);
						$DataMasuk[$Masuk] = array(
							$key => $value
						);
						$Masuk++;
					}
					$datake++;
				}

				print_r($DataMasuk);
			}
		}
	}



	public function JadwalGuruMengajar2()
	{
		if ($this->session->userdata('Status') !== "Login") {
			// Jika belum login, arahkan kembali ke halaman login
			redirect(base_url("User_login"));
		} else {
			// Jika sudah login, lanjutkan eksekusi berikutnya

			// Menyiapkan data yang diperlukan untuk header bagian atas
			$Data002 = array(
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
				'aktif' => 'JadwalGuruMengajar'
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
			$content['Jumlah_Staff'] 			= $this->M_UserCek->DataStaffAmbilAllNumber();
			$content['Jumlah_Kelas'] 			= $this->M_UserCek->DataKelasAmbilAllNumber();
			$content['Jumlah_Murid'] 			= $this->M_UserCek->DataMuridAmbilAllNumber();
			$content['Jumlah_Guru'] 			= $this->M_UserCek->DataGuruAmbilAllNumber();
			$content['TabelTingkat'] 			= $this->M_UserCek->AmbilTahun();

			$content['TabelHari'] 				= $this->M_UserCek->ReadHari();
			$content['TabelKelas'] 				= $this->M_UserCek->DataKelas();
			$content['TabelMapel'] 				= $this->M_UserCek->DataMapel();
			$content['DataJampel'] 				= $this->M_UserCek->ReadJampel();
			$content['tabel2'] 					= $this->M_UserCek->DataHakakses();
			$content['tabel'] 					= $this->M_UserCek->DataGuruPengajar();
			$content['TabelGuru'] 				= $this->M_UserCek->DataGuruPengajar();
			$content['DataMapelGuru'] 			= $this->M_UserCek->ReadDataGuruMengajar();
			$content['DataJadwalKelasMapel']	= $this->M_UserCek->ReadJadwalKelasMapel();

			if ($this->input->post('CariData') && $this->input->post('CariData') == 'Jadwal') {
				$content['DataJadwal'] = 'Ada';
				$where = array(
					'jadwal_kelas_mapel.IDGuru' => $this->input->post('IDGuru'),
					'jadwal_kelas_mapel.IDMapel' => $this->input->post('IDMaPel')
				);
				$content['JadwalMapelGuru'] = $this->M_UserCek->ReadJadwalKelasMapelby($where);

				$where3 = array(
					'tg.IDGuru' => $this->input->post('IDGuru'),
					'tgm.IDMaPel' => $this->input->post('IDMaPel')
				);
				$ambilGuru = $this->M_UserCek->GuruMengajar($where3);

				foreach ($ambilGuru as $aG) {
					$content['NamaMaPel'] = $aG->NamaMapel;
					$content['NamaGuru'] = $aG->NamaGuru;
					$content['NomorIndukGuru'] = $aG->NomorIndukGuru;
					$content['IDGuru'] = $aG->IDGuru;
					$content['IDHari'] = $this->input->post('IDHari');
					$content['IDMaPel'] = $this->input->post('IDMaPel');
				}

				$where2 = array('tb_hari.IDHari' => $this->input->post('IDHari'));
				$content['JadwalJamPelajaran'] = $this->M_UserCek->ReadHariJamBy($where2);
			}
			// Memuat tampilan berdasarkan template dan data yang telah disiapkan
			$this->load->view('halaman/template/001', $Data004); // Template bagian atas
			$this->load->view('halaman/template/002(UPPER)', $Data002); // Template bagian header
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003); // Template bagian sidebar
			$this->load->view('halaman/content/halamanSistem/admin/JadwalGuruMengajar', $content);
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004); // Template bagian bawah
		}
	}
	public function JadwalGuruMengajarCRUD2()
	{
		if ($this->session->userdata('Status') !== "Login") {
			// Jika belum login, arahkan kembali ke halaman login
			redirect(base_url("User_login"));
		} else {
			$IDGuru = $this->input->post('IDGuru');
			$IDMaPel = $this->input->post('IDMaPel');

			if ($IDGuru !== null && $IDMaPel !== null) {
				print_r($_POST);
				echo "<br>";
				$datake = 0;
				$Masuk = 0;
				$where = array();
				$DataMasuk = array();
				$where2 = array();

				foreach ($_POST as $key => $value) {
					if ($datake < 2) {
						$where[$datake] = array(
							$key => $value
						);
					}

					if ($datake > 1) {
						$where2 = array(
							'IDGuru' => $where[0]['IDGuru'],
							'IDMaPel' => $where[1]['IDMaPel']
						);
						$DataMasuk[$Masuk] = array(
							$key => $value
						);
						$Masuk++;
					}

					$datake++;
				}

				print_r($DataMasuk);
			}
		}
	}




	// SURAT DIGITALLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLL

	public function SuratDigital($halaman = null, $IDBaca = null)
	{
		if ($this->session->userdata('Status') !== "Login") {
			// Jika belum login, arahkan kembali ke halaman login
			redirect(base_url("User_login"));
		} else {
			$Data002 = array(
				'KodeGuru' => $this->session->userdata('KodeGuru'),
				'NamaGuru' => $this->session->userdata('NamaGuru'),
				'UsrGuru' => $this->session->userdata('UsrGuru'),
				'KodeMapel' => $this->session->userdata('KodeMapel'),
				'IDHak' => $this->session->userdata('IDHak'),
				'IDAjaran' => $this->session->userdata('IDjaran')
			);
			$Data003['SISTEM'] = $this->M_UserCek->APPNAME();
			$Data003['aktif'] = 'SuratDigital';
			$Data003['HakAkses'] = $this->M_UserCek->DataHakakses();
			$Data003['IDHak'] = $this->session->userdata('IDHak');
			$Data003['Fitur'] = $this->M_UserCek->FiturSistem();
			$Data004['ButuhTabel'] = TRUE;
			$Data004['ButuhForm'] = TRUE;
			$content['TahunAjaran'] = $this->M_UserCek->AmbilTahunAjaran();
			$where[0] = array(
				'sd.IDHak' => '1',
				'sd.status' => 'Terkirim',
				'sd.Sampah' => 'Tidak'
			);
			$content['SuratDigital'] = $this->M_UserCek->SuratDigitalRead($where[0]);
			$this->load->view('halaman/template/001', $Data004);
			$this->load->view('halaman/template/002(UPPER)', $Data002);
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003);
			if ($halaman == null) {
				$this->load->view('halaman/content/halamanSistem/admin/SuratDigital/SuratDigital', $content);
			} elseif ($halaman == 'Baca' && $IDBaca !== null) {
				$where[1] = array(
					'sd.IDSurat' => $IDBaca
				);
				$content['SuratDigitalBaca'] = $this->M_UserCek->SuratDigitalRead($where[1]);
				$this->load->view('halaman/content/halamanSistem/admin/SuratDigital/SuratDigitalBaca', $content);
			} elseif ($halaman == 'Edit' && $IDBaca !== null) {
				$where[1] = array(
					'sd.IDSurat' => $IDBaca
				);
				$content['SuratDigitalBaca'] = $this->M_UserCek->SuratDigitalRead($where[1]);
				$this->load->view('halaman/content/halamanSistem/admin/SuratDigital/SuratDigitalEdit', $content);
			}
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004);
		}
	}
	public function SuratDigitalCRUD($halaman = null, $ID = null)
	{
		if ($this->session->userdata('Status') !== "Login") {
			// Jika belum login, arahkan kembali ke halaman login
			redirect(base_url("User_login"));
		} else {
			if ($halaman == 'Hapus' && $ID !== null) {
				$DataMasuk = array(
					'Sampah' => 'Ya'
				);
				$where = array('IDSurat' => $ID);
				$this->M_UserCek->SuratDigitalUpdate($DataMasuk, $where);
				redirect(base_url("User_admin/SuratDigitalHapus"));
			}
		}
	}
	public function SuratDigitalHapusPermanen($halaman = null, $ID = null)
	{
		if ($this->session->userdata('Status') !== "Login") {
			// Jika belum login, arahkan kembali ke halaman login
			redirect(base_url("User_login"));
		} else {
			if ($halaman == 'Permanen' && $ID !== null) {
				$where = array('IDSurat' => $ID);
				$this->M_UserCek->SuratDigitalDelete($where);
				$this->session->set_flashdata('toastr_success', 'Surat Berhasil Dihapus Permanen!');
				redirect(base_url("User_admin/SuratDigitalHapus"));
			}
		}
	}
	public function SuratDigitalRestore($halaman = null, $ID = null)
	{
		if ($this->session->userdata('Status') !== "Login") {
			// Jika belum login, arahkan kembali ke halaman login
			redirect(base_url("User_login"));
		} else {
			if ($halaman == 'Restore' && $ID !== null) {
				$DataMasuk = array(
					'Sampah' => 'Tidak'
				);
				$where = array('IDSurat' => $ID);
				$this->M_UserCek->SuratDigitalUpdate($DataMasuk, $where);
				$this->session->set_flashdata('toastr_success', 'Surat Berhasil dikembalikan!');
				redirect(base_url("User_admin/SuratDigitalHapus"));
			}
		}
	}
	public function ServerSideSave()
	{
		if ($this->input->is_ajax_request()) {
			// Pastikan ini adalah permintaan AJAX

			// Mengambil data dari permintaan POST

			$subjek = $this->input->post('Subjek');
			$keterangan = $this->input->post('Keterangan');
			$isiSurat = $this->input->post('IsiSurat');
			$kategoriSurat = $this->input->post('KategoriSurat');
			$filterKategori = $this->input->post('FilterKategori');

			// Contoh: Simpan data ke dalam tabel di database menggunakan model
			$dataSimpan = array(
				'KategoriSurat' => $kategoriSurat,
				'SubjekSurat' => $subjek,
				'Keterangan' => $keterangan,
				'IsiSurat' => $isiSurat,
				'Status' => 'Rancangan',
				'IDHak' => '1',
				'IDGuru' => $this->session->userdata('IDGuru'),
				'Sampah' => 'Tidak',
				'TanggalSurat' => date("Y-m-d H:i:s")
			);

			if ($this->input->post('IDSuratDigital') == 0) {
				// Panggil model untuk menyimpan data ke database
				$idSuratBaru = $this->M_UserCek->SuratDigitalInsert($dataSimpan); // Ganti sesuai dengan model dan fungsi Anda
			} elseif ($this->input->post('IDSuratDigital') !== 0) {
				$where = array('IDSurat' => $this->input->post('IDSuratDigital'));
				$idSuratBaru = $this->M_UserCek->SuratDigitalUpdate($dataSimpan, $where);
			}

			if ($idSuratBaru !== false) {
				// Jika berhasil, kirim respons ke AJAX bahwa penyimpanan berhasil
				$response['status'] = 'success';
				$response['message'] = 'Data surat berhasil disimpan!';
				echo json_encode($response);
			} else {
				// Jika terjadi kesalahan, kirim respons ke AJAX bahwa terjadi kesalahan
				$response['status'] = 'error';
				$response['message'] = 'Gagal menyimpan data surat.';
				echo json_encode($response);
			}
		} else {
			// Tangani jika ini bukan permintaan AJAX
		}
	}



	public function SuratDigitalBuat($halaman = null)
	{
		if ($this->session->userdata('Status') !== "Login") {
			// Jika belum login, arahkan kembali ke halaman login
			redirect(base_url("User_login"));
		} else {
			if ($halaman == null) {

				$Data002 = array(
					'KodeGuru' => $this->session->userdata('KodeGuru'),
					'NamaGuru' => $this->session->userdata('NamaGuru'),
					'UsrGuru' => $this->session->userdata('UsrGuru'),
					'KodeMapel' => $this->session->userdata('KodeMapel'),
					'IDHak' => $this->session->userdata('IDHak'),
					'IDAjaran' => $this->session->userdata('IDjaran')
				);
				$Data003['SISTEM'] = $this->M_UserCek->APPNAME();
				$Data003['Fitur'] = $this->M_UserCek->FiturSistem();
				$Data003['aktif'] = 'SuratDigital';
				$Data003['HakAkses'] = $this->M_UserCek->DataHakakses();
				$Data003['IDHak'] = $this->session->userdata('IDHak');
				$Data004['ButuhTabel'] = TRUE;
				$Data004['ButuhForm'] = TRUE;
				$content['TahunAjaran'] = $this->M_UserCek->AmbilTahunAjaran();
				$this->load->view('halaman/template/001', $Data004);
				$this->load->view('halaman/template/002(UPPER)', $Data002);
				$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003);
				$this->load->view('halaman/content/halamanSistem/admin/SuratDigital/SuratDigitalBuat', $content);
				$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
				$this->load->view('halaman/template/004', $Data004);
			} elseif ($halaman == 'Kirim') {
				if ($this->input->post('IDSuratDigital') == '0') {
					$DataMasuk = array(
						'KategoriSurat' => $this->input->post('KategoriSurat'),
						'SubjekSurat' => $this->input->post('Subjek'),
						'Keterangan' => $this->input->post('Keterangan'),
						'IsiSurat' => $this->input->post('IsiSurat'),
						'Status' => 'Terkirim',
						'IDHak' => '1',
						'IDGuru' => $this->session->userdata('IDGuru'),
						'Sampah' => 'Tidak',
						'TanggalSurat' => date("Y-m-d H:i:s")
					);
					if ($this->input->post('KategoriSurat') == 'Khusus') {
						$DataMasuk['FilterKategori'] = $this->input->post('FilterKategori');
					}
					$this->M_UserCek->SuratDigitalInsert($DataMasuk);
					$this->session->set_flashdata('toastr_success', 'Surat Berhasil dikirim!');
					redirect(base_url("User_admin/SuratDigital"));
				} elseif ($this->input->post('IDSuratDigital') !== '0') {
					$DataMasuk = array(
						'KategoriSurat' => $this->input->post('KategoriSurat'),
						'SubjekSurat' => $this->input->post('Subjek'),
						'Keterangan' => $this->input->post('Keterangan'),
						'IsiSurat' => $this->input->post('IsiSurat'),
						'Status' => 'Terkirim',
						'IDGuru' => $this->session->userdata('IDGuru'),
						'Sampah' => 'Tidak',
						'TanggalSurat' => date("Y-m-d H:i:s")
					);
					$where = array('IDSurat' => $this->input->post('IDSuratDigital'));
					if ($this->input->post('KategoriSurat') == 'Khusus') {
						$DataMasuk['FilterKategori'] = $this->input->post('FilterKategori');
					}
					$this->M_UserCek->SuratDigitalUpdate($DataMasuk, $where);
					$this->session->set_flashdata('toastr_success', 'Surat Berhasil diubah!');
					redirect(base_url("User_admin/SuratDigital"));
				}
			}
		}
	}


	public function SuratDigitalDraft($halaman = null, $IDBaca = null)
	{
		if ($this->session->userdata('Status') !== "Login") {
			// Jika belum login, arahkan kembali ke halaman login
			redirect(base_url("User_login"));
		} else {
			$Data002 = array(
				'KodeGuru' => $this->session->userdata('KodeGuru'),
				'NamaGuru' => $this->session->userdata('NamaGuru'),
				'UsrGuru' => $this->session->userdata('UsrGuru'),
				'KodeMapel' => $this->session->userdata('KodeMapel'),
				'IDHak' => $this->session->userdata('IDHak'),
				'IDAjaran' => $this->session->userdata('IDjaran')
			);
			$Data003['SISTEM'] = $this->M_UserCek->APPNAME();
			$Data003['Fitur'] = $this->M_UserCek->FiturSistem();
			$Data003['aktif'] = 'SuratDigital';
			$Data003['HakAkses'] = $this->M_UserCek->DataHakakses();
			$Data003['IDHak'] = $this->session->userdata('IDHak');
			$Data004['ButuhTabel'] = TRUE;
			$Data004['ButuhForm'] = TRUE;
			$content['TahunAjaran'] = $this->M_UserCek->AmbilTahunAjaran();
			$where[0] = array(
				'sd.IDHak' => '1',
				'sd.status' => 'Rancangan',
				'sd.Sampah' => 'Tidak'
			);

			$content['DataSuratDigital'] = $this->M_UserCek->SuratDigitalRead($where[0]);

			$content['SuratDigital'] = $this->M_UserCek->SuratDigitalRead($where[0]);
			$this->load->view('halaman/template/001', $Data004);
			$this->load->view('halaman/template/002(UPPER)', $Data002);
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003);
			if ($halaman == null) {
				$this->load->view('halaman/content/halamanSistem/admin/SuratDigital/SuratDigitalDraft', $content);
			} elseif ($halaman == 'Baca' && $IDBaca !== null) {
				$where[1] = array(
					'sd.IDSurat' => $IDBaca
				);
				$content['SuratDigitalBaca'] = $this->M_UserCek->SuratDigitalRead($where[1]);
				$this->load->view('halaman/content/halamanSistem/admin/SuratDigital/SuratDigitalDraftBaca', $content);
			} elseif ($halaman == 'Edit' && $IDBaca !== null) {
				$where[1] = array(
					'sd.IDSurat' => $IDBaca
				);
				$content['SuratDigitalBaca'] = $this->M_UserCek->SuratDigitalRead($where[1]);
				$this->load->view('halaman/content/halamanSistem/admin/SuratDigital/SuratDigitalDraftEdit', $content);
			}
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004);
		}
	}

	public function SuratDigitalDraftCRUD($halaman = null, $IDSurat = null)
	{
		if ($this->session->userdata('Status') !== "Login") {
			// Jika belum login, arahkan kembali ke halaman login
			redirect(base_url("User_login"));
		} else {
			if ($halaman == 'Simpan' && $this->input->post('IDSuratDigital') == '0') {
				$DataMasuk = array(
					'KategoriSurat' => $this->input->post('KategoriSurat'),
					'SubjekSurat' => $this->input->post('Subjek'),
					'Keterangan' => $this->input->post('Keterangan'),
					'IsiSurat' => $this->input->post('IsiSurat'),
					'Status' => 'Rancangan',
					'IDHak' => '1',
					'IDGuru' => $this->session->userdata('IDGuru'),
					'Sampah' => 'Tidak',
					'TanggalSurat' => date("Y-m-d H:i:s")

				);
				if ($this->input->post('KategoriSurat') == 'Special') {
					$DataMasuk['FilterKategori'] = $this->input->post('FilterKategori');
				}
				$this->M_UserCek->SuratDigitalInsert($DataMasuk);
				$this->session->set_flashdata('toastr_success', 'Surat Berhasil dikirim!');
				redirect(base_url("User_admin/SuratDigital"));
			} elseif ($halaman == 'Simpan' && $this->input->post('IDSuratDigital') !== '0') {
				$DataMasuk = array(
					'KategoriSurat' => $this->input->post('KategoriSurat'),
					'SubjekSurat' => $this->input->post('Subjek'),
					'Keterangan' => $this->input->post('Keterangan'),
					'IsiSurat' => $this->input->post('IsiSurat'),
					'Status' => 'Rancangan',
					'IDHak' => '1',
					'IDGuru' => $this->session->userdata('IDGuru'),
					'Sampah' => 'Tidak',
					'TanggalSurat' => date("Y-m-d H:i:s")

				);
				if ($this->input->post('KategoriSurat') == 'Special') {
					$DataMasuk['FilterKategori'] = $this->input->post('FilterKategori');
				}
				$this->M_UserCek->SuratDigitalInsert($DataMasuk);
				$this->session->set_flashdata('toastr_success', 'Surat Berhasil dikirim!');
				redirect(base_url("User_admin/SuratDigital"));
			}
		}
	}


	public function SuratDigitalHapus($halaman = null, $IDBaca = null)
	{
		if ($this->session->userdata('Status') !== "Login") {
			// Jika belum login, arahkan kembali ke halaman login
			redirect(base_url("User_login"));
		} else {
			$Data002 = array(
				'KodeGuru' => $this->session->userdata('KodeGuru'),
				'NamaGuru' => $this->session->userdata('NamaGuru'),
				'UsrGuru' => $this->session->userdata('UsrGuru'),
				'KodeMapel' => $this->session->userdata('KodeMapel'),
				'IDHak' => $this->session->userdata('IDHak'),
				'IDAjaran' => $this->session->userdata('IDjaran')
			);
			$Data003['SISTEM'] = $this->M_UserCek->APPNAME();
			$Data003['Fitur'] = $this->M_UserCek->FiturSistem();
			$Data003['aktif'] = 'SuratDigital';
			$Data003['HakAkses'] = $this->M_UserCek->DataHakakses();
			$Data003['IDHak'] = $this->session->userdata('IDHak');
			$Data004['ButuhTabel'] = TRUE;
			$Data004['ButuhForm'] = TRUE;
			$content['TahunAjaran'] = $this->M_UserCek->AmbilTahunAjaran();
			$where[0] = array(
				'sd.IDHak' => '1',
				'sd.Sampah' => 'Ya'
			);

			$content['DataSuratDigital'] = $this->M_UserCek->SuratDigitalRead($where[0]);

			$content['SuratDigital'] = $this->M_UserCek->SuratDigitalRead($where[0]);
			$this->load->view('halaman/template/001', $Data004);
			$this->load->view('halaman/template/002(UPPER)', $Data002);
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003);
			if ($halaman == null) {
				$this->load->view('halaman/content/halamanSistem/admin/SuratDigital/SuratDigitalSampah', $content);
			} elseif ($halaman == 'Baca' && $IDBaca !== null) {
				$where[1] = array(
					'sd.IDSurat' => $IDBaca
				);
				$content['SuratDigitalBaca'] = $this->M_UserCek->SuratDigitalRead($where[1]);
				$this->load->view('halaman/content/halamanSistem/admin/SuratDigital/SuratDigitalSampahBaca', $content);
			}
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004);
		}
	}

	public function SuratDigitalHapusMany()
	{
		if ($this->session->userdata('Status') !== "Login") {
			// Jika belum login, arahkan kembali ke halaman login
			redirect(base_url("User_login"));
		} else {
			if ($this->input->post() !== null) {
				$data = $this->input->post('IDSurat');
				$jumlah = 0;
				for ($i = 0; $i < count($this->input->post('IDSurat')); $i++) {
					$where = array('IDSurat' => $data[$i]);
					$DataMasuk = array('Sampah' => 'Ya');
					$this->M_UserCek->SuratDigitalUpdate($DataMasuk, $where);
					$jumlah++;
				}
				if ($jumlah == count($this->input->post('IDSurat'))) {
					$this->session->set_flashdata('toastr_success', $jumlah . ' Data Berhasil dihapus!');
					redirect(base_url("User_admin/" . $this->input->post('Halaman')));
				}
			}
		}
	}
	public function SuratHapusPermanenMany()
	{
		if ($this->session->userdata('Status') !== "Login") {
			// Jika belum login, arahkan kembali ke halaman login
			redirect(base_url("User_login"));
		} else {
			if ($this->input->post() !== null) {
				$data = $this->input->post('IDSurat');
				$jumlah = 0;
				for ($i = 0; $i < count($this->input->post('IDSurat')); $i++) {
					$where = array('IDSurat' => $data[$i]);
					$this->M_UserCek->SuratDigitalDelete($where);
					$jumlah++;
				}
				if ($jumlah == count($this->input->post('IDSurat'))) {
					$this->session->set_flashdata('toastr_success', $jumlah . ' Data Berhasil dihapus!');
					redirect(base_url("User_admin/SuratDigitalHapus"));
				}
			}
		}
	}

	// SURAT DIGITALLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLL

	public function TabelLevelUser()
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
				'aktif' => 'TabelLevelUser'
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

			// Memuat tampilan berdasarkan template dan data yang telah disiapkan
			$this->load->view('halaman/template/001', $Data004); // Template bagian atas
			$this->load->view('halaman/template/002(UPPER)', $Data002); // Template bagian header
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003); // Template bagian sidebar
			$this->load->view('halaman/content/halamanSistem/admin/TabelLevelUser'); // Konten halaman dashboard
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004); // Template bagian bawah
		}
	}
}
