<?php

class M_API extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
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

    public function DataHakakses($start, $length, $order, $searchValue = null)
    {
        // Menambahkan kondisi pencarian jika ada nilai pencarian yang diberikan
        if ($searchValue !== null) {
            $this->db->group_start();
            $this->db->like('KodeHak', $searchValue);
            $this->db->or_like('JenisHak', $searchValue);
            $this->db->or_like('NamaHak', $searchValue);
            // tambahkan kondisi pencarian untuk kolom lainnya yang ingin Anda cari
            $this->db->group_end();
        }

        // Mengatur order
        $column_order = array('KodeHak', 'JenisHak', 'NamaHak'); // Sesuaikan dengan kolom yang dapat diurutkan
        $column_search = array(); // Kolom yang dapat dicari
        $order_dir = $order['dir'];
        if (!empty ($order['column'])) {
            $this->db->order_by($column_order[$order['column']], $order_dir);
        } else {
            $this->db->order_by('IDHak', 'asc');
        }
        // Menangani paging
        if ($length != -1) {
            $this->db->limit($length, $start);
        }
        $query = $this->db->get('tb_hakakses');
        return $query->result();
    }

    public function DataHakaksesNumber()
    {
        $sql = "SELECT `IDHak`, `KodeHak`, `JenisHak`, `NamaHak` FROM `tb_hakakses` WHERE 1;";
        return $this->db->query($sql)->num_rows();
    }

    function DataHakaksesWhere($where)
    {
        $this->db->where($where);
        $query = $this->db->get('tb_hakakses');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function DataHakaksesCreate($data)
    {
        $this->db->insert('tb_hakakses', $data);
    }

    function DataHakaksesUpdate($where, $data)
    {
        $this->db->where($where);
        $this->db->update('tb_hakakses', $data);
    }

    function DataHakaksesDelete($where)
    {
        $this->db->where($where);
        $this->db->delete('tb_hakakses');
    }

    public function DataJurnalKegiatan($start, $length, $order, $searchValue = null, $where)
    {
        // Menambahkan kondisi pencarian jika ada nilai pencarian yang diberikan
        if ($searchValue !== null) {
            $this->db->group_start();
            $this->db->like('TanggalJurnal', $searchValue);
            $this->db->or_like('Kegiatan', $searchValue);
            $this->db->or_like('Keterangan', $searchValue);
            // tambahkan kondisi pencarian untuk kolom lainnya yang ingin Anda cari
            $this->db->group_end();
        }

        // Mengatur order
        $column_order = array('TanggalJurnal', 'Kegiatan', 'Keterangan'); // Sesuaikan dengan kolom yang dapat diurutkan
        $column_search = array(); // Kolom yang dapat dicari
        $order_dir = $order['dir'];
        if (!empty ($order['column'])) {
            $this->db->order_by($column_order[$order['column']], $order_dir);
        } else {
            $this->db->order_by('IDHak', 'asc');
        }
        // Menangani paging
        if ($length != -1) {
            $this->db->limit($length, $start);
        }
        $this->db->where($where);
        $query = $this->db->get('jurnal_guru_kegiatan');
        return $query->result();
    }
    public function DataJurnalKegiatanNumber($where)
    {
        $this->db->where($where);
        $query = $this->db->get('jurnal_guru_kegiatan');
        return $query->num_rows();
    }

    public function CreateDataJurnalKegiatan($data)
    {
        $this->db->insert('jurnal_guru_kegiatan', $data);
    }

    public function ReadDataJurnalKegiatan($where)
    {
        $this->db->where($where);
        $query = $this->db->get('jurnal_guru_kegiatan');

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    function UpdateDataJurnalKegiatan($where, $data)
    {
        $this->db->where($where);
        $this->db->update('jurnal_guru_kegiatan', $data);
    }

    function DeleteDataJurnalKegiatan($where)
    {
        $this->db->where($where);
        $this->db->delete('jurnal_guru_kegiatan');
    }

    function ReadDataTugasTambahan($where)
    {
        $this->db->where($where);
        $query = $this->db->get('tb_tugastambahan');

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    function DeleteJurnalGuru($where)
    {
        $this->db->where($where);
        $this->db->delete('jurnal_guru_mapel');
    }

    function ReadDataAbsensiGuruPelajaran($where)
    {
        $this->db->select('COUNT(*) AS JumlahData, asm.IDKelasMapel, asm.IDAbsen, asm.IDJampel, asm.TglAbsensi, asm.NisSiswa, asm.JamMasuk, asm.MISA, asm.IDSemester, asm.IDAjaran, jkm.IDKelas AS IDKelasJadwal, jkm.IDMapel AS IDMapelJadwal, jkm.IDGuru AS IDGuruJadwal, jkm.IDAjaran AS IDAjaranJadwal, jkm.Keterangan AS KeteranganJadwal, tg.UsrGuru, tg.KodeGuru, tg.NamaGuru, tg.NomorIndukGuru, tg.KodeMapel AS KodeMapelGuru, tg.IDHak, tg.PassGuru, tg.NomorHP, tg.Status, tm.KodeMapel AS KodeMapelMapel, tm.NamaMapel, tm.Keterangan AS KeteranganMapel, tk.IDKelas, tk.KodeKelas, tk.KodeTahun, tk.KodeGuru AS KodeGuruKelas, tk.IDGuru AS IDGuruKelas, tk.RuanganKelas');
        $this->db->from('absensi_siswa_mapel asm');
        $this->db->join('jadwal_kelas_mapel jkm', 'asm.IDKelasMapel = jkm.IDKelasMapel');
        $this->db->join('tb_guru tg', 'jkm.IDGuru = tg.IDGuru');
        $this->db->join('tb_mapel tm', 'jkm.IDMapel = tm.IDMapel');
        $this->db->join('tb_kelas tk', 'jkm.IDKelas = tk.IDKelas');
        $this->db->group_by('asm.IDKelasMapel');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }

}
?>