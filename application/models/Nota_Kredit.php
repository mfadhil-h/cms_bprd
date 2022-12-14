<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class Nota_Kredit extends CI_Model
{
	public function getTotalTaxByBranchType($date_start,$date_end){

		//$subquery = $this->getTaxByMerchant($date_start,$date_end);
		//var_dump($subquery);
		//exit();
		$this->db->select('h.merchant_id, h.branch_id, SUM(h.ppn_dpp) as totalperoutlet');
		$this->db->from('header h');
		$this->db->where("h.bill_date BETWEEN '$date_start' AND '$date_end'");
		$this->db->group_by('h.merchant_id, h.branch_id');
		 $subquery = $this->db->get_compiled_select();
		

		//$this->db->_reset_select(); 
		$this->db->select('br.bt_desc, COALESCE(SUM(t1.totalperoutlet),0) AS total');
        $this->db->from('branchtype br');
        $this->db->join('branch b', 'br.bt_id = b.bt_id','Left');
		$this->db->join("($subquery)  t1",'t1.merchant_id = b.merchant_id AND t1.branch_id = b.branch_id','Left');
		$this->db->group_by('br.bt_desc');
        $query = $this->db->get();
        return $query;
	}

	public function getTotalTax($date_start,$date_end){
		$this->db->select('SUM(h.ppn_dpp) as total');
		$this->db->from('header h');
		$this->db->where("h.bill_date BETWEEN '$date_start' AND '$date_end'");
		$query = $this->db->get();
        return $query;
	}
}

?>