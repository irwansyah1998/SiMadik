<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_kepsek extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_UserCek');

        $this->load->helper(array('form', 'url', 'cookie'));
        $this->load->library('Pdf');
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
                    "message" => $ISIPESAN . $NII
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

    private function convertDate($date_str)
    {
        $timestamp = strtotime($date_str); // Mengonversi tanggal ke UNIX timestamp
        return $formatted_date = date('Y-m-d', $timestamp); // Mengonversi timestamp ke format Y-m-d
    }

    private function ubahFormatNomor($nomor)
    {
        // Hapus semua karakter selain angka
        $nomor = preg_replace("/[^0-9]/", "", $nomor);

        // Periksa apakah nomor dimulai dengan "0" dan panjangnya adalah 12 digit
        if (strlen($nomor) == 12 && substr($nomor, 0, 1) == '0') {
            // Ganti "0" di awal dengan "62"
            $nomor = '62' . substr($nomor, 1);
        }

        return $nomor;
    }

    // vita rahmada || 25 Januari 2024
    public function JurnalGuru()
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
                'aktif' => 'JurnalGuru'
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

            $where1 = array(
                'tg.KodeGuru' => $this->session->userdata('KodeGuru'),
                'tg.UsrGuru' => $this->session->userdata('UsrGuru')
            );

            // Mengambil data dari model untuk ditampilkan dalam tampilan
            $content['NamaGuru'] = $this->M_UserCek->DataGuru($where1);

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

            if (isset($_POST['CariData']) && $_POST['CariData'] == 'FilterData') {
                $content['TampilData'] = true;

                $where = array(
                    'tb_guru.IDGuru' => $this->session->userdata('IDGuru'),
                    'tb_guru.IDGuru' => $_POST['IDGuru'] // Sesuaikan dengan key yang benar
                );



                $start = $this->input->post('start'); // Ambil nilai start dari form
                $length = $this->input->post('length'); // Ambil nilai length dari form
                // $order = array(
                //     'column' => $this->input->post('order')[0]['column'], // Ambil kolom yang diurutkan dari form
                //     'dir' => $this->input->post('order')[0]['dir'] // Ambil arah pengurutan dari form
                // );

                $order_column = null;
                $order_dir = null;

                if ($this->input->post('order')) {
                    $order_column = $this->input->post('order')[0]['column'];
                    $order_dir = $this->input->post('order')[0]['dir'];
                }

                $order = array(
                    'column' => $order_column,
                    'dir' => $order_dir
                );

                $content['tabel'] = $this->M_UserCek->JurnalGuruMenuKepsek($where, $start, $length, $order);
            }


            // Memuat tampilan template dan komponen tampilan
            $this->load->view('halaman/template/001', $Data004);
            $this->load->view('halaman/template/002(UPPER)', $Data002);
            $this->load->view('halaman/template/003-01(SIDERIGHT)', $Data003);

            $this->load->view('halaman/content/halamanSistem/kepsek/JurnalGuru', $content);

            // Menampilkan bagian akhir tampilan
            $this->load->view('halaman/template/003-02(SIDELEFT)', $Data003);
            $this->load->view('halaman/template/004', $Data004);
        }
    }

    // vita rahmada || 25 Januari 2024 
    public function JurnalGuruAmbilData()
    {
        $draw = $this->input->post('draw');
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $order = $this->input->post('order')[0];

        $searchValue = $this->input->post('search')['value'];
        $IDGuru = $this->input->post('IDGuru');

        $DMN = array(
            'jadwal_kelas_mapel.IDGuru' => $this->input->post('IDGuru')
            // 'jurnal_guru_mapel.IDGuru'=> $IDGuru
        );

        $data = $this->M_UserCek->JurnalGuruMenuKepsek($DMN, $start, $length, $order, $searchValue);
        $dataSemua = $this->M_UserCek->JurnalGuruMenuKepsekHitung($DMN);

        $result = array(
            "draw" => $draw,
            "recordsTotal" => $dataSemua,
            "recordsFiltered" => $dataSemua,
            "data" => $data
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }
    public function JurnalSideServerCRUD()
    {
        $IDPengirim = $this->encryption->decrypt($this->input->post('IDPengirim'));
        $IDJurnal = $this->input->post('IDJurnal');
        $Perintah =  $this->encryption->decrypt($this->input->post('Perintah'));
        $result = array();
        $IDwhere = array('IDGuru' => $IDPengirim );
        $cekUser = $this->M_UserCek->DataGuruWhere($IDwhere);
        if ($cekUser!==false) {
            if ($Perintah=='Konfirmasi') {
                $where = array('IDJurnal' => $IDJurnal );
                $data = array('Status' => 'Konfirmasi' );
                $this->M_UserCek->UpdateJurnalGuru($where,$data);
                $result = array(
                    'status' => 'success',
                    'msg' => 'Berhasil untuk konfirmasi!'
                );
            }elseif ($Perintah=='Batalkan') {
                $where = array('IDJurnal' => $IDJurnal );
                $data = array('Status' => null );
                $this->M_UserCek->UpdateJurnalGuru($where,$data);
                $result = array(
                    'status' => 'success',
                    'msg' => 'Berhasil Membatalkan Konfirmasi!'
                );
            }
        }else{
            $result = array(
                'status' => 'Failed',
                'msg' => 'Anda tidak bisa masuk!'
            );
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function DataSekolah()
    {
        if ($this->session->userdata('Status') !== "Login") {
            redirect(base_url("User_login"));
        } else {
        }
    }
}
