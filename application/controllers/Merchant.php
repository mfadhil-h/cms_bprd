<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class merchant extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();

		$data = ['class' => 'merchant'];

		$this->load->model('merchantModels', 'mrc');
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
		$previlage = $this->master->module_access($_SESSION['up_id'], 'mod_merchant')->row();
        $data = [
        	'rights' => $previlage->ma_previlage
        ];

        $this->load->view('merchant/index', $data);
        $this->load->view('main/global_footbar');
	}


	public function get_merchant_data() {
				
		$merchants = $this->mrc->get_all_merchant()->result();
		
		$row = [];
		$data = [];
		$previlage = $this->master->module_access($_SESSION['up_id'], 'mod_merchant')->row();
		foreach ($merchants as  $rowMerchant) {
			$row = [];
			$row[] = $rowMerchant->merchant_name;
			$row[] = $rowMerchant->shared_key;
			$row[] = $rowMerchant->date_format;
			$row[] = $rowMerchant->no_tlp;
			$row[] = $rowMerchant->email;
			$row[] = $rowMerchant->owner_name;
			$row[] = $rowMerchant->owner_location;
			if ($previlage->ma_previlage == 3) {
				$row[] = '
					<a data-merchant-id="'.$rowMerchant->merchant_id.'" class="edit-control ext-light mr-3 font-16" data-toggle="tooltip" title="Edit Data"><i class="fa fa-pencil"></i></a>
					<a href="'.base_url('merchant/delete/'.$rowMerchant->merchant_id).' "data-merchant-id="'.$rowMerchant->merchant_id.'" class="delete-control ext-light mr-3 font-16" data-toggle="tooltip" title="Hapus Data"><i class="fa fa-trash"></i></a>';
			}
			$data[] = $row;
		}

		$output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->mrc->count_all(),
            "recordsFiltered" => $this->mrc->count_filtered(),
            "data" => $data,
        );

        echo json_encode($output);
        exit();
	}

	public function create()
	{
		foreach ($_REQUEST as $key => $value) {
        	$$key = $value;
      	}

	    $data = [];

	    $result = $this->load->view('merchant/create', $data, true);

	    echo json_encode($result,true);
	    exit();
	}



	public function store()
	{
		foreach ($_REQUEST as $key => $value) {
			$$key = $value;
		}

		$data = [
			'merchant_name'		=> $merchant_name,
			'shared_key' 		=> '10My04MAN2018',
			'date_format' 		=> $date_format,
			'no_tlp' 			=> $no_tlp,
			'email' 			=> $email,
			'created' 			=> date('Y-m-d H:i:s'),
			'modified'			=> date('Y-m-d H:i:s'),
			'owner_name' 		=> $owner_name,
			'owner_location' 	=> $owner_location,
			'pos_code'			=> $pos_code,
			'rt'				=> $rt,
			'rw'				=> $rw
		];

		$this->db->insert('merchant',$data);
		redirect('merchant/index');
	}

	public function before_saving() 
	{		
		foreach ($_REQUEST as $key => $value) {
			$$key = $value;
		}
		
		if (count($_REQUEST) > 1) {
			$this->db->select('*');
			$this->db->from('merchant');
			$this->db->where('merchant_name', $_REQUEST['merchant_name']);
			$this->db->where_not_in('merchant_id', $_REQUEST['merchant_id']);
			$query = $this->db->get();
		} else {
			$query = $this->db->get_where('merchant', array('merchant_name' => $_REQUEST['merchant_name']));
		}
		
		if ($query->num_rows() > 0){
			$result = [
				'res' => false,
				'message' => 'Nama Waijib Pajak sudah tersedia.'
				];
		} else {
			$result = [
				'res' => true,
				'message' => 'Data berhasil disimpan!'
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

		$query = $this->db->get_where('branch', ['merchant_id' => $merchant_id]);
		$queryHeader = $this->db->get_where('header', ['merchant_id' => $merchant_id]);

		if ($query->num_rows() > 0 || $queryHeader->num_rows() > 0) {
			$result = [
				'res' => false,
				'message' => 'Wajib Pajak tidak bisa dihapus'
			];
		} else {
			$result = [
				'res' => true,
				'message' => 'Data berhasil dihapus'
			];
		}
		echo json_encode($result);
		exit();
	}

	public function edit()
	{
		$merchants = $this->db->get_where('merchant',array('merchant_id'=>$_REQUEST['merchant_id']))->result();

		$data = [
			'merchant' => $merchants
			];

		$result = $this->load->view('merchant/edit', $data, true);

	    echo json_encode($result,true);
	    exit();
	}

	public function save()
	{
		foreach ($_REQUEST as $key => $value) {
			$$key = $value;
		}

		$data = [
			'merchant_name'		=> $merchant_name,
			'shared_key' 		=> '10My04MAN2018',
			'date_format' 		=> $date_format,
			'no_tlp' 			=> $no_tlp,
			'email' 			=> $email,
			'modified'			=> date('Y-m-d H:i:s'),
			'owner_name' 		=> $owner_name,
			'owner_location' 	=> $owner_location,
			'pos_code'			=> $pos_code,
			'rt'				=> $rt,
			'rw'				=> $rw
		];

		$this->db->where('merchant_id', $merchant_id);
		$this->db->update('merchant', $data);

    	redirect('merchant/index');
	}

	public function delete($req)
	{	
		$this->db->where('merchant_id', $req);
		$this->db->delete('merchant');

		redirect('merchant/index');
	}
}
?>