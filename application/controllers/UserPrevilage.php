<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class UserPrevilage extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();

		$data = ['class' => 'userprevilage'];

		$this->load->model('userPrevilageModels', 'userprev');
		

		$this->load->library("session");
		$this->load->model('Masters', 'master');
		
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
        $dataUserPrevilage = $this->userprev->get_data()->result();
        $previlage = $this->master->module_access($_SESSION['up_id'], 'mod_up')->row();

        $data = [
        	'fetch' 	=> $dataUserPrevilage,
        	'rights' 	=> $previlage->ma_previlage
        ];

        $this->load->view('userprevilage/index', $data);
        $this->load->view('main/global_footbar');
	}


	public function create()
	{
		$data = [];
		$result = $this->load->view('userprevilage/create',null, true);
        echo json_encode($result,true);
     	exit();	
	}


	public function store()
	{
		foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }

        
        $data = [
        	'up_name' 		=> $up_name,
        	'up_level' 		=> $up_level,
        	'created_at'    => date('Y-m-d H:i:s'),
        	'created_by'    => $_SESSION['username']
        ];

        $this->db->insert('userprevilage',$data);

        $this->db->select('up_id');
        $this->db->from('userprevilage');
        $this->db->order_by('up_id', 'desc');
        $up_id = $this->db->get()->row();
        
        
        $moduleData = $this->db->get('module')->result();
        
        $data = [];
        foreach ($moduleData as $value) {
        	$row = [];
        	$row ['mod_id'] 		= $value->mod_id;
        	$row ['up_id'] 			= $up_id->up_id;
        	$row ['ma_previlage'] 	= 1 ;
        	$row ['ma_approver'] 	= '2';
        	$row ['created_at']		= date('Y-m-d H:i:s');
        	$row ['created_by']		= $_SESSION['username'];

        	$data[] = $row;
        }
        $this->db->insert_batch('moduleaccess', $data);


        redirect('UserPrevilage/index');
	}

	public function before_saving() 
	{		
		foreach ($_REQUEST as $key => $value) {
			$$key = $value;
		}

		if (count($_REQUEST) > 1) {
			$this->db->select('*');
			$this->db->from('userprevilage');
			$this->db->where('up_name', $up_name);
			$this->db->where_not_in('up_id', $up_id);
			$query = $this->db->get();
		} else {
			$query = $this->db->get_where('userprevilage', ['up_name' => $up_name]);
		}
		
		
		if ($query->num_rows() > 0){
			$result = [
				'res' => false,
				'message' => 'Nama Hak akses sudah digunakan, silahkan ganti dengan nama yang lain.'
				];
		} else {
			$result = [
				'res' => true,
				'message' => 'Data Berhasil disimpan!'
			];
		}

		echo json_encode($result, true);
		exit();
	}

	public function before_delete()
	{
		foreach ($_REQUEST as $key => $value) {
			$$key = $value;
		}

		$dataUser = $this->db->get_where('user', ['up_id' => $up_id]);
		
		if ($dataUser->num_rows() > 0) {
			$result = [
				'res' => false,
				'message' => 'Hak Akses tidak bisa dihapus, Hak Akses sudah digunakan oleh user.'
			];
		} else {
			$result = [
				'res' => true,
				'message' => 'Data Berhasil dihapus !'
			];
		}

		echo json_encode($result);
		exit();
	}

	public function edit()
	{
		foreach ($_REQUEST as $key => $value) {
			$$key = $value;
		}

		$dataUserPrevilage = $this->userprev->get_data($up_id)->result();

		$data = [
			'row' => $dataUserPrevilage
		];
		$result = $this->load->view('userprevilage/edit',$data, true);
        echo json_encode($result,true);
     	exit();

	}

	public function save()
	{
		foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }

         $data = [
        	'up_name' 		=> $up_name,
        	'up_level' 		=> $up_level,
        	'modified_at'   => date('Y-m-d H:i:s'),
        	'modified_by'   => $_SESSION['username']
        ];

        $this->db->where('up_id', $up_id);
        $this->db->update('userprevilage', $data);
        redirect('UserPrevilage/index');
	}

	public function delete($req)
	{	
		$this->db->query('SET FOREIGN_KEY_CHECKS=0;');
		$this->db->where('up_id', $req);
		$this->db->delete('userprevilage');

		$this->db->query('SET FOREIGN_KEY_CHECKS=1;');

		redirect('UserPrevilage/index');
	}

	public function give_access()
	{
		foreach ($_REQUEST as $key => $value) {
			$$key = $value;
		}


		$row = $this->userprev->get_module_access($up_id)->result();
		$data = [
			'fetch' => $row
		];

		$result = $this->load->view('userprevilage/access',$data, true);
        echo json_encode($result,true);
     	exit();
	}

	public function save_access()
	{
		foreach ($_REQUEST as $key => $value) {
			$$key = $value;
		}

		$countModule = $this->db->get('module')->num_rows();

		for ($i = 0; $i < $countModule ; $i++) { 
			$data = [];
			$data = [
				'ma_previlage' 	=> ${'ma_previlage_'.$i},
				'ma_approver'	=> ${'ma_approver_'.$i},
				'modified_at'   => date('Y-m-d H:i:s'),
        		'modified_by'   => $_SESSION['username']
			];

			$this->db->where('up_id', $up_id);
			$this->db->where('mod_id', ${'mod_id_'.$i});
        	$this->db->update('moduleaccess', $data);	
		}

		redirect('UserPrevilage/index');
	}
}
?>