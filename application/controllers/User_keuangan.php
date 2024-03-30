<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'libraries/PhpSpreadsheet/autoload.php';

class User_keuangan extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_UserCek');
		$this->load->helper(array('form', 'url', 'cookie'));
		$this->load->library('Pdf');
		
	}

	private function formatRupiah($angka) {
	    $rupiah = number_format($angka, 2, ',', '.');
	    return $rupiah;
	}

	private function ubahFormatNomor($nomor) {
		if ($nomor!==null) {
		    // Hapus semua karakter selain angka
		    $nomor = preg_replace("/[^0-9]/", "", $nomor);
		    
		    // Periksa apakah nomor dimulai dengan "0" dan panjangnya adalah 12 digit
		    if (strlen($nomor) == 12 && substr($nomor, 0, 1) == '0') {
		        // Ganti "0" di awal dengan "62"
		        $nomor = '62' . substr($nomor, 1);
		    }
		    
		    return $nomor;
		}else{
			return $nomor='+628111127735';
		}
    }

	private function SENDINGWA($ISIPESAN,$WATUJUAN){
		$this->load->model('M_WhatsApp');
		$Data003['SISTEM'] = $this->M_UserCek->APPNAME();
		foreach ($Data003['SISTEM'] as $DS3) {
            $NWA=$DS3->NomorWA;
            $NII=$DS3->NamaInstansi;
        }
        $where2=array(
            'whatsapp_number'=>$NWA,
            'status'=>'CONNECTED'
        );
        $Ambil=$this->M_WhatsApp->ReadDataSessionsConnectedBy($where2);
        $WACEK='';
        if ($Ambil!==false) {
        foreach ($Ambil as $DWA) {
            $WA['whatsapp_number']=$DWA->whatsapp_number;
            $WA['api_key']=$DWA->api_key;
        }
        $url = 'https://whatsapp.'.str_replace('https://', '', base_url() ).'api/send-message';
        $data = [
            "api_key" => $WA['api_key'],
            "receiver" => $this->ubahFormatNomor($WATUJUAN),
            "data" => [
            	"message" => $ISIPESAN.$NII
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
              $WACEK=true;
        }else{
        	$WACEK=false;
        }
        // Kelola hasil respons
        // if ($response === FALSE) {
        //     $data 'Gagal melakukan permintaan ke API';
        // } else {
        //     echo 'Respon dari API: ' . $response;
        // }
        return $WACEK;
	}

	private function convertDate($date_str)
	{
		$timestamp = strtotime($date_str); // Mengonversi tanggal ke UNIX timestamp
		return $formatted_date = date('Y-m-d', $timestamp); // Mengonversi timestamp ke format Y-m-d
	}

	public function SPP($fungsi = null, $id = null)
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
			$Data003 = array(
				'UsrGuru' => $this->session->userdata('UsrGuru'),
				'aktif' => 'SPP'
			);
        	$Data003['Fitur'] = $this->M_UserCek->FiturSistem();
			$where = $this->session->userdata('KodeGuru');
			$Data003['SISTEM'] = $this->M_UserCek->APPNAME();
			$Data003['HakAkses'] = $this->M_UserCek->DataHakakses();
			$Data003['IDHak'] = $this->session->userdata('IDHak');
			$Data004['ButuhTabel'] = TRUE;
			$Data004['ButuhForm'] = TRUE;
			$content['datatahun'] = $this->M_UserCek->AmbilTahun();
			$content['datakelas'] = $this->M_UserCek->DataKelasAmbil();
			$content['datasiswa'] = $this->M_UserCek->DataMuridOnly();
			$content['datatahunajaran'] = $this->M_UserCek->AmbilTahunAjaran();
			$content['datasemester'] = $this->M_UserCek->AmbilSemester();

			$content['tabel'] = $this->M_UserCek->ReadSpp();
			$this->load->view('halaman/template/001', $Data004);
			$this->load->view('halaman/template/002(UPPER)', $Data002);
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003);
			if ($fungsi === null) {
				$this->load->view('halaman/content/halamanSistem/keuangan/keuangan_spp', $content);
			} elseif ($fungsi === 'Detail' && $id !== null) {
				$where = array('keuangan_spp.IDSpp' => $id);
				$content['tabel2'] = $this->M_UserCek->ReadSppWhere($where);
				$this->load->view('halaman/content/halamanSistem/keuangan/keuangan_spp_detail', $content);
			}
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004);
		}
	}

	public function SPPCRUD()
	{
		if ($this->session->userdata('Status') !== "Login") {
			redirect(base_url("User_login"));
		} else {
			if (isset($_POST)) {
				if (isset($_POST['SPP']) && !isset($_POST['IDSpp'])) {
					// print_r($_POST);
					$DataMasuk = array(
						'JumlahRp' => str_replace(',', '', $_POST['JumlahRp']),
						'IDAjaran' => $_POST['IDAjaran'],
						'Keterangan' => $_POST['Keterangan']
					);
					$this->M_UserCek->InsertSpp($DataMasuk);
					$this->session->set_flashdata('toastr_success', 'Data berhasil disimpan!');
					redirect(base_url("User_keuangan/SPP"));
				} elseif (isset($_POST['EditData']) && isset($_POST['IDSpp'])) {
					// print_r($_POST);
					// echo "<br> Update <br>";
					$DataMasuk = array(
						'JumlahRp' => str_replace(',', '', $_POST['JumlahRp']),
						'IDAjaran' => $_POST['IDAjaran'],
						'Keterangan' => $_POST['Keterangan']
					);
					$where = array('IDSpp' => $_POST['IDSpp']);
					$this->M_UserCek->UpdateSpp($where, $DataMasuk);
					$this->session->set_flashdata('toastr_success', 'Data berhasil diperbarui!');
					redirect(base_url("User_keuangan/SPP"));
				} elseif (isset($_POST['HapusData']) && isset($_POST['IDSpp'])) {
					// print_r($_POST);
					// echo "<br> Hapus <br>";
					$where = array('IDSpp' => $_POST['IDSpp']);
					$this->M_UserCek->DeleteSpp($where);
					$this->session->set_flashdata('toastr_success', 'Data berhasil dihapus!');
					redirect(base_url("User_keuangan/SPP"));
				} elseif (isset($_POST['SubSPP']) && isset($_POST['IDSpp'])) {
					$where = array('IDSpp' => $_POST['IDSpp']);
					// print_r($_POST);
					if (count($_POST['nama']) === count($_POST['jumlah'])) {
						$dataNama = implode("//A//", $_POST['nama']);
						$Box = array();
						for ($i = 0; $i < count($_POST['jumlah']); $i++) {
							$Box[$i] = str_replace(',', '', $_POST['jumlah'][$i]);
						}
						$dataJumlah = implode("//A//", $Box);
					}
					// echo $dataNama." <br> ".$dataJumlah;
					$DataMasuk = array('Nama' => $dataNama, 'Jumlah' => $dataJumlah);
					$this->M_UserCek->UpdateSpp($where, $DataMasuk);
					$this->session->set_flashdata('toastr_success', 'Data berhasil diperbarui!');
					redirect(base_url("User_keuangan/SPP/Detail/" . $_POST['IDSpp']));
				}
			}
		}
	}


	public function BayarSPP($fungsi = null, $id = null)
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
			$Data003 = array(
				'UsrGuru' => $this->session->userdata('UsrGuru'),
				'aktif' => 'BayarSPP'
			);
			$where = $this->session->userdata('KodeGuru');
        	$Data003['Fitur'] = $this->M_UserCek->FiturSistem();
			$Data003['SISTEM'] = $this->M_UserCek->APPNAME();
			$Data003['HakAkses'] = $this->M_UserCek->DataHakakses();
			$Data003['IDHak'] = $this->session->userdata('IDHak');
			$Data004['ButuhTabel'] = TRUE;
			$Data004['ButuhForm'] = TRUE;
			$content['datatahun'] = $this->M_UserCek->AmbilTahun();
			$content['datakelas'] = $this->M_UserCek->DataKelasAmbil();
			$content['datasiswa'] = $this->M_UserCek->DataMuridOnly();
			$content['datatahunajaran'] = $this->M_UserCek->ReadSpp();
			$content['datasemester'] = $this->M_UserCek->AmbilSemester();
			$content['tabel'] = $this->M_UserCek->ReadSpp();
			$this->load->view('halaman/template/001', $Data004);
			$this->load->view('halaman/template/002(UPPER)', $Data002);
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003);
			if ($fungsi === null) {
				if (!isset($_POST['KeuanganBayar'])) {
					$content['DataCari'] = FALSE;
				} else {
					$where = array('keuangan_spp.IDSpp' => $_POST['IDSpp']);
					$where2 = array(
						'keuangan_spp_bayar.IDSpp' => $_POST['IDSpp'],
						'keuangan_spp_bayar.NisSiswa' => $_POST['NisSiswa']
					);
					$content['DataCari'] = $this->M_UserCek->ReadBayarSpp($where2);
					$content['tabel2'] = $this->M_UserCek->ReadSppWhere($where);
				}
				$this->load->view('halaman/content/halamanSistem/keuangan/keuangan_spp_bayar', $content);
			}elseif ($fungsi=="Riwayat" && $id!==null) {
				$NisSiswa = array('tb_siswa.NisSiswa' => $id );
				$NisSiswa2 = array('keuangan_spp_bayar.NisSiswa' => $id );
				$content['DataSiswaPembayaran'] = $this->M_UserCek->getSiswaWithOrtuBy($NisSiswa);
				$content['RiwayatPembayaran']=$this->M_UserCek->ReadBayarSpp($NisSiswa2);
				$this->load->view('halaman/content/halamanSistem/keuangan/keuangan_spp_laporan', $content);
			}
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004);
		}
	}

	public function BayarSPPCRUD()
	{
		if ($this->session->userdata('Status') !== "Login") {
			redirect(base_url("User_login"));
		} else {
			if (isset($_POST['BayarSPP'])) {
				// print_r($_POST);
				$where = array('KodeGuru' => $this->session->userdata('KodeGuru'));
				foreach ($this->M_UserCek->DataGuruWhere($where) as $key) {
					$DataGuru = $key->IDGuru;
				}
				$cek = 1;
				$totalBayar=0;
				for ($i = 0; $i < count($_POST['bayar']); $i++) {
					$pisah = explode('/', $_POST['bayar'][$i]);
					$DataMasuk = array(
						'NisSiswa' => $_POST['NisSiswa'],
						'IDSpp' => $_POST['IDSpp'],
						'JumlahRp' => $_POST['JumlahRp'],
						'BayarBulan' => $pisah[0],
						'BayarTahun' => $pisah[1],
						'Keterangan' => 'Lunas',
						'IDGuru' => $DataGuru,
						'TglBayar' => date('d/m/Y')
					);
					$this->M_UserCek->InsertBayarSPP($DataMasuk);
					$totalBayar+=$_POST['JumlahRp'];
					// print_r($DataMasuk);
					// echo "User_keuangan/BayarSPP";
					if ($cek == count($_POST['bayar'])) {
						$Dmn2 = array('tb_siswa.NisSiswa' => $_POST['NisSiswa'] );
						$AmbilDataSiswa=$this->M_UserCek->getSiswaWithOrtuByArr($Dmn2);
						$Pesan = "Pemberitahuan! Pembayaran untuk " . $AmbilDataSiswa[0]['NamaSiswa'] . ", sebesar Rp.".$this->formatRupiah($totalBayar).", Pada tanggal *_".date('d/m/Y')."_*  berhasil dilakukan.\n";
						$Pesan .= "Terima kasih atas kerjasama Anda. Pembayaran ini akan mendukung kelancaran proses pembelajaran di sekolah kami.\n";
						$Pesan .= "Salam hormat,\n";
								$this->SENDINGWA($Pesan,$AmbilDataSiswa[0]['NomorHP']);
						$this->session->set_flashdata('toastr_success', 'Pembayaran Berhasil!');
						redirect(base_url("User_keuangan/BayarSPP"));
					}
					$cek++;
				}
			}
		}
	}

	public function Wajib()
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
			$Data003 = array(
				'UsrGuru' => $this->session->userdata('UsrGuru'),
				'aktif' => 'Wajib'
			);
			$where = $this->session->userdata('KodeGuru');
        	$Data003['Fitur'] = $this->M_UserCek->FiturSistem();
			$Data003['SISTEM'] =	$this->M_UserCek->APPNAME();
			$Data003['HakAkses'] = $this->M_UserCek->DataHakakses();
			$Data003['IDHak'] = $this->session->userdata('IDHak');
			$Data003['DataWajib'] = $this->M_UserCek->ReadWajibKeuangan();
			$Data004['ButuhTabel'] = TRUE;
			$Data004['ButuhForm'] = TRUE;

			$content['datatahunajaran'] = $this->M_UserCek->AmbilTahunAjaran();
			// Memuat tampilan berdasarkan template dan data yang telah disiapkan
			$this->load->view('halaman/template/001', $Data004); // Template bagian atas
			$this->load->view('halaman/template/002(UPPER)', $Data002); // Template bagian header
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003); // Template sidebar
			$this->load->view('halaman/content/halamanSistem/keuangan/keuangan_wajib', $content);
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004); // Template bagian bawah
		}
	}

	public function WajibCRUD()
	{
		if ($this->session->userdata('Status') !== "Login") {
			redirect(base_url("User_login"));
		} else {
			if (isset($_POST)) {
				if ($_POST['Wajib'] == 'TRUE' && $_POST['Insert'] == 'TRUE') {
					// print_r($_POST);
					$DataMasuk = array(
						'NamaWajib' => $_POST['Nama'],
						'IDAjaran' => $_POST['IDAjaran'],
						'JumlahRpWajib' => str_replace(',', '', $_POST['JumlahRp']),
						'Keterangan' => $_POST['Keterangan']
					);
					// print_r($DataMasuk);

					$this->session->set_flashdata('toastr_success', 'Pembayaran Berhasil!');
					redirect(base_url("User_keuangan/Wajib"));
				}
			}
		}
	}


	public function WajibBayar($fungsi = null, $id = null)
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
			$Data003 = array(
				'UsrGuru' => $this->session->userdata('UsrGuru'),
				'aktif' => 'WajibBayar'
			);
			$where = $this->session->userdata('KodeGuru');
			$Data003['SISTEM'] = $this->M_UserCek->APPNAME();
        	$Data003['Fitur'] = $this->M_UserCek->FiturSistem();
			$Data003['HakAkses'] = $this->M_UserCek->DataHakakses();
			$Data003['IDHak'] = $this->session->userdata('IDHak');
			$Data004['ButuhTabel'] = TRUE;
			$Data004['ButuhForm'] = TRUE;
			$content['datatahun'] = $this->M_UserCek->AmbilTahun();
			$content['datakelas'] = $this->M_UserCek->DataKelasAmbil();
			$content['datasiswa'] = $this->M_UserCek->DataMuridOnly();
			$content['datatahunajaran'] = $this->M_UserCek->JustReadWajibKeuangan();
			$content['datasemester'] = $this->M_UserCek->AmbilSemester();
			$content['tabel'] = $this->M_UserCek->ReadSpp();
			$this->load->view('halaman/template/001', $Data004);
			$this->load->view('halaman/template/002(UPPER)', $Data002);
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003);
			if ($fungsi === null) {
				if (!isset($_POST['KeuanganBayar'])) {
					$content['DataCari'] = FALSE;
				} else {
					$where = array('keuangan_spp.IDSpp' => $_POST['IDSpp']);
					$where2 = array(
						'keuangan_spp_bayar.IDSpp' => $_POST['IDSpp'],
						'keuangan_spp_bayar.NisSiswa' => $_POST['NisSiswa']
					);
					$content['DataCari'] = $this->M_UserCek->ReadBayarSpp($where2);
					$content['tabel2'] = $this->M_UserCek->ReadSppWhere($where);
				}
				$this->load->view('halaman/content/halamanSistem/keuangan/keuangan_wajib_bayar', $content);
			}
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004);
		}
	}
}
