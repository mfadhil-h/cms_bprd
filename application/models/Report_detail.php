<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 */
class Report_detail extends CI_Model
{
	var $column_order = array(null, 'merchant_name','branch_name', 'npwp', 'nopd', 'bill_no', 'bill_date', 'total_amount', 'service', 'ppn', 'total_trx_amount', 'payment_type');
    var $column_search = array('merchant_name','branch_name', 'npwp', 'nopd', 'bill_no', 'bill_date', 'total_amount', 'service', 'ppn', 'total_trx_amount', 'payment_type');
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

	public function query($start_date, $end_date, $merchantId, $branchId, $subanId, $bill_no, $type) 
	{

		$month = date('m',strtotime($start_date));
		$year = date('Y', strtotime($end_date));
		
		$resConnect = $this->dbConnection($year, $month);


		$tableHeader = 'header';
		$tableDetail = 'detail';
		
		if ($resConnect != 'warehouse') {
			$this->db->select('
				merchant.merchant_name AS merchant_name,
			  	branch.branch_name     AS branch_name,
			  	'.$tableDetail.'.bill_no         AS bill_no,
			  	DATE_FORMAT('.$tableHeader.'.bill_date, "%d %M %Y")       AS bill_date,
			  	'.$tableDetail.'.item_name       AS item_name,
			  	'.$tableDetail.'.item_type       AS item_type,
			  	'.$tableDetail.'.item_price      AS item_price,
			  	'.$tableDetail.'.quantity        AS quantity,
			  	'.$tableDetail.'.item_amount     AS item_amount'
			);
			$this->db->from($tableHeader);
			$this->db->join($tableDetail, ''.$tableHeader.'.id = '.$tableDetail.'.header_id');
			$this->db->join('branch', ''.$tableHeader.'.merchant_id = branch.merchant_id and '.$tableHeader.'.branch_id = branch.branch_id');
			$this->db->join('merchant', ''.$tableHeader.'.merchant_id = merchant.merchant_id');
			$this->db->join('kecamatan', 'kecamatan.kec_id = branch.kec_id');
			$this->db->where("bill_date BETWEEN '$start_date' AND '$end_date'");
			if ($merchantId != 'ALL') {
				$this->db->where($tableHeader.'.merchant_id = '.$merchantId);
				if($branchId != 'ALL') {
					$this->db->where($tableHeader.'.branch_id = '.$branchId);
				}	
			}

			if ($subanId != 'ALL') {
				$this->db->where('kecamatan.suban_id', $subanId);
			}

			if (!empty($bill_no) || $bill_no != '') {
				$this->db->where($tableHeader.'.bill_no', $bill_no);
			}
		} else {
			$tableHeader = 'bprdwarehouse.headerunder2019';
			$tableDetail = 'bprdwarehouse.detailunder2019';

			if ($year >= 2019) {
    			$tableHeader = 'bprdwarehouse.header'.$year.$month;
    			$tableDetail = 'bprdwarehouse.detail'.$year.$month;
    		}

			$this->db->select('
				h.merchant_name 						AS merchant_name,
			  	h.branch_name     						AS branch_name,
			  	d.bill_no         						AS bill_no,
			  	DATE_FORMAT(h.bill_date, "%d %M %Y")	AS bill_date,
			  	d.item_name       						AS item_name,
			  	d.item_type       						AS item_type,
			  	d.item_price      						AS item_price,
			  	d.quantity        						AS quantity,
			  	d.item_amount     						AS item_amount'
			);
			$this->db->from($tableHeader.' as h');
			$this->db->join($tableDetail.' as d', 'h.id = d.header_id');
			$this->db->where("bill_date BETWEEN '$start_date' AND '$end_date'");
			if ($merchantId != 'ALL') {
				$this->db->where('h.merchant_id = '.$merchantId);
				if($branchId != 'ALL') {
					$this->db->where('h.branch_id = '.$branchId);
				}	
			}

			if ($subanId != 'ALL') {
				$this->db->where('h.suban_id', $subanId);
			}

			if (!empty($bill_no) || $bill_no != '') {
				$this->db->where('h.bill_no', $bill_no);
			}
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

	public function get_data_table($start_date, $end_date, $merchantId, $branchId, $subanId, $bill_no)
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
		$data = $this->query($start_date, $end_date, $merchantId, $branchId, $subanId, $bill_no, 'dataTable');
		return $data;
	}

	public function count_all($start_date, $end_date, $merchantId, $branchId, $subanId, $bill_no)
	{
		$data = $this->query($start_date, $end_date, $merchantId, $branchId, $subanId, $bill_no, 'countAll');
		return $data;
	}

	public function count_filtered($start_date, $end_date, $merchantId, $branchId, $subanId, $bill_no)
	{
		$data = $this->query($start_date, $end_date, $merchantId, $branchId, $subanId, $bill_no, 'countFiltered');
		return $data->num_rows();
	}

	public function get_data($start_date, $end_date, $merchantId, $branchId, $subanId, $bill_no)
	{
		$data = $this->query($start_date, $end_date, $merchantId, $branchId, $subanId, $bill_no, 'getData');
		return $data;
	}
}

?>