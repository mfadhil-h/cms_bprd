<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class sptpd extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();

		$data = ['class' => 'sptpd'];

		$this->load->model('subans', 'suban');
		$this->load->model('branchModels', 'branch');
		$this->load->model('payments');
		$this->load->model('kecamatanModels', 'kec');

		$this->load->library("session");

		$this->load->view('main/header', $data);
        $this->load->view('main/footer');
	}

	public function report($month, $year, $merchantId, $branchId)
	{	
		$query = $this->payments->getPayment($merchantId, $branchId, $month, $year);
		$data = $query->result_array();
		

		$dataKecamatan = $this->kec->getKecByBranch($merchantId, $branchId);
		$data['kecamatan_name'] = $dataKecamatan['kec_name'];

		$dataBranch = $this->branch->getBranchByid($branchId, $merchantId);
		$dataMerchant = $this->db->get_where('merchant', ['merchant_id' => $merchantId])->row();
		$data['month'] = $month;
		$data['year'] = $year;
		$data['npwp'] = $dataBranch['npwp'];
		$data['nopd'] = $dataBranch['nopd'];
		$data['alamat']= $dataBranch['location'];
		$data['merchant'] = $dataMerchant;
		
		$dataResult = [
			'fetch' => $data
		];
		
		$this->load->view('report/sptpd', $dataResult);
	}

}
?>