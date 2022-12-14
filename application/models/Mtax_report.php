<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	 * 
	 */
	class mtax_report extends CI_Model {
		var $column_order = array(null, 'merchant_name','branch_name', 'total_payment', 'payment_date', 'flag', 'periode');
  	  	var $column_search = array('merchant_name','branch_name', 'total_payment', 'payment_date', 'flag', 'periode');
    	var $order = array('branch_name' => 'asc');

    	public function query($merchant_id, $branch_id, $periode, $type)
    	{
    		$this->db->select('
	        	p.`pa_id`,
	            p.`merchant_id`, 
	            p.`branch_id`, 
	            m.`merchant_name`,
	            b.`branch_name`,
	            b.`npwp`,
	            b.`nopd`,
	            p.`total_payment`, 
	            p.`flag`, 
	            p.`payment_date`, 
	            p.`periode`,
	            p.`kode_bayar`'
	        ) ;

	        $this->db->from('paymentautodebet as p');
	        $this->db->join('merchant as m', 'm.merchant_id = p.merchant_id');
	        $this->db->join('branch as b', 'b.merchant_id = p.merchant_id and b.branch_id = p.branch_id');
	        $this->db->where('p.merchant_id', $merchant_id);
	        $this->db->where('p.periode', $periode);
	        $this->db->where('p.flag', '2');
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

    	 public function count_all($merchant_id, $branch_id, $periode)
	    {
	        $data = $this->query($merchant_id, $branch_id, $periode, 'countAll');
	        return $data;
	    }

	    public function count_filtered($merchant_id, $branch_id, $periode)
	    {
	        $data = $this->query($merchant_id, $branch_id, $periode, 'countFiltered');
	        return $data->num_rows();
	    }

	    public function get_data_table($merchant_id, $branch_id, $periode)
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

	    	$data = $this->query($merchant_id, $branch_id, $periode, 'dataTable');
	    	return $data;
	    }			
	}

?>