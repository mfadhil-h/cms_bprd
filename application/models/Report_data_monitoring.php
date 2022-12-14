<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 */
class Report_data_monitoring extends CI_Model
{
	var $column_order = array(null, 'merchant_name','branch_name', 'npwp', 'nopd', 'bill_no', 'bill_date', 'total_amount', 'service', 'ppn', 'total_trx_amount', 'payment_type');
    var $column_search = array('merchant_name','branch_name', 'npwp', 'nopd', 'bill_no', 'bill_date', 'total_amount', 'service', 'ppn', 'total_trx_amount', 'payment_type');
    var $order = array('merchant_name' => 'asc');

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

    public function query($start_date, $end_date, $merchantId, $branchId, $suban_id, $hideEmpyData, $type)
    {
    	$month = date('m',strtotime($start_date));
		$year = date('Y', strtotime($start_date));
		
		$monthNow = date('m');
		$table = 'header';
			
		$resConnect = $this->dbConnection($year, $month);

    	$firstDay 	= date('d', strtotime($start_date));
    	$endDay 	= date('d', strtotime($end_date));
    	$year 		= date('Y', strtotime($end_date));
    	$month 		= date('m', strtotime($end_date));
    	$column = '';

    	for ($i=intval($firstDay); $i <= intval($endDay) ; $i++) {

    		$column = $column.", COUNT( IF( (DAY(bill_date) = '".$i."' AND MONTH(bill_date) = '".$month."'), bill_no, NULL) ) AS 'day_".$i."'";
    	}

    	if ($resConnect != 'warehouse') {
    		$this->db->select('h.merchant_id, h.branch_id, m.merchant_name, b.branch_name '.$column);
	    	$this->db->from($table.' as h');
	    	$this->db->join('merchant as m', 'm.merchant_id = h.merchant_id');
	    	$this->db->join('branch as b', 'b.merchant_id = h.merchant_id AND b.branch_id = h.branch_id');
	    	$this->db->join('kecamatan as k', 'k.kec_id = b.kec_id');
	    	if ($suban_id != 'ALL') {
				$this->db->where('k.suban_id', $suban_id);	
			}

			if ($merchantId != 'ALL') {
				$this->db->where('m.merchant_id = '.$merchantId);
				if($branchId != 'ALL') {
					$this->db->where('b.branch_id = '.$branchId);
				}	
			}
    		$this->db->group_by('h.`merchant_id`, h.`branch_id`');
    	} else {
    		$table = 'bprdwarehouse.headerunder2019';

        	if ($year >= 2019) {
    			$table = 'bprdwarehouse.header'.$year.$month;
    		}
    		$this->db->select('h.merchant_id, h.branch_id, h.merchant_name, h.branch_name '.$column);
    		if ($suban_id != 'ALL') {
				$this->db->where('k.suban_id', $suban_id);	
			}

			if ($merchantId != 'ALL') {
				$this->db->where('h.merchant_id = '.$merchantId);
				if($branchId != 'ALL') {
					$this->db->where('h.branch_id = '.$branchId);
				}	
			}
    		$this->db->group_by('h.`merchant_id`, h.`branch_id`');
    		$this->db->from($table.' as h');
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
    public function query2($start_date, $end_date, $merchantId, $branchId, $suban_id, $hideEmpyData, $type)
    {
		$month = date('m',strtotime($start_date));
		$year = date('Y', strtotime($start_date));
		
		$monthNow = date('m');
		$table = 'header';
		
		if($year < 2019) {
			$table ='headerunder2019';
		} if ($year != date('Y')) {
			$table = 'header'.$year.$month;
		} else if ($year == date('Y') && $monthNow - $month > 1 ) {
			$table = 'header'.$year.$month;
		}



    	$this->db->select('
					merchant.`merchant_name`,
					branch.`branch_name`,
					DATE_FORMAT('.$table.'.bill_date, "%d %M %Y") as date_transaction,
					COUNT('.$table.'.`bill_date`) as total_transaction');
		$this->db->from('merchant');
		$this->db->join('branch', '`merchant`.`merchant_id` = `branch`.`merchant_id`');
		$this->db->join($table, "(".$table.".merchant_id = branch.merchant_id and ".$table.".branch_id = branch.branch_id and (bill_date BETWEEN '$start_date' AND '$end_date'))", 'left');
		$this->db->join('kecamatan', 'kecamatan.kec_id = branch.kec_id');
		
		if ($suban_id != 'ALL') {
			$this->db->where('kecamatan.suban_id', $suban_id);	
		}

		$this->db->where('(1=1)');
		if ($merchantId != 'ALL') {
			$this->db->where('merchant.merchant_id = '.$merchantId);
			if($branchId != 'ALL') {
				$this->db->where('branch.branch_id = '.$branchId);
			}	
		}

		$this->db->group_by('branch.`merchant_id`, branch.`branch_id`');
		
		if ($hideEmpyData == 'true') {
			$this->db->having('COUNT('.$table.'.`bill_date`)',  0);
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
	public function get_data_table($start_date, $end_date, $merchantId, $branchId, $suban_id, $hideEmpyData)
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
		$data = $this->query($start_date, $end_date, $merchantId, $branchId, $suban_id ,$hideEmpyData, 'dataTable');
		return $data;
	}

	public function count_all($start_date, $end_date, $merchantId, $branchId, $suban_id, $hideEmpyData)
	{
		$data = $this->query($start_date, $end_date, $merchantId, $branchId, $suban_id, $hideEmpyData, 'countAll');
		return $data;
	}

	public function count_filtered($start_date, $end_date, $merchantId, $branchId, $suban_id, $hideEmpyData)
	{
		$data = $this->query($start_date, $end_date, $merchantId, $branchId, $suban_id, $hideEmpyData, 'countFiltered');
		return $data->num_rows();
	}

	public function get_data($start_date, $end_date, $merchantId, $branchId, $suban_id, $hideEmpyData)
	{
		$data = $this->query($start_date, $end_date, $merchantId, $branchId, $suban_id, $hideEmpyData, 'getData');
		return $data;
	}
}

?>