<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class kecamatanModels extends CI_Model
{
	public function getKec($subanId = null)
	{	
		$this->db->select('kec.kec_id, kec.kec_name, suban.suban_name');
		$this->db->from('kecamatan AS kec');
		$this->db->join('suban', 'kec.suban_id = suban.suban_id');
		if (!empty($subanId)) {
			$this->db->where('kec.suban_id ='.$subanId);
		}
		$query = $this->db->get();

		return $query->result_array();
	}

	public function getKecBySuban($suban)
	{
		$query = $this->db->get_where('kecamatan', $suban)->result_array();
		return $query;
	}

	public function getKecByBranch($merchantId, $branchId)
	{
		$this->db->select('kec.kec_id, kec.kec_name');
		$this->db->from('kecamatan as kec');
		$this->db->join('branch', 'kec.kec_id = branch.kec_id');
		$this->db->where('branch.branch_id =', $branchId);
		$this->db->where('branch.merchant_id =', $merchantId);
		$query = $this->db->get();
		return $query->row_array();
	}
}

?>