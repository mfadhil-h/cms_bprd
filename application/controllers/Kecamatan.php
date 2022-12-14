<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class kecamatan extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();

		$data = ['class' => 'kecamatan'];
		$this->load->model('subans', 'suban');
		$this->load->model('kecamatanModels', 'kec');
		$this->load->model('branchModels', 'branch');
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
		$subanId = null;
		if ($_SESSION['level'] == 3) {
			$subanId = $_SESSION['suban_id'];
		}

		$fetch = $this->kec->getKec($subanId);
		$row = [];
		$previlage = $this->master->module_access($_SESSION['up_id'], 'mod_kec')->row();
		
		foreach ($fetch as $key => $value) {
			$getBranch = $this->db->get_where('branch',array('kec_id'=>$value['kec_id']))->result_array();
			if (count($getBranch) > 0) {
				array_push($row, $value['kec_id']);
			}
		}

		$data = [
			'fetch' => $fetch,
			'kec'	=> $row,
			'rights' => $previlage->ma_previlage
		];

        $this->load->view('kecamatan/index', $data);
        $this->load->view('main/global_footbar');
	}

	public function create()
	{	
		$subanId = null;
		if ($_SESSION['level'] == 3) {
			$subanId = $_SESSION['suban_id'];
		}
		
		$suban = $this->suban->getSuban($subanId);
		$data = ['subans' => $suban];
		$this->load->view('kecamatan/create', $data);
        $this->load->view('main/global_footbar');
	}

	public function before_saving()
	{
		foreach ($_REQUEST as $key => $value) {
			$$key = $value;
		}

		$return = 'true';
		$kecamatan = $this->kec->getKec();

		foreach ($kecamatan as $rowKecamatan) {
			$kecName = strtoupper($rowKecamatan['kec_name']);
			if (strtoupper($kec_name) == $kecName) {
				$return = 'false';
				break;
			}
		}

		$res = array(
                "STATUS" => $return
		);

		echo json_encode($res);
	}

	public function store()
	{
		foreach ($_REQUEST as $key => $value) {
			$$key = $value;
		}

		$data = [
			'suban_id' => $suban_id,
			'kec_name' => $kec_name,
			'created_at' => date('Y-m-d H:i:s')
		];

		$this->db->insert('kecamatan',$data);

		redirect('kecamatan/index');
	}

	public function edit($req)
	{
		$subanId = null;
		if ($_SESSION['level'] == 3) {
			$subanId = $_SESSION['suban_id'];
		}

		$row 	= $this->db->get_where('kecamatan',array('kec_id'=>$req))->result_array();
		$suban 	= $this->suban->getSuban($subanId);
		$data 	= [
					'subans' => $suban,
					'row' => $row[0]
		];

		$this->load->view('kecamatan/edit', $data);
        $this->load->view('main/global_footbar');
	}

	public function save()
	{
		foreach ($_REQUEST as $key => $value) {
			$$key = $value;
		}

		$data = [ 
			'suban_id' 	=> $suban_id,
			'kec_name' 	=> $kec_name,
			'updated_at'=> date('Y-m-d H:i:s')];
			
		$this->db->where('kec_id', $kec_id);
    	$this->db->update('kecamatan', $data);


		redirect('kecamatan/index');
	}

	public function before_delete()
	{
		foreach ($_REQUEST as $key => $value) {
			$$key = $value; 
		}
		
		$kec = [ 'kec_id' => $kec_id ];

		$return = 'true';
		$branch = $this->branch->getBranchByKec($kec);
		if (count($branch) > 0) {
			$return = 'false';
		}

		$res = array(
                "STATUS" => $return
		);

		echo json_encode($res);

	}

	public function delete($req)
	{
		$row = $this->db->get_where('branch',array('kec_id'=>$req))->result_array();
		if (count($row) > 0) {
			redirect('kecamatan/index');
		} else {
			$this->db->where('kec_id', $req);
			$this->db->delete('kecamatan');

			redirect('kecamatan/index');
		}
	}
}
?>