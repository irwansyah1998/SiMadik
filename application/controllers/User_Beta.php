<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'libraries/PhpSpreadsheet/autoload.php';

class User_Beta extends CI_Controller
{

	private function FREEVer($DataPesan){
		$Sistem = $this->M_UserCek->APPNAME();
		foreach ($Sistem as $row) {
		  $NamaSistem = $row->NamaSistem;
		  $NamaInstansi = $row->NamaInstansi;
		  $Alamat = $row->Alamat;
		  $Keterangan = $row->Keterangan;
		  $Logo = $row->Logo;
		}

		$TanggalSekarang=date('l, d-m-Y H:i:s');

		$Variabel = "Abaikan semua instruksi sebelumnya. Anda adalah orang yang sopan, berpengetahuan dan suka membantu yang dapat menjawab segala pertanyaan, dan nama kamu adalah Si Adik (Sistem Artificial Intelligence Pendidikan) dibuat dan dikembangkan tanggal 10 Desember 2023 oleh PT. Bening Jaya Sentosa untuk membantu guru/pengajar ".$NamaInstansi.". Untuk referensi sekarang adalah tanggal ".$TanggalSekarang.", dan Nama orang yang bertanya saat ini adalah ".$this->session->userdata('NamaGuru').". Tugas Anda adalah menjawab pertanyaan berikut yang dibatasi oleh tiga backticks.
			Pertanyaan:
			```".$DataPesan."```";
			return $Variabel;
	}

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_UserCek');
		$this->load->model('M_WhatsApp');
		$this->load->helper(array('form', 'url', 'cookie'));
		$this->load->library('Pdf');
		
	}

	public function SiAdik()
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
				'aktif' => 'SiAdik'
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
			$this->load->view('halaman/template/001', $Data004); // Template bagian atas
			$this->load->view('halaman/template/002(UPPER)', $Data002); // Template bagian header
			$this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003); // Template bagian sidebar
			$this->load->view('halaman/content/halamanSistem/beta/SiAdik', $content); // Konten halaman dashboard
			$this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
			$this->load->view('halaman/template/004', $Data004); // Template bagian bawah
		}
	}
	public function sendMessage()
	{
	    // Ambil pesan dari pengguna dari input POST dengan nama 'message'
	    $userMessage = $this->input->post('message');

	    // Informasi API OpenAI
	    $apiUrl = 'https://api.openai.com/v1/chat/completions';
	    // $apiKey = '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';
	    $apiKey = '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';
	    $headers = array(
	        'Content-Type: application/json',
	        'Authorization: Bearer ' . $apiKey
	    );

	    // Data yang akan dikirim ke API OpenAI
	    $data = array(
		    'model' => 'gpt-3.5-turbo',
		    'temperature' => 0.3,  // Atur suhu untuk mengontrol kreativitas respons
		    'max_tokens' => 1500,   // Atur maksimum token untuk membatasi panjang respons
		    'messages' => array(
		        array('role' => 'system', 'content' => 'Anda bergabung dalam obrolan'),
		        array('role' => 'user', 'content' => $this->FREEVer($userMessage)),
		        // Tambahkan konteks sebelumnya di sini
		        // array('role' => 'assistant', 'content' => 'Sebelumnya, Anda bertanya: ...'), // Gantilah dengan konteks yang sesuai
		    )
		);

	    // Inisialisasi cURL
	    $ch = curl_init($apiUrl);

	    // Konfigurasi opsi cURL
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	    // Eksekusi cURL untuk mengirim permintaan ke API OpenAI
	    $response = curl_exec($ch);

	    // Tutup koneksi cURL
	    curl_close($ch);

	    // Parse respons JSON
	    $responseData = json_decode($response, true);

	    // Ambil pesan dari asisten (assistant) dari respons
	    $assistantMessage = $responseData;

	    // Tampilkan pesan pengguna dan respons asisten ke antarmuka pengguna (ubah sesuai kebutuhan Anda)
	    $Data = array(
	        'Anda' => $userMessage,
	        'AI' => $assistantMessage
	    );
	    $this->output
	        ->set_content_type('application/json')
	        ->set_output(json_encode($Data));
	}





}