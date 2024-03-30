<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


class ExportImport extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_ExportImport');
		$this->load->helper(array('form', 'url', 'cookie'));
		$this->load->library('PhpSpreadsheet');
		// Load library PHPExcel
	}

	public function exportToExcel()
	{
		if ($this->session->userdata('Status') !== "Login") {
			redirect(base_url("User_login"));
		} else {
			$content['DataGuru'] = $this->M_ExportImport->DataGuruAmbil();
			$this->load->view('halaman/export/DataSiswa', $content);
		}
	}

	public function TabelMuridExcell($kelas = null)
	{
		if ($this->session->userdata('Status') !== "Login") {
			redirect(base_url("User_login"));
		} else {
			if ($kelas == null) {
				$content['DataMurid'] = $this->M_ExportImport->DataMuridArray();
				$this->load->view('halaman/export/TabelMuridExcell', $content);
			} elseif ($kelas !== null) {
				$where = array('IDKelas' => $kelas);
				$content['Kelas'] = $kelas;
				$content['DataMurid'] = $this->M_ExportImport->DataMuridwhereArray($where);
				$this->load->view('halaman/export/TabelMuridExcellWhere', $content);
			}
		}
	}

	public function ImportTabelMuridExcell($kelas = null)
	{
		if ($this->session->userdata('Status') !== "Login") {
			redirect(base_url("User_login"));
		} else {
			if ($kelas == null) {
					// Konfigurasi unggahan file
					$config['upload_path'] = './application/uploads/';
					$config['allowed_types'] = 'xls|xlsx';
					$config['max_size'] = 2048;
					$config['overwrite'] = true;
					$config['file_name'] = 'DataMuridAll';
					$this->load->library('upload', $config);
					// print_r($config);
					if ($this->upload->do_upload('excelfile')) {
						// Jika unggahan berhasil
						$upload_data = $this->upload->data();
						$file_path = $upload_data['full_path'];
						// print_r($file_path);
						$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($file_path);
						$spreadsheet = $reader->load($file_path);
						// Ambil sheet berdasarkan indeks (indeks dimulai dari 0)
						$worksheet = $spreadsheet->getSheet(0);
						// Atau, jika Anda ingin menggunakan nama sheet, Anda bisa gunakan:
						// $worksheet = $spreadsheet->getSheetByName('NamaSheet');
						$data = $worksheet->toArray();

						// Filter data yang hanya berisi nilai yang tidak kosong pada kolom 0 hingga 6

						
						$HitungData = array('Masuk' => 0, 'Update' => 0, 'Bermasalah'=>0);
						for ($i = 1; $i < count($data); $i++) {
							$datalewat=false;
							if($data[$i][1]==null || $data[$i][4]==null || $data[$i][5]==null || $data[$i][6]==null || $data[$i][7]==null || $data[$i][8]==null || $data[$i][9]==null || $data[$i][10]==null){
								$datalewat=true;
							}
							if ($datalewat==false) {
								$where = array('NisSiswa' => $data[$i][1]);
								$cek = $this->M_ExportImport->DataMuridby($where);
								$ambil = array(
									'NisSiswa' => $data[$i][1],
									'NISNSiswa' => $data[$i][2],
									'KodeKelas' => $data[$i][3],
									'NamaSiswa' => $data[$i][4],
									'GenderSiswa' => $data[$i][5],
									'AyahSiswa' => $data[$i][6],
									'IbuSiswa' => $data[$i][7],
									'TglLhrSiswa' => $data[$i][8],
									'TmptLhrSiswa' => $data[$i][9],
									'TGLMasuk' => $data[$i][10],
									'TGLKeluar' => $data[$i][11],
									'Status' => $data[$i][12],
									'Wali' => 'Tidak'
								);
								if ($cek == FALSE) {
									$this->M_ExportImport->DataMuridInsert($ambil);
									$HitungData['Masuk']++;

								} elseif ($cek != FALSE) {
									$this->M_ExportImport->DataMuridUpdate($where, $ambil);
									$HitungData['Update']++;

								}
							}elseif ($datalewat==true) {
								$HitungData['Bermasalah']++;
							}

							
							// $data=$this->M_ExportImport->DataMuridArray();
							if ($HitungData['Masuk'] + $HitungData['Update']+$HitungData['Bermasalah'] == count($data) - 1) {
								$this->session->set_flashdata('toastr_success', $HitungData['Masuk'] . ' Data berhasil disimpan! <br> ' . $HitungData['Update'] . ' Data berhasil diperbarui! <br> ');
								if ($HitungData['Bermasalah']>0) {
									$this->session->set_flashdata('toastr_warning', $HitungData['Bermasalah'].' Data tidak valid!');
								}
								redirect(base_url("User_admin/TabelMurid"));
							}
						}
					} else {
						// $error = $this->upload->display_errors();
						// echo "Error: " . $error;
						// error_log('Upload Error: ' . $this->upload->display_errors());
						$this->session->set_flashdata('toastr_info', 'Silahkan Periksa Kembali File Anda!');
						redirect(base_url("User_admin/TabelMurid"));
					}
			} elseif ($kelas !== null) {
					// Konfigurasi unggahan file
					$config['upload_path'] = './application/uploads/';
					$config['allowed_types'] = 'xls|xlsx';
					$config['max_size'] = 2048;
					$config['overwrite'] = true;
					$config['file_name'] = 'DataMuridAll';
					$this->load->library('upload', $config);
					// print_r($config);
					if ($this->upload->do_upload('excelfile')) {
						// Jika unggahan berhasil
						$upload_data = $this->upload->data();
						$file_path = $upload_data['full_path'];
						$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($file_path);
						$spreadsheet = $reader->load($file_path);
						// Ambil sheet berdasarkan indeks (indeks dimulai dari 0)
						$worksheet = $spreadsheet->getSheet(0);
						// Atau, jika Anda ingin menggunakan nama sheet, Anda bisa gunakan:
						// $worksheet = $spreadsheet->getSheetByName('NamaSheet');
						$data = $worksheet->toArray();

						// Filter data yang hanya berisi nilai yang tidak kosong pada kolom 0 hingga 6

						
						$HitungData = array('Masuk' => 0, 'Update' => 0, 'Bermasalah'=>0);
						for ($i = 1; $i < count($data); $i++) {
							$datalewat=false;
							if($data[$i][1]==null || $data[$i][3]==null || $data[$i][4]==null || $data[$i][5]==null || $data[$i][6]==null || $data[$i][7]==null || $data[$i][8]==null || $data[$i][9]==null){
								$datalewat=true;
							}
							if ($datalewat==false) {
									$where = array('NisSiswa' => $data[$i][1]);
									$where2 = array('IDKelas' => $kelas );
									$DataKelas = $this->M_ExportImport->DataKelasWhereArr($where2);
									$cek = $this->M_ExportImport->DataMuridby($where);
									$ambil = array(
										'NisSiswa' => $data[$i][1],
										'NISNSiswa' => $data[$i][2],
										'KodeKelas' => $DataKelas[0]['KodeKelas'],
										'NamaSiswa' => $data[$i][3],
										'GenderSiswa' => $data[$i][4],
										'AyahSiswa' => $data[$i][5],
										'IbuSiswa' => $data[$i][6],
										'TglLhrSiswa' => $data[$i][7],
										'TmptLhrSiswa' => $data[$i][8],
										'TGLMasuk' => $data[$i][9],
										'TGLKeluar' => $data[$i][10],
										'Status' => $data[$i][11],
										'Wali' => 'Tidak'
									);
									if ($cek == FALSE) {
										$this->M_ExportImport->DataMuridInsert($ambil);
										$HitungData['Masuk']++;
										// print_r($ambil);
										// echo '<br>Insert<br><br>';
									} elseif ($cek != FALSE) {
										$this->M_ExportImport->DataMuridUpdate($where, $ambil);
										$HitungData['Update']++;
										// print_r($ambil);
										// echo '<br>Update<br><br>';
									}
									// $data=$this->M_ExportImport->DataMuridArray();
							}elseif ($datalewat==true) {
								$HitungData['Bermasalah']++;
							}

							
							// $data=$this->M_ExportImport->DataMuridArray();
							if ($HitungData['Masuk'] + $HitungData['Update']+$HitungData['Bermasalah'] == count($data) - 1) {
								$this->session->set_flashdata('toastr_success', $HitungData['Masuk'] . ' Data berhasil disimpan! <br> ' . $HitungData['Update'] . ' Data berhasil diperbarui! <br> ');
								if ($HitungData['Bermasalah']>0) {
									$this->session->set_flashdata('toastr_warning', $HitungData['Bermasalah'].' Data tidak valid!');
								}
								redirect(base_url("User_admin/TabelKelas/Kelas/".$kelas));
							}
						}
					} else {
						// $error = $this->upload->display_errors();
						// echo "Error: " . $error;
						// error_log('Upload Error: ' . $this->upload->display_errors());
						$this->session->set_flashdata('toastr_info', 'Silahkan Periksa Kembali File Anda!');
						redirect(base_url("User_admin/TabelKelas/Kelas/".$kelas));
					}
			}
		}
	}

	public function ImportTabelWaliMuridExcell()
	{
        if ($this->session->userdata('Status') !== "Login") {
			redirect(base_url("User_login"));
		} else {
					// Konfigurasi unggahan file
					$config['upload_path'] = './application/uploads/';
					$config['allowed_types'] = 'xls|xlsx';
					$config['max_size'] = 2048;
					$config['overwrite'] = true;
					$config['file_name'] = 'DataMuridAll';
					$this->load->library('upload', $config);
					// print_r($config);
					if ($this->upload->do_upload('excelfile')) {
						// Jika unggahan berhasil
						$upload_data = $this->upload->data();
						$file_path = $upload_data['full_path'];
						$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($file_path);
						$spreadsheet = $reader->load($file_path);
						// Ambil sheet berdasarkan indeks (indeks dimulai dari 0)
						$worksheet = $spreadsheet->getSheet(0);
						// Atau, jika Anda ingin menggunakan nama sheet, Anda bisa gunakan:
						// $worksheet = $spreadsheet->getSheetByName('NamaSheet');
						$data = $worksheet->toArray();

						// Filter data yang hanya berisi nilai yang tidak kosong pada kolom 0 hingga 6

						
						$HitungData = array('Masuk' => 0, 'Update' => 0, 'Bermasalah'=>0);
						for ($i = 1; $i < count($data); $i++) {
							$datalewat=false;
							if($data[$i][0]==null || $data[$i][1]==null || $data[$i][4]==null){
								$datalewat=true;
							}
							if ($datalewat==false) {
								$where[0] = array('tb_ortu.NisSiswa' => $data[$i][0]);
								$cek = $this->M_ExportImport->getSiswaWithOrtubyArr($where[0]);
								
								$nomorHP = $data[$i][4]; // Mengambil nomor HP dari data
								// Memeriksa apakah nomor HP dimulai dengan "0" atau tidak
								if (substr($nomorHP, 0, 1) !== '0') {
								    $nomorHP = '0' . $nomorHP; // Menambahkan "0" di awal jika tidak dimulai dengan "0"
								}
								$ambil = array(
								    'NisSiswa' => $data[$i][0],
								    'UsrOrtu' => $data[$i][1],
								    'PassOrtu' => $data[$i][2],
								    'NamaOrtu' => $data[$i][3],
								    'NomorHP' => $nomorHP, // Menggunakan variabel $nomorHP yang sudah diperiksa
								    'Alamat' => $data[$i][5]
								);
								if ($cek == FALSE) {
									$this->M_ExportImport->DataWaliInsert($ambil);
									$HitungData['Masuk']++;
									// print_r($ambil);
									// echo '<br>Insert<br><br>';
								} elseif ($cek != FALSE) {
									$this->M_ExportImport->DataWaliUpdate($where[0], $ambil);
									$HitungData['Update']++;
									// print_r($ambil);
									// echo '<br>Update<br><br>';
								}
							}elseif ($datalewat==true) {
								$HitungData['Bermasalah']++;
							}

							
							// $data=$this->M_ExportImport->DataMuridArray();
							if ($HitungData['Masuk'] + $HitungData['Update']+$HitungData['Bermasalah'] == count($data) - 1) {
								$this->session->set_flashdata('toastr_success', $HitungData['Masuk'] . ' Data berhasil disimpan! <br> ' . $HitungData['Update'] . ' Data berhasil diperbarui! <br> ');
								if ($HitungData['Bermasalah']>0) {
									$this->session->set_flashdata('toastr_warning', $HitungData['Bermasalah'].' Data tidak valid!');
								}
								redirect(base_url("User_admin/WaliMurid"));
							}
						}
					} else {
						// $error = $this->upload->display_errors();
						// echo "Error: " . $error;
						// error_log('Upload Error: ' . $this->upload->display_errors());
						$this->session->set_flashdata('toastr_info', 'Silahkan Periksa Kembali File Anda!');
						redirect(base_url("User_admin/WaliMurid"));
					}
		}
	}
	public function ExportTabelWaliMuridExcell()
	{
		if ($this->session->userdata('Status') !== "Login") {
			redirect(base_url("User_login"));
		} else {
			$content['DataMurid'] = $this->M_ExportImport->DataMuridArray();
			$content['DataWaliMurid'] = $this->M_ExportImport->getSiswaWithOrtuArr();

			$this->load->view('halaman/export/TabelWaliMuridExcell', $content);
			
		}
	}

	
    public function ImportTabelGuruExcell()
	{
		if ($this->session->userdata('Status') !== "Login") {
			redirect(base_url("User_login"));
		} else {
					// Konfigurasi unggahan file
					$config['upload_path'] = './application/uploads/';
					$config['allowed_types'] = 'xls|xlsx';
					$config['max_size'] = 2048;
					$config['overwrite'] = true;
					$config['file_name'] = 'DataGuruAll';
					$this->load->library('upload', $config);
					// print_r($config);
					if ($this->upload->do_upload('excelfile')) {
						// Jika unggahan berhasil
						$upload_data = $this->upload->data();
						$file_path = $upload_data['full_path'];
						$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($file_path);
						$spreadsheet = $reader->load($file_path);
						// Ambil sheet berdasarkan indeks (indeks dimulai dari 0)
						$worksheet = $spreadsheet->getSheet(0);
						// Atau, jika Anda ingin menggunakan nama sheet, Anda bisa gunakan:
						// $worksheet = $spreadsheet->getSheetByName('NamaSheet');
						$data = $worksheet->toArray();

						// Filter data yang hanya berisi nilai yang tidak kosong pada kolom 0 hingga 6

						
						$HitungData = array('Masuk' => 0, 'Update' => 0, 'Bermasalah'=>0, 'DataSalah'=>0);
						for ($i = 1; $i < count($data); $i++) {
							$datalewat=false;
							if($data[$i][1]==null || $data[$i][2]==null || $data[$i][3]==null || $data[$i][4]==null || $data[$i][5]==null || $data[$i][6]==null){
								$datalewat=true;
							}
							if ($datalewat==false) {
								# code...
							$where = array('NomorIndukGuru' => $data[$i][1]);
							$cek = $this->M_ExportImport->DataGuruWhere($where);
							$ambil = array(
								'NomorIndukGuru' => $data[$i][1],
								'UsrGuru' => $data[$i][2],
								'KodeGuru' => $data[$i][3],
								'NamaGuru' => $data[$i][4],
								'PassGuru' => $data[$i][5],
								'IDHak' => $data[$i][6],
								'NomorHP' => $data[$i][8]
							);
							if ($cek == FALSE) {
								$this->M_ExportImport->DataGuruInsert($ambil);
								$HitungData['Masuk']++;
								// print_r($ambil);
								// echo '<br>Insert<br><br>';
							} elseif ($cek != FALSE) {
								$this->M_ExportImport->DataGuruUpdate($where, $ambil);
								$HitungData['Update']++;
								// print_r($ambil);
								// echo '<br>Update<br><br>';
							}
							$DataGuruAmbilAja=$this->M_ExportImport->DataGuruWhere($where);
							foreach ($DataGuruAmbilAja as $guru) {
								$IDGuru = $guru->IDGuru;
							}
							if ($data[$i][7]!='') {
								$Mapel = explode('//', $data[$i][7]);
								if (count($Mapel) > 0) {
									foreach ($Mapel as $mapel) {
										$arrayName = array('IDMapel' => $mapel );
										if ($this->M_ExportImport->DataMapelArrayBy($arrayName)!==false) {
											$ambil2 = array(
												'IDGuru' => $IDGuru,
												'IDMapel' => $mapel
											);
											$dataMengajar = $this->M_ExportImport->ReadDataMengajarBy($ambil2);
											if (!$dataMengajar) {
												$this->M_ExportImport->InsertDataMengajar($ambil2);
											} else {
												foreach ($dataMengajar as $key) {
													$where2 = array('IDMengajar' => $key->IDMengajar);
												}
												$this->M_ExportImport->UpdateDataMengajar($where2, $ambil2);
											}
										}else{
											$HitungData['DataSalah']++;
										}
									}
								}
							}
							}elseif ($datalewat==true) {
								$HitungData['Bermasalah']++;
							}

							
							// $data=$this->M_ExportImport->DataMuridArray();
							if ($HitungData['Masuk'] + $HitungData['Update']+$HitungData['Bermasalah']+$HitungData['DataSalah'] == count($data) - 1) {
								$this->session->set_flashdata('toastr_success', $HitungData['Masuk'] . ' Data berhasil disimpan! <br> ' . $HitungData['Update'] . ' Data berhasil diperbarui! <br> ');
								if ($HitungData['Bermasalah']>0) {
									$this->session->set_flashdata('toastr_warning', $HitungData['Bermasalah'].' Data tidak valid!');
								}
								if ($HitungData['DataSalah']>0) {
									$this->session->set_flashdata('toastr_warning', $HitungData['DataSalah'].' Data Tidak Benar!');
								}
								redirect(base_url("User_admin/TabelGuru"));
							}
						}
					} else {
						// $error = $this->upload->display_errors();
						// echo "Error: " . $error;
						// error_log('Upload Error: ' . $this->upload->display_errors());
						$this->session->set_flashdata('toastr_info', 'Silahkan Periksa Kembali File Anda!');
						redirect(base_url("User_admin/TabelGuru"));
					}
		}
	}

    public function TabelKelasExcell()
    {
    	if ($this->session->userdata('Status') !== "Login") {
			redirect(base_url("User_login"));
		} else {
			$content['DataKelas'] = $this->M_ExportImport->DataKelasArray();
			$content['Keterangan'] = $this->M_ExportImport->DataGuruAmbilArray();
			$this->load->view('halaman/export/TabelKelasExcell', $content);
		}
    }
    public function ImportTabelKelasExcell()
	{
		if ($this->session->userdata('Status') !== "Login") {
			redirect(base_url("User_login"));
		} else {
					// Konfigurasi unggahan file
					$config['upload_path'] = './application/uploads/';
					$config['allowed_types'] = 'xls|xlsx';
					$config['max_size'] = 2048;
					$config['overwrite'] = true;
					$config['file_name'] = 'DataKelasAll';
					$this->load->library('upload', $config);
					// print_r($config);
					if ($this->upload->do_upload('excelfile')) {
						// Jika unggahan berhasil
						$upload_data = $this->upload->data();
						$file_path = $upload_data['full_path'];
						$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($file_path);
						$spreadsheet = $reader->load($file_path);
						$worksheet = $spreadsheet->getSheet(0);
						$data = $worksheet->toArray();
						// Lakukan sesuatu dengan data yang dibaca
						// Misalnya, tampilkan data
						// echo '<pre>';
						// print_r($data);
						// echo '</pre>';
						$HitungData = array('Masuk' => 0, 'Update' => 0);
						for ($i = 1; $i < count($data); $i++) {
							$where = array('KodeKelas' => $data[$i][1]);
							$cek = $this->M_ExportImport->DataKelasWhere($where);
							$guru = array('NomorIndukGuru' => $data[$i][3] );
							foreach ($this->M_ExportImport->DataGuruWhere($guru) as $tb) {
								$IDGuru = $tb->IDGuru;
							}
							$ambil = array(
								'KodeKelas' => $data[$i][1],
								'KodeTahun' => $data[$i][2],
								'IDGuru' => $IDGuru,
								'RuanganKelas' => $data[$i][5]
							);
							if ($cek == FALSE) {
								$this->M_ExportImport->DataKelasInsert($ambil);
								$HitungData['Masuk']++;
								// print_r($ambil);
								// echo '<br>Insert<br><br>';
							} elseif ($cek != FALSE) {
								$this->M_ExportImport->DataKelasUpdate($where, $ambil);
								$HitungData['Update']++;
								// print_r($ambil);
								// echo '<br>Update<br><br>';
							}
							// $data=$this->M_ExportImport->DataMuridArray();
							if ($HitungData['Masuk'] + $HitungData['Update'] == count($data) - 1) {
								$this->session->set_flashdata('toastr_success', $HitungData['Masuk'] . ' Data berhasil disimpan! <br> ' . $HitungData['Update'] . ' Data berhasil diperbarui!');
								redirect(base_url("User_admin/TabelKelas"));
							}
						}
					} else {
						// $error = $this->upload->display_errors();
						// echo "Error: " . $error;
						// error_log('Upload Error: ' . $this->upload->display_errors());
						$this->session->set_flashdata('toastr_info', 'Silahkan Periksa Kembali File Anda!');
						redirect(base_url("User_admin/TabelKelas"));
					}
		}
	}

	public function TabelMapelExcell()
    {
    	if ($this->session->userdata('Status') !== "Login") {
			redirect(base_url("User_login"));
		} else {
			$content['DataMapel'] = $this->M_ExportImport->DataMapelArray();
			$this->load->view('halaman/export/TabelMaPelExcell', $content);
		}
    }

    public function ImportTabelMapelExcell()
    {
		if ($this->session->userdata('Status') !== "Login") {
			redirect(base_url("User_login"));
		} else {
					// Konfigurasi unggahan file
					$config['upload_path'] = './application/uploads/';
					$config['allowed_types'] = 'xls|xlsx';
					$config['max_size'] = 2048;
					$config['overwrite'] = true;
					$config['file_name'] = 'DataKelasAll';
					$this->load->library('upload', $config);
					// print_r($config);
					if ($this->upload->do_upload('excelfile')) {
						// Jika unggahan berhasil
						$upload_data = $this->upload->data();
						$file_path = $upload_data['full_path'];
						$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($file_path);
						$spreadsheet = $reader->load($file_path);
						// Ambil sheet berdasarkan indeks (indeks dimulai dari 0)
						$worksheet = $spreadsheet->getSheet(0);
						// Atau, jika Anda ingin menggunakan nama sheet, Anda bisa gunakan:
						// $worksheet = $spreadsheet->getSheetByName('NamaSheet');
						$data = $worksheet->toArray();

						// Filter data yang hanya berisi nilai yang tidak kosong pada kolom 0 hingga 6

						
						$HitungData = array('Masuk' => 0, 'Update' => 0, 'Bermasalah'=>0);
						for ($i = 1; $i < count($data); $i++) {
							$datalewat=false;
							if($data[$i][1]==null || $data[$i][2]==null){
								$datalewat=true;
							}
							if ($datalewat==false) {
								$where[0] = array('KodeMapel' => $data[$i][1]);
								$cek = $this->M_ExportImport->DataMapelArrayBy($where[0]);
								$ambil = array(
									'KodeMapel' => $data[$i][1],
									'NamaMapel' => $data[$i][2]
								);
								if ($cek == FALSE) {
									$this->M_ExportImport->DataMataPelajaranInsert($ambil);
									$HitungData['Masuk']++;
									// print_r($ambil);
									// echo '<br>Insert<br><br>';
								} elseif ($cek != FALSE) {
									$this->M_ExportImport->DataMataPelajaranUpdate($where[0], $ambil);
									$HitungData['Update']++;
									// print_r($ambil);
									// echo '<br>Update<br><br>';
								}
							}elseif ($datalewat==true) {
								$HitungData['Bermasalah']++;
							}

							
							// $data=$this->M_ExportImport->DataMuridArray();
							if ($HitungData['Masuk'] + $HitungData['Update']+$HitungData['Bermasalah'] == count($data) - 1) {
								$this->session->set_flashdata('toastr_success', $HitungData['Masuk'] . ' Data berhasil disimpan! <br> ' . $HitungData['Update'] . ' Data berhasil diperbarui! <br> ');
								if ($HitungData['Bermasalah']>0) {
									$this->session->set_flashdata('toastr_warning', $HitungData['Bermasalah'].' Data tidak valid!');
								}
								redirect(base_url("User_admin/TabelMapel"));
							}
						}
					} else {
						// $error = $this->upload->display_errors();
						// echo "Error: " . $error;
						// error_log('Upload Error: ' . $this->upload->display_errors());
						$this->session->set_flashdata('toastr_info', 'Silahkan Periksa Kembali File Anda!');
						redirect(base_url("User_admin/TabelMapel"));
					}
		}
	}
}
