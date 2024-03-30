<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'libraries/PhpSpreadsheet/autoload.php';
require 'vendor/autoload.php';
class User_bk extends CI_Controller{


	public function __construct(){
		parent::__construct();
		$this->load->model('M_UserCek');
        $this->load->model('M_WhatsApp');
		$this->load->helper(array('form', 'url', 'cookie'));
		$this->load->library('Pdf');
        
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

    private function ubahFormatNomor($nomor) {
    // Hapus semua karakter selain angka
    $nomor = preg_replace("/[^0-9]/", "", $nomor);
    
    // Periksa apakah nomor dimulai dengan "0" dan panjangnya adalah 12 digit
    if (strlen($nomor) == 12 && substr($nomor, 0, 1) == '0') {
        // Ganti "0" di awal dengan "62"
        $nomor = '62' . substr($nomor, 1);
    }
    
    return $nomor;
    }


    function BKSkoringSetting($aktif=null,$fungsi=null,$id=null){
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
            'aktif' => 'BKSkoringSetting'
        );

        // Mengambil data dari model untuk ditampilkan dalam tampilan
        $Data003['SISTEM'] = $this->M_UserCek->APPNAME();
        $Data003['Fitur'] = $this->M_UserCek->FiturSistem();
        $Data003['IDHak'] = $this->session->userdata('IDHak');
        $Data004['ButuhTabel'] = TRUE;
        $Data004['ButuhForm'] = TRUE;

        // Mengambil data dari model untuk ditampilkan dalam tampilan

        $content['DataPoin'] = $this->M_UserCek->ReadJenisPelanggaran();
        $content['RekapPoinPelanggaran']=$this->M_UserCek->RekapSkoringGlobal();

        // Memuat tampilan template dan komponen tampilan
        $this->load->view('halaman/template/001', $Data004);
        $this->load->view('halaman/template/002(UPPER)', $Data002);
        $this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003);

        if ($this->input->post()!==null) {
        	if ($this->input->post('Insert')!==null) {
        		if ($this->input->post('Insert')=='JenisPoin') {
        			$DataMasuk = array(
        				'Poin' => $this->input->post('Poin'),
        				'Keterangan' => $this->input->post('Keterangan')
        					);
        			$this->M_UserCek->InsertJenisPelanggaran($DataMasuk);
        			$this->session->set_flashdata('toastr_success', 'Berhasil Memasukkan Data!');
						redirect(base_url("User_bk/BKSkoringSetting"));
        		}
        	}elseif($this->input->post('Update')!==null){
        		if ($this->input->post('Update')=='JenisPoin') {
        			$where = array('IDJenis' => $this->input->post('IDJenis'));
        			$DataMasuk = array(
        				'Poin' => $this->input->post('Poin'),
        				'Keterangan' => $this->input->post('Keterangan')
        					);
        			$this->M_UserCek->UpdateJenisPelanggaran($DataMasuk,$where);
        			$this->session->set_flashdata('toastr_success', 'Berhasil Merubah Data!');
						redirect(base_url("User_bk/BKSkoringSetting"));
        		}
        	}elseif ($this->input->post('Hapus')!==null) {
        		if ($this->input->post('Hapus')=='JenisPoin') {
        			$where = array('IDJenis' => $this->input->post('IDJenis'));
        			$this->M_UserCek->DeleteJenisPelanggaran($where);
        			$this->session->set_flashdata('toastr_success', 'Berhasil Menghapus Data!');
						redirect(base_url("User_bk/BKSkoringSetting"));
        		}
        	}
        }
            $this->load->view('halaman/content/halamanSistem/bimbingan/bk_skoring_setting', $content);
        	// Menampilkan bagian akhir tampilan
        $this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
        $this->load->view('halaman/template/004', $Data004);
    	}
    }

    function BKSkoringPelanggaran($fungsi=null,$id=null){
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
            'aktif' => 'BKSkoringPelanggaran'
        );

        // Mengambil data dari model untuk ditampilkan dalam tampilan
        $Data003['Fitur'] = $this->M_UserCek->FiturSistem();
        $Data003['SISTEM'] = $this->M_UserCek->APPNAME();
        $Data003['IDHak'] = $this->session->userdata('IDHak');
        $Data004['ButuhTabel'] = TRUE;
        $Data004['ButuhForm'] = TRUE;

        // Mengambil data dari model untuk ditampilkan dalam tampilan

        $content['DataPoin'] = $this->M_UserCek->ReadJenisPelanggaran();
        $where = array('StatusBK' => 'Baru');
        $content['RekapPoinPelanggaran']=$this->M_UserCek->RekapSkoringALLBy($where);

        // Memuat tampilan template dan komponen tampilan
        $this->load->view('halaman/template/001', $Data004);
        $this->load->view('halaman/template/002(UPPER)', $Data002);
        $this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003);
        if ($fungsi===null) {
            if (isset($_POST)) {
        	   if (isset($_POST['Insert'])) {
        	       if ($_POST['Insert']=='JenisPoin') {
        		      $DataMasuk = array(
        				'Poin' => $_POST['Poin'],
        				'Keterangan' => $_POST['Keterangan']
        					);
      					//$this->session->set_flashdata('toastr_success', 'Berhasil Memasukkan Data!');
						// redirect(base_url("User_Halaman/BKSkoringSetting"));
        		      }
        	   }elseif(isset($_POST['Update'])){
        		  if ($_POST['Update']=='JenisPoin') {
        			$where = array('IDJenis' => $_POST['IDJenis']);
        			$DataMasuk = array(
        				'Poin' => $_POST['Poin'],
        				'Keterangan' => $_POST['Keterangan']
        					);
        			
      					//$this->session->set_flashdata('toastr_success', 'Berhasil Merubah Data!');
						// redirect(base_url("User_Halaman/BKSkoringSetting"));
        	       }
        	   }elseif (isset($_POST['Hapus'])) {
        		  if ($_POST['Hapus']=='JenisPoin') {
        			$where = array('IDJenis' => $_POST['IDJenis']);
        			
                        //$this->session->set_flashdata('toastr_success', 'Berhasil Menghapus Data!');
						// redirect(base_url("User_Halaman/BKSkoringSetting"));
        		      }
        	       }
                }
                $this->load->view('halaman/content/halamanSistem/bimbingan/bk_skoring_DataPelanggaran', $content);
        	   // Menampilkan bagian akhir tampilan
            }elseif ($fungsi=='Detail' && $id!==null) {
                
                if (isset($_POST)) {
                    
                    if (isset($_POST['Konfirmasi']) && $_POST['Konfirmasi']=='True') {

                        $DataUpdate = array('StatusBK' => 'Konfirmasi' );
                        $where = array('IDLapor' => $_POST['IDLapor'] );
                        $where3 = array('lp.IDLapor' => $id );
                        $DataPelanggaran=$this->M_UserCek->DetailPelanggaran($where3);
                        foreach ($DataPelanggaran as $DP) {
                                $TglLapor = $DP->TglLapor;
                                $NisSiswa = $DP->NisSiswa;
                                $IDJenis = $DP->IDJenis;
                                $Keterangan = $DP->Keterangan;
                                $JenisPelanggaran = $DP->KeteranganJenis;
                                $KodeKelas = $DP->KodeKelas;
                                $NamaSiswa = $DP->NamaSiswa;
                                $NamaOrtu = $DP->NamaOrtu;
                                $File = $DP->File;
                                $StatusBK = $DP->StatusBK;
                        }
                        $Dmn2 = array('tb_siswa.NisSiswa' => $NisSiswa );
                            $AmbilDataSiswa=$this->M_UserCek->getSiswaWithOrtuByArr($Dmn2);
                            $ISIPESAN="<<<SISTEM PEMBERITAHUAN!!!>>>\nNama Siswa : \n*_".$AmbilDataSiswa[0]['NamaSiswa']."_*\nPelanggaran : \n*_".$JenisPelanggaran."_*\nTanggal : \n*_".$TglLapor."_*\n\nKeterangan : \n*_".$Keterangan."_*\n\nSistem Notifikasi Wali Kelas ";
                            $WATUJUAN = $_POST['NomorHP'];
                            $this->SENDINGWA($ISIPESAN,$AmbilDataSiswa[0]['NomorHPGuru']);
                        $this->M_UserCek->UpdateLaporPelanggaran($DataUpdate,$where);
                        $this->session->set_flashdata('toastr_success', 'Berhasil Memasukkan Data!');
                        redirect(base_url("User_bk/BKSkoringPelanggaran/Detail/".$_POST['IDLapor']));
                    }elseif(isset($_POST['Laporkan']) && $_POST['Laporkan']=='True'){
                        
                        $DataUpdate = array('StatusBK' => 'Konfirmasi' );
                        $where = array('IDLapor' => $_POST['IDLapor'] );
                        $where3 = array('lp.IDLapor' => $id );
                        $DataPelanggaran=$this->M_UserCek->DetailPelanggaran($where3);
                        foreach ($DataPelanggaran as $DP) {
                                $TglLapor = $DP->TglLapor;
                                $NisSiswa = $DP->NisSiswa;
                                $IDJenis = $DP->IDJenis;
                                $Keterangan = $DP->Keterangan;
                                $JenisPelanggaran = $DP->KeteranganJenis;
                                $KodeKelas = $DP->KodeKelas;
                                $NamaSiswa = $DP->NamaSiswa;
                                $NamaOrtu = $DP->NamaOrtu;
                                $File = $DP->File;
                                $StatusBK = $DP->StatusBK;
                        }
                        if ($StatusBK !== 'Konfirmasi') {

                            $Dmn2 = array('tb_siswa.NisSiswa' => $NisSiswa );
                            $AmbilDataSiswa=$this->M_UserCek->getSiswaWithOrtuByArr($Dmn2);
                            $ISIPESAN="<<<SISTEM PEMBERITAHUAN!!!>>>\nNama Siswa : \n*_".$AmbilDataSiswa[0]['NamaSiswa']."_*\nPelanggaran : \n*_".$JenisPelanggaran."_*\nTanggal : \n*_".$TglLapor."_*\n\nKeterangan : \n*_".$Keterangan."_*\n\nSistem Notifikasi Wali Kelas ";
                            $WATUJUAN = $_POST['NomorHP'];
                            $this->SENDINGWA($ISIPESAN,$AmbilDataSiswa[0]['NomorHPGuru']);
                        }
                        $this->M_UserCek->UpdateLaporPelanggaran($DataUpdate,$where);
                        $ISIPESAN="🚨 [Pemberitahuan Pelanggaran Sekolah] 🚨\n\nHalo Orang Tua/Wali,\n\nKami ingin memberi tahu Anda bahwa anak Anda, ".$NamaSiswa.", telah melakukan pelanggaran di sekolah pada tanggal ".$TglLapor.".\n\n📖 Detail Pelanggaran :\n".$Keterangan."\nPelanggaran: ".$JenisPelanggaran."\n\n\n⚖️ Tindakan yang Akan Diambil:\nKami sedang mengkaji tindakan yang akan diambil sesuai dengan kebijakan sekolah. Kami akan memberi tahu Anda lebih lanjut segera.\n\n❓ Pertanyaan?\nJika Anda memiliki pertanyaan atau memerlukan informasi lebih lanjut, silakan hubungi kami.\n\nTerima kasih atas perhatiannya.\n\nHormat kami,\n";
                            $WATUJUAN = $_POST['NomorHP'];
                            $WACEK=$this->SENDINGWA($ISIPESAN,$WATUJUAN);
                        if ($WACEK!==false) {
                            $this->session->set_flashdata('toastr_success', 'Berhasil Melaporkan Ke Wali Murid !');
                        }else{
                            $this->session->set_flashdata('toastr_warning', 'WhatsApp tidak terhubung, coba cek kembali !');
                        }
                        redirect(base_url("User_bk/BKSkoringPelanggaran/Detail/".$_POST['IDLapor']));
                    }
                }
               $where = array('lp.IDLapor' => $id );
               $content['DataPelanggaran']=$this->M_UserCek->DetailPelanggaran($where);
               $this->load->view('halaman/content/halamanSistem/bimbingan/bk_skoring_DataPelanggaran_detail', $content);
            }
            $this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
            $this->load->view('halaman/template/004', $Data004);
    	}
    }

	function BKIndividu() {
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
                'aktif' => 'BKIndividu'
            );

            // Mengambil data dari model untuk ditampilkan dalam tampilan
            $Data003['Fitur'] = $this->M_UserCek->FiturSistem();
            $Data003['SISTEM'] = $this->M_UserCek->APPNAME();
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

            // Melakukan pengecekan fungsi yang akan dilakukan
            if (isset($_POST)) {
            	if (isset($_POST['CariData'])&&$_POST['CariData']=='Siswa') {
            		$where = array('NisSiswa' => $_POST['NisSiswa'], 'StatusBK' => 'Konfirmasi');
                	$content['RekapIndividu']=$this->M_UserCek->RekapSkoringIndividuBy($where);
                	$content['CariData']=$_POST['CariData'];
            	}
            }else {
                // Menampilkan halaman penilaian
            }
                $this->load->view('halaman/content/halamanSistem/bimbingan/bk_individu', $content);
            	// Menampilkan bagian akhir tampilan
                $this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
                $this->load->view('halaman/template/004', $Data004);
        	}
	}

    public function BKCRUD($halaman=null,$id=null)
    {
        if ($this->session->userdata('Status') !== "Login") {
            redirect(base_url("User_login"));
        } else {
            if ($halaman=='Hapus'&&$id!==null) {
                if ($this->input->post('IDLapor')==$id) {
                    // print_r($this->input->post());
                    $where = array('IDLapor' => $this->input->post('IDLapor') );
                    foreach ($this->M_UserCek->DetailPelanggaran($where) as $key) {
                        if (file_exists($key->File)) {
                            unlink($key->File);
                        }
                    }
                    $this->M_UserCek->DeleteteLaporPelanggaran($where);
                    $this->session->set_flashdata('toastr_success', 'Berhasil Menghapus Data!');
                    redirect(base_url("User_bk/BKSkoringPelanggaran/"));
                }
            }
        }
    }



    // SURAT DIGITALLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLL

    public function SuratDigital($halaman=null,$IDBaca=null)
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
            $Data003['aktif'] = 'SuratDigitalBK';
            $Data003['HakAkses'] = $this->M_UserCek->DataHakakses();
            $Data003['IDHak'] = $this->session->userdata('IDHak');
            $Data003['Fitur'] = $this->M_UserCek->FiturSistem();
            $Data004['ButuhTabel'] = TRUE;
            $Data004['ButuhForm'] = TRUE;
            $content['TahunAjaran'] = $this->M_UserCek->AmbilTahunAjaran();
            $where[0] = array(
                'sd.IDHak' =>'5',
                'sd.status' => 'Terkirim',
                'sd.KategoriSurat' => 'BK',
                'sd.Sampah' => 'Tidak'
            );
            $content['SuratDigital'] = $this->M_UserCek->SuratDigitalRead($where[0]);
            $this->load->view('halaman/template/001', $Data004);
            $this->load->view('halaman/template/002(UPPER)', $Data002);
            $this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003);
            if ($halaman==null) {
                $this->load->view('halaman/content/halamanSistem/bimbingan/SuratDigital/SuratDigital', $content);
            }elseif ($halaman=='Baca' && $IDBaca!==null) {
                $where[1] = array(
                    'sd.KategoriSurat' => 'BK',
                    'sd.IDSurat' => $IDBaca
                );
                $content['SuratDigitalBaca'] = $this->M_UserCek->SuratDigitalRead($where[1]);
                $this->load->view('halaman/content/halamanSistem/bimbingan/SuratDigital/SuratDigitalBaca', $content);
            }elseif ($halaman=='Edit' && $IDBaca!==null) {
                $where[1] = array(
                    'sd.KategoriSurat' => 'BK',
                    'sd.IDSurat' => $IDBaca
                );
                $content['SuratDigitalBaca'] = $this->M_UserCek->SuratDigitalRead($where[1]);
                $this->load->view('halaman/content/halamanSistem/bimbingan/SuratDigital/SuratDigitalEdit', $content);
            }
            $this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
            $this->load->view('halaman/template/004', $Data004);
        }
    }
    public function SuratDigitalCRUD($halaman=null,$ID=null)
    {
        if ($this->session->userdata('Status') !== "Login") {
            // Jika belum login, arahkan kembali ke halaman login
            redirect(base_url("User_login"));
        } else {
            if ($halaman=='Hapus' && $ID!==null) {
                $DataMasuk = array(
                    'Sampah' => 'Ya'
                    );
                $where = array('IDSurat' => $ID );
                $this->M_UserCek->SuratDigitalUpdate($DataMasuk,$where);
                redirect(base_url("User_bk/SuratDigitalHapus"));
            }
        }
    }
    public function SuratDigitalHapusPermanen($halaman=null,$ID=null)
    {
        if ($this->session->userdata('Status') !== "Login") {
            // Jika belum login, arahkan kembali ke halaman login
            redirect(base_url("User_login"));
        } else {
            if ($halaman=='Permanen' && $ID!==null) {
                $where = array('IDSurat' => $ID );
                $this->M_UserCek->SuratDigitalDelete($where);
                $this->session->set_flashdata('toastr_success', 'Surat Berhasil Dihapus Permanen!');
                redirect(base_url("User_bk/SuratDigitalHapus"));
            }
        }
    }
    public function SuratDigitalRestore($halaman=null,$ID=null)
    {
        if ($this->session->userdata('Status') !== "Login") {
            // Jika belum login, arahkan kembali ke halaman login
            redirect(base_url("User_login"));
        } else {
            if ($halaman=='Restore' && $ID!==null) {
                $DataMasuk = array(
                    'Sampah' => 'Tidak'
                    );
                $where = array('IDSurat' => $ID );
                $this->M_UserCek->SuratDigitalUpdate($DataMasuk,$where);
                $this->session->set_flashdata('toastr_success', 'Surat Berhasil dikembalikan!');
                redirect(base_url("User_bk/SuratDigitalHapus"));
            }
        }
    }
    public function ServerSideSave()
    {
        if ($this->input->is_ajax_request()) {
            // Pastikan ini adalah permintaan AJAX
            $IDSuratDigital=$this->input->post('IDSuratDigital');
            $subjek = $this->input->post('Subjek');
            $keterangan = $this->input->post('Keterangan');
            $isiSurat = $this->input->post('IsiSurat');
            // Mengambil data dari permintaan POST
            $IDGuru = $this->encryption->decrypt($this->input->post('Token'));
            $where = array('tg.IDGuru' => $IDGuru );
            $cek=$this->M_UserCek->GuruMengajar($where);
            if ($cek!==false) {
                // Contoh: Simpan data ke dalam tabel di database menggunakan model
                $dataSimpan = array(
                    'KategoriSurat' => 'BK',
                    'SubjekSurat' => $subjek,
                    'Keterangan' => $keterangan,
                    'IsiSurat' => $isiSurat,
                    'Status' => 'Rancangan',
                    'IDHak' => '5',
                    'IDGuru' => $this->session->userdata('IDGuru'),
                    'Sampah' => 'Tidak',
                    'TanggalSurat' => date("Y-m-d H:i:s")
                );

                if ($this->input->post('IDSurat')==null) {
                    // Panggil model untuk menyimpan data ke database
                    $idSuratBaru = $this->M_UserCek->SuratDigitalInsert($dataSimpan); // Ganti sesuai dengan model dan fungsi Anda
                }elseif ($this->input->post('IDSurat')!==null) {
                    $where = array('IDSurat' => $this->input->post('IDSurat') );
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
            }

        } else {
            // Tangani jika ini bukan permintaan AJAX
        }
    }

    

    public function SuratDigitalBuat($halaman=null)
    {
        if ($this->session->userdata('Status') !== "Login") {
            // Jika belum login, arahkan kembali ke halaman login
            redirect(base_url("User_login"));
        } else {
            if ($halaman==null) {

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
                $Data003['aktif'] = 'SuratDigitalBK';
                $Data003['HakAkses'] = $this->M_UserCek->DataHakakses();
                $Data003['IDHak'] = $this->session->userdata('IDHak');
                $Data004['ButuhTabel'] = TRUE;
                $Data004['ButuhForm'] = TRUE;
                $content['TahunAjaran'] = $this->M_UserCek->AmbilTahunAjaran();
                $this->load->view('halaman/template/001', $Data004);
                $this->load->view('halaman/template/002(UPPER)', $Data002);
                $this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003);
                $this->load->view('halaman/content/halamanSistem/bimbingan/SuratDigital/SuratDigitalBuat', $content);
                $this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
                $this->load->view('halaman/template/004', $Data004);

            }elseif($halaman=='Kirim'){
                if ($this->input->post('IDSurat')==null) {
                    $DataMasuk = array(
                        'KategoriSurat' => 'BK',
                        'SubjekSurat' => $this->input->post('Subjek'),
                        'Keterangan' => $this->input->post('Keterangan'),
                        'IsiSurat' => $this->input->post('IsiSurat'),
                        'Status' => 'Terkirim',
                        'IDHak' => '5',
                        'IDGuru' => $this->session->userdata('IDGuru'),
                        'Sampah' => 'Tidak',
                        'TanggalSurat' => date("Y-m-d H:i:s")
                    );
                    if ($this->input->post('KategoriSurat')=='BK') {
                        $DataMasuk['FilterKategori']='Ortu';
                    }
                    $this->M_UserCek->SuratDigitalInsert($DataMasuk);
                    $cek=$this->M_UserCek->GETSuratDigitalArr($DataMasuk);
                    if ($cek!==false) {
                        print_r($cek);
                    }
                    // $this->session->set_flashdata('toastr_success', 'Surat Berhasil dikirim!');
                    // redirect(base_url("User_bk/SuratDigital"));
                }elseif ($this->input->post('IDSurat')!==null) {
                    $DataMasuk = array(
                        'KategoriSurat' => 'BK',
                        'SubjekSurat' => $this->input->post('Subjek'),
                        'Keterangan' => $this->input->post('Keterangan'),
                        'IsiSurat' => $this->input->post('IsiSurat'),
                        'Status' => 'Terkirim',
                        'IDGuru' => $this->session->userdata('IDGuru'),
                        'Sampah' => 'Tidak',
                        'TanggalSurat' => date("Y-m-d H:i:s")
                    );
                    $where = array('IDSurat' => $this->input->post('IDSuratDigital') );
                    if ($this->input->post('KategoriSurat')=='Special') {
                        $DataMasuk['FilterKategori']=$this->input->post('FilterKategori');
                    }
                    $this->M_UserCek->SuratDigitalUpdate($DataMasuk, $where);
                    $this->session->set_flashdata('toastr_success', 'Surat Berhasil diubah!');
                    redirect(base_url("User_bk/SuratDigital"));
                }
            }
        }
    }
    public function ServerSideWaliMurid()
    {
        if ($this->input->is_ajax_request()) {
            $IDGuru = $this->encryption->decrypt($this->input->post('Token'));
            $where = array('tg.IDGuru' => $IDGuru );
            $cek=$this->M_UserCek->GuruMengajar($where);
            if ($cek!==false) {
                $response = $this->M_UserCek->getSiswaWithOrtuArr();
                echo json_encode($response);
            }
        } else {
            // Tangani jika ini bukan permintaan AJAX
        }
    }


    public function SuratDigitalDraft($halaman=null,$IDBaca=null)
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
            $Data003['aktif'] = 'SuratDigitalBK';
            $Data003['HakAkses'] = $this->M_UserCek->DataHakakses();
            $Data003['IDHak'] = $this->session->userdata('IDHak');
            $Data004['ButuhTabel'] = TRUE;
            $Data004['ButuhForm'] = TRUE;
            $content['TahunAjaran'] = $this->M_UserCek->AmbilTahunAjaran();
            $where[0] = array(
                'sd.IDHak' =>'5',
                'sd.KategoriSurat' => 'Khusus',
                'sd.status' => 'Rancangan',
                'sd.Sampah' => 'Tidak',
                'sd.FilterKategori' => 'BK'
            );

            $content['DataSuratDigital'] = $this->M_UserCek->SuratDigitalRead($where[0]);

            $content['SuratDigital'] = $this->M_UserCek->SuratDigitalRead($where[0]);
            $this->load->view('halaman/template/001', $Data004);
            $this->load->view('halaman/template/002(UPPER)', $Data002);
            $this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003);
            if ($halaman==null) {
                $this->load->view('halaman/content/halamanSistem/bimbingan/SuratDigital/SuratDigitalDraft', $content);
            }elseif ($halaman=='Baca'&&$IDBaca!==null) {
                $where[1] = array(
                    'sd.IDSurat' => $IDBaca
                );
                $content['SuratDigitalBaca'] = $this->M_UserCek->SuratDigitalRead($where[1]);
                $this->load->view('halaman/content/halamanSistem/bimbingan/SuratDigital/SuratDigitalDraftBaca', $content);
            }elseif ($halaman=='Edit'&&$IDBaca!==null) {
                $where[1] = array(
                    'sd.IDSurat' => $IDBaca
                );
                $content['SuratDigitalBaca'] = $this->M_UserCek->SuratDigitalRead($where[1]);
                $this->load->view('halaman/content/halamanSistem/bimbingan/SuratDigital/SuratDigitalDraftEdit', $content);
            }
            $this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
            $this->load->view('halaman/template/004', $Data004);
        }
    }

    public function SuratDigitalDraftCRUD($halaman=null,$IDSurat=null)
    {
        if ($this->session->userdata('Status') !== "Login") {
            // Jika belum login, arahkan kembali ke halaman login
            redirect(base_url("User_login"));
        } else {
            if ($halaman=='Simpan' && $this->input->post('IDSuratDigital')=='0') {
                    $DataMasuk = array(
                        'KategoriSurat' => 'Khusus',
                        'SubjekSurat' => $this->input->post('Subjek'),
                        'Keterangan' => $this->input->post('Keterangan'),
                        'IsiSurat' => $this->input->post('IsiSurat'),
                        'Status' => 'Rancangan',
                        'IDHak' => '5',
                        'IDGuru' => $this->session->userdata('IDGuru'),
                        'Sampah' => 'Tidak',
                        'TanggalSurat' => date("Y-m-d H:i:s")

                    );
                    if ($this->input->post('KategoriSurat')=='Khusus') {
                        $DataMasuk['FilterKategori']='BK';
                    }
                    $this->M_UserCek->SuratDigitalInsert($DataMasuk);
                    $this->session->set_flashdata('toastr_success', 'Surat Berhasil dikirim!');
                    redirect(base_url("User_bk/SuratDigital"));
            }elseif ($halaman=='Simpan' && $this->input->post('IDSuratDigital')!=='0') {
                    $DataMasuk = array(
                        'KategoriSurat' => 'Khusus',
                        'SubjekSurat' => $this->input->post('Subjek'),
                        'Keterangan' => $this->input->post('Keterangan'),
                        'IsiSurat' => $this->input->post('IsiSurat'),
                        'Status' => 'Rancangan',
                        'IDHak' => '5',
                        'IDGuru' => $this->session->userdata('IDGuru'),
                        'Sampah' => 'Tidak',
                        'TanggalSurat' => date("Y-m-d H:i:s")

                    );
                    if ($this->input->post('KategoriSurat')=='Khusus') {
                        $DataMasuk['FilterKategori']='BK';
                    }
                    $this->M_UserCek->SuratDigitalInsert($DataMasuk);
                    $this->session->set_flashdata('toastr_success', 'Surat Berhasil dikirim!');
                    redirect(base_url("User_bk/SuratDigital"));
                }
        }
    }


    public function SuratDigitalHapus($halaman=null,$IDBaca=null)
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
            $Data003['aktif'] = 'SuratDigitalBK';
            $Data003['HakAkses'] = $this->M_UserCek->DataHakakses();
            $Data003['IDHak'] = $this->session->userdata('IDHak');
            $Data004['ButuhTabel'] = TRUE;
            $Data004['ButuhForm'] = TRUE;
            $content['TahunAjaran'] = $this->M_UserCek->AmbilTahunAjaran();
            $where[0] = array(
                'sd.IDHak' =>'5',
                'sd.Sampah' => 'Ya'
            );

            $content['DataSuratDigital'] = $this->M_UserCek->SuratDigitalRead($where[0]);

            $content['SuratDigital'] = $this->M_UserCek->SuratDigitalRead($where[0]);
            $this->load->view('halaman/template/001', $Data004);
            $this->load->view('halaman/template/002(UPPER)', $Data002);
            $this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003);
            if ($halaman==null) {
            $this->load->view('halaman/content/halamanSistem/bimbingan/SuratDigital/SuratDigitalSampah', $content);
            }elseif ($halaman=='Baca' && $IDBaca!==null) {
                $where[1] = array(
                    'sd.IDSurat' => $IDBaca
                );
                $content['SuratDigitalBaca'] = $this->M_UserCek->SuratDigitalRead($where[1]);
                $this->load->view('halaman/content/halamanSistem/bimbingan/SuratDigital/SuratDigitalSampahBaca', $content);
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
            if ($this->input->post()!==null) {
                $data=$this->input->post('IDSurat');
                $jumlah=0;
                for ($i=0; $i < count($this->input->post('IDSurat')); $i++) { 
                    $where = array('IDSurat' => $data[$i] );
                    $DataMasuk = array('Sampah' => 'Ya');
                    $this->M_UserCek->SuratDigitalUpdate($DataMasuk, $where);
                    $jumlah++;
                }
                if ($jumlah==count($this->input->post('IDSurat'))) {
                    $this->session->set_flashdata('toastr_success', $jumlah.' Data Berhasil dihapus!');
                    redirect(base_url("User_bk/".$this->input->post('Halaman')));
                }
            }
        }
    }
    public function SuratHapusPermanenMany(){
        if ($this->session->userdata('Status') !== "Login") {
            // Jika belum login, arahkan kembali ke halaman login
            redirect(base_url("User_login"));
        } else {
            if ($this->input->post()!==null) {
                $data=$this->input->post('IDSurat');
                $jumlah=0;
                for ($i=0; $i < count($this->input->post('IDSurat')); $i++) { 
                    $where = array('IDSurat' => $data[$i] );
                    $this->M_UserCek->SuratDigitalDelete($where);
                    $jumlah++;
                }
                if ($jumlah==count($this->input->post('IDSurat'))) {
                    $this->session->set_flashdata('toastr_success', $jumlah.' Data Berhasil dihapus!');
                    redirect(base_url("User_bk/SuratDigitalHapus"));
                }
            }
        }
    }

    // SURAT DIGITALLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLL

}