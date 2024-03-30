<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

require_once APPPATH . 'libraries/PhpSpreadsheet/autoload.php';

class v2 extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_API');
        $this->load->helper(array('form', 'url', 'cookie'));
        $this->load->library('upload');
    }

    private function convertDate($date_str)
    {
        $timestamp = strtotime($date_str); // Mengonversi tanggal ke UNIX timestamp
        return $formatted_date = date('Y-m-d', $timestamp); // Mengonversi timestamp ke format Y-m-d
    }

    public function AbsensiGuruMapel()
    {
        $result = array(
            'status' => 'debug',
            'msg' => 'connected!'
        );
        if ($this->input->method() === 'get' && $this->input->get('Token') !== null) {
            $where = array(
                'jkm.IDGuru' => $this->input->get('Token')
            );
            $result['status'] = 'Ada';
            $result['msg'] = 'connected!';
            $result['data'] = $this->M_API->ReadDataAbsensiGuruPelajaran($where);
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }
}