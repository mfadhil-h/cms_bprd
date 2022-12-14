<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class sspdSptpd extends CI_Model
{

    var $column_order = array(null, 'merchant_name','branch_name', 'npwp', 'branch.nopd', 'document.`periode`', 'document.`ntpd`');
    var $column_search = array('merchant_name','branch_name', 'npwp', 'branch.nopd', 'document.`periode`', 'document.`ntpd`');
    var $order = array('branch_name' => 'asc');

    public function query($periode, $merchant_id, $branch_id, $type)
    {
    	$this->db->select('
			merchant.`merchant_id` AS merchant_id, 
			merchant.`merchant_name` AS merchant_name,
			branch.`branch_id` AS branch_id,
			branch.`branch_name` AS branch_name,
			branch.`npwp` AS npwp,
			branch.`nopd` AS nopd,
			document.`ntpd` AS ntpd,
			document.`periode` AS periode'
		);
		$this->db->from('document');
		$this->db->join('merchant', 'merchant.`merchant_id` = document.`merchant_id`');
		$this->db->join('branch', 'branch.`branch_id` = document.`branch_id` AND branch.`merchant_id` = document.`merchant_id`');
		$this->db->where('document.`ntpd` IS NOT NULL');
		
		if ($merchant_id != 'ALL') {
			$this->db->where('document.merchant_id', $merchant_id);

			if ($branch_id != 'ALL') {
				$this->db->where('document.branch_id', $branch_id);
			}
		}

		$this->db->where('document.periode', $periode);

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

	public function count_filtered($periode, $merchant_id, $branch_id)
	{
		$data  = $this->query($periode, $merchant_id, $branch_id, 'countFiltered');
		return $data->num_rows();
	}

	public function count_all($periode, $merchant_id, $branch_id)
	{
		$data  = $this->query($periode, $merchant_id, $branch_id, 'countAll');
		return $data;
	}

}

?>