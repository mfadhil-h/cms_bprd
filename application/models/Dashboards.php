<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Dashboards extends CI_Model {

    public function werehouseTable($minDate)
    {
        $month = date('m',strtotime($minDate));
		$year = date('Y', strtotime($minDate));
		
		$monthNow = date('m');
		$table = 'header';
        
        if ($year < 2019) {
            $table ='headerunder2019';
        }else if ($year != date('Y')) {
			$table = 'header'.$year.$month;
		} else if ($year == date('Y') && $monthNow - $month > 1 ) {
			$table = 'header'.$year.$month;
        }
        
        return $table;
    }

    public function branch_online ($suban_id = null)
    {

        $minDate =  date('Y-m-d 00:00:00',strtotime("-1 days"));
        $maxDate =  date('Y-m-d 23:59:59',strtotime("-1 days"));

        $this->db->select('header.merchant_id');
        $this->db->from('header');
        $this->db->where("bill_date BETWEEN '$minDate' AND '$maxDate'");
        $this->db->join('branch', 'branch.branch_id = header.branch_id AND branch.merchant_id = header.merchant_id');
        $this->db->join('kecamatan', 'branch.kec_id = kecamatan.kec_id');
        if ($suban_id != null || !empty($suban_id)) {
            $this->db->where('kecamatan.suban_id', $suban_id);
        }
        $this->db->group_by('header.merchant_id, header.branch_id');
       
        $data_online = $this->db->count_all_results();
        return $data_online;
    }

    public function branch_monitoring($suban_id = null)
    {
        $minDate = date('Y-m-01');
        $maxDate = date('Y-m-d');

        $this->db->select('DATE_FORMAT(date, "%d %M %Y") as `description`, count(branchmonitoring.merchant_id) as `transactions`, count(branchmonitoring.merchant_id) as `ppn` ');
        $this->db->from('branchmonitoring');
        $this->db->join('branch', 'branch.branch_id = branchmonitoring.branch_id AND branch.merchant_id = branchmonitoring.merchant_id');
        $this->db->join('kecamatan', 'branch.kec_id = kecamatan.kec_id');
        if ($suban_id != null || !empty($suban_id)) {
            $this->db->where('kecamatan.suban_id', $suban_id);
        }
        $this->db->where("date BETWEEN '$minDate' AND '$maxDate'");
        $this->db->group_by('date');
        $result = $this->db->get();
        
        return $result;
    }
    
    public function get_purchase($minDate,$maxDate,$merchant_id,$branch_id){
        $table = $this->werehouseTable($minDate);
        
        $this->db->select('head.merchant_id as `merchant_id`, head.branch_id as `branch_id`, branch.branch_name as `description`, COUNT(head.bill_no) AS `transactions`, SUM(head.ppn) AS `ppn`');
        $this->db->from($table.' as head');
        $this->db->join('branch', 'head.merchant_id = branch.merchant_id AND head.branch_id = branch.branch_id');
        $this->db->group_by('merchant_id, branch_id');
        if($merchant_id != NUll){
            $this->db->where("head.merchant_id = ".$merchant_id);
            if($branch_id!= null){
                $this->db->where("head.branch_id = ".$branch_id);
            }
        }
        if(!empty($minDate)and!empty($maxDate))
        {   
            $this->db->where("bill_date BETWEEN '$minDate' AND '$maxDate'");
        }

        $query = $this->db->get();
        
        return $query;

    }

    public function get_purchase_branch($minDate,$maxDate,$merchant_id,$branch_id)
    {
        $table = $this->werehouseTable($minDate);
        $this->db->select('head.merchant_id as `merchant_id`, head.branch_id as `branch_id`, DATE_FORMAT(head.`bill_date`, "%d " "%M " "%Y") as `description`, COUNT(head.bill_no) AS `transactions`, SUM(head.ppn) AS `ppn`');
        $this->db->from($table.' as head');
        $this->db->join('branch', 'head.merchant_id = branch.merchant_id and head.branch_id = branch.branch_id');
        $this->db->where('head.merchant_id ='.$merchant_id);
        $this->db->where('head.branch_id='.$branch_id);
        $this->db->where("bill_date BETWEEN '$minDate' AND '$maxDate'");
        $this->db->group_by('head.merchant_id, head.branch_id, description');

        $result = $this->db->get();
        return $result->result_array();
    }

    public function get_tax_persuban($minDate, $maxDate) {
        $table = $this->werehouseTable($minDate);
        $this->db->select('suban.`suban_name`, suban.`suban_id`, sum(head.`ppn`) as ppn, count(head.`bill_no`) as transactions');
        $this->db->from($table.' as head');
        $this->db->join('branch', 'head.merchant_id = branch.merchant_id and head.branch_id = branch.branch_id');
        $this->db->join('kecamatan', 'branch.`kec_id` = kecamatan.`kec_id`');
        $this->db->join('suban', 'kecamatan.`suban_id` = suban.`suban_id`', 'right');
        $this->db->where("bill_date BETWEEN '$minDate' AND '$maxDate'");
        $this->db->group_by('suban.`suban_name`');

        $result = $this->db->get();
        return $result->result_array();
    }
    
    public function subanNotin($id) {
        $this->db->select('suban.`suban_id`, suban.`suban_name`');
        $this->db->from('suban');
        $this->db->where_not_in('suban.`suban_id`', $id);

        $result = $this->db->get();
        return $result;
    }


    public function get_purchase_suban($minDate,$maxDate){
        $table = $this->werehouseTable($minDate);
        $this->db->select('head.merchant_id as `merchant_id`, head.branch_id as `branch_id`, suban.suban_name as `description`, COUNT(head.bill_no) AS `transactions`, SUM(head.ppn) AS `ppn`');
        $this->db->from($table.' as head');
        $this->db->join('branch', 'head.merchant_id = branch.merchant_id AND head.branch_id = branch.branch_id');
        $this->db->join('kecamatan', 'branch.`kec_id` = kecamatan.`kec_id`');
        $this->db->join('suban', 'kecamatan.`suban_id` = suban.`suban_id`', 'right');
        if(!empty($minDate)and!empty($maxDate))
        {  
            $this->db->where("bill_date BETWEEN '$minDate' AND '$maxDate'");
        }
        $this->db->group_by('suban.`suban_name`');

        $query = $this->db->get();
        return $query;

    }

    public function get_purchase_kecamatan($minDate, $maxDate, $subanId) {
        $table = $this->werehouseTable($minDate);
        $this->db->select('head.merchant_id as `merchant_id`, head.branch_id as `branch_id`, kecamatan.kec_name as `description`, COUNT(head.bill_no) AS `transactions`, SUM(head.ppn) AS `ppn`');
        $this->db->from($table.' as head');
        $this->db->join('branch', 'head.merchant_id = branch.merchant_id AND head.branch_id = branch.branch_id');
        $this->db->join('kecamatan', 'branch.`kec_id` = kecamatan.`kec_id`');
        $this->db->join('suban', 'kecamatan.`suban_id` = suban.`suban_id`');
        $this->db->where("suban.`suban_id`", $subanId);
        $this->db->where("bill_date BETWEEN '$minDate' AND '$maxDate'");
        $this->db->group_by('kecamatan.`kec_name`');
        $query = $this->db->get();
        return $query;
    }

    public function get_purchase_merchant($minDate, $maxDate, $subanId) {
        $table = $this->werehouseTable($minDate);
        $this->db->select('head.merchant_id as `merchant_id`, head.branch_id as `branch_id`, merchant.merchant_name as `description`, COUNT(head.bill_no) AS `transactions`, SUM(head.ppn) AS `ppn`');
        $this->db->from($table.' as head');
        $this->db->join('merchant', 'head.merchant_id = merchant.merchant_id');
        $this->db->join('branch', 'head.merchant_id = branch.merchant_id AND head.branch_id = branch.branch_id');
        $this->db->join('kecamatan', 'branch.`kec_id` = kecamatan.`kec_id`');
        $this->db->join('suban', 'kecamatan.`suban_id` = suban.`suban_id`');
        $this->db->where("suban.`suban_id`", $subanId);
        $this->db->where("bill_date BETWEEN '$minDate' AND '$maxDate'");
        $this->db->group_by('merchant.`merchant_name`');
        $query = $this->db->get();
        return $query;

    }

}