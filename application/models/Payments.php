<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class payments extends CI_Model
{
    
	public function getPayment($merchantId, $branchId, $month, $year)
	{       
        $monthNow = date('m');
		$table = 'header';
		if($year < 2019) {
			$table ='headerunder2019';
		} else if ($year != date('Y')) {
			$table = 'header'.$year.($month < 10 ? '0'.$month : $month );
		} else if ($year == date('Y') && $monthNow - $month > 1 ) {
			$table = 'header'.$year.($month < 10 ? '0'.$month : $month );
        }
        
        $this->db->select(
            'head`.`merchant_id` AS `merchant_id`,
            `merchant`.`merchant_name` AS `merchant_name`,
            `head`.`branch_id` AS `branch_id`,
            `branch`.`branch_name` AS `branch_name`,
            DATE_FORMAT(head.bill_date, "%d %M %Y") AS `bill_date`,
            SUM(`head`.`ppn_dpp`) AS `tax`, 
            SUM(`head`.`service`) AS `service_charge`, 
            SUM(`head`.`total_amount`) AS `total_amount`,
            SUM(`head`.`dpp`) AS `dpp`');
        $this->db->from($table.' as head');
        $this->db->join('merchant', 'head.merchant_id = merchant.merchant_id');
        $this->db->join('branch', 'head.merchant_id = branch.merchant_id AND head.branch_id = branch.branch_id');
        $this->db->where("head.merchant_id = ".$merchantId);
        if ($branchId != 'ALL') {
            $this->db->where("head.branch_id = ".$branchId);
        }
        $this->db->where("month(head.`bill_date`)= ".$month);
        $this->db->where("year(head.`bill_date`) = ".$year);
        $this->db->group_by('merchant_id, branch_id');

        $data = $this->db->get();
        return $data;
	}

    public function waiting_payment($merchant_id, $branch_id , $month, $year)
    {
        $this->db->select('
            SUM(paymentrequest.`total_ppn`) AS total_ppn,
            paymentrequest.`month`,
            paymentrequest.`year`,
            paymentrequest.`order_id`,
            paymentstatus.`notifstatuscode`,
            bnihistory.`va_number`'
        );
        $this->db->from('paymentrequest');
        $this->db->join('branch', 'branch.`branch_id` = paymentrequest.`branch_id` AND branch.`merchant_id` = paymentrequest.`merchant_id`');
        $this->db->join('merchant', 'merchant.`merchant_id` = paymentrequest.`merchant_id`');
        $this->db->join('paymentstatus', 'paymentstatus.`orderid` = paymentrequest.`order_id`');
        $this->db->join('bnihistory', 'bnihistory.`order_id` = paymentrequest.`order_id`');
        $this->db->where('paymentstatus.`notifstatusdesc` != "Success"');
        if ($merchant_id != 'ALL' && !empty($merchant_id)) {
                $this->db->where('paymentrequest.merchant_id = '.$merchant_id);
                if($branch_id != 'ALL' && !empty($branch_id)) {
                        $this->db->where('paymentrequest.branch_id = '.$branch_id);
                }       
        }
        if ($year != 'ALL' && !empty($year)) {
                $this->db->where('paymentrequest.year = '.$year);
                if($month != 'ALL' && !empty($month)) {
                        $this->db->where('paymentrequest.month = '.$month);
                }       
        }
        $this->db->group_by('paymentrequest.`order_id`');

        return $this->db->get();
            
    }

    public function show_detail($oder_id)
    {
            $this->db->select('merchant.merchant_name,
                    branch.branch_name,
                    paymentrequest.month,
                    paymentrequest.year,
                    paymentrequest.total_ppn,
                    paymentrequest.kode_bayar');
            $this->db->from('paymentrequest');
            $this->db->join('branch', 'branch.`branch_id` = paymentrequest.`branch_id` AND branch.`merchant_id` = paymentrequest.`merchant_id`');
            $this->db->join('merchant', 'merchant.`merchant_id` = paymentrequest.`merchant_id`');
            $this->db->where('paymentrequest.order_id = '.$oder_id);
            return $this->db->get();


    }

    var $column_order = array(null, 'branch_name','merchant_name', 'paymentrequest.`month`', 'paymentrequest.`year`', 'paymentrequest.`kode_bayar`', 'bnihistory.`va_number`');
    var $column_search = array('branch_name','merchant_name', 'paymentrequest.`month`', 'paymentrequest.`year`', 'paymentrequest.`kode_bayar`', 'bnihistory.`va_number`');
    var $order = array('branch_name' => 'asc');

    public function query_tax_report($year, $month, $merchant_id, $branch_id, $type)
    {
        $this->db->select('
            branch.`nopd`               as nopd,
            branch.`npwp`               as npwp,
            branch.`merchant_id`        as merchant_id, 
            branch.`branch_id`          as branch_id,
            branch.`branch_name`        as branch_name,
            merchant.`merchant_name`    as merchant_name,
            bnihistory.`va_number`      as va_number,
            paymentrequest.`month`      as month,
            paymentrequest.`year`       as year,
            paymentrequest.`total_ppn`  as total_ppn,
            paymentrequest.`kode_bayar` as kode_bayar,
            paymentrequest.`order_id`   as order_id' 
        );
        $this->db->from('paymentrequest');
        $this->db->join('branch', 'branch.`branch_id` = paymentrequest.`branch_id` AND branch.`merchant_id` = paymentrequest.`merchant_id`');
        $this->db->join('merchant', 'merchant.`merchant_id` = paymentrequest.`merchant_id`');
        $this->db->join('paymentstatus', 'paymentstatus.`orderid` = paymentrequest.`order_id`');
        $this->db->join('bnihistory', 'bnihistory.`order_id` = paymentrequest.`order_id`');
        $this->db->where('paymentrequest.`month`', $month);
        $this->db->where('paymentrequest.`year`', $year);
        $this->db->where('paymentrequest.`merchant_id`', $merchant_id);
        $this->db->where('paymentrequest.`branch_id`', $branch_id);
        $this->db->where('paymentstatus.`notifstatusdesc` = "Success"');

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

    public function get_data_table_tax_report($year, $month, $merchant_id, $branch_id)
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

        $data = $this->query_tax_report($year, $month, $merchant_id, $branch_id, 'dataTable');

        return $data;
    }

    public function count_all_tax_report($year, $month, $merchant_id, $branch_id)
    {
        $data = $this->query_tax_report($year, $month, $merchant_id, $branch_id, 'countAll');
        return $data;
    }


    public function count_filtered_tax_report($year, $month, $merchant_id, $branch_id)
    {
        $data = $this->query_tax_report($year, $month, $merchant_id, $branch_id, 'countFiltered');
        
        return $data->num_rows();
    }

    public function get_data_tax_report($year, $month, $merchant_id, $branch_id)
    {
        $data = $this->query_tax_report($year, $month, $merchant_id, $branch_id, 'getData');
        
        return $data;
    }

}

?>