<?php

class M_PdfPrint extends CI_Model
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
        	return false;
    	} else {
        	return $query->result();
    	}
	}
}