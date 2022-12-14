<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signin extends CI_Controller {

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
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct()
	{
		parent::__construct();

		$this->load->model('Masters');
	}

	public function index()
	{
		$this->load->view('signin/header');
		$this->load->view('signin/form');
		$this->load->view('signin/footer');
	}

	public function verify()
	{
		$params = $this->input->post();
		$result = $this->db->query("SELECT * FROM user WHERE username='".$params['username']."' and password='".md5($params['password'])."' ");
		//$result = $this->db->get_where('users',array('username'=>$params['username'],'password'=>md5($params['password'])));

		$res = $this->Masters->login($params['username'], md5($params['password']))->row();
		

		
		if(count($res) > 0)
		{

			$data ['user_id'] 		= $res->id;
			$data ['up_id'] 		= $res->up_id;
			$data ['username'] 		= $res->username;
			$data ['level'] 		= $res->up_level;
			$data ['suban_id'] 		= $res->suban_id;
			$data ['merchantid'] 	= $res->merchant_id;
			$data ['branchid'] 		= $res->branch_id;

			if($res->up_level == 4){
				$query = $this->db->get_where('branch',array('merchant_id'=>$data['merchantid']));
				$data_query = $query->row_array();
				$data['npwp'] = $data_query['npwp'];
			} else if ($res->up_level == 5) {
				$merchant_name = $this->db->get_where('merchant', ['merchant_id' => $res->merchant_id])->row();
				$data['merchant_name'] = $merchant_name->merchant_name;
			} else if ($res->up_level == 6) {
				$branch_name = $this->db->get_where('branch', ['merchant_id' => $res->merchant_id,  'branch_id' =>$res->branch_id])->row();
				$data['branch_name'] = $branch_name->branch_name;
			} else {
				$data['npwp'] = null;
			}
		
			$data['islogin']  = true;
			$this->set_session($data);
			redirect(base_url('welcome/'));


			
		}else{
			redirect(base_url());
		}
	}

	private function set_session($data)
	{
		$this->session->set_userdata($data);
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url());
	}

}
