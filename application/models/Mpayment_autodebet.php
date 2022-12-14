<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	 * 
	 */
	class mpayment_autodebet extends CI_Model
	{
		var $column_order = array(null, 'merchant_name','branch_name', 'total_payment', 'payment_date', 'flag', 'periode');
  	  	var $column_search = array('merchant_name','branch_name', 'total_payment', 'payment_date', 'flag', 'periode');
    	var $order = array('branch_name' => 'asc');
		
		public function get_detail ($pa_id) 
		{
			$this->db->select('
	        	p.`pa_id`,
	            p.`merchant_id`, 
	            p.`branch_id`,
	            m.`merchant_name`, 
	            b.`branch_name`, 
	            p.`total_payment`, 
	            p.`flag`, 
	            p.`payment_date`, 
	            p.`periode`,
	            p.`kode_bayar`,
	            b.`nopd`,
	            b.`npwp`'
	        ) ;
	        $this->db->from('paymentautodebet as p');
	        $this->db->join('merchant as m', 'm.merchant_id = p.merchant_id');
	        $this->db->join('branch as b', 'b.merchant_id = p.merchant_id and b.branch_id = p.branch_id');
	        $this->db->where('p.pa_id', $pa_id);
	        $query = $this->db->get();

	        return $query;
		}

		public function update_autodebet($merchant_id, $branch_id, $year, $month, $bill_no, $total_adjustment, $pa_id)
		{
	        $table = 'header';

	       	$resConnect = $this->dbConnection($year, $month);

	       	if ($resConnect == 'default') {
	       		$this->db->select('sum(h.ppn_dpp) as ppn');
				$this->db->from($table.' as h');
				$this->db->where('merchant_id', $merchant_id);
				$this->db->where('branch_id', $branch_id);
				$this->db->where('year(h.bill_date)', $year);
				$this->db->where('month(h.bill_date)', $month);
				$this->db->where_not_in('bill_no', $bill_no);
				$this->db->group_by('merchant_id, branch_id');
	       	} else {
	       		$table = 'bprdwarehouse.headerunder2019';
	       		$month = ($month < 10 ? '0'.$month : $month);
	       		
	       		if ($year >= 2019) {
        			$table = 'bprdwarehouse.header'.$year.$month;
        		}
	       		$this->db->select('sum(h.ppn_dpp) as ppn');
				$this->db->from($table.' as h');
				$this->db->where('h.merchant_id', $merchant_id);
				$this->db->where('h.branch_id', $branch_id);
				$this->db->where('year(h.bill_date)', $year);
				$this->db->where('month(h.bill_date)', $month);
				$this->db->where_not_in('h.bill_no', $bill_no);
				$this->db->group_by('h.merchant_id, h.branch_id');
	       	}
			$query = $this->db->get()->row();



	        $ppn = $query->ppn;
	        $newPpn = $ppn + $total_adjustment;

	        $this->db->where('pa_id', $pa_id);
			$this->db->update('paymentautodebet', ['total_payment' => $newPpn]);

			return $newPpn;
		}

		public function dbConnection($year, $month)
		{
			$monthNow 	= date('m');
	        $yearNow 	= date('Y');

			$connection = 'default';

	        if ($year != $yearNow || ($year == $yearNow && $monthNow - $month > 1) ) {
	        	$connection = 'werehouse';
	        }

	        return $connection;
		}

		public function query($periode, $merchant_id, $branch_id, $type)
	    {
	        $this->db->select('
	        	p.`pa_id`,
	            p.`merchant_id`, 
	            p.`branch_id`, 
	            m.`merchant_name`, 
	            b.`branch_name`, 
	            p.`total_payment`, 
	            p.`flag`, 
	            p.`payment_date`, 
	            p.`periode`'
	        ) ;
	        $this->db->from('paymentautodebet as p');
	        $this->db->join('merchant as m', 'm.merchant_id = p.merchant_id');
	        $this->db->join('branch as b', 'b.merchant_id = p.merchant_id and b.branch_id = p.branch_id');
	        $this->db->where('p.merchant_id', $merchant_id);
	        $this->db->where('periode', $periode);

	        if ($branch_id != 'ALL') {
	            $this->db->where('p.branch_id', $branch_id);
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

	    public function count_all($periode, $merchant_id, $branch_id)
	    {
	        $data = $this->query($periode, $merchant_id, $branch_id, 'countAll');
	        return $data;
	    }

	    public function count_filtered($periode, $merchant_id, $branch_id)
	    {
	        $data = $this->query($periode, $merchant_id, $branch_id, 'countFiltered');
	        return $data->num_rows();
	    }

	    public function get_data_table($periode, $merchant_id, $branch_id)
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

	    	$data = $this->query($periode, $merchant_id, $branch_id, 'dataTable');
	    	return $data;
	    }

	    public function history_payment($pa_id)
	    {
	    	$this->db->select('
	    		m.merchant_name AS merchant_name,
				b.branch_name AS branch_name,
				ph.kode_bayar AS kode_bayar,
				ph.payment_status AS payment_status,
				p.pa_id AS pa_id,
				p.total_payment,
				p.periode,
				ph.created_at AS payment_date'
	    	);
	    	$this->db->from('paymentautodebethistory AS ph');
	    	$this->db->join('paymentautodebet AS p','p.pa_id = ph.pa_id');
	    	$this->db->join('merchant AS m', 'm.merchant_id = p.merchant_id');
	    	$this->db->join('branch AS b ',' b.merchant_id = p.merchant_id AND b.branch_id = p.branch_id');
	    	$this->db->where('p.pa_id', $pa_id);
	    	$query = $this->db->get();
	    
	    	return $query;
	    }

	    public function insert_autodebet($year, $month, $merchant_id, $branch_id)
	    {
	        $table = 'header';

	       	$resConnect = $this->dbConnection($year, $month);

	        $month = ($month < 10 ? '0'.$month : $month);
	        
	        if ($resConnect == 'default') {
	        	$this->db->select('
		            h.merchant_id 			as merchant_id,
		            h.branch_id 			as branch_id,
		            "'.$month.'/'.$year.'" 	as periode,
		            date(now()) 			as payment_date,
		            sum(h.ppn_dpp) 			as total_payment,
		            1 						as flag,
		            date(now()) 			as created_at,
		            "'.$_SESSION['username'].'" as created_by');
		        $this->db->from($table.' as h');
		        $this->db->where('h.merchant_id', $merchant_id);
		        if ($branch_id != 'ALL') {
		            $this->db->where('h.branch_id', $branch_id);
		        }
		        $this->db->where('year(h.bill_date)', $year);
		        $this->db->where('month(h.bill_date)', $month);
		        $this->db->group_by('h.merchant_id, h.branch_id');
	        } else {
	        	$table = 'bprdwarehouse.headerunder2019';
	        	if ($year >= 2019) {
        			$table = 'bprdwarehouse.header'.$year.$month;
        		}
        		
        		$this->db->select('
        			hw.merchant_id 						as merchant_id,
        			hw.branch_id						as branch_id,
        			"'.$month.'/'.$year.'" 				as periode,
        			date(now()) 						as payment_date,
        			sum(hw.ppn_dpp)						as total_payment,
        			0									as flag,
        			date(now()) 						as payment_date'
        		);

        		$this->db->from($table. ' as hw');
        		$this->db->where('hw.merchant_id', $merchant_id);
		        if ($branch_id != 'ALL') {
		            $this->db->where('hw.branch_id', $branch_id);
		        }
		        $this->db->where('year(hw.bill_date)', $year);
		        $this->db->where('month(hw.bill_date)', $month);
		        $this->db->group_by('hw.merchant_id, hw.branch_id');
	        }
	        

	        $resSelect = $this->db->get();
	        
	        if ($resSelect->num_rows()) {
	            $dataInsert = $resSelect->result_array();
	            $this->db->insert_batch('paymentautodebet', $dataInsert);
	        }
	    }

	    public function get_data($year, $month, $merchant_id, $branch_id)
	    {
	    	$table = 'header';

	       	$resConnect = $this->dbConnection($year, $month);

	        $month = ($month < 10 ? '0'.$month : $month);
	        
	        if ($resConnect == 'default') {
	        	$this->db->select('
		            h.merchant_id 			as merchant_id,
		            h.branch_id 			as branch_id,
		            "'.$month.'/'.$year.'" 	as periode,
		            date(now()) 			as payment_date,
		            SUM(h.ppn_dpp) 			as tax, 
		            SUM(h.service) 			as service_charge, 
		            SUM(h.total_amount) 	as total_amount,
		            SUM(h.dpp) 				as dpp,
		            1 						as flag,
		            date(now()) 			as created_at,
		            "'.$_SESSION['username'].'" as created_by');
		        $this->db->from($table.' as h');
		        $this->db->where('h.merchant_id', $merchant_id);
		        if ($branch_id != 'ALL') {
		            $this->db->where('h.branch_id', $branch_id);
		        }
		        $this->db->where('year(h.bill_date)', $year);
		        $this->db->where('month(h.bill_date)', $month);
		        $this->db->group_by('h.merchant_id, h.branch_id');
	        } else {
	        	$table = 'bprdwarehouse.headerunder2019';
	        	if ($year >= 2019) {
        			$table = 'bprdwarehouse.header'.$year.$month;
        		}

        		$this->db->select('
        			hw.merchant_id 			as merchant_id,
        			hw.branch_id			as branch_id,
        			"'.$month.'/'.$year.'" 	as periode,
        			date(now()) 			as payment_date,
        			SUM(hw.ppn_dpp) 		as tax, 
		            SUM(hw.service) 		as service_charge, 
		            SUM(hw.total_amount)	as total_amount,
		            SUM(hw.dpp) 			as dpp,
        			0						as flag,
        			date(now()) 			as payment_date'
        		);

        		$this->db->from($table. ' as hw');
        		$this->db->where('hw.merchant_id', $merchant_id);
		        if ($branch_id != 'ALL') {
		            $this->db->where('hw.branch_id', $branch_id);
		        }
		        $this->db->where('year(hw.bill_date)', $year);
		        $this->db->where('month(hw.bill_date)', $month);
		        $this->db->group_by('hw.merchant_id, hw.branch_id');
	        }
	        

	        $resSelect = $this->db->get();
	    
	        return $resSelect;
	    }
	}


?>