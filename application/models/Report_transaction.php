<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class Report_transaction extends CI_Model
{

	var $column_order = array(null, 'merchant_name','branch_name', 'npwp', 'nopd', 'bill_no', 'bill_date', 'total_amount', 'service', 'ppn', 'total_trx_amount', 'payment_type');
    var $column_search = array('merchant_name','branch_name', 'npwp', 'nopd', 'bill_no', 'bill_date', 'total_amount', 'service', 'ppn', 'total_trx_amount', 'payment_type');
    var $order = array('merchant_name' => 'asc');

    public function dbConnection($year, $month)
	{
		$monthNow 	= date('m');
        $yearNow 	= date('Y');

		$connection = 'default';
		if ($monthNow!='01') {
			if ($year != $yearNow || ($year == $yearNow && $monthNow - $month > 1) ) {
	        	$connection = 'warehouse';
	        }
		}
        

        return $connection;
	}

    public function query($startDate, $endDate, $merchantId, $branchId, $billNumber, $subanId = 'ALL', $type)
    {

		$month = date('m',strtotime($startDate));
		$year = date('Y', strtotime($startDate));		
		$table ='header';
		$resConnect = $this->dbConnection($year, $month);

		if ($resConnect != 'warehouse') {
			$this->db->select('
				`merchant`.`merchant_name`  	AS `merchant_name`,
				`branch`.`branch_name`      	AS `branch_name`,
				`branch`.`npwp`             	AS `npwp`,
				`branch`.`nopd`             	AS `nopd`,
				`'.$table.'`.`bill_no`          	AS `bill_no`,
				DATE_FORMAT('.$table.'.bill_date, "%d %M %Y")       AS `bill_date`,
				`'.$table.'`.`total_amount`     	AS `total_amount`,
				`'.$table.'`.`service`          	AS `service`,
				`'.$table.'`.`ppn`              	AS `ppn`,
				`'.$table.'`.`total_trx_amount` 	AS `total_trx_amount`,
				`'.$table.'`.`payment_type`     	AS `payment_type`'
			);
			$this->db->from($table);
			$this->db->join('branch', '`'.$table.'`.`merchant_id` = `branch`.`merchant_id` AND `'.$table.'`.`branch_id` = `branch`.`branch_id`');
			$this->db->join('merchant','`'.$table.'`.`merchant_id` = `merchant`.`merchant_id`');
			$this->db->join('kecamatan', 'branch.kec_id = kecamatan.kec_id');
			$this->db->where("bill_date BETWEEN '$startDate' AND '$endDate'");

			if ($merchantId != 'ALL') {
				$this->db->where($table.'.merchant_id = '.$merchantId);
				if($branchId != 'ALL') {
					$this->db->where($table.'.branch_id = '.$branchId);
				}	
			}

			if ($subanId != 'ALL') {
				$this->db->where('kecamatan.suban_id ='. $subanId);
			}

			if($billNumber != '' || !empty($billNumber)) {
				$this->db->where($table.'.bill_no', $billNumber);
			}
		} else {
			$table = 'bprdwarehouse.headerunder2019';

        	if ($year >= 2019) {
    			$table = 'bprdwarehouse.header'.$year.$month;
    		}

    		$this->db->select('
    			hw.merchant_name  						AS merchant_name,
				hw.branch_name      					AS branch_name,
				hw.npwp             					AS npwp,
				hw.nopd             					AS nopd,
				hw.bill_no          					AS bill_no,
				DATE_FORMAT(hw.bill_date, "%d %M %Y")	AS bill_date,
				hw.total_amount     					AS total_amount,
				hw.service          					AS service,
				hw.ppn              					AS ppn,
				hw.total_trx_amount 					AS total_trx_amount,
				hw.payment_type     					AS payment_type'
			);
			$this->db->from($table. ' as hw');
			if ($merchantId != 'ALL') {
				$this->db->where('hw.merchant_id = '.$merchantId);
				if($branchId != 'ALL') {
					$this->db->where('hw.branch_id = '.$branchId);
				}	
			}

			if ($subanId != 'ALL') {
				$this->db->where('hw.suban_id ='. $subanId);
			}

			if($billNumber != '' || !empty($billNumber)) {
				$this->db->where('hw.bill_no', $billNumber);
			}
			$this->db->where("hw.bill_date BETWEEN '$startDate' AND '$endDate'");
		}

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

    public function get_data_table($startDate, $endDate, $merchantId, $branchId, $billNumber, $subanId = 'ALL')
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

        $data = $this->query($startDate, $endDate, $merchantId, $branchId, $billNumber, $subanId, 'dataTable');

        return $data;
	}

	public function count_all($startDate, $endDate, $merchantId, $branchId, $billNumber, $subanId = 'ALL')
	{
		$data = $this->query($startDate, $endDate, $merchantId, $branchId, $billNumber, $subanId, 'countAll');
    	return $data;
	}


	public function count_filtered($startDate, $endDate, $merchantId, $branchId, $billNumber, $subanId = 'ALL')
	{
		$data = $this->query($startDate, $endDate, $merchantId, $branchId, $billNumber, $subanId, 'countFiltered');
		
		return $data->num_rows();
	}

	public function get_data($startDate, $endDate, $merchantId, $branchId, $billNumber, $subanId = 'ALL')
	{
		$data = $this->query($startDate, $endDate, $merchantId, $branchId, $billNumber, $subanId, 'getData');
		
		return $data;
	}
}

?>