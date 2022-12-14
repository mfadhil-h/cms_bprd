<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 */
class Report_summary extends CI_Model
{
	var $column_order = array(null, 'date_transaction', 'merchant_name','branch_name', 'daily_tax', 'daily_transaction');
    var $column_search = array('date_transaction', 'merchant_name','branch_name', 'daily_tax', 'daily_transaction');
    var $order = array('merchant_name' => 'asc');

    public function dbConnection($year, $month)
    {
        $monthNow   = date('m');
        $yearNow    = date('Y');

        $connection = 'default';

        if ($year != $yearNow || ($year == $yearNow && $monthNow - $month > 1) ) {
            $connection = 'warehouse';
        }

        return $connection;
    }

    public function query($month, $year, $merchantId, $branchId, $subanId, $type)
    {
		$monthNow = date('m');
		$table = 'header';
        $resConnect = $this->dbConnection($year, $month);
		if ($resConnect != 'warehouse') {
            $this->db->select('
                DATE_FORMAT(head.bill_date, "%d %M %Y") as date_transaction,
                merchant.`merchant_name` AS merchant_name,
                branch.`branch_name` AS branch_name,
                SUM(head.`ppn`) AS daily_tax,
                COUNT(head.`bill_no`) AS daily_transaction'
            );
            $this->db->from($table.' as head');
            $this->db->join('merchant', 'head.merchant_id = merchant.merchant_id');
            $this->db->join('branch', 'head.merchant_id = branch.merchant_id and head.branch_id = branch.branch_id');
            $this->db->join('kecamatan', 'branch.kec_id = kecamatan.kec_id','left');
            $this->db->where('MONTH(head.bill_date) = '.$month);
            $this->db->where('YEAR(head.bill_date) = '.$year);
            if ($merchantId != 'ALL') {
                $this->db->where('head.merchant_id = ' . $merchantId);
            	$this->db->where('head.branch_id =' .$branchId);
            }
	    if ($subanId != 'ALL') {
                $this->db->where('kecamatan.suban_id =' .$subanId);
            }
            $this->db->group_by('head.merchant_id, head.branch_id, date_transaction');
        } else {
            $table = 'bprdwarehouse.headerunder2019';

            if ($year >= 2019) {
                if ($month < 10) {
                    $month2 = '0'.$month;
                    $month=$month2;
                }
                $table = 'bprdwarehouse.header'.$year.$month;
            }

            $this->db->select('
                DATE_FORMAT(head.bill_date, "%d %M %Y") as date_transaction,
                head.`merchant_name` AS merchant_name,
                head.`branch_name` AS branch_name,
                SUM(head.`ppn`) AS daily_tax,
                COUNT(head.`bill_no`) AS daily_transaction'
            );
            $this->db->from($table.' as head');
            $this->db->where('MONTH(head.bill_date) = '.$month);
            $this->db->where('YEAR(head.bill_date) = '.$year);
            if ($merchantId != 'ALL') {
            	$this->db->where('head.merchant_id = '.$merchantId);
	    }
            $this->db->where('head.branch_id =' .$branchId);
            if ($subanId != 'ALL') {
                $this->db->where('head.suban_id =' .$subanId);
            }
            $this->db->group_by('head.merchant_id, head.branch_id, date_transaction');
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

    public function get_data_table($month, $year, $merchantId, $branchId, $subanId)
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

    	$data = $this->query($month, $year, $merchantId, $branchId, $subanId, 'dataTable');
    	return $data;
    }

	public function count_all($month, $year, $merchantId, $branchId, $subanId)
    {
    	$data = $this->query($month, $year, $merchantId, $branchId, $subanId, 'countAll');
    	return $data;
    }

    public function count_filtered($month, $year, $merchantId, $branchId, $subanId)
    {
    	$data = $this->query($month, $year, $merchantId, $branchId, $subanId, 'countFiltered');
    	return $data->num_rows();
    }

	public function get_data($month, $year, $merchantId, $branchId, $subanId)
	{
		$data = $this->query($month, $year, $merchantId, $branchId, $subanId, 'getData');
    	return $data;
	}
}

?>
