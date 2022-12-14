<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class mreport_live_branch extends CI_Model
{
	var $column_order = array(null, 'merchant_name','branch_name', 'npwp', 'nopd', 'date_live');
    var $column_search = array('merchant_name','branch_name', 'npwp', 'nopd', 'date_live');
    var $order = array('merchant_name' => 'asc');


    public function query($year, $month, $merchantId, $branchId, $subanId = 'ALL', $type)
    {
		
    	$this->db->select('
			`merchant`.`merchant_name`  	AS `merchant_name`,
			`branch`.`branch_name`      	AS `branch_name`,
			`branch`.`npwp`             	AS `npwp`,
			`branch`.`nopd`             	AS `nopd`,
			`livebranch`.`date_live`	    AS `date_live`,
	'
		);
		$this->db->from('livebranch');
		$this->db->join('branch', '`livebranch`.`merchant_id` = `branch`.`merchant_id` AND `livebranch`.`branch_id` = `branch`.`branch_id`', 'left');
		$this->db->join('merchant','`livebranch`.`merchant_id` = `merchant`.`merchant_id`', 'left');
		$this->db->join('kecamatan','`branch`.`kec_id` = `kecamatan`.`kec_id`', 'left');

		if ($year != 'ALL') {
			$this->db->where('year(`livebranch`.`date_live`)',$year);
		}

		if ($month != 'ALL') {
			$this->db->where('month(`livebranch`.`date_live`)',$month);
		}

		if ($merchantId != 'ALL') {
			$this->db->where('`livebranch`.`merchant_id` = '.$merchantId);
			if($branchId != 'ALL') {
				$this->db->where('`livebranch`.`branch_id` = '.$branchId);
			}	
		}

		if ($subanId != 'ALL') {
			$this->db->where('kecamatan.suban_id', $subanId);
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

    public function get_data_table($year, $month, $merchantId, $branchId, $subanId = 'ALL')
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

        $data = $this->query($year, $month, $merchantId, $branchId, $subanId, 'dataTable');

        return $data;
	}

	public function count_all($year, $month, $merchantId, $branchId, $subanId = 'ALL')
	{
		$data = $this->query($year, $month, $merchantId, $branchId, $subanId, 'countAll');
    	return $data;
	}


	public function count_filtered($year, $month, $merchantId, $branchId, $subanId = 'ALL')
	{
		$data = $this->query($year, $month, $merchantId, $branchId, $subanId, 'countFiltered');
		
		return $data->num_rows();
	}

	public function get_data($year, $month, $merchantId, $branchId, $subanId = 'ALL')
	{
		$data = $this->query($year, $month, $merchantId, $branchId, $subanId, 'getData');
		
		return $data;
	}
}

?>