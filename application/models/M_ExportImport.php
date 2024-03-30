<?php

class M_ExportImport extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function APPNAMEarr()
    {
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('penggunaapp',1);
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result_array();
        }
    }

    public function ReadDataMengajarArray()
    {
        $this->db->order_by('IDGuru', 'asc');
        $query = $this->db->get('tb_guru_mengajar');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result_array();
        }
    }
    public function ReadDataMengajarByArray($where)
    {
        $this->db->where($where);
        $this->db->order_by('IDGuru', 'asc');
        $query = $this->db->get('tb_guru_mengajar');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result_array();
        }
    }
    public function ReadDataMengajarBy($where)
    {
        $this->db->where($where);
        $this->db->order_by('IDGuru', 'asc');
        $query = $this->db->get('tb_guru_mengajar');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }
    public function InsertDataMengajar($data)
    {
        $this->db->insert('tb_guru_mengajar', $data);
    }
    public function UpdateDataMengajar($where,$data)
    {
        $this->db->where($where);
        $this->db->update('tb_guru_mengajar', $data);
    }

    public function DataHakaksesArray()
    {
        $sql = "SELECT `IDHak`, `KodeHak`, `JenisHak`, `NamaHak` FROM `tb_hakakses` WHERE 1;";

        if ($this->db->query($sql)->num_rows() == 0) {
            return FALSE;
        } else {
            return $this->db->query($sql)->result_array();
        }
    }

    public function DataMapelArray()
    {
        $query = $this->db->get('tb_mapel');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result_array();
        }
    }
    public function ReadJadwalKelasMapelbyArr($where){
        $this->db->select('
            jadwal_kelas_mapel.IDKelasMapel,
            jadwal_kelas_mapel.IDKelas,
            jadwal_kelas_mapel.IDMapel AS IDMapel,
            jadwal_kelas_mapel.Keterangan AS jadwal_kelas_Keterangan,
            jadwal_kelas_mapel.IDGuru AS IDGuru,
            jadwal_kelas_mapel.IDAjaran AS IDAjaran,
            tb_mapel.KodeMapel AS KodeMapel,
            tb_mapel.NamaMapel AS NamaMapel,
            tb_kelas.KodeKelas AS KodeKelas,
            tb_kelas.KodeGuru AS kelas_KodeGuru,
            tb_kelas.IDGuru AS kelas_IDGuru,
            tb_kelas.RuanganKelas AS kelas_RuanganKelas,
            tb_guru.UsrGuru AS guru_UsrGuru,
            tb_guru.NamaGuru AS guru_NamaGuru,
            tb_guru.NomorIndukGuru AS guru_NomorIndukGuru,
            tb_guru.KodeMapel AS guru_KodeMapel,
            tb_guru.IDHak AS guru_IDHak,
            tb_guru.PassGuru AS guru_PassGuru,
            tb_guru.Status AS guru_Status,
            pengajar.UsrGuru AS pengajar_UsrGuru,
            pengajar.NamaGuru AS pengajar_NamaGuru,
            pengajar.NomorIndukGuru AS pengajar_NomorIndukGuru,
            pengajar.KodeMapel AS pengajar_KodeMapel,
            pengajar.IDHak AS pengajar_IDHak,
            pengajar.PassGuru AS pengajar_PassGuru,
            pengajar.Status AS pengajar_Status,
            tb_tahun.IDTahun,
            tb_tahun.KodeTahun AS KodeTahun,
            tb_tahun.PenyebutanTahun AS PenyebutanTahun,
            tb_tahun.PenulisanTahun AS tahun_PenulisanTahun
        ');

        $this->db->from('jadwal_kelas_mapel');
        $this->db->join('tb_mapel', 'jadwal_kelas_mapel.IDMapel = tb_mapel.IDMapel', 'left');
        $this->db->join('tb_kelas', 'jadwal_kelas_mapel.IDKelas = tb_kelas.IDKelas', 'left');
        $this->db->join('tb_guru', 'tb_kelas.IDGuru = tb_guru.IDGuru', 'left');
        $this->db->join('tb_guru AS pengajar', 'jadwal_kelas_mapel.IDGuru = pengajar.IDGuru', 'left');
        $this->db->join('tb_tahun', 'tb_tahun.KodeTahun = tb_kelas.KodeTahun', 'left');
        // Gabungkan dengan tabel tb_guru
        $this->db->where($where);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result_array();
        }
    }
    public function DataMapelArrayBy($where)
    {
        $this->db->where($where);
        $query = $this->db->get('tb_mapel');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result_array();
        }
    }
    public function DataMataPelajaranInsert($data)
    {
        $this->db->insert('tb_mapel', $data);
    }
    public function DataMataPelajaranUpdate($where, $data)
    {
        $this->db->where($where);
        $this->db->update('tb_mapel', $data);
    }

	public function DataGuruAmbil()
    {
        $this->db->order_by('NamaGuru', 'asc');
        $query = $this->db->get('tb_guru');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function DataGuruAmbilArray()
    {
        $this->db->order_by('NamaGuru', 'asc');
        $query = $this->db->get('tb_guru');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result_array();
        }
    }

    public function DataMuridAmbilArr($where)
    {
        $this->db->where($where);
        $this->db->select('tb_siswa.IDSiswa,
        tb_siswa.NisSiswa,
        tb_siswa.NamaSiswa,
        tb_siswa.KodeKelas,
        tb_siswa.NamaSiswa,
        tb_siswa.GenderSiswa,
        tb_siswa.AyahSiswa,
        tb_siswa.IbuSiswa,
        tb_siswa.TglLhrSiswa,
        tb_siswa.TmptLhrSiswa,
        tb_siswa.NISNSiswa,
        tb_siswa.TGLMasuk,
        tb_siswa.TGLKeluar,
        tb_siswa.Status,
        tb_siswa.Wali,
        tb_kelas.KodeKelas,
        tb_kelas.IDKelas,
        tb_kelas.RuanganKelas'); // Ganti dengan kolom yang sesuai
        $this->db->from('tb_siswa');
        $this->db->join('tb_kelas', 'tb_siswa.KodeKelas = tb_kelas.KodeKelas');
        $this->db->order_by('tb_siswa.NamaSiswa', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result_array();
        }
    }

    function DataMuridBy($where)
    {
        $this->db->where($where);
        $this->db->order_by('NamaSiswa', 'asc');
        $query = $this->db->get('tb_siswa');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function DataMuridInsert($data)
    {
        $this->db->insert('tb_siswa', $data);
    }

    function DataMuridUpdate($where, $data)
    {
        $this->db->where($where);
        $this->db->update('tb_siswa', $data);
    }

    

        // DATA MURID
    public function DataMuridArray()
    {
        $sql = "SELECT
    `1`.`IDSiswa`,
    `1`.`NisSiswa`,
    `1`.`KodeKelas`,
    `1`.`NamaSiswa`,
    `1`.`GenderSiswa`,
    `1`.`AyahSiswa`,
    `1`.`IbuSiswa`,
    `1`.`TglLhrSiswa`,
    `1`.`TmptLhrSiswa`,
    `1`.`NISNSiswa`,
    `1`.`TGLMasuk`,
    `1`.`TGLKeluar`,
    `1`.`Status`,
    `2`.`IDKelas`,
    `2`.`KodeKelas`,
    `2`.`RuanganKelas`,
    `3`.`IDGuru`,
    `3`.`NamaGuru`,
    `3`.`NomorIndukGuru`,
    `3`.`KodeMapel`,
    `3`.`IDHak`,
    `4`.`IDTahun`,
    `4`.`KodeTahun`,
    `4`.`PenyebutanTahun`,
    `4`.`PenulisanTahun`,
    `4`.`Keterangan`
FROM `tb_siswa` AS `1`
LEFT JOIN `tb_kelas` AS `2`
ON `1`.`KodeKelas` = `2`.`KodeKelas`
LEFT JOIN `tb_guru` AS `3`
ON `2`.`IDGuru` = `3`.`IDGuru`
LEFT JOIN `tb_tahun` AS `4`
ON `2`.`KodeTahun` = `4`.`KodeTahun`
ORDER BY `1`.`NamaSiswa` ASC";


        if ($this->db->query($sql)->num_rows() == 0) {
            return FALSE;
        } else {
            return $this->db->query($sql)->result_array();
        }
    }

    public function DataMuridwhereArray($where)
    {
        $sql = "SELECT
            `1`.`IDSiswa`,
            `1`.`NisSiswa`,
            `1`.`KodeKelas`,
            `1`.`NamaSiswa`,
            `1`.`GenderSiswa`,
            `1`.`AyahSiswa`,
            `1`.`IbuSiswa`,
            `1`.`TglLhrSiswa`,
            `1`.`TmptLhrSiswa`,
            `1`.`NISNSiswa`,
            `1`.`TGLMasuk`,
            `1`.`TGLKeluar`,
            `1`.`Status`,
            `2`.`IDKelas`,
            `2`.`KodeKelas`,
            `2`.`RuanganKelas`,
            `3`.`IDGuru`,
            `3`.`KodeGuru`,
            `3`.`NamaGuru`,
            `3`.`NomorIndukGuru`,
            `3`.`KodeMapel`,
            `3`.`IDHak`,
            `4`.`IDTahun`,
            `4`.`KodeTahun`,
            `4`.`PenyebutanTahun`,
            `4`.`PenulisanTahun`,
            `4`.`Keterangan`
        FROM `tb_siswa` AS `1`
        LEFT JOIN `tb_kelas` AS `2`
        ON `1`.`KodeKelas` = `2`.`KodeKelas`
        LEFT JOIN `tb_guru` AS `3`
        ON `2`.`KodeGuru` = `3`.`KodeGuru`
        LEFT JOIN `tb_tahun` AS `4`
        ON `2`.`KodeTahun` = `4`.`KodeTahun`
        WHERE `2`.IDKelas='" . $where['IDKelas'] . "'
        ORDER BY `1`.`NamaSiswa` ASC";


        if ($this->db->query($sql)->num_rows() == 0) {
            return FALSE;
        } else {
            return $this->db->query($sql)->result_array();
        }
    }

    public function DataKelasArray()
    {
        $sql = "SELECT
        `1`.`IDKelas`,
        `1`.`KodeKelas`,
        `1`.`KodeTahun`,
        `1`.`RuanganKelas`,
        `2`.`IDGuru`,
        `2`.`NamaGuru`,
        `2`.`NomorIndukGuru`,
        `3`.`IDTahun`,
        `3`.`KodeTahun`,
        `3`.`PenyebutanTahun`,
        `3`.`PenulisanTahun`,
        `3`.`Keterangan`
        FROM
        `tb_kelas` AS `1`
        LEFT JOIN
        `tb_guru` AS `2`
        ON
        `1`.`IDGuru`=`2`.`IDGuru`
        LEFT JOIN
        `tb_tahun` AS `3`
        ON
        `1`.`KodeTahun`=`3`.`KodeTahun`
        WHERE 1;";
        if ($this->db->query($sql)->num_rows() == 0) {
            return FALSE;
        } else {
            return $this->db->query($sql)->result_array();
        }
    }

    public function DataGuruInsert($data)
    {
        $this->db->insert('tb_guru', $data);
    }
    public function DataGuruWhere($where)
    {
        $this->db->where($where);
        $this->db->order_by('NamaGuru', 'asc');
        $query = $this->db->get('tb_guru');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }
    public function DataGuruWhereArr($where)
    {
        $this->db->where($where);
        $this->db->order_by('NamaGuru', 'asc');
        $query = $this->db->get('tb_guru');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result_array();
        }
    }
    function DataGuruUpdate($where, $data)
    {
        $this->db->where($where);
        $this->db->update('tb_guru', $data);
    }

    function DataKelasWhere($where)
    {
        $this->db->where($where);
        $query = $this->db->get('tb_kelas');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }
    function DataKelasWhereArr($where)
    {
        $this->db->where($where);
        $query = $this->db->get('tb_kelas');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result_array();
        }
    }
    function DataKelasUpdate($where, $data)
    {
        $this->db->where($where);
        $this->db->update('tb_kelas', $data);
    }
    public function DataKelasInsert($data)
    {
        $this->db->insert('tb_kelas', $data);
    }

    public function GuruMengajar($where)
    {
        $this->db->select('
            tg.IDGuru,
            tg.UsrGuru,
            tg.KodeGuru,
            tg.NamaGuru,
            tg.NomorIndukGuru,
            tg.KodeMapel,
            tg.PassGuru,
            tg.Status,
            tgm.IDMengajar,
            tgm.IDMapel,
            tgm.IDGuru AS IDGuru_Tgm,
            tgm.Keterangan,
            tm.IDMapel AS IDMapel_Tm,
            tm.KodeMapel AS KodeMapel_Tm,
            tm.NamaMapel,
            tm.Keterangan AS Keterangan_Tm
        ');

        $this->db->from('tb_guru tg');
        $this->db->join('tb_guru_mengajar tgm', 'tg.IDGuru = tgm.IDGuru', 'left');
        $this->db->join('tb_mapel tm', 'tgm.IDMapel = tm.IDMapel', 'left');
        $this->db->where($where);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function DataWaliInsert($data)
    {
        $this->db->insert('tb_ortu', $data);
    }
    public function getSiswaWithOrtuArr()
    {
        $this->db->select('tb_siswa.IDSiswa, tb_ortu.NisSiswa AS NisSiswa , tb_siswa.NisSiswa as NisSiswaSiswa, KodeKelas, NamaSiswa, GenderSiswa, AyahSiswa, IbuSiswa, TglLhrSiswa, TmptLhrSiswa, NISNSiswa, TGLMasuk, TGLKeluar, Status, Wali, IDOrtu, UsrOrtu, PassOrtu, NamaOrtu, NomorHP, Alamat');
        $this->db->from('tb_ortu');
        $this->db->join('tb_siswa', 'tb_siswa.NisSiswa = tb_ortu.NisSiswa', 'left');
        $query = $this->db->get();

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result_array();
        }
    }
    public function DataWaliUpdate($where, $data_masuk)
    {
        $this->db->where($where);
        $this->db->update('tb_ortu', $data_masuk);
    }
    public function getSiswaWithOrtubyArr($where)
    {
        $this->db->select('tb_siswa.IDSiswa, tb_siswa.NisSiswa as NisSiswaSiswa, KodeKelas, NamaSiswa, GenderSiswa, AyahSiswa, IbuSiswa, TglLhrSiswa, TmptLhrSiswa, NISNSiswa, TGLMasuk, TGLKeluar, Status, Wali, IDOrtu, UsrOrtu, PassOrtu, NamaOrtu, NomorHP, Alamat');
        $this->db->from('tb_ortu');
        $this->db->join('tb_siswa', 'tb_siswa.NisSiswa = tb_ortu.NisSiswa', 'left');
        $this->db->where($where);
        $query = $this->db->get();

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result_array();
        }
    }

    public function ReadNilaiByArr($where)
    {
        // Tabel pertama: jadwal_kelas_mapel
        $this->db->select('jadwal_kelas_mapel.IDKelasMapel, jadwal_kelas_mapel.IDKelas, jadwal_kelas_mapel.IDMapel, jadwal_kelas_mapel.IDGuru, jadwal_kelas_mapel.IDAjaran, jadwal_kelas_mapel.Keterangan');
        $this->db->from('jadwal_kelas_mapel');

        // Tabel kedua: nilai_mapel
        $this->db->join('nilai_mapel', 'jadwal_kelas_mapel.IDKelasMapel = nilai_mapel.IDKelasMapel', 'inner');
        $this->db->select('nilai_mapel.IDNilaiMapel, nilai_mapel.IDSemester, nilai_mapel.NamaMapel, nilai_mapel.NilaiUTS, nilai_mapel.NilaiUAS');

        // Menambahkan kondisi WHERE jika diperlukan
        $this->db->where($where);

        // Eksekusi query
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result_array();
        }
    }
    public function ReadNilaHariArr($where)
    {
        // Tabel pertama: jadwal_kelas_mapel
        $this->db->select('jadwal_kelas_mapel.IDKelasMapel, jadwal_kelas_mapel.IDKelas, jadwal_kelas_mapel.IDMapel, jadwal_kelas_mapel.IDGuru, jadwal_kelas_mapel.IDAjaran, jadwal_kelas_mapel.Keterangan');
        $this->db->from('jadwal_kelas_mapel');

        // Tabel kedua: nilai_mapel_hari
        $this->db->join('nilai_mapel_hari', 'jadwal_kelas_mapel.IDKelasMapel = nilai_mapel_hari.IDKelasMapel', 'inner');
        $this->db->select('nilai_mapel_hari.IDNilaiHari, nilai_mapel_hari.IDSemester, nilai_mapel_hari.NamaNilai, nilai_mapel_hari.KodeNilai, nilai_mapel_hari.NilaiHari, nilai_mapel_hari.Keterangan');

        // Menambahkan kondisi WHERE jika diperlukan
        $this->db->where($where);

        // Eksekusi query
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result_array();
        }
    }

    public function ReadNilaHariSiswaArr($where)
    {
        $this->db->select('nilai_mapel_hari_siswa.IDMHS, nilai_mapel_hari_siswa.IDNilaiHari, nilai_mapel_hari_siswa.NisSiswa, nilai_mapel_hari_siswa.Nilai, nilai_mapel_hari.IDSemester, nilai_mapel_hari.*');
        $this->db->from('nilai_mapel_hari_siswa');
        $this->db->join('nilai_mapel_hari', 'nilai_mapel_hari_siswa.IDNilaiHari = nilai_mapel_hari.IDNilaiHari', 'inner');
        $this->db->join('jadwal_kelas_mapel', 'nilai_mapel_hari.IDKelasMapel = jadwal_kelas_mapel.IDKelasMapel', 'inner');
        $this->db->order_by('nilai_mapel_hari_siswa.NisSiswa', 'asc');
        $this->db->where($where);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result_array();
        }
    }

    public function ReadNilaiSiswaArr($where)
    {
        // Menggunakan Model Builder untuk menggabungkan tabel
        $this->db->select('nilai_mapel.IDNilaiMapel, nilai_mapel.IDKelasMapel, nilai_mapel.IDSemester, nilai_mapel.NisSiswa, nilai_mapel.NamaMapel, nilai_mapel.NilaiUTS, nilai_mapel.NilaiUAS, jadwal_kelas_mapel.IDKelas, jadwal_kelas_mapel.IDMapel, jadwal_kelas_mapel.IDGuru, jadwal_kelas_mapel.IDAjaran, jadwal_kelas_mapel.Keterangan');
        $this->db->from('nilai_mapel');
        $this->db->join('jadwal_kelas_mapel', 'nilai_mapel.IDKelasMapel = jadwal_kelas_mapel.IDKelasMapel', 'inner');
        
        // Menambahkan kondisi WHERE berdasarkan parameter $where
        if (!empty($where)) {
            $this->db->where($where);
        }

        // Mendapatkan hasil query
        $query = $this->db->get();

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result_array();
        }
    }

}
?>