<?php
class Whatsapp extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('M_UserCek');
		$this->load->helper('url');
		$this->load->helper('cookie');
		$this->load->library('Pdf');
        // $this->load->library('encryption');
	}



        public function TesKoneksi()
        {
            // Pastikan keyId terdefinisi dan tidak kosong
            if ($this->input->post('keyId')!==null) {
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
                        "receiver" => $WA['whatsapp_number'],
                        "data" => [
                            "message" => "💻🖥️🛠️📡🛰️📡🛠️🖥️💻\n🛠️SISTEM MELAKUKAN\n🔄KONEKSI\nKE 🖥️SERVER\n📅PADA ".date('d F Y H:i:s')."✅✅✅✅✅\n💻🖥️🛠️📡🛰️📡🛠️🖥️💻"
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
                    $err = curl_error($ch);
                    curl_close($ch);
                    if ($err) {
                        $result = [
                            "status" => false,
                            "message" => "WhatsApp Tidak Terhubung!"
                        ];
                    } else {
                        $result = [
                            "status" => true,
                            "message" => "WhatsApp Terhubung!"
                        ];
                    }
                }else {
                    $result = [
                        "status" => false,
                        "message" => "Tidak Ada WhatsApp Yang Terhubung!"
                    ];
                }
                $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
            }else{
                // Mendapatkan alamat IP pengguna
                $ip_address1 = $_SERVER['REMOTE_ADDR'];

                // Jika pengguna menggunakan proxy, Anda dapat mencoba menggunakan HTTP_X_FORWARDED_FOR
                // Namun, perlu diingat bahwa nilai ini bisa dipalsukan oleh pengguna
                if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $ip_address2 = $_SERVER['HTTP_X_FORWARDED_FOR'];
                }else{
                    $ip_address2 = 'none';
                }
                $Data = [
                        "IP Address 1" => $ip_address1,
                        "IP Address 2" => $ip_address2,
                        "Device" => $_SERVER['HTTP_USER_AGENT']
                    ];
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($Data));

            }
        }

        public function SpamKeNomor()
        {
            // Pastikan keyId terdefinisi dan tidak kosong
            if ($this->input->post('keyId')!==null) {
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
                        "receiver" => '6282111076521',
                        "data" => [
                            "message" => "💻🖥️🛠️📡🛰️📡🛠️🖥️💻\n🛠️SISTEM MELAKUKAN\n🔄KONEKSI\nKE 🖥️SERVER\n📅PADA ".date('d F Y H:i:s')."✅✅✅✅✅\n💻🖥️🛠️📡🛰️📡🛠️🖥️💻"
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
                    $err = curl_error($ch);
                    curl_close($ch);
                    if ($err) {
                        $result = [
                            "status" => false,
                            "message" => "WhatsApp Tidak Terhubung!"
                        ];
                    } else {
                        $result = [
                            "status" => true,
                            "message" => "Mengirim Pesan!"
                        ];
                    }
                }else {
                    $result = [
                        "status" => false,
                        "message" => "Tidak Ada WhatsApp Yang Terhubung!"
                    ];
                }
                $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
            }else{
                // Mendapatkan alamat IP pengguna
                $ip_address1 = $_SERVER['REMOTE_ADDR'];

                // Jika pengguna menggunakan proxy, Anda dapat mencoba menggunakan HTTP_X_FORWARDED_FOR
                // Namun, perlu diingat bahwa nilai ini bisa dipalsukan oleh pengguna
                if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $ip_address2 = $_SERVER['HTTP_X_FORWARDED_FOR'];
                }else{
                    $ip_address2 = 'none';
                }
                $Data = [
                        "IP Address 1" => $ip_address1,
                        "IP Address 2" => $ip_address2,
                        "Device" => $_SERVER['HTTP_USER_AGENT']
                    ];
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($Data));

            }
        }


}