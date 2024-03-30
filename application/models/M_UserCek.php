<?php

class M_UserCek extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function FiturSistem()
    {
        $this->db->order_by('ID', 'asc');
        $query = $this->db->get('aktif_fitur');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function APPNAME()
    {
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('penggunaapp', 1);
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }
    public function APPNAMEUpdate($data)
    {
        $this->db->where('id', '1');
        $this->db->update('penggunaapp', $data);
    }

    public function cek_login($usrnm, $pswrd)
    {
        $sql = "SELECT `IDGuru`, `UsrGuru`, `KodeGuru`, `NamaGuru`, `NomorIndukGuru`, `KodeMapel`, `IDHak`, `PassGuru`
        FROM `tb_guru`
        WHERE `UsrGuru` = ? AND `PassGuru` = ?";
        $query = $this->db->query($sql, array($usrnm, $pswrd));

        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->result();
        }
    }

    public function cek_walilogin($usrnm, $pswrd)
    {
        $sql = "SELECT `IDOrtu`, `UsrOrtu`, `NamaOrtu`, `NisSiswa` FROM `tb_ortu` WHERE `UsrOrtu` = '" . $usrnm . "' AND `PassOrtu` = '" . $pswrd . "';";


        if ($this->db->query($sql)->num_rows() == 0) {
            return FALSE;
        } else {
            return $this->db->query($sql)->result();
        }
    }

    public function AmbilTahunAjaranLimit($limit)
    {
        $this->db->order_by('TahunAwal', 'desc');
        $query = $this->db->get('report_ajaran', $limit);
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function AmbilTahunAjaranSaatIni()
    {
        $where = array('Status' => 'Aktif');
        $this->db->order_by('TahunAwal', 'desc');
        $this->db->where($where);
        $query = $this->db->get('report_ajaran');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
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

    public function GuruMengajarlimit($where)
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
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function AmbilDataJadwal($where)
    {
        $this->db->select('mk.IDMK, mk.IDMengajar, mk.IDKelas, mk.IDJampel, mk.IDHari, mk.Keterangan AS KeteranganMK');
        $this->db->select('h.IDHari, h.NamaHari, h.KodeHari, h.Keterangan AS KeteranganHari');
        $this->db->select('j.IDJamPel, j.MulaiJampel, j.AkhirJampel');
        $this->db->select('gm.IDMengajar AS IDMengajarGuru, gm.IDMapel AS IDMapelGuru, gm.IDGuru, gm.Keterangan AS KeteranganGuru');
        $this->db->select('m.IDMapel, m.KodeMapel, m.NamaMapel, m.Keterangan AS KeteranganMapel');
        $this->db->select('g.IDGuru, g.UsrGuru, g.KodeGuru, g.NamaGuru, g.NomorIndukGuru, g.KodeMapel AS KodeMapelGuru, g.IDHak, g.PassGuru, g.Status');
        $this->db->select('k.IDKelas, k.KodeKelas, k.KodeTahun, k.RuanganKelas');
        $this->db->from('tb_mengajar_kelas mk');
        $this->db->join('tb_hari h', 'mk.IDHari = h.IDHari', 'left');
        $this->db->join('tb_jampel j', 'mk.IDJampel = j.IDJamPel', 'left');
        $this->db->join('tb_guru_mengajar gm', 'mk.IDMengajar = gm.IDMengajar', 'left');
        $this->db->join('tb_mapel m', 'gm.IDMapel = m.IDMapel', 'left');
        $this->db->join('tb_guru g', 'gm.IDGuru = g.IDGuru', 'left');
        $this->db->join('tb_kelas k', 'mk.IDKelas = k.IDKelas', 'left');
        $this->db->where($where);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function AmbilSemesterlimit($limit)
    {
        $this->db->order_by('IDSemester', 'asc');
        $query = $this->db->get('report_semester', $limit);
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function AmbilSemesterSaatIni()
    {
        $where = array('Status' => 'Aktif');
        $this->db->order_by('IDSemester', 'asc');
        $this->db->where($where);
        $query = $this->db->get('report_semester');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function AmbilSemesterby($where)
    {
        $this->db->order_by('IDSemester', 'asc');
        $this->db->where($where);
        $query = $this->db->get('report_semester');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function AmbilSemesterbyArr($where)
    {
        $this->db->order_by('IDSemester', 'asc');
        $this->db->where($where);
        $query = $this->db->get('report_semester');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result_array();
        }
    }

    public function DataGuru()
    {
        $this->db->select('guru.IDGuru, guru.KodeGuru, guru.NomorIndukGuru, guru.NamaGuru, guru.IDHak, mapel.NamaMapel');
        $this->db->from('tb_guru guru');
        $this->db->join('tb_mapel mapel', 'guru.KodeMapel = mapel.KodeMapel', 'left');
        $this->db->order_by('NamaGuru', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->result();
        }

    }

    public function DataGuruPengajar()
    {

        $this->db->select('guru.IDGuru, guru.KodeGuru, guru.NomorIndukGuru, guru.NamaGuru, guru.IDHak, mapel.NamaMapel');
        $this->db->from('tb_guru guru');
        $this->db->join('tb_mapel mapel', 'guru.KodeMapel = mapel.KodeMapel', 'left');
        $this->db->like('guru.IDHak', '6');
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->result();
        }
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
    public function ReadDataGuruMengajar()
    {
        $this->db->select('tb_guru.IDGuru, UsrGuru, KodeGuru, NamaGuru, NomorIndukGuru, tb_guru_mengajar.IDMapel, tb_mapel.KodeMapel, tb_mapel.NamaMapel, tb_mapel.Keterangan, IDHak, PassGuru, Status, IDMengajar');
        $this->db->from('tb_guru');
        $this->db->join('tb_guru_mengajar', 'tb_guru.IDGuru = tb_guru_mengajar.IDGuru', 'left');
        $this->db->join('tb_mapel', 'tb_guru_mengajar.IDMapel = tb_mapel.IDMapel', 'left'); // Tambahkan join untuk tb_mapel
        $this->db->order_by('IDGuru', 'asc');
        $query = $this->db->get();

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function ReadDataGuruMengajarby($where)
    {
        $this->db->where($where);
        $this->db->select('tb_guru.IDGuru, UsrGuru, KodeGuru, NamaGuru, NomorIndukGuru, KodeMapel, IDHak, PassGuru, Status, IDMengajar, tb_guru_mengajar.IDMapel, tb_guru_mengajar.IDGuru, Keterangan');
        $this->db->from('tb_guru');
        $this->db->join('tb_guru_mengajar', 'tb_guru.IDGuru = tb_guru_mengajar.IDGuru', 'left');
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function DataGuruInsert($data)
    {
        $this->db->insert('tb_guru', $data);
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

    public function DataGuruDelete($where)
    {
        $this->db->where($where);
        $this->db->delete('tb_guru');
    }

    public function DataGuruOnlyAmbil()
    {
        $this->db->order_by('NamaGuru', 'asc');
        $query = $this->db->get('tb_guru');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function DataGuruWaliOnly()
    {
        $this->db->like('IDHak', '3');
        $this->db->order_by('NamaGuru', 'asc');
        $query = $this->db->get('tb_guru');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function DataGuruAmbilWhere($where)
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

    public function InsertDataMengajar($data)
    {
        $this->db->insert('tb_guru_mengajar', $data);
    }
    public function DeleteDataMengajar($where)
    {
        $this->db->delete('tb_guru_mengajar', $where);
    }
    public function ReadDataMengajar()
    {
        $this->db->order_by('IDGuru', 'asc');
        $query = $this->db->get('tb_guru_mengajar');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function DataGuruUpdate($data, $where)
    {
        $this->db->where($where);
        $this->db->update('tb_guru', $data);
    }

    public function DataGuruCek($data)
    {
        $sql1 = "SELECT * FROM `tb_guru` WHERE `UsrGuru` = '" . $data['UsrGuru'] . "'";
        $sql2 = "SELECT * FROM `tb_guru` WHERE `KodeGuru` = '" . $data['KodeGuru'] . "'";
        $sql3 = "SELECT * FROM `tb_guru` WHERE `NomorIndukGuru` = '" . $data['NomorIndukGuru'] . "'";
        if ($this->db->query($sql1)->num_rows() !== 0 || $this->db->query($sql2)->num_rows() !== 0 || $this->db->query($sql3)->num_rows() !== 0) {
            return "Data Exist!";
        } else {
            return TRUE;
        }
    }


    public function DataGuruCekWhere($data, $where)
    {
        $cek = 0;
        $sql1 = "SELECT * FROM `tb_guru` WHERE `IDGuru`<> '" . $where . "' AND `UsrGuru` = '" . $data['UsrGuru'] . "'";
        $sql2 = "SELECT * FROM `tb_guru` WHERE `IDGuru`<> '" . $where . "' AND `KodeGuru` = '" . $data['KodeGuru'] . "'";
        $sql3 = "SELECT * FROM `tb_guru` WHERE `IDGuru`<> '" . $where . "' AND `NomorIndukGuru` = '" . $data['NomorIndukGuru'] . "'";
        if ($this->db->query($sql1)->num_rows() !== 0) {
            $cek + 1;
        } elseif ($this->db->query($sql2)->num_rows() !== 0) {
            $cek + 1;
        } elseif ($this->db->query($sql3)->num_rows() !== 0) {
            $cek + 1;
        } else {
            return TRUE;
        }
    }

    function DataHakakses()
    {
        $this->db->order_by('IDHak', 'asc');
        $query = $this->db->get('tb_hakakses');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function DataHakHitung()
    {
        $sql = "SELECT * FROM `tb_hakakses` WHERE 1;";

        if ($this->db->query($sql)->num_rows() !== 0) {
            return $data = $this->db->query($sql)->num_rows();
        } else {
            return 0;
        }
    }

    function DataTahunAjaranWhere($where)
    {
        $this->db->where($where);
        $query = $this->db->get('report_ajaran');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    function DataTahunAjaranWhereArr($where)
    {
        $this->db->where($where);
        $query = $this->db->get('report_ajaran');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result_array();
        }
    }




    public function DataMurid()
    {
        $this->db->select('
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
        ');

        $this->db->from('tb_siswa AS `1`');
        $this->db->join('tb_kelas AS `2`', '`1`.`KodeKelas` = `2`.`KodeKelas`', 'LEFT');
        $this->db->join('tb_guru AS `3`', '`2`.`IDGuru` = `3`.`IDGuru`', 'LEFT');
        $this->db->join('tb_tahun AS `4`', '`2`.`KodeTahun` = `4`.`KodeTahun`', 'LEFT');
        $this->db->order_by('`1`.`NamaSiswa`', 'ASC');


        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function DataMuridP($limit, $offset)
    {
        $this->db->select('
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
        ');

        $this->db->from('tb_siswa AS `1`');
        $this->db->join('tb_kelas AS `2`', '`1`.`KodeKelas` = `2`.`KodeKelas`', 'LEFT');
        $this->db->join('tb_guru AS `3`', '`2`.`IDGuru` = `3`.`IDGuru`', 'LEFT');
        $this->db->join('tb_tahun AS `4`', '`2`.`KodeTahun` = `4`.`KodeTahun`', 'LEFT');
        $this->db->order_by('`1`.`NamaSiswa`', 'ASC');
        $this->db->limit($limit, $offset);

        $query = $this->db->get();

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }


    public function DataMurid2($limit, $offset, $searchValue = null)
    {
        $this->db->select('tb_siswa.*, tb_kelas.*, tb_guru.*, tb_tahun.*');
        $this->db->from('tb_siswa');
        $this->db->join('tb_kelas', 'tb_siswa.KodeKelas = tb_kelas.KodeKelas', 'left');
        $this->db->join('tb_guru', 'tb_kelas.IDGuru = tb_guru.IDGuru', 'left');
        $this->db->join('tb_tahun', 'tb_kelas.KodeTahun = tb_tahun.KodeTahun', 'left');

        $this->db->order_by('tb_siswa.NamaSiswa', 'asc');

        // Menambahkan kondisi pencarian jika ada nilai pencarian yang diberikan
        if ($searchValue !== null) {
            $this->db->group_start();
            $this->db->like('tb_siswa.NamaSiswa', $searchValue);
            $this->db->or_like('tb_siswa.AyahSiswa', $searchValue);
            $this->db->or_like('tb_siswa.IbuSiswa', $searchValue);
            $this->db->or_like('tb_siswa.NisSiswa', $searchValue);
            $this->db->or_like('tb_siswa.NISNSiswa', $searchValue);
            $this->db->or_like('tb_kelas.KodeKelas', $searchValue);
            $this->db->or_like('tb_guru.NamaGuru', $searchValue);

            // tambahkan kondisi pencarian untuk kolom lainnya yang ingin Anda cari
            $this->db->group_end();
        }

        $this->db->limit($limit, $offset);

        return $this->db->get()->result();
    }



    public function JumlahDataMurid()
    {
        return $this->db->count_all('tb_siswa');
    }



    public function DataMuridwhere($where)
    {
        $sql = "SELECT `1`.`IDSiswa`,`1`.`GenderSiswa`, `1`.`NisSiswa`, `1`.`NISNSiswa`, `1`.`KodeKelas`, `3`.`PenyebutanTahun`, `3`.`PenulisanTahun`, `3`.`Keterangan`, `1`.`NamaSiswa`, `1`.`AyahSiswa`, `1`.`IbuSiswa`, `1`.`TglLhrSiswa`, `1`.`TmptLhrSiswa`, `2`.`KodeTahun`, `4`.`NamaGuru`
        FROM
        `tb_siswa` AS `1`
        LEFT JOIN
        `tb_kelas` AS `2`
        ON
        `1`.`KodeKelas`=`2`.`KodeKelas`
        LEFT JOIN
        `tb_tahun` AS `3`
        ON
        `2`.`KodeTahun` = `3`.`KodeTahun`
        LEFT JOIN
        `tb_guru` AS `4`
        ON
        `2`.`IDGuru` = `4`.`IDGuru`
        WHERE `1`.`KodeKelas`='" . $where['KodeKelas'] . "'";


        if ($this->db->query($sql)->num_rows() == 0) {
            return FALSE;
        } else {
            return $this->db->query($sql)->result();
        }
    }

    public function DataMuridNis($where)
    {
        $sql = "SELECT `1`.`IDSiswa`,`1`.`GenderSiswa`, `1`.`NisSiswa`, `1`.`NISNSiswa`, `1`.`KodeKelas`, `3`.`PenyebutanTahun`, `3`.`PenulisanTahun`, `3`.`Keterangan`, `1`.`NamaSiswa`, `1`.`AyahSiswa`, `1`.`IbuSiswa`, `1`.`TglLhrSiswa`, `1`.`TmptLhrSiswa`, `2`.`IDKelas`, `2`.`KodeTahun`,`4`.`IDGuru`, `4`.`NamaGuru`
        FROM
        `tb_siswa` AS `1`
        LEFT JOIN
        `tb_kelas` AS `2`
        ON
        `1`.`KodeKelas`=`2`.`KodeKelas`
        LEFT JOIN
        `tb_tahun` AS `3`
        ON
        `2`.`KodeTahun` = `3`.`KodeTahun`
        LEFT JOIN
        `tb_guru` AS `4`
        ON
        `2`.`IDGuru` = `4`.`IDGuru`
        WHERE `1`.`NisSiswa`='" . $where['NisSiswa'] . "'
        ORDER BY `1`.`NamaSiswa` ASC";


        if ($this->db->query($sql)->num_rows() == 0) {
            return FALSE;
        } else {
            return $this->db->query($sql)->result();
        }
    }

    public function DataMuridCekWhere($data, $where)
    {
        $sql1 = "SELECT * FROM `tb_siswa` WHERE `IDSiswa`<> '" . $where . "' AND `NisSiswa` = '" . $data['NisSiswa'] . "'";
        if ($this->db->query($sql1)->num_rows() !== 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function DataMuridCek($data)
    {
        $sql1 = "SELECT * FROM `tb_siswa` WHERE `NisSiswa` = '" . $data['NisSiswa'] . "'";
        if ($this->db->query($sql1)->num_rows() !== 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function DataMuridAmbil($where)
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
            return $query->result();
        }
    }



    public function countDataMurid()
    {
        return $this->db->count_all('tb_siswa'); // Ganti 'nama_tabel_data_murid' dengan nama tabel yang sesuai
    }
    public function getDataMuridPagination($limit, $start)
    {
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
            tb_kelas.RuanganKelas'); // Sesuaikan kolom yang diambil
        $this->db->from('tb_siswa');
        $this->db->join('tb_kelas', 'tb_siswa.KodeKelas = tb_kelas.KodeKelas');
        $this->db->limit($limit, $start); // Menambahkan limit dan offset
        $query = $this->db->get();

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
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
        tb_kelas.KodeKelas AS kelas_KodeKelas,
        tb_kelas.IDKelas,
        tb_kelas.RuanganKelas'); // Ganti dengan kolom yang sesuai
        $this->db->from('tb_siswa');
        $this->db->join('tb_kelas', 'tb_siswa.KodeKelas = tb_kelas.KodeKelas', 'left');
        $this->db->order_by('NamaSiswa', 'asc');

        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result_array();
        }
    }





    function DataMuridOnly()
    {
        $this->db->order_by('NamaSiswa', 'asc');
        $query = $this->db->get('tb_siswa');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
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

    function DataMuridDelete($where)
    {
        $this->db->where($where);
        $this->db->delete('tb_siswa');
    }

    function DataMuridUpdate($where, $data)
    {
        $this->db->where($where);
        $this->db->update('tb_siswa', $data);
    }


    function AmbilDataMuridAbsensi($where)
    {
        $sql = 'SELECT `1`.`IDKelas`, `2`.`IDSiswa`, `1`.`KodeTahun`, `1`.`KodeGuru`, `1`.`RuanganKelas`, `2`.`NisSiswa`, `2`.`KodeKelas`, `2`.`NamaSiswa`, `3`.`TglAbsen`, `3`.`JamAbsen`, `3`.`KodeGuru`, `3`.`IDAbsen`, `3`.`IDAbsenSiswa` FROM `tb_kelas` AS `1` LEFT JOIN `tb_siswa` AS `2` ON `1`.`KodeKelas` = `2`.`KodeKelas` LEFT JOIN `absensi_siswa` AS `3` ON `2`.`NisSiswa` = `3`.`NisSiswa` AND `2`.`KodeKelas` = `3`.`KodeKelas` WHERE `1`.`KodeKelas` = "' . $where . '" ORDER BY `2`.`NamaSiswa` ASC ';
        if ($this->db->query($sql)->num_rows() == 0) {
            return FALSE;
        } else {
            return $this->db->query($sql)->result();
        }
    }

    function GuruAbsenMurid($cari)
    {
        $sql = 'SELECT 
    `1`.`IDAbsen`,
    `1`.`TglAbsen`,
    `1`.`JamAbsen`,
    `1`.`KodeGuru`,
    `1`.`KodeKelas`,
    `3`.`NisSiswa`,
    `3`.`NamaSiswa`
FROM
    `report_absensi` AS `1`
LEFT JOIN
    `absensi_siswa` AS `2`
ON
    `1`.`IDAbsen` = `2`.`IDAbsen`
LEFT JOIN
    `tb_siswa` AS `3`
ON
    `2`.`NisSiswa` = `3`.`NisSiswa`
WHERE 
    `1`.`TglAbsen` = "' . $cari['TglAbsen'] . '" AND `1`.`KodeGuru` = "' . $cari['KodeGuru'] . '" AND `1`.`KodeKelas` = "' . $cari['KodeKelas'] . '"
ORDER BY 
    `3`.`NamaSiswa` ASC;';
        if ($this->db->query($sql)->num_rows() == 0) {
            return FALSE;
        } else {
            return $this->db->query($sql)->result();
        }
    }

    function AbsensiSiswa($tgl, $kls, $jampel)
    {
        $sql = 'SELECT
       `IDAbsenSiswa`,
       `NisSiswa`,
       `KodeKelas`,
       `TglAbsen`,
       `JamAbsen`,
       `KodeGuru`,
       `IDAbsen`,
       `MSIA`
       FROM
       `absensi_siswa`
       WHERE `TglAbsen`="' . $tgl . '" AND `KodeKelas`="' . $kls . '" AND `IDJamPel`="' . $jampel . '"';
        if ($this->db->query($sql)->num_rows() == 0) {
            return FALSE;
        } else {
            return $this->db->query($sql)->result();
        }
    }

    function AbsensiMuridDelete($where)
    {
        $this->db->where($where);
        $this->db->delete('absensi_siswa');
    }

    function cekAbsenMuridby($where)
    {
        $this->db->where($where);
        $query = $this->db->get('absensi_siswa');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    function AbsenMuridJumlah($where)
    {
        $this->db->where($where);
        $query = $this->db->get('absensi_siswa');
        return $query->num_rows();
    }

    function MuridAbsensiInsert($data)
    {
        $this->db->insert('absensi_siswa', $data);
    }

    function AbsensiDelete($where)
    {
        $this->db->where($where);
        $this->db->delete('report_absensi');
    }

    function DataAbsensiInsert($data)
    {
        $this->db->insert('report_absensi', $data);
    }

    function AbsensiCekData($where)
    {
        $this->db->where($where);
        $query = $this->db->get('report_absensi');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    function AbsensiUpdate($where, $data)
    {
        $this->db->where($where);
        $this->db->update('report_absensi', $data);
    }



    function AmbilTahun()
    {
        $this->db->order_by('KodeTahun', 'asc');
        $query = $this->db->get('tb_tahun');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    function UpdateTahun($where, $data)
    {
        $this->db->where($where);
        $this->db->update('tb_tahun', $data);
    }

    function InsertTahun($data)
    {
        $this->db->insert('tb_tahun', $data);
    }

    function DeleteTahun($where)
    {
        $this->db->where($where);
        $this->db->delete('tb_tahun');
    }


    // DATA KELAS
    public function DataKelas()
    {
        $this->db->select('tb_kelas.IDKelas, KodeKelas, tb_kelas.KodeTahun AS KelasKodeTahun, tb_kelas.KodeGuru, tb_kelas.IDGuru, RuanganKelas, UsrGuru, NamaGuru, NomorIndukGuru, KodeMapel, Status, tb_tahun.IDTahun, tb_tahun.PenyebutanTahun, tb_tahun.PenulisanTahun, Keterangan');
        $this->db->from('tb_kelas');
        $this->db->join('tb_guru', 'tb_kelas.IDGuru = tb_guru.IDGuru', 'left');
        $this->db->join('tb_tahun', 'tb_kelas.KodeTahun = tb_tahun.KodeTahun', 'left');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
            // Lakukan sesuatu dengan hasil query
        } else {
            return FALSE;
        }
    }
    public function DataKelasBy($where)
    {
        $this->db->select('tb_kelas.IDKelas, KodeKelas, tb_kelas.KodeTahun AS KelasKodeTahun, tb_kelas.KodeGuru, tb_kelas.IDGuru, RuanganKelas, UsrGuru, NamaGuru, NomorIndukGuru, KodeMapel, Status, tb_tahun.IDTahun, tb_tahun.PenyebutanTahun, tb_tahun.PenulisanTahun, Keterangan');
        $this->db->from('tb_kelas');
        $this->db->join('tb_guru', 'tb_kelas.IDGuru = tb_guru.IDGuru', 'left');
        $this->db->join('tb_tahun', 'tb_kelas.KodeTahun = tb_tahun.KodeTahun', 'left');
        $this->db->where($where);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
            // Lakukan sesuatu dengan hasil query
        } else {
            return FALSE;
        }
    }
    public function DataKelasByArr($where)
    {
        $this->db->select('tb_kelas.IDKelas, KodeKelas, tb_kelas.KodeTahun AS KelasKodeTahun, tb_kelas.KodeGuru, tb_kelas.IDGuru, RuanganKelas, UsrGuru, NamaGuru, NomorIndukGuru, KodeMapel, Status, tb_tahun.IDTahun, tb_tahun.PenyebutanTahun, tb_tahun.PenulisanTahun, Keterangan');
        $this->db->from('tb_kelas');
        $this->db->join('tb_guru', 'tb_kelas.IDGuru = tb_guru.IDGuru', 'left');
        $this->db->join('tb_tahun', 'tb_kelas.KodeTahun = tb_tahun.KodeTahun', 'left');
        $this->db->where($where);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
            // Lakukan sesuatu dengan hasil query
        } else {
            return FALSE;
        }
    }

    function DataKelasInsert($data)
    {
        $this->db->insert('tb_kelas', $data);
    }
    public function DataKelasUpdate($where, $data)
    {
        $this->db->where($where);
        $this->db->update('tb_kelas', $data);
    }
    function DataKelasHapus($where)
    {
        $this->db->where($where);
        $this->db->delete('tb_kelas');
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
    function DataKelasAmbil()
    {
        $query = $this->db->get('tb_kelas');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    function DataKelasAmbilWhere($where)
    {
        $this->db->where($where);
        $query = $this->db->get('tb_kelas');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }


    public function DataWaliMurid()
    {
        $sql = "SELECT `IDOrtu`, `UsrOrtu`, `NamaOrtu`, `NisSiswa` FROM `tb_ortu` WHERE 1";
        if ($this->db->query($sql)->num_rows() == 0) {
            return FALSE;
        } else {
            return $this->db->query($sql)->result();
        }
    }
    public function DataWaliMuridArr()
    {
        $sql = "SELECT `IDOrtu`, `UsrOrtu`, `NamaOrtu`, `NisSiswa` FROM `tb_ortu` WHERE 1";
        if ($this->db->query($sql)->num_rows() == 0) {
            return FALSE;
        } else {
            return $this->db->query($sql)->result_array();
        }
    }

    public function getSiswaWithOrtu()
    {
        $this->db->select('tb_siswa.IDSiswa, tb_siswa.NisSiswa as NisSiswaSiswa, KodeKelas, NamaSiswa, GenderSiswa, AyahSiswa, IbuSiswa, TglLhrSiswa, TmptLhrSiswa, NISNSiswa, TGLMasuk, TGLKeluar, Status, Wali, IDOrtu, UsrOrtu, PassOrtu, NamaOrtu');
        $this->db->from('tb_ortu');
        $this->db->join('tb_siswa', 'tb_siswa.NisSiswa = tb_ortu.NisSiswa', 'left');
        $query = $this->db->get();

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }
    public function getSiswaWithOrtuArr()
    {
        $this->db->select('tb_siswa.IDSiswa, tb_siswa.NisSiswa as NisSiswaSiswa, KodeKelas, NamaSiswa, GenderSiswa, AyahSiswa, IbuSiswa, TglLhrSiswa, TmptLhrSiswa, NISNSiswa, TGLMasuk, TGLKeluar, Status, Wali, IDOrtu, UsrOrtu, PassOrtu, NamaOrtu');
        $this->db->from('tb_ortu');
        $this->db->join('tb_siswa', 'tb_siswa.NisSiswa = tb_ortu.NisSiswa', 'left');
        $query = $this->db->get();

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result_array();
        }
    }
    public function getSiswaWithOrtuBy($where)
    {
        $this->db->select('tb_siswa.IDSiswa, tb_siswa.NisSiswa as NisSiswaSiswa, KodeKelas, NamaSiswa, GenderSiswa, AyahSiswa, IbuSiswa, TglLhrSiswa, TmptLhrSiswa, NISNSiswa, TGLMasuk, TGLKeluar, Status, Wali, IDOrtu, UsrOrtu, NomorHP, PassOrtu, NamaOrtu');
        $this->db->from('tb_siswa');
        $this->db->join('tb_ortu', 'tb_siswa.NisSiswa = tb_ortu.NisSiswa', 'left');
        $this->db->where($where);
        $query = $this->db->get();

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }
    public function getSiswaWithOrtuByArr($where)
    {
        $this->db->select('tb_siswa.IDSiswa, tb_siswa.NisSiswa as NisSiswaSiswa, tb_siswa.KodeKelas as KodeKelasSiswa, NamaSiswa, GenderSiswa, AyahSiswa, IbuSiswa, TglLhrSiswa, TmptLhrSiswa, NISNSiswa, TGLMasuk, TGLKeluar, tb_siswa.Status as StatusSiswa, Wali, IDOrtu, UsrOrtu, tb_ortu.NomorHP as NomorHP, PassOrtu, NamaOrtu, tb_guru.IDGuru, UsrGuru, NamaGuru, NomorIndukGuru, KodeMapel, IDHak, tb_guru.NomorHP as NomorHPGuru, tb_guru.Status as StatusGuru');

        $this->db->from('tb_siswa');
        $this->db->join('tb_ortu', 'tb_siswa.NisSiswa = tb_ortu.NisSiswa', 'left');
        $this->db->join('tb_kelas', 'tb_siswa.KodeKelas = tb_kelas.KodeKelas', 'left');
        $this->db->join('tb_guru', 'tb_kelas.IDGuru = tb_guru.IDGuru', 'left'); // Gabungkan dengan tabel ke-4 (misalnya tb_guru)
        $this->db->where($where);
        $query = $this->db->get();

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result_array();
        }

    }

    public function DataWaliMuridWhere($where)
    {
        $this->db->where($where);
        $query = $this->db->get('tb_ortu');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function DataWaliMuridWhereAnd($where, $where2)
    {
        $this->db->select('IDOrtu, UsrOrtu, PassOrtu, NamaOrtu, NisSiswa');
        $this->db->from('tb_ortu');
        $this->db->where('UsrOrtu', $where['UsrOrtu']);
        $this->db->where('IDOrtu !=', $where2);
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

    public function DataWaliUpdate($where, $data_masuk)
    {
        $this->db->where('IDOrtu', $where);
        $this->db->update('tb_ortu', $data_masuk);
    }

    public function DataWaliDelete($where)
    {
        $this->db->where($where);
        $this->db->delete('tb_ortu');
    }

    public function DataGuruIUD($jenis, $where, $data_masuk)
    {
        $this->db->where($where);
        $this->db->update('tb_pesanan', $data_masuk);
    }


    public function DataMapel()
    {
        $query = $this->db->get('tb_mapel');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function DataKelasOnly()
    {
        $query = $this->db->get('tb_kelas');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function DataKelasCustom($where)
    {
        $this->db->select('
            tb_kelas.IDKelas, 
            tb_kelas.KodeKelas, 
            tb_kelas.KodeTahun, 
            tb_kelas.IDGuru,
            tb_siswa.IDSiswa, 
            tb_siswa.NisSiswa, 
            tb_siswa.KodeKelas AS SiswaKodeKelas, 
            tb_siswa.NamaSiswa, 
            tb_siswa.GenderSiswa, 
            tb_siswa.AyahSiswa, 
            tb_siswa.IbuSiswa, 
            tb_siswa.TglLhrSiswa, 
            tb_siswa.TmptLhrSiswa, 
            tb_siswa.NISNSiswa'
        );
        $this->db->from('tb_kelas');
        $this->db->join('tb_siswa', 'tb_kelas.KodeKelas = tb_siswa.KodeKelas', 'left');
        $this->db->where($where);
        $this->db->order_by('tb_siswa.NamaSiswa', 'asc');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }

    }

    public function AbsenMasuk($data)
    {
        $this->db->insert('report_absensi', $data);
    }





    // Jam Pelajaran
    public function Jampel1Only()
    {
        $this->db->order_by('MulaiJampel', 'asc');
        $query = $this->db->get('tb_jampel', 1);  // Ganti 'nama_tabel' dengan nama tabel Anda
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }
    public function ReadJampel()
    {
        $this->db->order_by('MulaiJampel', 'asc');
        $query = $this->db->get('tb_jampel');  // Ganti 'nama_tabel' dengan nama tabel Anda
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }
    public function AmbilJamPelajaranBy($where)
    {
        $this->db->where($where);
        $query = $this->db->get('tb_jampel');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }
    public function AmbilJamPelajaranByArr($where)
    {
        $this->db->where($where);
        $query = $this->db->get('tb_jampel');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result_array();
        }
    }
    public function AmbilJamPelajaran()
    {
        $query = $this->db->get('tb_jampel');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }
    public function MasukJamPelajaran($data)
    {
        $this->db->insert('tb_jampel', $data);
    }
    public function UpdateJamPelajaran($where, $data)
    {
        $this->db->where($where);
        $this->db->update('tb_jampel', $data);
    }
    function DeleteJamPelajaran($where)
    {
        $this->db->where($where);
        $this->db->delete('tb_jampel');
    }



    public function AmbilTahunAjaran()
    {
        $this->db->order_by('KodeAjaran', 'desc');
        $query = $this->db->get('report_ajaran');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function AmbilTahunAjaranWhere($where)
    {
        $this->db->order_by('KodeAjaran', 'desc');
        $this->db->where($where);
        $query = $this->db->get('report_ajaran');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function AmbilTahunAjaranWhereArr($where)
    {
        $this->db->order_by('KodeAjaran', 'desc');
        $this->db->where($where);
        $query = $this->db->get('report_ajaran');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result_array();
        }
    }

    public function UbahTahunAjaranSelain($DataArray, $data)
    {
        $this->db->where('IDAjaran !=', $DataArray[0]);
        $this->db->update('report_ajaran', $data);
    }

    public function UpdateTahunAjaran($where, $data)
    {
        $this->db->where($where);
        $this->db->Update('report_ajaran', $data);
    }

    public function InsertTahunAjaran($data)
    {
        $this->db->insert('report_ajaran', $data);
    }

    public function DeleteTahunAjaran($where)
    {
        $this->db->where($where);
        $this->db->delete('report_ajaran');
    }

    public function AmbilSemester()
    {
        $this->db->order_by('NamaSemester', 'asc');
        $query = $this->db->get('report_semester');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function AmbilSemesterWhere($where)
    {
        $this->db->where($where);

        $this->db->order_by('NamaSemester', 'asc');
        $query = $this->db->get('report_semester');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function AmbilSemesterWhereArr($where)
    {
        $this->db->where($where);

        $this->db->order_by('NamaSemester', 'asc');
        $query = $this->db->get('report_semester');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result_array();
        }
    }

    public function UbahSemesterSelain($DataArray, $data)
    {
        $this->db->where('IDSemester !=', $DataArray[0]);
        $this->db->update('report_semester', $data);
    }

    public function UpdateSemester($where, $data)
    {
        $this->db->where($where);
        $this->db->Update('report_semester', $data);
    }

    public function InsertSemester($data)
    {
        $this->db->insert('report_semester', $data);
    }

    public function DeleteSemester($where)
    {
        $this->db->where($where);
        $this->db->delete('report_semester');
    }


    public function AmbilDataWaliSiswa($where)
    {
        $this->db->where($where);
        $this->db->order_by('tb_ortu.NamaOrtu', 'asc');
        $this->db->select('tb_siswa.IDSiswa, tb_siswa.NisSiswa, tb_siswa.KodeKelas, tb_siswa.NamaSiswa, tb_siswa.GenderSiswa, tb_siswa.AyahSiswa, tb_siswa.IbuSiswa, tb_siswa.TglLhrSiswa, tb_siswa.TmptLhrSiswa, tb_siswa.NISNSiswa, tb_ortu.IDOrtu, tb_ortu.IDOrtu, tb_ortu.NomorHP, tb_ortu.Alamat, tb_ortu.UsrOrtu, tb_ortu.NamaOrtu, tb_ortu.PassOrtu');
        $this->db->from('tb_ortu');
        $this->db->join('tb_siswa', 'tb_ortu.NisSiswa = tb_siswa.NisSiswa', 'left');
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function AmbilDataSiswaWali($where)
    {
        $this->db->where($where);
        $this->db->order_by('tb_ortu.NamaOrtu', 'asc');
        $this->db->select('tb_siswa.IDSiswa, tb_siswa.NisSiswa, tb_siswa.KodeKelas, tb_siswa.NamaSiswa, tb_siswa.GenderSiswa, tb_siswa.AyahSiswa, tb_siswa.IbuSiswa, tb_siswa.TglLhrSiswa, tb_siswa.TmptLhrSiswa, tb_siswa.NISNSiswa, tb_ortu.IDOrtu, tb_ortu.IDOrtu, tb_ortu.NomorHP, tb_ortu.Alamat, tb_ortu.UsrOrtu, tb_ortu.NamaOrtu');
        $this->db->from('tb_siswa');
        $this->db->join('tb_ortu', 'tb_ortu.NisSiswa = tb_siswa.NisSiswa', 'left');
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }





    public function DataMuridAmbilAllNumber()
    {
        $this->db->order_by('NamaSiswa', 'asc');
        $query = $this->db->get('tb_siswa');
        return $query->num_rows();
    }

    public function DataGuruAmbilAllNumber()
    {
        $this->db->select('tb_guru.IDGuru, UsrGuru, KodeGuru, NamaGuru, NomorIndukGuru, IDHak, PassGuru, Status');
        $this->db->select('GROUP_CONCAT(tb_mapel.KodeMapel) as KodeMapel', false); // Menggunakan GROUP_CONCAT untuk menggabungkan KodeMapel
        $this->db->select('GROUP_CONCAT(tb_mapel.NamaMapel) as NamaMapel', false); // Menggunakan GROUP_CONCAT untuk menggabungkan NamaMapel
        $this->db->select('GROUP_CONCAT(tb_mapel.Keterangan) as Keterangan', false); // Menggunakan GROUP_CONCAT untuk menggabungkan Keterangan
        $this->db->from('tb_guru');
        $this->db->join('tb_guru_mengajar', 'tb_guru.IDGuru = tb_guru_mengajar.IDGuru', 'inner');
        $this->db->join('tb_mapel', 'tb_guru_mengajar.IDMapel = tb_mapel.IDMapel', 'left');
        $this->db->group_by('tb_guru.IDGuru, UsrGuru, KodeGuru, NamaGuru, NomorIndukGuru, IDHak, PassGuru, Status');
        $query = $this->db->get();
        return $query->num_rows();

    }

    public function DataStaffAmbilAllNumber()
    {
        $where = array('KodeMapel' => null);
        $this->db->where($where);
        $this->db->order_by('NamaGuru', 'asc');
        $query = $this->db->get('tb_guru');
        return $query->num_rows();
    }

    public function DataKelasAmbilAllNumber()
    {
        $this->db->order_by('KodeTahun', 'asc');
        $query = $this->db->get('tb_kelas');
        return $query->num_rows();
    }

    public function DataMataPelajaran()
    {
        $this->db->order_by('NamaMapel', 'asc');
        $query = $this->db->get('tb_mapel');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function DataMataPelajaranCek($where)
    {
        $this->db->where($where);
        $this->db->order_by('NamaMapel', 'asc');
        $query = $this->db->get('tb_mapel');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }
    public function DataMataPelajaranCekArr($where)
    {
        $this->db->where($where);
        $this->db->order_by('NamaMapel', 'asc');
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

    public function DataMataPelajaranDelete($where)
    {
        $this->db->where($where);
        $this->db->delete('tb_mapel');
    }

    public function DataMataPelajaranUpdate($where, $data)
    {
        $this->db->where($where);
        $this->db->update('tb_mapel', $data);
    }




    public function ReadSpp()
    {
        $this->db->order_by('report_ajaran.KodeAjaran', 'desc');
        $this->db->select('keuangan_spp.IDSpp, keuangan_spp.Nama, keuangan_spp.Jumlah, keuangan_spp.JumlahRp, keuangan_spp.IDAjaran, report_ajaran.KodeAjaran, report_ajaran.TahunAwal, report_ajaran.TahunAkhir, keuangan_spp.Keterangan');
        $this->db->from('keuangan_spp');
        $this->db->join('report_ajaran', 'keuangan_spp.IDAjaran = report_ajaran.IDAjaran', 'left');
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function ReadSppWhere($where)
    {
        $this->db->where($where);
        $this->db->order_by('report_ajaran.KodeAjaran', 'desc');
        $this->db->select('keuangan_spp.IDSpp, keuangan_spp.Nama, keuangan_spp.Jumlah, keuangan_spp.JumlahRp, keuangan_spp.IDAjaran, report_ajaran.KodeAjaran, report_ajaran.TahunAwal, report_ajaran.TahunAkhir, keuangan_spp.Keterangan');
        $this->db->from('keuangan_spp');
        $this->db->join('report_ajaran', 'keuangan_spp.IDAjaran = report_ajaran.IDAjaran', 'left');
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function InsertSpp($data)
    {
        $this->db->insert('keuangan_spp', $data);
    }

    public function UpdateSpp($where, $data)
    {
        $this->db->where($where);
        $this->db->update('keuangan_spp', $data);
    }

    public function DeleteSpp($where)
    {
        $this->db->where($where);
        $this->db->delete('keuangan_spp');
    }

    public function ReadBayarSpp($where)
    {
        $this->db->where($where);
        $this->db->order_by('keuangan_spp_bayar.TglBayar', 'desc');
        $this->db->select('
            tb_siswa.IDSiswa,
            tb_siswa.NamaSiswa,
            tb_siswa.TGLMasuk, 
            tb_siswa.TGLKeluar,
            keuangan_spp_bayar.IDBayar,
            keuangan_spp_bayar.NisSiswa,
            keuangan_spp_bayar.TglBayar,
            keuangan_spp_bayar.BayarBulan,
            keuangan_spp_bayar.BayarTahun,
            keuangan_spp_bayar.IDGuru,
            keuangan_spp_bayar.Keterangan,
            keuangan_spp_bayar.JumlahRp as RiwayatBayar,
            keuangan_spp.IDSpp,
            keuangan_spp.JumlahRp,
            keuangan_spp.Nama,
            keuangan_spp.Jumlah,
            keuangan_spp.Keterangan as KetSPP,
            report_ajaran.IDAjaran,
            report_ajaran.KodeAjaran,
            report_ajaran.TahunAwal,
            report_ajaran.TahunAkhir,
            report_ajaran.Kurikulum,
            tb_guru.IDGuru,
            tb_guru.UsrGuru,
            tb_guru.KodeGuru,
            tb_guru.NamaGuru,
            tb_guru.NomorIndukGuru,
            tb_guru.Status
        ');
        $this->db->from('keuangan_spp_bayar');
        $this->db->join('tb_siswa', 'keuangan_spp_bayar.NisSiswa = tb_siswa.NisSiswa', 'left');
        $this->db->join('keuangan_spp', 'keuangan_spp_bayar.IDSpp = keuangan_spp.IDSpp', 'left');
        $this->db->join('report_ajaran', 'keuangan_spp.IDAjaran = report_ajaran.IDAjaran', 'left');
        $this->db->join('tb_guru', 'keuangan_spp_bayar.IDGuru = tb_guru.IDGuru', 'left');
        $query = $this->db->get();

        if ($query->num_rows() == 0) {
            return 'Data Kosong';
        } else {
            return $query->result();
        }
    }


    public function InsertBayarSPP($data)
    {
        $this->db->insert('keuangan_spp_bayar', $data);
    }

    public function ReadJenisPelanggaran()
    {
        $this->db->order_by('Poin', 'asc');
        $query = $this->db->get('bk_jenis_pelangaran');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function InsertJenisPelanggaran($data)
    {
        $this->db->insert('bk_jenis_pelangaran', $data);
    }

    public function UpdateJenisPelanggaran($data, $where)
    {
        $this->db->where($where);
        $this->db->update('bk_jenis_pelangaran', $data);
    }

    public function DeleteJenisPelanggaran($where)
    {
        $this->db->where($where);
        $this->db->delete('bk_jenis_pelangaran');
    }

    public function InsertLaporPelanggaran($data)
    {
        $this->db->insert('bk_lapor_pelanggaran', $data);
    }

    public function UpdateLaporPelanggaran($data, $where)
    {
        $this->db->where($where);
        $this->db->update('bk_lapor_pelanggaran', $data);
    }

    public function DeleteteLaporPelanggaran($where)
    {
        $this->db->where($where);
        $this->db->delete('bk_lapor_pelanggaran');
    }

    public function RekapSkoringIndividu($where)
    {
        $sql = "SELECT
    jp.IDJenis,
    jp.Poin,
    jp.Keterangan AS KeteranganJenis,
    lp.IDLapor,
    lp.TglLapor,
    lp.NisSiswa,
    lp.File,
    lp.Keterangan AS KeteranganLapor,
    lp.IDGuru,
    ts.IDSiswa,
    ts.KodeKelas,
    ts.NamaSiswa,
    ts.GenderSiswa,
    ts.AyahSiswa,
    ts.IbuSiswa,
    ts.TglLhrSiswa,
    ts.TmptLhrSiswa,
    ts.NISNSiswa,
    ts.TGLMasuk,
    ts.TGLKeluar,
    ts.Status,
    tg.KodeGuru,
    tg.NamaGuru,
    tg.NomorIndukGuru,
    tg.KodeMapel,
    tg.IDHak
FROM
    bk_jenis_pelangaran AS jp
INNER JOIN
    bk_lapor_pelanggaran AS lp
ON
    jp.IDJenis = lp.IDJenis
INNER JOIN
    tb_siswa AS ts
ON
    lp.NisSiswa = ts.NisSiswa
INNER JOIN
    tb_guru AS tg
ON
    lp.IDGuru = tg.IDGuru
WHERE
    lp.NisSiswa = '" . $where['NisSiswa'] . "'
ORDER BY
    lp.TglLapor";
        if ($this->db->query($sql)->num_rows() == 0) {
            return FALSE;
        } else {
            return $this->db->query($sql)->result();
        }
    }

    public function RekapSkoringIndividuBy($where)
    {
        $sql = "SELECT
    jp.IDJenis,
    jp.Poin,
    jp.Keterangan AS KeteranganJenis,
    lp.IDLapor,
    lp.TglLapor,
    lp.NisSiswa,
    lp.File,
    lp.Keterangan AS KeteranganLapor,
    lp.IDGuru,
    lp.StatusBK,
    ts.IDSiswa,
    ts.KodeKelas,
    ts.NamaSiswa,
    ts.GenderSiswa,
    ts.AyahSiswa,
    ts.IbuSiswa,
    ts.TglLhrSiswa,
    ts.TmptLhrSiswa,
    ts.NISNSiswa,
    ts.TGLMasuk,
    ts.TGLKeluar,
    ts.Status,
    tg.KodeGuru,
    tg.NamaGuru,
    tg.NomorIndukGuru,
    tg.KodeMapel,
    tg.IDHak
FROM
    bk_jenis_pelangaran AS jp
INNER JOIN
    bk_lapor_pelanggaran AS lp
ON
    jp.IDJenis = lp.IDJenis
INNER JOIN
    tb_siswa AS ts
ON
    lp.NisSiswa = ts.NisSiswa
INNER JOIN
    tb_guru AS tg
ON
    lp.IDGuru = tg.IDGuru
WHERE
    lp.NisSiswa = '" . $where['NisSiswa'] . "' AND lp.StatusBK = '" . $where['StatusBK'] . "'
ORDER BY
    lp.TglLapor";
        if ($this->db->query($sql)->num_rows() == 0) {
            return FALSE;
        } else {
            return $this->db->query($sql)->result();
        }
    }

    public function RekapSkoringKelas($where)
    {
        $this->db->select('jp.IDJenis, SUM(jp.Poin) AS TotalPoin, jp.Keterangan AS KeteranganJenis, lp.IDLapor, lp.TglLapor, ts.NisSiswa, lp.File, lp.Keterangan AS KeteranganLapor, lp.IDGuru, ts.IDSiswa, ts.KodeKelas, ts.NamaSiswa, ts.GenderSiswa, ts.AyahSiswa, ts.IbuSiswa, ts.TglLhrSiswa, ts.TmptLhrSiswa, ts.NISNSiswa, ts.TGLMasuk, ts.TGLKeluar, ts.Status, tg.KodeGuru, tg.NamaGuru, tg.NomorIndukGuru, tg.KodeMapel, tg.IDHak, kl.IDKelas, kl.KodeKelas AS KelasKode, kl.KodeTahun, kl.KodeGuru AS GuruKode, kl.IDGuru AS KelasIDGuru, kl.RuanganKelas');
        $this->db->from('tb_kelas AS kl');
        $this->db->join('tb_siswa AS ts', 'kl.KodeKelas = ts.KodeKelas', 'left');
        $this->db->join('bk_lapor_pelanggaran AS lp', 'ts.NisSiswa = lp.NisSiswa', 'left');
        $this->db->join('bk_jenis_pelangaran AS jp', 'lp.IDJenis = jp.IDJenis', 'left');
        $this->db->join('tb_guru AS tg', 'lp.IDGuru = tg.IDGuru', 'left');
        $this->db->where($where);
        $this->db->group_by('ts.NisSiswa');
        $this->db->order_by('lp.TglLapor');

        $query = $this->db->get();

        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->result();
        }
    }

    public function RekapSkoringGlobal()
    {
        $sql = "SELECT
    jp.IDJenis,
    SUM(jp.Poin) AS TotalPoin,
    jp.Keterangan AS KeteranganJenis,
    lp.IDLapor,
    lp.TglLapor,
    lp.NisSiswa,
    lp.File,
    lp.Keterangan AS KeteranganLapor,
    lp.IDGuru,
    ts.IDSiswa,
    ts.KodeKelas,
    ts.NamaSiswa,
    ts.GenderSiswa,
    ts.AyahSiswa,
    ts.IbuSiswa,
    ts.TglLhrSiswa,
    ts.TmptLhrSiswa,
    ts.NISNSiswa,
    ts.TGLMasuk,
    ts.TGLKeluar,
    ts.Status,
    tg.KodeGuru,
    tg.NamaGuru,
    tg.NomorIndukGuru,
    tg.KodeMapel,
    tg.IDHak
FROM
    bk_jenis_pelangaran AS jp
INNER JOIN
    bk_lapor_pelanggaran AS lp
ON
    jp.IDJenis = lp.IDJenis
INNER JOIN
    tb_siswa AS ts
ON
    lp.NisSiswa = ts.NisSiswa
INNER JOIN
    tb_guru AS tg
ON
    lp.IDGuru = tg.IDGuru
WHERE
    1
GROUP BY
    ts.NisSiswa
ORDER BY
    lp.TglLapor";
        if ($this->db->query($sql)->num_rows() == 0) {
            return FALSE;
        } else {
            return $this->db->query($sql)->result();
        }
    }

    public function RekapSkoringALLBy($where)
    {
        $sql = "SELECT
    jp.IDJenis,
    jp.Poin,
    jp.Keterangan AS KeteranganJenis,
    lp.IDLapor,
    lp.TglLapor,
    lp.NisSiswa,
    lp.File,
    lp.Keterangan AS KeteranganLapor,
    lp.IDGuru,
    lp.StatusBK,
    ts.IDSiswa,
    ts.KodeKelas,
    ts.NamaSiswa,
    ts.GenderSiswa,
    ts.AyahSiswa,
    ts.IbuSiswa,
    ts.TglLhrSiswa,
    ts.TmptLhrSiswa,
    ts.NISNSiswa,
    ts.TGLMasuk,
    ts.TGLKeluar,
    ts.Status,
    tg.KodeGuru,
    tg.NamaGuru,
    tg.NomorIndukGuru,
    tg.KodeMapel,
    tg.IDHak
FROM
    bk_jenis_pelangaran AS jp
INNER JOIN
    bk_lapor_pelanggaran AS lp
ON
    jp.IDJenis = lp.IDJenis
INNER JOIN
    tb_siswa AS ts
ON
    lp.NisSiswa = ts.NisSiswa
INNER JOIN
    tb_guru AS tg
ON
    lp.IDGuru = tg.IDGuru
WHERE
    lp.StatusBK = '" . $where['StatusBK'] . "'
ORDER BY
    lp.TglLapor";
        if ($this->db->query($sql)->num_rows() == 0) {
            return FALSE;
        } else {
            return $this->db->query($sql)->result();
        }
    }

    public function DetailPelanggaran($where)
    {
        $this->db->select('lp.IDLapor, lp.TglLapor, lp.NisSiswa, lp.IDJenis, lp.File, lp.Keterangan, lp.IDGuru, lp.StatusBK, ts.IDSiswa, ts.KodeKelas, ts.NamaSiswa, ts.GenderSiswa, ts.AyahSiswa, ts.IbuSiswa, ts.TglLhrSiswa, ts.TmptLhrSiswa, ts.NISNSiswa, ts.TGLMasuk, ts.TGLKeluar, ts.Status, ts.Wali, `to`.IDOrtu, `to`.UsrOrtu, `to`.NamaOrtu, `to`.NomorHP, `to`.Alamat, `to`.NisSiswa AS NisSiswaOrtu, j.Poin, j.Keterangan AS KeteranganJenis, tg.KodeGuru, tg.NamaGuru, tg.NomorIndukGuru, tg.KodeMapel, tg.IDHak');
        $this->db->from('bk_lapor_pelanggaran lp');
        $this->db->join('tb_siswa ts', 'lp.NisSiswa = ts.NisSiswa', 'inner');
        $this->db->join('tb_ortu `to`', 'ts.NisSiswa = `to`.NisSiswa', 'left');
        $this->db->join('bk_jenis_pelangaran j', 'lp.IDJenis = j.IDJenis', 'left');
        $this->db->join('tb_guru tg', 'lp.IDGuru = tg.IDGuru', 'left');
        $this->db->where($where);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->result();
        }
    }

    public function ReadWajibKeuangan()
    {
        $this->db->select('report_ajaran.IDAjaran, report_ajaran.KodeAjaran, report_ajaran.TahunAwal, report_ajaran.TahunAkhir, report_ajaran.Kurikulum, keuangan_wajib.NamaWajib, keuangan_wajib.JumlahRpWajib, keuangan_wajib.Keterangan, keuangan_wajib.IDWajib');
        $this->db->from('report_ajaran');
        $this->db->join('keuangan_wajib', 'report_ajaran.IDAjaran = keuangan_wajib.IDAjaran', 'inner');

        $query = $this->db->get();

        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->result();
        }
    }

    public function InsertWajibKeuangan($data)
    {
        $this->db->insert('keuangan_wajib', $data);
    }

    public function JustReadWajibKeuangan()
    {
        $this->db->select('report_ajaran.IDAjaran, report_ajaran.KodeAjaran, report_ajaran.TahunAwal, report_ajaran.TahunAkhir, report_ajaran.Kurikulum, keuangan_wajib.NamaWajib, keuangan_wajib.JumlahRpWajib, keuangan_wajib.Keterangan, keuangan_wajib.IDWajib');
        $this->db->from('report_ajaran');
        $this->db->join('keuangan_wajib', 'report_ajaran.IDAjaran = keuangan_wajib.IDAjaran', 'inner');
        $this->db->group_by('report_ajaran.IDAjaran'); // Mengelompokkan berdasarkan report_ajaran.IDAjaran

        $query = $this->db->get();

        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->result();
        }
    }

    public function ReadHari()
    {
        $this->db->order_by('UrutanKe', 'asc');
        $query = $this->db->get('tb_hari');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }
    public function ReadHariJam()
    {
        $this->db->select('tb_hari.IDHari, tb_hari.NamaHari, tb_hari.KodeHari, tb_hari.Keterangan, tb_hari.UrutanKe, tb_jampel.IDJamPel, tb_jampel.MulaiJampel, tb_jampel.AkhirJampel');
        $this->db->from('tb_hari');
        $this->db->join('tb_jampel', 'tb_hari.IDHari = tb_jampel.IDHari', 'left'); // Gabungkan dengan tabel tb_jampel
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }
    public function ReadHariJamBy($where)
    {
        $this->db->select('
            tb_hari.IDHari,
            tb_hari.NamaHari,
            tb_hari.KodeHari,
            tb_hari.Keterangan,
            tb_hari.UrutanKe,
            tb_jampel.IDJamPel,
            tb_jampel.MulaiJampel,
            tb_jampel.AkhirJampel
        ');
        $this->db->from('tb_hari');
        $this->db->join('tb_jampel', 'tb_hari.IDHari = tb_jampel.IDHari', 'left');
        $this->db->order_by('MulaiJampel', 'asc');
        $this->db->where($where);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }
    public function InsertHari($data)
    {
        $this->db->insert('tb_hari', $data);
    }
    public function UpdateHari($data, $where)
    {
        $this->db->where($where);
        $this->db->update('tb_hari', $data);
    }
    public function DeleteHari($where)
    {
        $this->db->where($where);
        $this->db->delete('tb_hari');
    }


    public function ReadJadwalKelasMapel()
    {
        $this->db->select('jadwal_kelas_mapel.IDKelasMapel, jadwal_kelas_mapel.IDKelas, jadwal_kelas_mapel.IDMapel, jadwal_kelas_mapel.IDAjaran, jadwal_kelas_mapel.Keterangan, tb_mapel.KodeMapel, tb_mapel.NamaMapel');
        $this->db->from('jadwal_kelas_mapel');
        $this->db->join('tb_mapel', 'jadwal_kelas_mapel.IDMapel = tb_mapel.IDMapel', 'left'); // Ganti 'left' sesuai kebutuhan join Anda

        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }
    public function ReadJadwalKelasMapelWhere($where)
    {
        $this->db->select('jadwal_kelas_mapel.IDKelasMapel, jadwal_kelas_mapel.IDKelas, jadwal_kelas_mapel.IDMapel, jadwal_kelas_mapel.IDAjaran, jadwal_kelas_mapel.Keterangan, tb_mapel.KodeMapel, tb_mapel.NamaMapel');
        $this->db->from('jadwal_kelas_mapel');
        $this->db->where($where);
        $this->db->join('tb_mapel', 'jadwal_kelas_mapel.IDMapel = tb_mapel.IDMapel', 'left'); // Ganti 'left' sesuai kebutuhan join Anda

        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }
    public function ReadJadwalKelasMapelby($where)
    {
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
            return $query->result();
        }
    }
    public function ReadJadwalKelasMapelbyArr($where)
    {
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

    public function ReadJadwalKelasMapelbyArray($where)
    {
        $this->db->order_by('IDKelasMapel', 'asc');
        $this->db->where($where);
        $query = $this->db->get('jadwal_kelas_mapel');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result_array();
        }
    }
    public function InsertJadwalKelasMapelby($data)
    {
        $this->db->insert('jadwal_kelas_mapel', $data);
    }
    public function DeleteJadwalKelasMapel($where)
    {
        $this->db->where($where);
        $this->db->delete('jadwal_kelas_mapel');
    }
    public function UpdateJadwalKelasMapel($where, $data)
    {
        $this->db->where($where);
        $this->db->update('jadwal_kelas_mapel', $data);
    }

    public function ReadNilaiBy($where)
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
            return $query->result();
        }
    }
    public function ReadNilaHari($where)
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
            return $query->result();
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
    public function InsertNilaHari($data)
    {
        $this->db->insert('nilai_mapel_hari', $data);
    }
    public function UpdateNilaHari($where, $data)
    {
        $this->db->where($where);
        $this->db->update('nilai_mapel_hari', $data);
    }
    public function DeleteNilaHari($where)
    {
        $this->db->where($where);
        $this->db->delete('nilai_mapel_hari');
    }

    public function AbsenMasukGuru($data)
    {
        $this->db->insert('absensi_guru_mapel', $data);
    }

    public function ReadAbsensi($where)
    {
        $this->db->where($where);
        $query = $this->db->get('absensi_siswa_mapel');  // Ganti 'nama_tabel' dengan nama tabel Anda
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }
    public function ReadAbsensiArr($where)
    {
        $this->db->where($where);
        $query = $this->db->get('absensi_siswa_mapel');  // Ganti 'nama_tabel' dengan nama tabel Anda
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result_array();
        }
    }
    public function ReadSiswaAbsensi($where)
    {
        $this->db->select('*');
        $this->db->from('tb_siswa');
        $this->db->join('absensi_siswa_mapel', 'tb_siswa.NisSiswa = absensi_siswa_mapel.NisSiswa', 'left');
        $this->db->where($where);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }
    public function ReadSiswaAbsensiArr($where)
    {
        $this->db->select('*');
        $this->db->from('tb_siswa');
        $this->db->join('absensi_siswa_mapel', 'tb_siswa.NisSiswa = absensi_siswa_mapel.NisSiswa', 'left');
        $this->db->where($where);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }
    public function InsertAbsensi($data)
    {
        $this->db->insert('absensi_siswa_mapel', $data);
    }
    public function UpdateAbsensi($where, $data)
    {
        $this->db->where($where);
        $this->db->update('absensi_siswa_mapel', $data);
    }

    public function ReadRekapAbsen($where)
    {
        $this->db->select('
            jadwal_kelas_mapel.*, 
            MIN(absensi_siswa_mapel.IDAbsen) AS absen_IDAbsen,
            absensi_siswa_mapel.IDJamPel AS absen_IDJamPel,
            absensi_siswa_mapel.TglAbsensi AS absen_TglAbsensi,
            absensi_siswa_mapel.NisSiswa AS absen_NisSiswa,
            absensi_siswa_mapel.JamMasuk AS absen_JamMasuk,
            tb_kelas.KodeKelas AS kelas_KodeKelas,
            (
                SELECT absensi_siswa_mapel.MISA 
                FROM absensi_siswa_mapel
                INNER JOIN tb_jampel ON tb_jampel.IDJamPel = absensi_siswa_mapel.IDJamPel
                WHERE absensi_siswa_mapel.TglAbsensi = absen_TglAbsensi AND tb_kelas.KodeKelas = kelas_KodeKelas AND absensi_siswa_mapel.NisSiswa = absen_NisSiswa
                LIMIT 1
            ) AS absen_MISA,
            tb_kelas.KodeTahun AS kelas_KodeTahun,
            tb_kelas.RuanganKelas AS kelas_RuanganKelas,
            tb_kelas.IDKelas AS kelas_IDKelas,
            tb_guru.UsrGuru AS guru_UsrGuru,
            tb_guru.NamaGuru AS guru_NamaGuru,
            tb_guru.NomorIndukGuru AS guru_NomorIndukGuru,
            tb_guru.KodeMapel AS guru_KodeMapel,
            tb_guru.IDHak AS guru_IDHak,
            tb_guru.PassGuru AS guru_PassGuru,
            tb_guru.Status AS guru_Status,
            tb_guru.IDGuru AS guru_IDGuru,
            tb_jampel.IDJamPel AS jampel_IDJamPel,
            tb_jampel.IDHari AS jampel_IDHari,
            MIN(tb_jampel.MulaiJampel) AS jampel_MulaiJampel,
            MIN(tb_jampel.AkhirJampel) AS jampel_AkhirJampel,
            tb_hari.IDHari AS hari_IDHari,
            tb_hari.NamaHari AS hari_NamaHari,
            tb_hari.KodeHari AS hari_KodeHari,
            tb_hari.Keterangan AS hari_Keterangan,
            tb_hari.UrutanKe AS hari_UrutanKe
        ');
        $this->db->where($where);
        $this->db->from('jadwal_kelas_mapel');
        $this->db->join('absensi_siswa_mapel', 'jadwal_kelas_mapel.IDKelasMapel = absensi_siswa_mapel.IDKelasMapel', 'inner');
        $this->db->join('tb_kelas', 'jadwal_kelas_mapel.IDKelas = tb_kelas.IDKelas', 'inner');
        $this->db->join('tb_guru', 'tb_kelas.IDGuru = tb_guru.IDGuru', 'inner');
        $this->db->join('tb_jampel', 'absensi_siswa_mapel.IDJamPel = tb_jampel.IDJamPel', 'inner');
        $this->db->join('tb_hari', 'tb_jampel.IDHari = tb_hari.IDHari', 'inner');

        $this->db->group_by('absen_NisSiswa, absen_TglAbsensi'); // Kelompokkan berdasarkan NisSiswa dan TglAbsensi
        $this->db->order_by('absen_NisSiswa', 'ASC'); // Urutkan berdasarkan NisSiswa
        $this->db->order_by('absen_IDJamPel', 'ASC'); // Kemudian urutkan berdasarkan IDJamPel

        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function ReadRekapAbsenLimit7($where)
    {
        $this->db->select('
            jadwal_kelas_mapel.*, 
            MIN(absensi_siswa_mapel.IDAbsen) AS absen_IDAbsen,
            absensi_siswa_mapel.IDJamPel AS absen_IDJamPel,
            absensi_siswa_mapel.TglAbsensi AS absen_TglAbsensi,
            absensi_siswa_mapel.NisSiswa AS absen_NisSiswa,
            absensi_siswa_mapel.JamMasuk AS absen_JamMasuk,
            absensi_siswa_mapel.MISA AS absen_MISA,
            tb_kelas.KodeKelas AS kelas_KodeKelas,
            tb_kelas.KodeTahun AS kelas_KodeTahun,
            tb_kelas.RuanganKelas AS kelas_RuanganKelas,
            tb_kelas.IDKelas AS kelas_IDKelas,
            tb_guru.UsrGuru AS guru_UsrGuru,
            tb_guru.NamaGuru AS guru_NamaGuru,
            tb_guru.NomorIndukGuru AS guru_NomorIndukGuru,
            tb_guru.KodeMapel AS guru_KodeMapel,
            tb_guru.IDHak AS guru_IDHak,
            tb_guru.PassGuru AS guru_PassGuru,
            tb_guru.Status AS guru_Status,
            tb_guru.IDGuru AS guru_IDGuru,
            tb_jampel.IDJamPel AS jampel_IDJamPel,
            tb_jampel.IDHari AS jampel_IDHari,
            tb_jampel.MulaiJampel AS jampel_MulaiJampel,
            tb_jampel.AkhirJampel AS jampel_AkhirJampel,
            tb_hari.IDHari AS hari_IDHari,
            tb_hari.NamaHari AS hari_NamaHari,
            tb_hari.KodeHari AS hari_KodeHari,
            tb_hari.Keterangan AS hari_Keterangan,
            tb_hari.UrutanKe AS hari_UrutanKe
        ');
        $this->db->where($where);
        $this->db->from('jadwal_kelas_mapel');
        $this->db->join('absensi_siswa_mapel', 'jadwal_kelas_mapel.IDKelasMapel = absensi_siswa_mapel.IDKelasMapel', 'inner');
        $this->db->join('tb_kelas', 'jadwal_kelas_mapel.IDKelas = tb_kelas.IDKelas', 'inner');
        $this->db->join('tb_guru', 'tb_kelas.IDGuru = tb_guru.IDGuru', 'inner');
        $this->db->join('tb_jampel', 'absensi_siswa_mapel.IDJamPel = tb_jampel.IDJamPel', 'inner');
        $this->db->join('tb_hari', 'tb_jampel.IDHari = tb_hari.IDHari', 'inner');

        $this->db->group_by('absen_NisSiswa, absen_TglAbsensi'); // Kelompokkan berdasarkan NisSiswa dan TglAbsensi
        $this->db->order_by('absen_NisSiswa', 'ASC'); // Urutkan berdasarkan NisSiswa
        $this->db->order_by('absen_IDJamPel', 'ASC'); // Kemudian urutkan berdasarkan IDJamPel

        $query = $this->db->get();
        $this->db->limit(7);
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function ReadSiswaAbsensiSS($where)
    {
        $this->db->select('absensi_siswa_mapel.IDAbsen AS absen_IDAbsen, absensi_siswa_mapel.IDKelasMapel AS absen_IDKelasMapel, absensi_siswa_mapel.IDJampel AS absen_IDJampel, absensi_siswa_mapel.TglAbsensi AS absen_TglAbsensi, absensi_siswa_mapel.NisSiswa AS absen_NisSiswa, absensi_siswa_mapel.JamMasuk AS absen_JamMasuk, absensi_siswa_mapel.MISA AS absen_MISA, jadwal_kelas_mapel.IDKelas AS jadwal_IDKelas, jadwal_kelas_mapel.IDMapel AS jadwal_IDMapel, jadwal_kelas_mapel.IDGuru AS jadwal_IDGuru, jadwal_kelas_mapel.IDAjaran AS jadwal_IDAjaran, jadwal_kelas_mapel.Keterangan AS jadwal_Keterangan, tb_guru.IDGuru, tb_guru.UsrGuru, tb_guru.KodeGuru, tb_guru.NamaGuru, tb_guru.NomorIndukGuru, tb_guru.KodeMapel, tb_guru.IDHak, tb_guru.PassGuru, tb_guru.NomorHP, tb_guru.Status, tb_jampel.IDJamPel, tb_jampel.IDHari, tb_jampel.MulaiJampel, tb_jampel.AkhirJampel, tb_jampel.JamKe, tb_mapel.IDMapel, tb_mapel.KodeMapel AS mapel_KodeMapel, tb_mapel.NamaMapel, tb_mapel.Keterangan AS mapel_Keterangan');
        $this->db->from('absensi_siswa_mapel');
        $this->db->join('jadwal_kelas_mapel', 'absensi_siswa_mapel.IDKelasMapel = jadwal_kelas_mapel.IDKelasMapel');
        $this->db->join('tb_guru', 'tb_guru.IDGuru = jadwal_kelas_mapel.IDGuru');
        $this->db->join('tb_jampel', 'tb_jampel.IDJampel = absensi_siswa_mapel.IDJampel');
        $this->db->join('tb_mapel', 'tb_mapel.IDMapel = jadwal_kelas_mapel.IDMapel'); // Menambahkan join dengan tb_mapel
        $this->db->where($where);
        $this->db->order_by('tb_jampel.MulaiJampel', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function InsertNilaHariSiswa($data)
    {
        $this->db->insert('nilai_mapel_hari_siswa', $data);
    }
    public function UpdateNilaHariSiswa($where, $data)
    {
        $this->db->where($where);
        $this->db->update('nilai_mapel_hari_siswa', $data);
    }
    public function ReadNilaHariSiswa($where)
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
            return $query->result();
        }
    }


    public function ReadNilaiSiswa($where)
    {
        // Menggunakan Model Builder untuk menggabungkan tabel
        $this->db->select('nilai_mapel.IDNilaiMapel, nilai_mapel.IDKelasMapel, nilai_mapel.IDSemester, nilai_mapel.NisSiswa, nilai_mapel.NamaMapel, nilai_mapel.NilaiUTS, nilai_mapel.NilaiUAS, jadwal_kelas_mapel.IDKelas, jadwal_kelas_mapel.IDMapel, jadwal_kelas_mapel.IDGuru, jadwal_kelas_mapel.IDAjaran, jadwal_kelas_mapel.Keterangan');
        $this->db->from('nilai_mapel');
        $this->db->join('jadwal_kelas_mapel', 'nilai_mapel.IDKelasMapel = jadwal_kelas_mapel.IDKelasMapel', 'inner');

        // Menambahkan kondisi WHERE berdasarkan parameter $where
        if (!empty ($where)) {
            $this->db->where($where);
        }

        // Mendapatkan hasil query
        $query = $this->db->get();

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }
    public function InsertNilaiSiswa($data)
    {
        $this->db->insert('nilai_mapel', $data);
    }
    public function UpdateNilaiSiswa($where, $data)
    {
        $this->db->where($where);
        $this->db->update('nilai_mapel', $data);
    }


    public function ReadNilaiKeWali($where)
    {
        $this->db->select('jadwal_kelas_mapel.IDKelasMapel, jadwal_kelas_mapel.IDKelas, jadwal_kelas_mapel.IDMapel, jadwal_kelas_mapel.IDGuru, jadwal_kelas_mapel.IDAjaran, jadwal_kelas_mapel.Keterangan AS KeteranganJadwal, tb_mapel.KodeMapel, tb_mapel.NamaMapel, tb_mapel.Keterangan AS KeteranganMapel, nilai_mapel.IDNilaiMapel, nilai_mapel.IDSemester, nilai_mapel.NisSiswa, nilai_mapel.NilaiUTS, nilai_mapel.NilaiUAS, nilai_mapel.NilaiAkhir, nilai_mapel.Status');
        $this->db->from('jadwal_kelas_mapel');
        $this->db->join('tb_mapel', 'jadwal_kelas_mapel.IDMapel = tb_mapel.IDMapel');
        $this->db->join('nilai_mapel', 'jadwal_kelas_mapel.IDKelasMapel = nilai_mapel.IDKelasMapel');
        if (!empty ($where)) {
            $this->db->where($where);
        }
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function ReadDataSiswaMapelGuruMapelNilaiSemesterAjaran($where)
    {
        $this->db->select('
            tb_kelas.IDKelas AS kelas_IDKelas,
            tb_kelas.KodeKelas AS kelas_KodeKelas,
            tb_kelas.KodeTahun,
            tb_kelas.KodeGuru AS kelas_KodeGuru,
            tb_kelas.IDGuru AS kelas_IDGuru,
            tb_kelas.RuanganKelas,
            jadwal_kelas_mapel.IDKelasMapel,
            jadwal_kelas_mapel.IDMapel AS mapel_IDMapel,
            jadwal_kelas_mapel.IDAjaran,
            jadwal_kelas_mapel.Keterangan,
            tb_siswa.IDSiswa,
            tb_siswa.NisSiswa,
            tb_siswa.KodeKelas AS siswa_KodeKelas,
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
            tb_guru.IDGuru AS guru_IDGuru,
            tb_guru.UsrGuru,
            tb_guru.KodeGuru AS guru_KodeGuru,
            tb_guru.NamaGuru,
            tb_guru.NomorIndukGuru,
            tb_guru.KodeMapel AS guru_KodeMapel,
            tb_guru.IDHak,
            tb_guru.PassGuru,
            tb_guru.Status AS guru_Status,
            tb_mapel.IDMapel AS mapel_IDMapel,
            tb_mapel.KodeMapel AS mapel_KodeMapel,
            tb_mapel.NamaMapel,
            tb_mapel.Keterangan AS mapel_Keterangan,
            nilai_mapel.IDNilaiMapel AS nilai_IDNilaiMapel,
            nilai_mapel.IDKelasMapel AS nilai_IDKelasMapel,
            nilai_mapel.IDSemester AS nilai_IDSemester,
            nilai_mapel.NisSiswa AS nilai_NisSiswa,
            nilai_mapel.NamaMapel AS nilai_NamaMapel,
            nilai_mapel.NilaiHarian,
            nilai_mapel.NilaiUTS,
            nilai_mapel.NilaiUAS,
            nilai_mapel.NilaiAkhir,
            nilai_mapel.Status AS nilai_Status,
            report_semester.IDSemester AS report_IDSemester,
            report_semester.NamaSemester,
            report_semester.Penyebutan,
            report_semester.Keterangan AS report_Keterangan,
            report_ajaran.IDAjaran AS report_IDAjaran,
            report_ajaran.KodeAjaran,
            report_ajaran.TahunAwal,
            report_ajaran.TahunAkhir,
            report_ajaran.Kurikulum
        ');
        $this->db->from('tb_kelas');
        $this->db->join('jadwal_kelas_mapel', 'tb_kelas.IDKelas = jadwal_kelas_mapel.IDKelas', 'inner');
        $this->db->join('tb_siswa', 'tb_kelas.KodeKelas = tb_siswa.KodeKelas', 'inner');
        $this->db->join('tb_guru', 'jadwal_kelas_mapel.IDGuru = tb_guru.IDGuru', 'inner');
        $this->db->join('tb_mapel', 'jadwal_kelas_mapel.IDMapel = tb_mapel.IDMapel', 'inner');
        $this->db->join('nilai_mapel', 'jadwal_kelas_mapel.IDKelasMapel = nilai_mapel.IDKelasMapel', 'inner');
        $this->db->join('report_semester', 'nilai_mapel.IDSemester = report_semester.IDSemester', 'inner');
        $this->db->join('report_ajaran', 'jadwal_kelas_mapel.IDAjaran = report_ajaran.IDAjaran', 'inner');

        if (!empty ($where)) {
            $this->db->where($where);
        }

        $query = $this->db->get();

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }


    }

    public function ReadJurnalGuru($where)
    {
        $this->db->where($where);
        $this->db->order_by('TanggalJurnal', 'desc');
        $query = $this->db->get('jurnal_guru_mapel');  // Ganti 'nama_tabel' dengan nama tabel Anda
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }
    public function ReadJurnalGuruArr($where)
    {
        $this->db->where($where);
        $this->db->order_by('TanggalJurnal', 'desc');
        $query = $this->db->get('jurnal_guru_mapel');  // Ganti 'nama_tabel' dengan nama tabel Anda
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result_array();
        }
    }
    public function InsertJurnalGuru($data)
    {
        $this->db->insert('jurnal_guru_mapel', $data);
    }
    public function UpdateJurnalGuru($where, $data)
    {
        $this->db->where($where);
        $this->db->update('jurnal_guru_mapel', $data);
    }

    public function ReadJurnalGuruGroupBy($where)
    {

        $this->db->select('jurnal_guru_mapel.IDJurnal, jurnal_guru_mapel.IDKelasMapel, jurnal_guru_mapel.IDGuru, jurnal_guru_mapel.IDAjaran, jurnal_guru_mapel.IDJamPel, jurnal_guru_mapel.IDKelas, jurnal_guru_mapel.IDMapel, jurnal_guru_mapel.KendalaFoto, jurnal_guru_mapel.PenyelesaianFoto, jurnal_guru_mapel.TanggalJurnal, jurnal_guru_mapel.KendalaKet, jurnal_guru_mapel.Penyelesaianket, jurnal_guru_mapel.MateriPokok, jurnal_guru_mapel.InPenKom, jurnal_guru_mapel.Kegiatan, jurnal_guru_mapel.Penilaian, jadwal_kelas_mapel.IDKelas, jadwal_kelas_mapel.IDMapel, jadwal_kelas_mapel.IDGuru AS Mapel_IDGuru, jadwal_kelas_mapel.IDAjaran, jadwal_kelas_mapel.Keterangan, tb_mapel.KodeMapel, tb_mapel.NamaMapel, tb_mapel.Keterangan as MapelKeterangan, tb_kelas.IDKelas, tb_kelas.KodeKelas, tb_kelas.KodeTahun, tb_kelas.KodeGuru, tb_kelas.IDGuru as KelasIDGuru, tb_kelas.RuanganKelas');
        $this->db->from('jurnal_guru_mapel');
        $this->db->join('jadwal_kelas_mapel', 'jurnal_guru_mapel.IDKelasMapel = jadwal_kelas_mapel.IDKelasMapel');
        $this->db->join('tb_mapel', 'jadwal_kelas_mapel.IDMapel = tb_mapel.IDMapel');
        $this->db->join('tb_kelas', 'jadwal_kelas_mapel.IDKelas = tb_kelas.IDKelas'); // Tambahkan baris ini untuk menambahkan tabel tb_kelas
        $this->db->where($where);

        $this->db->group_by('jurnal_guru_mapel.IDKelasMapel'); // Tambahkan baris ini untuk menggroup berdasarkan IDKelasMapel
        $this->db->order_by('TanggalJurnal', 'desc');

        $query = $this->db->get();

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }

    }

    // fungsi untuk menampilkan riwayat jurnal || 27 Januari 2024 || vita
    // Edited by Indra Gunawan at 29 Januari 2024
    public function RiwayatJurnal($where)
    {
        $this->db->select('absensi_siswa_mapel.IDAbsen, absensi_siswa_mapel.IDKelasMapel, absensi_siswa_mapel.IDJampel, absensi_siswa_mapel.TglAbsensi, absensi_siswa_mapel.NisSiswa, absensi_siswa_mapel.JamMasuk, absensi_siswa_mapel.MISA, jurnal_guru_mapel.IDJurnal, jurnal_guru_mapel.IDKelasMapel, jurnal_guru_mapel.IDGuru AS jg_IDGuru, jurnal_guru_mapel.IDAjaran, jurnal_guru_mapel.IDJamPel, jurnal_guru_mapel.IDKelas, jurnal_guru_mapel.IDMapel, jurnal_guru_mapel.IDSemester, jurnal_guru_mapel.KendalaFoto, jurnal_guru_mapel.PenyelesaianFoto, jurnal_guru_mapel.TanggalJurnal, jurnal_guru_mapel.KendalaKet, jurnal_guru_mapel.PenyelesaianKet, jurnal_guru_mapel.MateriPokok, jurnal_guru_mapel.InPenKom, jurnal_guru_mapel.Kegiatan, jurnal_guru_mapel.Penilaian, jurnal_guru_mapel.TindakLanjut, jadwal_kelas_mapel.IDKelasMapel, jadwal_kelas_mapel.IDKelas, jadwal_kelas_mapel.IDMapel, jadwal_kelas_mapel.IDGuru AS jk_IDGuru, jadwal_kelas_mapel.IDAjaran, jadwal_kelas_mapel.Keterangan, tb_kelas.IDKelas, tb_kelas.KodeKelas, tb_kelas.KodeTahun, tb_kelas.KodeGuru, tb_kelas.IDGuru AS ta_IDGuru, tb_kelas.RuanganKelas, tb_jampel.IDJamPel, tb_jampel.IDHari, tb_jampel.MulaiJampel, tb_jampel.AkhirJampel, tb_jampel.JamKe, tb_mapel.IDMapel, tb_mapel.KodeMapel, tb_mapel.NamaMapel, tb_mapel.Keterangan, tb_guru.IDGuru, tb_guru.UsrGuru, tb_guru.KodeGuru, tb_guru.NamaGuru, tb_guru.NomorIndukGuru, tb_guru.KodeMapel, tb_guru.IDHak, tb_guru.PassGuru, tb_guru.NomorHP, tb_guru.Status');
        $this->db->select('
            SUM(CASE WHEN MISA = "M" AND jurnal_guru_mapel.TanggalJurnal = absensi_siswa_mapel.TglAbsensi AND jurnal_guru_mapel.IDJamPel = absensi_siswa_mapel.IDJamPel AND absensi_siswa_mapel.IDKelasMapel = jurnal_guru_mapel.IDKelasMapel THEN 1 ELSE 0 END) AS JumlahM,
            SUM(CASE WHEN MISA = "I" AND jurnal_guru_mapel.TanggalJurnal = absensi_siswa_mapel.TglAbsensi AND jurnal_guru_mapel.IDJamPel = absensi_siswa_mapel.IDJamPel AND absensi_siswa_mapel.IDKelasMapel = jurnal_guru_mapel.IDKelasMapel THEN 1 ELSE 0 END) AS JumlahI,
            SUM(CASE WHEN MISA = "S" AND jurnal_guru_mapel.TanggalJurnal = absensi_siswa_mapel.TglAbsensi AND jurnal_guru_mapel.IDJamPel = absensi_siswa_mapel.IDJamPel AND absensi_siswa_mapel.IDKelasMapel = jurnal_guru_mapel.IDKelasMapel THEN 1 ELSE 0 END) AS JumlahS,
            SUM(CASE WHEN MISA = "A" AND jurnal_guru_mapel.TanggalJurnal = absensi_siswa_mapel.TglAbsensi AND jurnal_guru_mapel.IDJamPel = absensi_siswa_mapel.IDJamPel AND absensi_siswa_mapel.IDKelasMapel = jurnal_guru_mapel.IDKelasMapel THEN 1 ELSE 0 END) AS JumlahA,
            CASE WHEN jurnal_guru_mapel.IDJurnal IS NULL THEN "Belum Terisi" ELSE "Terisi" END AS KeteranganJurnal', false);

        $this->db->from('absensi_siswa_mapel');
        $this->db->join('jadwal_kelas_mapel', 'absensi_siswa_mapel.IDKelasMapel = jadwal_kelas_mapel.IDKelasMapel', 'left');
        $this->db->join('tb_guru', 'jadwal_kelas_mapel.IDGuru = tb_guru.IDGuru');
        $this->db->join('jurnal_guru_mapel', 'absensi_siswa_mapel.IDJampel = jurnal_guru_mapel.IDJamPel AND jurnal_guru_mapel.TanggalJurnal = absensi_siswa_mapel.TglAbsensi AND jurnal_guru_mapel.IDGuru = jadwal_kelas_mapel.IDGuru', 'left');
        $this->db->join('tb_kelas', 'jadwal_kelas_mapel.IDKelas = tb_kelas.IDKelas');
        $this->db->join('tb_jampel', 'absensi_siswa_mapel.IDJampel = tb_jampel.IDJamPel', 'left');
        $this->db->join('tb_mapel', 'jadwal_kelas_mapel.IDMapel = tb_mapel.IDMapel');

        $this->db->where($where);

        $this->db->group_by('absensi_siswa_mapel.IDJampel');
        $this->db->group_by('absensi_siswa_mapel.TglAbsensi');
        // $this->db->group_by('jurnal_guru_mapel.IDJurnal');

        $this->db->order_by('TglAbsensi', 'desc');

        $this->db->limit('35');

        $query = $this->db->get();

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }




    // 26 januari 2024 || vita 
    public function JurnalGuruMenuKepsek($where, $start, $length, $order)
    {
        $this->db->select('absensi_siswa_mapel.IDAbsen, absensi_siswa_mapel.IDKelasMapel, absensi_siswa_mapel.IDJampel, absensi_siswa_mapel.TglAbsensi, absensi_siswa_mapel.NisSiswa, absensi_siswa_mapel.JamMasuk, absensi_siswa_mapel.MISA, jurnal_guru_mapel.IDJurnal, jurnal_guru_mapel.IDKelasMapel, jurnal_guru_mapel.IDGuru AS JGM_IDGuru, jurnal_guru_mapel.IDAjaran, jurnal_guru_mapel.IDJamPel, jurnal_guru_mapel.IDKelas, jurnal_guru_mapel.IDMapel, jurnal_guru_mapel.IDSemester, jurnal_guru_mapel.KendalaFoto, jurnal_guru_mapel.PenyelesaianFoto, jurnal_guru_mapel.TanggalJurnal, jurnal_guru_mapel.KendalaKet, jurnal_guru_mapel.PenyelesaianKet, jurnal_guru_mapel.MateriPokok, jurnal_guru_mapel.InPenKom, jurnal_guru_mapel.Kegiatan, jurnal_guru_mapel.Penilaian, jurnal_guru_mapel.TindakLanjut, jurnal_guru_mapel.Status, jadwal_kelas_mapel.IDKelasMapel, jadwal_kelas_mapel.IDKelas, jadwal_kelas_mapel.IDMapel, jadwal_kelas_mapel.IDGuru, jadwal_kelas_mapel.IDAjaran, jadwal_kelas_mapel.Keterangan, tb_kelas.IDKelas, tb_kelas.KodeKelas, tb_kelas.KodeTahun, tb_kelas.KodeGuru, tb_kelas.IDGuru AS TK_IDGuru, tb_kelas.RuanganKelas, tb_jampel.IDJamPel, tb_jampel.IDHari, tb_jampel.MulaiJampel, tb_jampel.AkhirJampel, tb_jampel.JamKe, tb_mapel.IDMapel, tb_mapel.KodeMapel, tb_mapel.NamaMapel, tb_mapel.Keterangan, tb_guru.IDGuru TG_IDGuru, tb_guru.UsrGuru, tb_guru.KodeGuru, tb_guru.NamaGuru, tb_guru.NomorIndukGuru, tb_guru.KodeMapel, tb_guru.IDHak, tb_guru.PassGuru, tb_guru.NomorHP, tb_guru.Status AS TG_Status');

        $this->db->select_sum("CASE WHEN MISA = 'M' THEN 1 ELSE 0 END", 'JumlahM');
        $this->db->select_sum("CASE WHEN MISA = 'I' THEN 1 ELSE 0 END", 'JumlahI');
        $this->db->select_sum("CASE WHEN MISA = 'S' THEN 1 ELSE 0 END", 'JumlahS');
        $this->db->select_sum("CASE WHEN MISA = 'A' THEN 1 ELSE 0 END", 'JumlahA');
        $this->db->select('(CASE WHEN jurnal_guru_mapel.IDJurnal IS NULL THEN "Belum Terisi" ELSE "Terisi" END) AS KeteranganJurnal', false);
        $this->db->select('COUNT(DISTINCT absensi_siswa_mapel.NisSiswa) as TotalSiswa');
        $this->db->from('absensi_siswa_mapel');
        $this->db->join('jadwal_kelas_mapel', 'absensi_siswa_mapel.IDKelasMapel = jadwal_kelas_mapel.IDKelasMapel');
        $this->db->join('jurnal_guru_mapel', 'absensi_siswa_mapel.IDJampel = jurnal_guru_mapel.IDJamPel AND jurnal_guru_mapel.TanggalJurnal = absensi_siswa_mapel.TglAbsensi AND jurnal_guru_mapel.IDGuru = jadwal_kelas_mapel.IDGuru', 'left');
        $this->db->where('jurnal_guru_mapel.IDJurnal IS NOT NULL');
        $this->db->join('tb_kelas', 'jadwal_kelas_mapel.IDKelas = tb_kelas.IDKelas');
        $this->db->join('tb_jampel', 'absensi_siswa_mapel.IDJampel = tb_jampel.IDJamPel', 'left');
        $this->db->join('tb_mapel', 'jadwal_kelas_mapel.IDMapel = tb_mapel.IDMapel');
        $this->db->join('tb_guru', 'jurnal_guru_mapel.IDGuru = tb_guru.IDGuru');

        $this->db->where($where);
        $this->db->group_by('absensi_siswa_mapel.IDJampel');
        $this->db->group_by('absensi_siswa_mapel.TglAbsensi');

        // Mengatur order
        $column_order = array('absensi_siswa_mapel.TglAbsensi', 'tb_jampel.JamKe'); // Sesuaikan dengan kolom yang dapat diurutkan
        $column_search = array(); // Kolom yang dapat dicari
        $order_dir = $order['dir'];

        if (!empty ($order['column'])) {
            $this->db->order_by($column_order[$order['column']], $order_dir);
        } else {
            $this->db->order_by('TglAbsensi', 'desc');
        }

        // Menangani paging
        if ($length != -1) {
            $this->db->limit($length, $start);
        }

        $query = $this->db->get();

        return $query->result();
    }
    public function JurnalGuruMenuKepsekHitung($where)
    {
        $this->db->select('absensi_siswa_mapel.IDAbsen, absensi_siswa_mapel.IDKelasMapel, absensi_siswa_mapel.IDJampel, absensi_siswa_mapel.TglAbsensi, absensi_siswa_mapel.NisSiswa, absensi_siswa_mapel.JamMasuk, absensi_siswa_mapel.MISA, jurnal_guru_mapel.IDJurnal, jurnal_guru_mapel.IDKelasMapel, jurnal_guru_mapel.IDGuru AS JGM_IDGuru, jurnal_guru_mapel.IDAjaran, jurnal_guru_mapel.IDJamPel, jurnal_guru_mapel.IDKelas, jurnal_guru_mapel.IDMapel, jurnal_guru_mapel.IDSemester, jurnal_guru_mapel.KendalaFoto, jurnal_guru_mapel.PenyelesaianFoto, jurnal_guru_mapel.TanggalJurnal, jurnal_guru_mapel.KendalaKet, jurnal_guru_mapel.PenyelesaianKet, jurnal_guru_mapel.MateriPokok, jurnal_guru_mapel.InPenKom, jurnal_guru_mapel.Kegiatan, jurnal_guru_mapel.Penilaian, jurnal_guru_mapel.TindakLanjut, jurnal_guru_mapel.Status, jadwal_kelas_mapel.IDKelasMapel, jadwal_kelas_mapel.IDKelas, jadwal_kelas_mapel.IDMapel, jadwal_kelas_mapel.IDGuru, jadwal_kelas_mapel.IDAjaran, jadwal_kelas_mapel.Keterangan, tb_kelas.IDKelas, tb_kelas.KodeKelas, tb_kelas.KodeTahun, tb_kelas.KodeGuru, tb_kelas.IDGuru AS TK_IDGuru, tb_kelas.RuanganKelas, tb_jampel.IDJamPel, tb_jampel.IDHari, tb_jampel.MulaiJampel, tb_jampel.AkhirJampel, tb_jampel.JamKe, tb_mapel.IDMapel, tb_mapel.KodeMapel, tb_mapel.NamaMapel, tb_mapel.Keterangan, tb_guru.IDGuru TG_IDGuru, tb_guru.UsrGuru, tb_guru.KodeGuru, tb_guru.NamaGuru, tb_guru.NomorIndukGuru, tb_guru.KodeMapel, tb_guru.IDHak, tb_guru.PassGuru, tb_guru.NomorHP, tb_guru.Status AS TG_Status');

        $this->db->from('absensi_siswa_mapel');
        $this->db->join('jadwal_kelas_mapel', 'absensi_siswa_mapel.IDKelasMapel = jadwal_kelas_mapel.IDKelasMapel');
        $this->db->join('jurnal_guru_mapel', 'absensi_siswa_mapel.IDJampel = jurnal_guru_mapel.IDJamPel AND jurnal_guru_mapel.TanggalJurnal = absensi_siswa_mapel.TglAbsensi AND jurnal_guru_mapel.IDGuru = jadwal_kelas_mapel.IDGuru', 'left');
        $this->db->where('jurnal_guru_mapel.IDJurnal IS NOT NULL');
        $this->db->join('tb_kelas', 'jadwal_kelas_mapel.IDKelas = tb_kelas.IDKelas');
        $this->db->join('tb_jampel', 'absensi_siswa_mapel.IDJampel = tb_jampel.IDJamPel', 'left');
        $this->db->join('tb_mapel', 'jadwal_kelas_mapel.IDMapel = tb_mapel.IDMapel');
        $this->db->join('tb_guru', 'jurnal_guru_mapel.IDGuru = tb_guru.IDGuru');

        $this->db->where($where);
        $this->db->group_by('absensi_siswa_mapel.IDJampel');
        $this->db->group_by('absensi_siswa_mapel.TglAbsensi');

        $query = $this->db->get();

        return $query->num_rows();
    }

    // INdra Gunawan Ardiansyah || 25 Jan 2024
    public function RiwayatJurnalSS($where, $start, $length, $order, $searchValue = null)
    {
        $this->db->select('absensi_siswa_mapel.IDAbsen, absensi_siswa_mapel.IDKelasMapel, absensi_siswa_mapel.IDJampel, absensi_siswa_mapel.TglAbsensi, absensi_siswa_mapel.NisSiswa, absensi_siswa_mapel.JamMasuk, absensi_siswa_mapel.MISA, jurnal_guru_mapel.IDJurnal, jurnal_guru_mapel.IDKelasMapel, jurnal_guru_mapel.IDGuru AS JGM_IDGuru, jurnal_guru_mapel.IDAjaran, jurnal_guru_mapel.IDJamPel, jurnal_guru_mapel.IDKelas, jurnal_guru_mapel.IDMapel, jurnal_guru_mapel.IDSemester, jurnal_guru_mapel.KendalaFoto, jurnal_guru_mapel.PenyelesaianFoto, jurnal_guru_mapel.TanggalJurnal, jurnal_guru_mapel.KendalaKet, jurnal_guru_mapel.PenyelesaianKet, jurnal_guru_mapel.MateriPokok, jurnal_guru_mapel.InPenKom, jurnal_guru_mapel.Kegiatan, jurnal_guru_mapel.Penilaian, jurnal_guru_mapel.TindakLanjut, jadwal_kelas_mapel.IDKelasMapel, jadwal_kelas_mapel.IDKelas, jadwal_kelas_mapel.IDMapel, jadwal_kelas_mapel.IDGuru, jadwal_kelas_mapel.IDAjaran, jadwal_kelas_mapel.Keterangan, tb_kelas.IDKelas, tb_kelas.KodeKelas, tb_kelas.KodeTahun, tb_kelas.KodeGuru, tb_kelas.IDGuru AS TK_IDGuru, tb_kelas.RuanganKelas, tb_jampel.IDJamPel, tb_jampel.IDHari, tb_jampel.MulaiJampel, tb_jampel.AkhirJampel, tb_jampel.JamKe, tb_mapel.IDMapel, tb_mapel.KodeMapel, tb_mapel.NamaMapel, tb_mapel.Keterangan');

        $this->db->select_sum("CASE WHEN MISA = 'M' THEN 1 ELSE 0 END", 'JumlahM');
        $this->db->select_sum("CASE WHEN MISA = 'I' THEN 1 ELSE 0 END", 'JumlahI');
        $this->db->select_sum("CASE WHEN MISA = 'S' THEN 1 ELSE 0 END", 'JumlahS');
        $this->db->select_sum("CASE WHEN MISA = 'A' THEN 1 ELSE 0 END", 'JumlahA');
        $this->db->select('COUNT(DISTINCT absensi_siswa_mapel.NisSiswa) as TotalSiswa');
        $this->db->from('absensi_siswa_mapel');
        $this->db->join('jadwal_kelas_mapel', 'absensi_siswa_mapel.IDKelasMapel = jadwal_kelas_mapel.IDKelasMapel');
        $this->db->join('jurnal_guru_mapel', 'absensi_siswa_mapel.IDJampel = jurnal_guru_mapel.IDJamPel AND jurnal_guru_mapel.TanggalJurnal = absensi_siswa_mapel.TglAbsensi AND jurnal_guru_mapel.IDGuru = jadwal_kelas_mapel.IDGuru', 'inner');
        $this->db->join('tb_kelas', 'jadwal_kelas_mapel.IDKelas = tb_kelas.IDKelas');
        $this->db->join('tb_jampel', 'absensi_siswa_mapel.IDJampel = tb_jampel.IDJamPel', 'left');
        $this->db->join('tb_mapel', 'jadwal_kelas_mapel.IDMapel = tb_mapel.IDMapel');

        // $this->db->where($where);
        $this->db->group_by('absensi_siswa_mapel.IDJampel');
        $this->db->group_by('absensi_siswa_mapel.TglAbsensi');

        if (!empty ($where)) {
            $this->db->where($where);
        }
        // Menambahkan kondisi pencarian jika ada nilai pencarian yang diberikan
        if ($searchValue !== null) {
            $this->db->group_start();
            $this->db->like('absensi_siswa_mapel.TglAbsensi', $searchValue);
            $this->db->or_like('jurnal_guru_mapel.MateriPokok', $searchValue);
            $this->db->or_like('jurnal_guru_mapel.Kegiatan', $searchValue);
            $this->db->or_like('jurnal_guru_mapel.TindakLanjut', $searchValue);

            // tambahkan kondisi pencarian untuk kolom lainnya yang ingin Anda cari
            $this->db->group_end();
        }

        // Mengatur order
        $column_order = array('tb_jampel.JamKe', 'absensi_siswa_mapel.TglAbsensi'); // Sesuaikan dengan kolom yang dapat diurutkan
        $order_dir = $order['dir'];

        if (!empty ($order['column'])) {
            $this->db->order_by($column_order[$order['column']], $order_dir);
        } else {
            $this->db->order_by('TglAbsensi', 'desc');
        }

        // Menangani paging
        if ($length != -1) {
            $this->db->limit($length, $start);
        }


        $query = $this->db->get();

        return $query->result();
    }
    public function RiwayatJurnalNumber($where)
    {
        $this->db->select('absensi_siswa_mapel.IDAbsen, absensi_siswa_mapel.IDKelasMapel, absensi_siswa_mapel.IDJampel, absensi_siswa_mapel.TglAbsensi, absensi_siswa_mapel.NisSiswa, absensi_siswa_mapel.JamMasuk, absensi_siswa_mapel.MISA, jurnal_guru_mapel.IDJurnal, jurnal_guru_mapel.IDKelasMapel, jurnal_guru_mapel.IDGuru AS JGM_IDGuru, jurnal_guru_mapel.IDAjaran, jurnal_guru_mapel.IDJamPel, jurnal_guru_mapel.IDKelas, jurnal_guru_mapel.IDMapel, jurnal_guru_mapel.IDSemester, jurnal_guru_mapel.KendalaFoto, jurnal_guru_mapel.PenyelesaianFoto, jurnal_guru_mapel.TanggalJurnal, jurnal_guru_mapel.KendalaKet, jurnal_guru_mapel.PenyelesaianKet, jurnal_guru_mapel.MateriPokok, jurnal_guru_mapel.InPenKom, jurnal_guru_mapel.Kegiatan, jurnal_guru_mapel.Penilaian, jurnal_guru_mapel.TindakLanjut, jadwal_kelas_mapel.IDKelasMapel, jadwal_kelas_mapel.IDKelas, jadwal_kelas_mapel.IDMapel, jadwal_kelas_mapel.IDGuru, jadwal_kelas_mapel.IDAjaran, jadwal_kelas_mapel.Keterangan, tb_kelas.IDKelas, tb_kelas.KodeKelas, tb_kelas.KodeTahun, tb_kelas.KodeGuru, tb_kelas.IDGuru AS TK_IDGuru, tb_kelas.RuanganKelas, tb_jampel.IDJamPel, tb_jampel.IDHari, tb_jampel.MulaiJampel, tb_jampel.AkhirJampel, tb_jampel.JamKe, tb_mapel.IDMapel, tb_mapel.KodeMapel, tb_mapel.NamaMapel, tb_mapel.Keterangan');

        $this->db->select_sum("CASE WHEN MISA = 'M' THEN 1 ELSE 0 END", 'JumlahM');
        $this->db->select_sum("CASE WHEN MISA = 'I' THEN 1 ELSE 0 END", 'JumlahI');
        $this->db->select_sum("CASE WHEN MISA = 'S' THEN 1 ELSE 0 END", 'JumlahS');
        $this->db->select_sum("CASE WHEN MISA = 'A' THEN 1 ELSE 0 END", 'JumlahA');
        $this->db->select('COUNT(DISTINCT absensi_siswa_mapel.NisSiswa) as TotalSiswa');
        $this->db->from('absensi_siswa_mapel');
        $this->db->join('jadwal_kelas_mapel', 'absensi_siswa_mapel.IDKelasMapel = jadwal_kelas_mapel.IDKelasMapel');
        $this->db->join('jurnal_guru_mapel', 'absensi_siswa_mapel.IDJampel = jurnal_guru_mapel.IDJamPel AND jurnal_guru_mapel.TanggalJurnal = absensi_siswa_mapel.TglAbsensi AND jurnal_guru_mapel.IDGuru = jadwal_kelas_mapel.IDGuru', 'inner');
        $this->db->join('tb_kelas', 'jadwal_kelas_mapel.IDKelas = tb_kelas.IDKelas');
        $this->db->join('tb_jampel', 'absensi_siswa_mapel.IDJampel = tb_jampel.IDJamPel', 'left');
        $this->db->join('tb_mapel', 'jadwal_kelas_mapel.IDMapel = tb_mapel.IDMapel');

        // $this->db->where($where);
        $this->db->group_by('absensi_siswa_mapel.IDJampel');
        $this->db->group_by('absensi_siswa_mapel.TglAbsensi');

        if (!empty ($where)) {
            $this->db->where($where);
        }

        $query = $this->db->get();

        return $query->num_rows();
    }
    public function RiwayatJurnalAll($where)
    {
        $this->db->select('absensi_siswa_mapel.IDAbsen, absensi_siswa_mapel.IDKelasMapel, absensi_siswa_mapel.IDJampel, absensi_siswa_mapel.TglAbsensi, absensi_siswa_mapel.NisSiswa, absensi_siswa_mapel.JamMasuk, absensi_siswa_mapel.MISA, jurnal_guru_mapel.IDJurnal, jurnal_guru_mapel.IDKelasMapel, jurnal_guru_mapel.IDGuru, jurnal_guru_mapel.IDAjaran, jurnal_guru_mapel.IDJamPel, jurnal_guru_mapel.IDKelas, jurnal_guru_mapel.IDMapel, jurnal_guru_mapel.IDSemester, jurnal_guru_mapel.KendalaFoto, jurnal_guru_mapel.PenyelesaianFoto, jurnal_guru_mapel.TanggalJurnal, jurnal_guru_mapel.KendalaKet, jurnal_guru_mapel.PenyelesaianKet, jurnal_guru_mapel.MateriPokok, jurnal_guru_mapel.InPenKom, jurnal_guru_mapel.Kegiatan, jurnal_guru_mapel.Penilaian, jurnal_guru_mapel.TindakLanjut, jadwal_kelas_mapel.IDKelasMapel, jadwal_kelas_mapel.IDKelas, jadwal_kelas_mapel.IDMapel, jadwal_kelas_mapel.IDGuru, jadwal_kelas_mapel.IDAjaran, jadwal_kelas_mapel.Keterangan, tb_kelas.IDKelas, tb_kelas.KodeKelas, tb_kelas.KodeTahun, tb_kelas.KodeGuru, tb_kelas.IDGuru, tb_kelas.RuanganKelas, tb_jampel.IDJamPel, tb_jampel.IDHari, tb_jampel.MulaiJampel, tb_jampel.AkhirJampel, tb_jampel.JamKe, tb_mapel.IDMapel, tb_mapel.KodeMapel, tb_mapel.NamaMapel, tb_mapel.Keterangan');

        $this->db->select_sum("CASE WHEN MISA = 'M' THEN 1 ELSE 0 END", 'JumlahM');
        $this->db->select_sum("CASE WHEN MISA = 'I' THEN 1 ELSE 0 END", 'JumlahI');
        $this->db->select_sum("CASE WHEN MISA = 'S' THEN 1 ELSE 0 END", 'JumlahS');
        $this->db->select_sum("CASE WHEN MISA = 'A' THEN 1 ELSE 0 END", 'JumlahA');
        $this->db->select('COUNT(DISTINCT absensi_siswa_mapel.NisSiswa) as TotalSiswa');
        $this->db->from('absensi_siswa_mapel');
        $this->db->join('jadwal_kelas_mapel', 'absensi_siswa_mapel.IDKelasMapel = jadwal_kelas_mapel.IDKelasMapel');
        $this->db->join('jurnal_guru_mapel', 'absensi_siswa_mapel.IDJampel = jurnal_guru_mapel.IDJamPel AND jurnal_guru_mapel.TanggalJurnal = absensi_siswa_mapel.TglAbsensi', 'inner');
        $this->db->join('tb_kelas', 'jadwal_kelas_mapel.IDKelas = tb_kelas.IDKelas');
        $this->db->join('tb_jampel', 'absensi_siswa_mapel.IDJampel = tb_jampel.IDJamPel', 'left');
        $this->db->join('tb_mapel', 'jadwal_kelas_mapel.IDMapel = tb_mapel.IDMapel');

        // $this->db->where($where);
        $this->db->group_by('absensi_siswa_mapel.IDJampel');
        $this->db->group_by('absensi_siswa_mapel.TglAbsensi');

        $query = $this->db->get();

        return $query->result();
    }
    // INdra Gunawan Ardiansyah || 25 Jan 2024


    public function ReadJurnalGuruBy($where)
    {
        $this->db->select('jurnal_guru_mapel.IDJurnal, jurnal_guru_mapel.IDKelasMapel, jurnal_guru_mapel.IDGuru, jurnal_guru_mapel.IDAjaran AS JGM_IDAjaran, jurnal_guru_mapel.IDSemester AS JGM_IDSemester, jurnal_guru_mapel.IDJamPel, jurnal_guru_mapel.IDKelas, jurnal_guru_mapel.IDMapel, jurnal_guru_mapel.KendalaFoto, jurnal_guru_mapel.PenyelesaianFoto, jurnal_guru_mapel.TanggalJurnal, jurnal_guru_mapel.KendalaKet, jurnal_guru_mapel.Penyelesaianket, jurnal_guru_mapel.MateriPokok, jurnal_guru_mapel.InPenKom, jurnal_guru_mapel.Kegiatan, jurnal_guru_mapel.Penilaian, jurnal_guru_mapel.TindakLanjut, jurnal_guru_mapel.Status, jadwal_kelas_mapel.IDKelas, jadwal_kelas_mapel.IDMapel, jadwal_kelas_mapel.IDGuru AS JKM_IDGuru, jadwal_kelas_mapel.IDAjaran AS JKM_IDAjaran, jadwal_kelas_mapel.Keterangan, tb_mapel.KodeMapel, tb_mapel.NamaMapel, tb_mapel.Keterangan, tb_kelas.IDKelas, tb_kelas.KodeKelas, tb_kelas.KodeTahun, tb_kelas.KodeGuru, tb_kelas.IDGuru AS TK_IDGuru, tb_kelas.RuanganKelas, tb_jampel.IDJamPel, tb_jampel.IDHari, tb_jampel.MulaiJampel, tb_jampel.AkhirJampel, tb_jampel.JamKe, tb_hari.IDHari AS Hari_ID, tb_hari.NamaHari, tb_hari.KodeHari, tb_hari.Keterangan AS HariKeterangan, tb_hari.UrutanKe AS HariUrutanKe');
        $this->db->from('jurnal_guru_mapel');
        $this->db->join('jadwal_kelas_mapel', 'jurnal_guru_mapel.IDKelasMapel = jadwal_kelas_mapel.IDKelasMapel');
        $this->db->join('tb_mapel', 'jadwal_kelas_mapel.IDMapel = tb_mapel.IDMapel');
        $this->db->join('tb_kelas', 'jadwal_kelas_mapel.IDKelas = tb_kelas.IDKelas');
        $this->db->join('tb_jampel', 'jurnal_guru_mapel.IDJamPel = tb_jampel.IDJamPel', 'left'); // Tambahkan tabel tb_jampel
        $this->db->join('tb_hari', 'tb_jampel.IDHari = tb_hari.IDHari', 'left'); // Tambahkan tabel tb_hari
        $this->db->where($where);
        $this->db->order_by('TanggalJurnal', 'desc');

        $query = $this->db->get();

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function JurnalAbsensiGuru($where)
    {
        $this->db->select('asm.IDAbsen, asm.IDKelasMapel, asm.IDJamPel, asm.TglAbsensi, asm.NisSiswa, asm.JamMasuk, asm.MISA');
        $this->db->select('jkm.IDKelasMapel, jkm.IDKelas, jkm.IDMapel, jkm.IDGuru, jkm.IDAjaran, jkm.Keterangan');
        $this->db->select('ts.IDSiswa, ts.NisSiswa, ts.KodeKelas, ts.NamaSiswa, ts.GenderSiswa, ts.AyahSiswa, ts.IbuSiswa, ts.TglLhrSiswa, ts.TmptLhrSiswa, ts.NISNSiswa, ts.TGLMasuk, ts.TGLKeluar, ts.Status, ts.Wali');

        $this->db->from('absensi_siswa_mapel asm');
        $this->db->join('jadwal_kelas_mapel jkm', 'asm.IDKelasMapel = jkm.IDKelasMapel', 'left');
        $this->db->join('tb_siswa ts', 'asm.NisSiswa = ts.NisSiswa', 'left');

        $this->db->where($where);

        $query = $this->db->get();

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function ReadNilaiSiswaWaliMurid($where)
    {
        $this->db->select('tb_siswa.IDSiswa, tb_siswa.NisSiswa, tb_siswa.KodeKelas, tb_siswa.NamaSiswa, tb_siswa.GenderSiswa, tb_siswa.AyahSiswa, tb_siswa.IbuSiswa, tb_siswa.TglLhrSiswa, tb_siswa.TmptLhrSiswa, tb_siswa.NISNSiswa, tb_siswa.TGLMasuk, tb_siswa.TGLKeluar, tb_siswa.Status, tb_siswa.Wali, tb_kelas.IDKelas, tb_kelas.KodeKelas as KelasKode, tb_kelas.KodeTahun, tb_kelas.KodeGuru, tb_kelas.IDGuru, tb_kelas.RuanganKelas, jadwal_kelas_mapel.IDKelasMapel, jadwal_kelas_mapel.IDMapel, jadwal_kelas_mapel.IDGuru as JadwalIDGuru, jadwal_kelas_mapel.IDAjaran, jadwal_kelas_mapel.Keterangan, nilai_mapel.IDNilaiMapel, nilai_mapel.IDKelasMapel as NilaiKelasMapel, nilai_mapel.IDSemester, nilai_mapel.NisSiswa as NilaiNisSiswa, nilai_mapel.NamaMapel, nilai_mapel.NilaiHarian, nilai_mapel.NilaiUTS, nilai_mapel.NilaiUAS, nilai_mapel.NilaiAkhir, nilai_mapel.Status as NilaiStatus, tb_mapel.IDMapel, tb_mapel.KodeMapel, tb_mapel.NamaMapel as NamaMapelTBMapel, tb_mapel.Keterangan as KeteranganMapel, tb_guru.IDGuru as GuruIDGuru, tb_guru.UsrGuru, tb_guru.KodeGuru as KodeGuruGuru, tb_guru.NamaGuru, tb_guru.NomorIndukGuru, tb_guru.KodeMapel as KodeMapelGuru, tb_guru.IDHak, tb_guru.Status as GuruStatus');
        $this->db->from('tb_siswa');
        $this->db->join('tb_kelas', 'tb_kelas.KodeKelas = tb_siswa.KodeKelas', 'inner');
        $this->db->join('jadwal_kelas_mapel', 'jadwal_kelas_mapel.IDKelas = tb_kelas.IDKelas', 'inner');
        $this->db->join('nilai_mapel', 'nilai_mapel.NisSiswa = tb_siswa.NisSiswa AND nilai_mapel.IDKelasMapel = jadwal_kelas_mapel.IDKelasMapel', 'inner');
        $this->db->join('tb_mapel', 'tb_mapel.IDMapel = jadwal_kelas_mapel.IDMapel', 'inner');
        $this->db->join('tb_guru', 'tb_guru.IDGuru = jadwal_kelas_mapel.IDGuru', 'inner');
        $this->db->where($where);
        $this->db->order_by('tb_mapel.NamaMapel', 'ASC');
        $query = $this->db->get();

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function SuratDigitalInsert($data)
    {
        $this->db->insert('surat_digital', $data);
    }

    public function SuratDigitalUpdate($data, $where)
    {
        $this->db->where($where);
        $this->db->update('surat_digital', $data);
    }

    public function SuratDigitalRead($where)
    {
        $this->db->select('sd.IDSurat, sd.IDHak AS IDHakSurat, sd.IDGuru, sd.KategoriSurat, sd.FilterKategori, sd.IDIzin, sd.TanggalSurat, sd.SubjekSurat, sd.Keterangan, sd.IsiSurat, sd.status, sd.Sampah, tg.IDGuru AS Guru_IDGuru, tg.UsrGuru, tg.KodeGuru, tg.NamaGuru, tg.NomorIndukGuru, tg.KodeMapel, tg.IDHak AS Guru_IDHak, tg.PassGuru, tg.NomorHP, tg.Status AS Guru_Status');
        $this->db->from('surat_digital as sd');
        $this->db->join('tb_guru as tg', 'sd.IDGuru = tg.IDGuru', 'left');
        $this->db->order_by('sd.TanggalSurat', 'desc');
        if (!empty ($where)) {
            if (isset ($where['condition_1'])) {
                $this->db->group_start(); // Mulai kelompok kondisi pertama (AND)
                $this->db->or_group_start();
                $this->db->where($where['condition_1']);
                $this->db->group_end(); // Akhiri kelompok kondisi pertama (AND)
                if (isset ($where['condition_2'])) {
                    $this->db->or_group_start();
                    $this->db->where($where['condition_2']);
                    $this->db->group_end(); // Akhiri kelompok kondisi pertama (AND)
                }
                if (isset ($where['condition_3'])) {
                    $this->db->or_group_start();
                    $this->db->where($where['condition_3']);
                    $this->db->group_end(); // Akhiri kelompok kondisi pertama (AND)
                }
                $this->db->group_end(); // Akhiri kelompok kondisi pertama (AND)

            } else {
                $this->db->where($where);
            }
        }

        $query = $this->db->get();
        // echo $this->db->last_query();
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }

    }

    public function SuratDigitalDelete($where)
    {
        $this->db->where($where);
        $this->db->delete('surat_digital');
    }

    public function GETSuratDigital($where)
    {
        $this->db->where($where);
        $query = $this->db->get('surat_digital');

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function GETSuratDigitalArr($where)
    {
        $this->db->where($where);
        $query = $this->db->get('surat_digital');

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result_array();
        }
    }












}
