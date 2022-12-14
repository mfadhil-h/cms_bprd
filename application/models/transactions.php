<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class transactiohModels extends CI_Model
{
	public function get_data($startDate, $endDate, $merchantId, $branchId, $billNumber)
	{
		$this->db->select('
			`merchant`.`merchant_name`  	AS `merchant_name`,
			`branch`.`branch_name`      	AS `branch_name`,
			`branch`.`npwp`             	AS `npwp`,
			`branch`.`nopd`             	AS `nopd`,
			`header`.`bill_no`          AS `bill_no`,
			`header`.`bill_date`        AS `bill_date`,
			`header`.`total_amount`     AS `total_amount`,
			`header`.`service`          AS `service`,
			`header`.`ppn`              AS `ppn`,
			`header`.`total_trx_amount` AS `total_trx_amount`,
			`header`.`payment_type`     AS `payment_type`'
		);
		$this->db->from('header');
		$this->db->join('branch', '`header`.`merchant_id` = `branch`.`merchant_id` AND `header`.`branch_id` = `branch`.`branch_id`');
		$this->db->join('merchant','`header`.`merchant_id` = `merchant`.`merchant_id`');
		$this->db->where("bill_date BETWEEN '$startDate' AND '$endDate'");
		if ($merchantId != 'ALL') {
			$this->db->where('header.merchant_id = '.$merchantId);
			if($branchId != 'ALL') {
				$this->db->where('header.branch_id = '.$branchId);
			}	
		}
		if($billNumber != '' || !empty($billNumber)) {
			$this->db->where('header.bill_no = '.$billNumber);
		}
		return $this->db->get();

	}
}

?>