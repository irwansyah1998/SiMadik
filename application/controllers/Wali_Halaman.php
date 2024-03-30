<?php

class Wali_Halaman extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('M_UserCek');
		$this->load->helper('url');
		$this->load->helper('cookie');
		$this->load->library('Pdf');
		// $this->load->library('encryption');
	}

	public function index(){
		// Memeriksa apakah sesi 'Status' telah diatur sebagai "Login"
		if($this->session->userdata('Status') !== "WaliLogin"){
			// Jika belum login, arahkan kembali ke halaman login
			redirect(base_url("User_login"));
		}else{
			// Jika sudah login, lanjutkan eksekusi berikutnya
			// Menyiapkan data yang diperlukan untuk sidebar
			$Data003 = array(
				'UsrGuru' => $this->session->userdata('UsrGuru'),
				'aktif' => 'Dashboard'
			);
			// Mengambil informasi nama sistem dari model dan menambahkannya ke data sidebar
			$Data003['SISTEM']=$this->M_UserCek->APPNAME();
			// Mengambil informasi ID hak akses pengguna dan menambahkannya ke data sidebar
			$Data003['IDHak'] = $this->session->userdata('IDHak');
			// Menyiapkan data yang diperlukan untuk konten halaman
			$Data004['ButuhTabel'] = TRUE;
			$Data004['ButuhForm'] = TRUE;
			// Mengambil informasi jumlah murid, guru, dan kelas dari model dan menambahkannya ke data konten
			$where = array('NisSiswa' => $this->session->userdata('NisSiswa') );
			$where2 =array('tb_siswa.NisSiswa' => $this->session->userdata('NisSiswa') );
			$content['tabel'] = $this->M_UserCek->AmbilDataSiswaWali($where2);
			$content['TahunAjaran']=$this->M_UserCek->AmbilTahunAjaranLimit(1);
			$content['DataSiswa']=$this->M_UserCek->DataMuridNis($where);
			$content['RekapAbsen7']=$this->M_UserCek->ReadRekapAbsenLimit7($where);
			// print_r($content['RekapAbsen7']);

			// Memuat tampilan berdasarkan template dan data yang telah disiapkan
			$this->load->view('halaman/content/halamanWali/template/001',$Data004); // Template bagian atas
			$this->load->view('halaman/content/halamanWali/template/002(UPPER)'); // Template bagian header
			$this->load->view('halaman/content/halamanWali/template/003-01(SIDERIGHT)',$Data003); // Template bagian sidebar
			$this->load->view('halaman/content/halamanWali/konten/tampilawal',$content);
			$this->load->view('halaman/content/halamanWali/template/003-02(SIDELEFT)',$Data003);
			$this->load->view('halaman/content/halamanWali/template/004',$Data004); // Template bagian bawah
		}
	}

	public function NilaiSiswa()
	{
	    // Memeriksa apakah sesi 'Status' telah diatur sebagai "Login"
	    if ($this->session->userdata('Status') !== "WaliLogin") {
	        // Jika belum login, arahkan kembali ke halaman login
	        redirect(base_url("User_login"));
	    } else {
	        // Menyiapkan data yang diperlukan untuk sidebar
	        $Data003 = array(
	            'UsrGuru' => $this->session->userdata('UsrGuru'),
	            'aktif' => 'NilaiSiswa'
	        );
	        // Mengambil informasi nama sistem dari model dan menambahkannya ke data sidebar
	        $Data003['SISTEM'] = $this->M_UserCek->APPNAME();
	        // Mengambil informasi ID hak akses pengguna dan menambahkannya ke data sidebar
	        $Data003['IDHak'] = $this->session->userdata('IDHak');

	        // Menyiapkan data yang diperlukan untuk konten halaman
	        $Data004['ButuhTabel'] = TRUE;
	        $Data004['ButuhForm'] = TRUE;

	        // Mengambil informasi jumlah murid, guru, dan kelas dari model dan menambahkannya ke data konten
	        if ($this->input->post('CariData') && $this->input->post('CariData') == 'DataNilai') {
	            $content['TampilData'] = true;
	            $NAngNdi = array(
	                'tb_siswa.NisSiswa' => $this->session->userdata('NisSiswa'),
	                'jadwal_kelas_mapel.IDAjaran' => $this->input->post('IDAjaran'),
	                'nilai_mapel.IDSemester' => $this->input->post('IDSemester')
	            );
	            $content['tabelNilai'] = $this->M_UserCek->ReadNilaiSiswaWaliMurid($NAngNdi);
	        }

	        $where = array('NisSiswa' => $this->session->userdata('NisSiswa'));
	        $where2 = array('tb_siswa.NisSiswa' => $this->session->userdata('NisSiswa'));
	        $content['tabel'] = $this->M_UserCek->AmbilDataSiswaWali($where2);
	        $content['DataTahunAjaran'] = $this->M_UserCek->AmbilTahunAjaran();
	        $content['DataSemester'] = $this->M_UserCek->AmbilSemester();
	        $content['TahunAjaran'] = $this->M_UserCek->AmbilTahunAjaranLimit(1);
	        $content['DataSiswa'] = $this->M_UserCek->DataMuridNis($where);

	        // Memuat tampilan berdasarkan template dan data yang telah disiapkan
	        $this->load->view('halaman/content/halamanWali/template/001', $Data004); // Template bagian atas
	        $this->load->view('halaman/content/halamanWali/template/002(UPPER)'); // Template bagian header
	        $this->load->view('halaman/content/halamanWali/template/003-01(SIDERIGHT)', $Data003); // Template bagian sidebar
	        $this->load->view('halaman/content/halamanWali/konten/PenilaianSiswa', $content);
	        $this->load->view('halaman/content/halamanWali/template/003-02(SIDELEFT)', $Data003);
	        $this->load->view('halaman/content/halamanWali/template/004', $Data004); // Template bagian bawah
	    }
	}



	public function RiwayatBayar($fungsi = null)
	{
	    // Memeriksa apakah sesi 'Status' telah diatur sebagai "Login"
	    if ($this->session->userdata('Status') !== "WaliLogin") {
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
	        $Data003 = array(
	            'UsrGuru' => $this->session->userdata('UsrGuru'),
	            'aktif' => 'RiwayatBayar'
	        );
	        $where = $this->session->userdata('KodeGuru');
	        $Data003['SISTEM'] = $this->M_UserCek->APPNAME();
	        $Data003['IDHak'] = $this->session->userdata('IDHak');
	        $Data004['ButuhTabel'] = TRUE;
	        $Data004['ButuhForm'] = TRUE;
	        $content['datatahun'] = $this->M_UserCek->AmbilTahun();
	        $content['datakelas'] = $this->M_UserCek->DataKelasAmbil();
	        $content['datatahunajaran'] = $this->M_UserCek->ReadSpp();
	        $content['datasemester'] = $this->M_UserCek->AmbilSemester();
	        $content['tabel'] = $this->M_UserCek->ReadSpp();

	        // Memuat tampilan berdasarkan template dan data yang telah disiapkan
	        $this->load->view('halaman/content/halamanWali/template/001', $Data004); // Template bagian atas
	        $this->load->view('halaman/content/halamanWali/template/002(UPPER)'); // Template bagian header
	        $this->load->view('halaman/content/halamanWali/template/003-01(SIDERIGHT)', $Data003); // Template bagian sidebar
	        
	        if ($fungsi === null) {
	            if (!$this->input->post('KeuanganBayar')) {
	                $content['DataCari'] = FALSE;
	            } else {
	                $where = array('keuangan_spp.IDSpp' => $this->input->post('IDSpp'));
	                $where2 = array(
	                    'keuangan_spp_bayar.IDSpp' => $this->input->post('IDSpp'),
	                    'keuangan_spp_bayar.NisSiswa' => $this->session->userdata('NisSiswa')
	                );
	                $content['DataCari'] = $this->M_UserCek->ReadBayarSpp($where2);
	                $content['tabel2'] = $this->M_UserCek->ReadSppWhere($where);
	            }
	            $this->load->view('halaman/content/halamanWali/konten/KeuanganRiwayat', $content);
	        }

	        $this->load->view('halaman/content/halamanWali/template/003-02(SIDELEFT)', $Data003);
	        $this->load->view('halaman/content/halamanWali/template/004', $Data004); // Template bagian bawah
	    }
	}


	public function Pelanggaran() {
        if ($this->session->userdata('Status') !== "WaliLogin") {
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
                'aktif' => 'Pelanggaran'
            );

            // Mengambil data dari model untuk ditampilkan dalam tampilan
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


             // Memuat tampilan berdasarkan template dan data yang telah disiapkan
	        $this->load->view('halaman/content/halamanWali/template/001', $Data004); // Template bagian atas
	        $this->load->view('halaman/content/halamanWali/template/002(UPPER)'); // Template bagian header
	        $this->load->view('halaman/content/halamanWali/template/003-01(SIDERIGHT)', $Data003); // Template bagian sidebar

            // Melakukan pengecekan fungsi yang akan dilakukan
            	$where = array(
            		'NisSiswa' => $this->session->userdata('NisSiswa'),
            		'StatusBK' => 'Konfirmasi');
                $content['RekapIndividu']=$this->M_UserCek->RekapSkoringIndividuBy($where);
                $this->load->view('halaman/content/halamanWali/konten/Pelanggaran', $content);

            	$this->load->view('halaman/content/halamanWali/template/003-02(SIDELEFT)', $Data003);
	        $this->load->view('halaman/content/halamanWali/template/004', $Data004); // Template bagian bawah
        	}
	}

}
