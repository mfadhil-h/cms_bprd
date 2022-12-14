<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class user extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();

		$data = ['class' => 'user'];
		
		$this->load->model('userModels');
		$this->load->model('userPrevilageModels', 'up');
		$this->load->model('Masters', 'master');

		$this->load->library("session");

		$access = [
            'accessModule' => $this->master->user_access($_SESSION['up_id'])
        ];
        
		$this->load->view('main/header', $data);
        $this->load->view('main/global_headbar');
        $this->load->view('main/global_sidebar', $access);
        $this->load->view('main/footer');
	}

	public function index()	
	{
        $dataUser = $this->userModels->get_data()->result();
        $previlage = $this->master->module_access($_SESSION['up_id'], 'mod_user')->row();

        $data = [
        	'fetch' => $dataUser,
        	'rights' => $previlage->ma_previlage
        ];

        $this->load->view('user/index', $data);
	}


	public function create()
	{
		$dataUserPrevilage = $this->up->get_data()->result();
		$dataMerchant = $this->master->get_merchant();
		$dataSuban = $this->master->get_suban()->result();

		$data = [
			'userPrevilages' => $dataUserPrevilage,
			'subans'	=> $dataSuban,
			'merchants'	=> $dataMerchant
		];

		$result = $this->load->view('user/create',$data, true);
        echo json_encode($result,true);
     	exit();
	}

	public function store()
	{
		foreach ($_REQUEST as $key => $value) {
			$$key = $value;
		}

		$data =[
			'up_id'	=> $up_id,
			'username' => $username,
			'password' => md5($password)
		];

		if ($level == 3) {
			$data['suban_id'] = $suban_id;
		} elseif ($level == 4 || $level == 6) {
			$data['merchant_id'] = $merchant_id;
			$data['branch_id'] = $branch_id;
		} elseif ($level == 5) {
			$data['merchant_id'] = $merchant_id;
		}

		$this->db->insert('user', $data);
		redirect('user/index');
	}

	public function before_saving() 
	{		
		foreach ($_REQUEST as $key => $value) {
			$$key = $value;
		}

		if (count($_REQUEST) > 1) {
			$this->db->select('*');
			$this->db->from('user');
			$this->db->where('username', $username);
			$this->db->where_not_in('id', $id);
			$userData = $this->db->get()->num_rows();
		} else {
			$userData = $this->db->get_where('user', ['username' => $username])->num_rows();
		}


		if ($userData > 0){
			$result = [
				'res' => false,
				'message' => 'User name sudah tersedia'
				];
		} else {
			$result = [
				'res' => true,
				'message' => 'Data berhasil dihapus!'
			];
		}

		echo json_encode($result, true);
		exit();
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('user');

		redirect('user/index');
	}

	public function edit()
	{
		foreach ($_REQUEST as $key => $value) {
			$$key = $value;
		}

		$dataUser 			= $this->db->get_where('user', ['id' => $id])->row(); 
		$branch_id 			= $dataUser->branch_id;
		$merchant_id 		= $dataUser->merchant_id;
		$branch = null;

		if ($merchant_id != null && $branch_id != null) {
			$branch = $this->db->get_where('branch', ['merchant_id' => $merchant_id])->result();
		}

		$dataUserPrevilage 	= $this->up->get_data()->result();
		$dataMerchant 		= $this->master->get_merchant();
		$dataSuban 			= $this->master->get_suban()->result();
		$user 				= $this->userModels->get_data($id)->result();
		
		$data = [
			'userPrevilages' 	=> $dataUserPrevilage,
			'subans'			=> $dataSuban,
			'merchants'			=> $dataMerchant,
			'branchs'			=> $branch,
			'row'				=> $user
		];

		$result = $this->load->view('user/edit',$data, true);
        echo json_encode($result,true);
     	exit();
	}

	public function save()
	{
		foreach ($_REQUEST as $key => $value) {
			$$key = $value;
		}

		$data =[
			'up_id'	=> $up_id,
			'username' => $username
		];

		if ($level == 3) {
			$data['suban_id'] = $suban_id;
		} elseif ($level == 4 || $level == 6) {
			$data['merchant_id'] = $merchant_id;
			$data['branch_id'] = $branch_id;
		} elseif ($level == 5) {
			$data['merchant_id'] = $merchant_id;
		}

		$this->db->where('id', $id);
    	$this->db->update('user', $data);

    	redirect('user/index');
	}

}
?>