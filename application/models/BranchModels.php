<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class branchModels extends CI_Model
{

    var $column_order = array(null, 'branch_name','merchant_name', 'kec_name', 'bt_desc', 'npwp', 'nopd', 'location', 'branch.pos_code', 'pic', 'branch.no_tlp');
    var $column_search = array('branch_name','merchant_name', 'kec_name', 'bt_desc', 'npwp', 'nopd', 'location', 'branch.pos_code', 'pic', 'branch.no_tlp');
    var $order = array('branch_name' => 'asc');

    public function query($subanId = null, $type)
    {
    	$this->db->select('
    			branch.`id` 				as id,
				branch.`branch_id` 			as branch_id, 
				branch.`branch_name` 		as branch_name, 
				merchant.`merchant_id`		as merchant_id, 
				merchant.`merchant_name`	as merchant_name , 
				kecamatan.`kec_name` 		as kec_name,
				branchtype.`bt_desc`		as bt_desc,
				branch.`npwp`				as npwp, 
				branch.`nopd`				as nopd, 
				branch.`location` 			as location, 
				branch.`pos_code` 			as pos_code, 
				branch.`pic` 				as pic, 
				branch.`no_tlp` 			as no_tlp'
			);
		$this->db->from('branch');
		$this->db->join('merchant', 'branch.`merchant_id` = merchant.`merchant_id`');
		$this->db->join('kecamatan', 'branch.`kec_id` = kecamatan.`kec_id`', 'left');
		$this->db->join('branchtype', 'branch.`bt_id` = branchtype.`bt_id`', 'left');
		if ($subanId != null || !empty($subanId)) {
			$this->db->where('kecamatan.suban_id ='.$subanId);
		}
		$this->db->order_by('merchant.`merchant_id`');

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

	public function getBranch($subanId = null)
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

		$data = $this->query($subanId, 'dataTable');
		return $data;
	}

	public function count_filtered($subanId)
	{
		$data  = $this->query($subanId, 'countFiltered');
		return $data->num_rows();
	}

	public function count_all($subanId)
	{
		$data  = $this->query($subanId, 'countAll');
		return $data;
	}

	public function getBranchByid($branch_id, $merchant_id)
	{
		$query = $this->db->get_where('branch', array('branch_id' => $branch_id, 'merchant_id' => $merchant_id));
		return $query->row_array();
	}

	public function getBranchType()
	{
		$query = $this->db->get('branchtype');

		return $query->result_array();
	}

	public function getBranchByKec($kec) 
	{
		$query = $this->db->get_where('branch', $kec)->result_array();

		return $query;
	}
}

?>