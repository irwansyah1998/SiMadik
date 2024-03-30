<?php
class Absensi_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function simpan_absen_masuk($nisSiswa, $jamMasuk)
    {
        $data = array(
            'NisSiswa' => $nisSiswa,
            'JamMasuk' => $jamMasuk
        );

        $this->db->insert('absensi', $data);
    }
}