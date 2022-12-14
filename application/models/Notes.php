<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class notes extends CI_Model
{
	public function headerTableName($date, $year, $month)
	{
		$table = 'header';
		
		if(!empty($date)) {
			$monthNow = date('m');
			$yearNow = date('Y');
			$monthParam = date('m', strtotime($date));
			$yearParam = date('Y', strtotime($date));


			if ($yearParam < 2019) {
				$table ='bprdwarehouse.headerunder2019';
			}else if ($yearParam != $yearNow) {
				$table = 'bprdwarehouse.header'.$yearParam.$monthParam;
			} else if ($yearParam == $yearNow && $monthNow - $monthParam > 1 ) {
				$table = 'bprdwarehouse.header'.$yearParam.$monthParam;
			}
		} else {
			$monthNow = date('m');
			if ($year < 2019) {
				$table ='bprdwarehouse.header';
			}else if ($year != date('Y')) {
				$table = 'bprdwarehouse.header'.$year.($month < 10 ? '0'.$month : $month );
			} else if ($year == date('Y') && $monthNow - $month > 1 ) {
				$table = 'bprdwarehouse.header'.$year.($month < 10 ? '0'.$month : $month );
			}
		}

		return $table;
	}

	public function get_data_warehouse($param, $table)
	{
		$this->db->select('
			h.`id` AS id,
			h.`adjustment_value`  AS adjustment_value,
			h.`ppn_adjustment` AS ppn,
			h.`note` AS note,
			h.`bill_no` AS bill_number,
			h.`bill_date` AS date_transaction,
			YEAR(h.`bill_date`) AS year,
			MONTH(h.bill_date) AS month,
			h.`merchant_id` AS merchant_id,
			h.`branch_id` AS branch_id'
		);

		$this->db->from($table.' as h');
		$this->db->where($param);
		$this->db->where('adjustment_value is not null');
		$query = $this->db->get();

		return $query;
	}
	public function get_tax_value($bill_no, $month, $year) {
		$table = 'header';
		$resConnect = $this->dbConnection($year, intval($month));

		if ($resConnect != 'default') {
			$table = 'bprdwarehouse.headerunder2019';

        	if ($year >= 2019) {
    			$table = 'bprdwarehouse.header'.$year.$month;
    		}
		}

		$this->db->select('h.`ppn_dpp`');
		$this->db->from($table.' as h');
		$this->db->where('h.bill_no', $bill_no);
		$query = $this->db->get();

		return $query;
	}

	public function getBillNo($merchantId, $branchId, $date)
	{
		$year = date('Y', strtotime($date));
		$month = date('m', strtotime($date));
		$table = 'header';
		$resConnect = $this->dbConnection($year, intval($month));

		if ($resConnect != 'default') {
			$table = 'bprdwarehouse.headerunder2019';

        	if ($year >= 2019) {
    			$table = 'bprdwarehouse.header'.$year.$month;
    		}
		}

		$dateMin = $date.' 00:00:00';
		$dateMax = $date.' 23:59:59';
		$this->db->select('head.bill_no');
		$this->db->from($table.' as head');
		$this->db->where('head.merchant_id', $merchantId);
		$this->db->where('head.branch_id', $branchId);
		$this->db->where("bill_date BETWEEN '$dateMin' AND '$dateMax'");
		$query = $this->db->get();
        
        return $query;
	}

	public function dbConnection($year, $month)
	{
		$monthNow 	= date('m');
        $yearNow 	= date('Y');

		$connection = 'default';

        if ($year != $yearNow || ($year == $yearNow && $monthNow - $month > 1) ) {
        	$connection = 'warehouse';
        }

        return $connection;
	}

	public function get_data_transaction($merchant_id, $branch_id, $year, $month)
	{	
		$table = 'header';
		$resConnect = $this->dbConnection($year, $month);

		if ($resConnect != 'default') {
			$table = 'bprdwarehouse.headerunder2019';

        	if ($year >= 2019) {
    			$table = 'bprdwarehouse.header'.$year.($month < 10 ? '0'.$month : $month);
    		}
		}

		/*$this->db->select('bill_no');
		$this->db->from($table);
		$this->db->where('merchant_id', $merchant_id);
		$this->db->where('branch_id', $branch_id);
		$this->db->where('YEAR(bill_date)', $year);
		$this->db->where('MONTH(bill_date)', $month);
		$not_in = $this->db->get()->result_array();

		foreach ($not_in as $key => $value) {
			$data_not[] = $value['bill_no'];
		}*/

		$this->db->select('
			merchant.merchant_name as merchant_name,
			branch.branch_name as branch_name,
			head.ppn as ppn,
			head.bill_no as bill_no,
			head.bill_date as bill_date,
			head.ppn_dpp as ppn');
		$this->db->from($table.' as head');
		$this->db->join('merchant', 'head.merchant_id = merchant.merchant_id');
		$this->db->join('branch', '`head`.`merchant_id` = `branch`.`merchant_id` AND `head`.`branch_id` = `branch`.`branch_id`');
		$this->db->where('head.merchant_id', $merchant_id);
		$this->db->where('head.branch_id', $branch_id);
		$this->db->where('YEAR(head.bill_date)', $year);
		$this->db->where('MONTH(head.bill_date)', $month);
		$query = $this->db->get();
/*
		$this->db->select("`merchant`.`merchant_name` AS `merchant_name`, `branch`.`branch_name` AS `branch_name`, '-' AS `ppn`, '-' AS `bill_no`,'-' AS `bill_date`, `noteadjustment`.`adjustment_value` AS `adjustment_value`");
		$this->db->from('noteadjustment');
		$this->db->join('merchant', 'noteadjustment.merchant_id = merchant.merchant_id');
		$this->db->join('branch', '`noteadjustment`.`merchant_id` = `branch`.`merchant_id` AND `noteadjustment`.`branch_id` = `branch`.`branch_id`');
		$this->db->where('merchant.merchant_id', $merchant_id);
		$this->db->where('branch.branch_id', $branch_id);
		$this->db->where('noteadjustment.year', $year);
		$this->db->where('noteadjustment.month', $month);
		$this->db->where_not_in('bill_number', $data_not);
		$query2 = $this->db->get_compiled_select();

		$query = $this->db->query($query1." UNION ".$query2);*/
		return $query;
	}
}

?>