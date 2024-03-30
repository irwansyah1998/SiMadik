<?php

class M_WhatsApp extends CI_Model
{
    public function __construct(){
    	parent::__construct();
    	$this->load->database();
	}

    public function ReadDataSessionsConnected()
    {
        $where = array(
            'status'=>'CONNECTED',
        );
        $this->db->order_by('whatsapp_number', 'asc');
        $this->db->where($where);
        $this->db->where('user_id !=','1');
        $query = $this->db->get('sessions');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function ReadDataSessionsConnectedBy($where)
    {
        $this->db->order_by('whatsapp_number', 'asc');
        $this->db->where($where);
        $query = $this->db->get('sessions');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function ReadDataSessionsConnectedByArray($where)
    {
        $this->db->order_by('whatsapp_number', 'asc');
        $this->db->where($where);
        $query = $this->db->get('sessions');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result_array();
        }
    }
}