<?php
if (!defined('BASEPATH'))
	exit ('No direct script access allowed');

require_once APPPATH . 'libraries/PhpSpreadsheet/autoload.php';

class API extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_API');
		$this->load->helper(array('form', 'url', 'cookie'));
		$this->load->library('upload');
	}

	private function convertDate($date_str)
	{
		$timestamp = strtotime($date_str); // Mengonversi tanggal ke UNIX timestamp
		return $formatted_date = date('Y-m-d', $timestamp); // Mengonversi timestamp ke format Y-m-d
	}

	public function DTHakAkses()
	{
		$IDGuru = array('IDGuru' => $this->encryption->decrypt($this->input->post('IDGuru')));
		$CekAkses = $this->M_API->DataGuruWhere($IDGuru);
		if ($CekAkses !== false) {
			$draw = $this->input->post('draw');
			$start = $this->input->post('start');
			$length = $this->input->post('length');
			$order = $this->input->post('order')[0];
			$searchValue = $this->input->post('search')['value'];

			$data = $this->M_API->DataHakakses($start, $length, $order, $searchValue);

			// Filter data jika diterapkan
			$filtered_data = $this->filterHakAkses($data, $searchValue);

			// Jumlah total data sebelum diterapkan filter
			$total_records = $this->M_API->DataHakaksesNumber();

			// Jumlah total data setelah diterapkan filter
			$total_filtered_records = count($filtered_data);

			// Ambil data sesuai dengan limit dan offset yang diberikan oleh DataTables
			$data_to_show = array_slice($filtered_data, $start, $length);

			$result = array(
				"draw" => $draw,
				"recordsTotal" => $total_records,
				"recordsFiltered" => $total_filtered_records,
				"data" => $data_to_show
			);

			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($result));
		}
	}

	private function filterHakAkses($data, $searchValue)
	{
		// Filter berdasarkan nilai pencarian
		if (!empty ($searchValue)) {
			$filtered_data = array_filter($data, function ($item) use ($searchValue) {
				return strpos($item->KodeHak, $searchValue) !== false ||
					strpos($item->JenisHak, $searchValue) !== false ||
					strpos($item->NamaHak, $searchValue) !== false;
			});
		} else {
			$filtered_data = $data;
		}

		return $filtered_data;
	}

	public function HakAksesCRUD()
	{
		if ($this->input->get('token') !== null) {
			$IDGuru = array('IDGuru' => $this->encryption->decrypt($this->input->get('token')));
			$CekAkses = $this->M_API->DataGuruWhere($IDGuru);
			if ($CekAkses !== false) {
				$result = array();
				$where = array('IDHak' => $this->input->get('IDHak'));
				$result['data'] = $this->M_API->DataHakaksesWhere($where);
				$result['msg'] = 'Akses Diterima!!!';
				$result['tugas'] = 'Berhasil';
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode($result));
			}
		} elseif ($this->input->method() === 'patch' && $this->input->input_stream('token')) {
			$IDGuru = array('IDGuru' => $this->encryption->decrypt($this->input->input_stream('token')));
			$CekAkses = $this->M_API->DataGuruWhere($IDGuru);
			if ($CekAkses !== false) {
				$where = array('IDHak' => $this->input->input_stream('IDHak'));
				$DataMasuk = array(
					'KodeHak' => $this->input->input_stream('KodeHak'),
					'JenisHak' => $this->input->input_stream('JenisHak'),
					'NamaHak' => $this->input->input_stream('NamaHak')
				);
				$this->M_API->DataHakaksesUpdate($where, $DataMasuk);
				$result = array();
				$result['msg'] = 'Data Berhasil Diubah!!!';
				$result['tugas'] = 'Berhasil';
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode($result));
			}
		} elseif ($this->input->post('token') !== null && $this->input->post('token') !== '') {
			$IDGuru = array('IDGuru' => $this->encryption->decrypt($this->input->post('token')));
			$CekAkses = $this->M_API->DataGuruWhere($IDGuru);
			if ($CekAkses !== false) {
				// $where = array('IDHak' => $this->input->post('IDHak') );
				$DataMasuk = array(
					'KodeHak' => $this->input->post('KodeHak'),
					'JenisHak' => $this->input->post('JenisHak'),
					'NamaHak' => $this->input->post('NamaHak')
				);
				$this->M_API->DataHakaksesCreate($DataMasuk);
				$result = array();
				$result['msg'] = 'Data Berhasil DiMasukkan!!!';
				$result['tugas'] = 'Berhasil';
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode($result));
			}
		} elseif ($this->input->method() === 'delete' && $this->input->input_stream('token')) {
			$IDGuru = array('IDGuru' => $this->encryption->decrypt($this->input->input_stream('token')));
			$CekAkses = $this->M_API->DataGuruWhere($IDGuru);
			if ($CekAkses !== false) {
				$where = array('IDHak' => $this->input->input_stream('IDHak'));
				$this->M_API->DataHakaksesDelete($where);
				$result = array();
				$result['msg'] = 'Data Berhasil DiHapus!!!';
				$result['tugas'] = 'Berhasil';
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode($result));
			}
		} else {
			$result = 'Akses Ditolak!!!';
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($result));
		}
	}

	public function DTJurnalKegiatan()
	{
		$where = array(
			'IDGuru' => $this->encryption->decrypt($this->input->post('IDGuru')),
			'IDHak' => $this->encryption->decrypt($this->input->post('Token')),
		);
		$draw = $this->input->post('draw');
		$start = $this->input->post('start');
		$length = $this->input->post('length');
		$order = $this->input->post('order')[0];
		$searchValue = $this->input->post('search')['value'];

		$data = $this->M_API->DataJurnalKegiatan($start, $length, $order, $searchValue, $where);

		// Filter data jika diterapkan
		$filtered_data = $this->filterJurnalKegiatan($data, $searchValue);

		// Jumlah total data sebelum diterapkan filter
		$total_records = $this->M_API->DataJurnalKegiatanNumber($where);

		// Jumlah total data setelah diterapkan filter
		$total_filtered_records = count($filtered_data);

		// Ambil data sesuai dengan limit dan offset yang diberikan oleh DataTables
		$data_to_show = array_slice($filtered_data, $start, $length);

		$result = array(
			"draw" => $draw,
			"recordsTotal" => $total_records,
			"recordsFiltered" => $total_filtered_records,
			"data" => $data_to_show
		);

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($result));
	}
	private function filterJurnalKegiatan($data, $searchValue)
	{
		// Filter berdasarkan nilai pencarian
		if (!empty ($searchValue)) {
			$filtered_data = array_filter($data, function ($item) use ($searchValue) {
				return strpos($item->TanggalJurnal, $searchValue) !== false ||
					strpos($item->Kegiatan, $searchValue) !== false ||
					strpos($item->Keterangan, $searchValue) !== false;
			});
		} else {
			$filtered_data = $data;
		}

		return $filtered_data;
	}

	public function UploadGambarJurnalKegiatan()
	{
		// Mendapatkan token dari permintaan
		$IDGuru = array('IDGuru' => $this->encryption->decrypt($this->input->post('token')));
		$CekAkses = $this->M_API->DataGuruWhere($IDGuru);

		// Lakukan pemeriksaan token
		if ($CekAkses) {
			// Token ditemukan, proses upload dapat dilanjutkan

			// Konfigurasi upload file
			$config['upload_path'] = './file/data/gambar/jurnalkegiatan/sementara';
			$config['allowed_types'] = 'jpg|png';
			$config['max_size'] = 2048; // ukuran file maksimum (dalam kilobita)
			$config['encrypt_name'] = TRUE; // enkripsi nama file untuk menghindari nama file yang sama

			$this->upload->initialize($config);

			// Lakukan proses upload
			if ($this->upload->do_upload('file')) {
				// Jika upload berhasil
				$file_data = $this->upload->data();
				$file_path = $file_data['file_name'];

				// Kirim respon ke klien
				$result = array(
					'status' => 'success',
					'msg' => 'File berhasil di-upload.',
					'namafile' => $file_path
				);
			} else {
				// Jika upload gagal
				$error = $this->upload->display_errors();

				// Kirim respon ke klien
				$result = array(
					'status' => 'error',
					'msg' => $error
				);
			}
		} else {
			$result = array('msg' => 'Akses Ditolak');
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($result));
	}




	public function TambahDataJurnalKegiatan()
	{
		if ($this->input->method() === 'patch' && $this->input->input_stream('token') !== null) {
			$where = array(
				'IDJurnal' => $this->encryption->decrypt($this->input->input_stream('JurnalID'))
			);
			$cekID = $this->M_API->ReadDataJurnalKegiatan($where);
			$GambarCheked = null;
			if ($cekID !== false) {
				foreach ($cekID as $key) {
					$GambarCheked = $key->Foto;
				}
			}
			$IDHak = $this->encryption->decrypt($this->input->input_stream('IDHak'));
			$IDGuru = $this->encryption->decrypt($this->input->input_stream('token'));
			$TanggalJurnal = $this->convertDate($this->input->input_stream('TanggalJurnal'));
			$Kegiatan = $this->input->input_stream('Kegiatan');
			$Keterangan = $this->input->input_stream('Keterangan');
			$Foto = $this->input->input_stream('gambar');

			if ($GambarCheked !== $Foto) {
				unlink('./file/data/gambar/jurnalkegiatan/asli/' . $GambarCheked);
				$oldFilePath = './file/data/gambar/jurnalkegiatan/sementara/' . $Foto;
				$newFilePath = './file/data/gambar/jurnalkegiatan/asli/' . $Foto;
				// Memindahkan file
				rename($oldFilePath, $newFilePath);
			}

			$DataMasuk = array(
				'IDHak' => $IDHak,
				'IDGuru' => $IDGuru,
				'TanggalJurnal' => $this->convertDate($TanggalJurnal),
				'Kegiatan' => $Kegiatan,
				'Keterangan' => $Keterangan,
				'Foto' => $Foto,
			);

			$this->M_API->UpdateDataJurnalKegiatan($where, $DataMasuk);

			$result = array(
				'status' => 'success',
				'msg' => 'Berhasil Mengubah Data!',
				'data' => ''
			);
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($result));
		} elseif ($this->input->method() === 'post' && $this->input->post('token') !== null) {
			$IDHak = $this->encryption->decrypt($this->input->post('IDHak'));
			$IDGuru = $this->encryption->decrypt($this->input->post('token'));
			$TanggalJurnal = $this->convertDate($this->input->post('TanggalJurnal'));
			$IDSemester = $this->encryption->decrypt($this->input->post('IDSemester'));
			$IDAjaran = $this->encryption->decrypt($this->input->post('IDAjaran'));
			$Kegiatan = $this->input->post('Kegiatan');
			$Keterangan = $this->input->post('Keterangan');
			$Foto = $this->input->post('gambar');

			$DataMasuk = array(
				'IDHak' => $IDHak,
				'IDGuru' => $IDGuru,
				'TanggalJurnal' => $this->convertDate($TanggalJurnal),
				'IDSemester' => $IDSemester,
				'IDAjaran' => $IDAjaran,
				'Kegiatan' => $Kegiatan,
				'Keterangan' => $Keterangan,
				'Foto' => $Foto,
			);

			$this->M_API->CreateDataJurnalKegiatan($DataMasuk);
			$cekID = $this->M_API->ReadDataJurnalKegiatan($DataMasuk);
			if ($cekID !== false) {
				foreach ($cekID as $key) {
					$IDJurnal = $key->IDJurnal;
				}
			}


			// Memindahkan file ke direktori yang diinginkan
			$oldFilePath = './file/data/gambar/jurnalkegiatan/sementara/' . $Foto;
			$newFilePath = './file/data/gambar/jurnalkegiatan/asli/' . $Foto;

			// Memindahkan file
			if (rename($oldFilePath, $newFilePath)) {
				// Jika pemindahan berhasil, tambahkan data ke dalam result
				$result = array(
					'status' => 'success',
					'msg' => 'Data berhasil ditambahkan.',
					'data' => $this->encryption->encrypt($IDJurnal)
				);
			} else {
				// Jika pemindahan gagal, kirim pesan error
				$result = array(
					'status' => 'error',
					'msg' => 'Gagal memindahkan file.'
				);
			}

			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($result));
		} elseif ($this->input->method() === 'delete' && $this->input->input_stream('token') !== null) {
			$where = array('IDJurnal' => $this->input->input_stream('JurnalID'));
			$cekID = $this->M_API->ReadDataJurnalKegiatan($where);
			$GambarCheked = null;
			if ($cekID !== false) {
				foreach ($cekID as $key) {
					$GambarCheked = $key->Foto;
				}
			}

			$result = array(
				'status' => 'success',
				'msg' => $this->input->input_stream('JurnalID')
			);
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($result));
		}
	}

	public function TugasTambahan()
	{
		if ($this->input->method() === 'get' && $this->input->get('Token') !== null) {
			$where = array('IDGuru' => $this->encryption->decrypt($this->input->get('Token')));
			$cekID = $this->M_API->DataGuruWhere($where);
			$result = false;
			if ($cekID !== false) {
				$result = $this->M_API->ReadDataTugasTambahan($where);
			}
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($result));
		}
	}

	public function JurnalGuruPengajar()
	{
		$result = array(
			'status' => 'failed',
			'msg' => 'connection failed!'
		);

		// Memeriksa apakah permintaan merupakan metode DELETE
		if ($this->input->method() === 'delete' && $this->input->input_stream('Token') !== null) {
			$where[0] = array('IDGuru' => $this->encryption->decrypt($this->input->input_stream('Token')));
			$cek = $this->M_API->DataGuruWhere($where[0]);
			if ($cek !== false) {
				$where = array(
					'IDJurnal' => $this->input->input_stream('IDJurnal'),
					'IDGuru' => $where[0]['IDGuru']
				);
			}
			$this->M_API->DeleteJurnalGuru($where);
			$result = array(
				'status' => 'success',
				'msg' => 'Berhasil Menghapus Data!'
			);
		}

		// Mengirimkan response dalam format JSON
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($result));
	}




}