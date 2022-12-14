<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class suban extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();

		$data = ['class' => 'suban'];

		$this->load->model('subans', 'suban');
		$this->load->model('kecamatanModels', 'kec');
		$this->load->model('Masters', 'master');
		
		$access = [
            'accessModule' => $this->master->user_access($_SESSION['up_id'])
        ];
		$this->load->library("session");

		$this->load->view('main/header', $data);
        $this->load->view('main/global_headbar');
        $this->load->view('main/global_sidebar', $access);
        $this->load->view('main/footer');
	}

	public function index()
	{
		$data = $this->db->get('suban')->result_array();
		$previlage = $this->master->module_access($_SESSION['up_id'], 'mod_suban')->row();
		$data = [
			'fetch' => $data,
			'rights' => $previlage->ma_previlage
		];
        $this->load->view('suban/index', $data);
        $this->load->view('main/global_footbar');

	}

	public function create()
	{
		$this->load->view('suban/create');
        $this->load->view('main/global_footbar');	
	}

	public function store()
	{
		foreach ($_REQUEST as $key => $value) {
			$$key = $value;
		}

		$data = ['suban_name' => $suban_name,
				'created_at' => date('Y-m-d H:i:s')];

		$this->db->insert('suban',$data);
		$this->session->set_flashdata('success','Failed To 
        inserted Product');
		redirect('suban/index', 'refresh');
	}

	public function before_saving() 
	{
		var_dump('s'); exit();
		foreach ($_REQUEST as $key => $value) {
			$$key = $value;
		}
		
		$return 	= 'true';
		$subansData = $this->suban->getSuban();
		foreach ($subansData as $suban) {
			$subanName = strtoupper($suban['suban_name']);
			if ($subanName == strtoupper($suban_name)) {
				$return = 'false';
				break;
			}
		}

		$res = array(
                "STATUS" => $return
		);

		echo json_encode($res);
	}

	public function before_delete()
	{
		foreach ($_REQUEST as $key => $value) {
			$$key = $value;	
		}

		$suban 		= ['suban_id' => $suban_id];
		$kecData	= $this->kec->getKecBySuban($suban);
		
		$return		= 'true';
		
		if (count($kecData) > 0) {
			$return = 'false';
		}

		$res = [
			'status' => $return
		];

		echo json_encode($res);
	}

	public function edit($req)
	{
		$suban = $this->db->get_where('suban',array('suban_id'=>$req))->result_array();

		if (count($suban) > 0) {
			$dataSuban = $suban['0'];

			$data = ['suban_id'		=> $dataSuban['suban_id'],
				 'suban_name'	=> $dataSuban['suban_name']
			];
			$this->load->view('suban/edit', $data);
        	$this->load->view('main/global_footbar');
		}
	}

	public function save()
	{
		foreach ($_REQUEST as $key => $value) {
			$$key = $value;
		}

		$data = ['suban_name' => $suban_name,
				'updated_at' => date('Y-m-d H:i:s')];
		
		$this->db->where('suban_id', $suban_id);
    	$this->db->update('suban', $data);

    	redirect('suban/index');
	}

	public function delete($req)
	{	
		$this->db->where('suban_id', $req);
		$this->db->delete('suban');

		redirect('suban/index');
	}
}
?>