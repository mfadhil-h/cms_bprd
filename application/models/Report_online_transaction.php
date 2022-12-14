<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class Report_online_transaction extends CI_Model
{

	var $column_order = array(null, 'merchant_name','branch_name', 'npwp', 'nopd', 'bill_no', 'bill_date', 'total_amount', 'service', 'ppn', 'total_trx_amount', 'payment_type');
    var $column_search = array('merchant_name','branch_name', 'npwp', 'nopd', 'bill_no', 'bill_date', 'total_amount', 'service', 'ppn', 'total_trx_amount', 'payment_type');
    var $order = array('merchant_name' => 'asc');

    public function query($startDate, $endDate, $merchantId, $branchId, $subanId, $billNumber, $type)
    {
    	$this->db->select('
			`merchant`.`merchant_name`  	AS `merchant_name`,
			`branch`.`branch_name`      	AS `branch_name`,
			`branch`.`npwp`             	AS `npwp`,
			`branch`.`nopd`             	AS `nopd`,
			`realheader`.`bill_no`          AS `bill_no`,
			DATE_FORMAT(realheader.bill_date, "%d %M %Y %H:%i:%S")        AS `bill_date`,
			`realheader`.`total_amount`     AS `total_amount`,
			`realheader`.`service`          AS `service`,
			`realheader`.`ppn`              AS `ppn`,
			`realheader`.`total_trx_amount` AS `total_trx_amount`,
			`realheader`.`payment_type`     AS `payment_type`'
		);
		$this->db->from('realheader');
		$this->db->join('branch', '`realheader`.`merchant_id` = `branch`.`merchant_id` AND `realheader`.`branch_id` = `branch`.`branch_id`');
		$this->db->join('merchant','`realheader`.`merchant_id` = `merchant`.`merchant_id`');
		$this->db->join('kecamatan', 'branch.kec_id = kecamatan.kec_id');
		$this->db->where("bill_date BETWEEN '$startDate' AND '$endDate'");
		if ($merchantId != 'ALL') {
			$this->db->where('realheader.merchant_id = '.$merchantId);
			if($branchId != 'ALL') {
				$this->db->where('realheader.branch_id = '.$branchId);
			}	
		}
		if($billNumber != '' || !empty($billNumber)) {
			$this->db->where('realheader.bill_no', $billNumber);
		}

		
		if ($subanId != 'ALL') {
			$this->db->where('kecamatan.suban_id', $subanId);
		}

		$this->db->order_by('realheader.bill_date', 'ASC');

		if ($type == 'dataTable') {
			$this->db->limit($_POST['length'], $_POST['start']);
			$data = $this->db->get();
		} elseif ($type == 'getData') {
			$data = $this->db->get();
		} elseif ($type == 'countAll') {
			$data = $this->db->count_all_results();
		} elseif($type == 'countFiltered') {
			$data = $this->db->get();
		} else {
			$data = $this->db->get();
		}

		return $data;
    }

    public function get_data_tables($startDate, $endDate, $merchantId, $branchId, $subanId, $billNumber)
    {
    	$i = 0;

        foreach ($this->column_search as $item)
        {
            if($_POST['search']['value'])
            {
                 
                if($i===0)
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
         
        if(isset($_POST['order'])) 
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }

        $data = $this->query($startDate, $endDate, $merchantId, $branchId, $subanId, $billNumber, 'dataTable');

        return $data;
    }

	public function get_data($startDate, $endDate, $merchantId, $branchId, $subanId, $billNumber)
	{
		$data  = $this->query($startDate, $endDate, $merchantId, $branchId, $subanId, $billNumber, 'getData');

		return $data;
	}

	public function count_filtered($startDate, $endDate, $merchantId, $branchId, $subanId, $billNumber)
	{
		$data  = $this->query($startDate, $endDate, $merchantId, $branchId, $subanId, $billNumber, 'countFiltered');
		return $data->num_rows();
	}

	public function count_all($startDate, $endDate, $merchantId, $branchId, $subanId, $billNumber)
	{
		$data  = $this->query($startDate, $endDate, $merchantId, $branchId, $subanId, $billNumber, 'countAll');
		return $data;
	}
}

?>