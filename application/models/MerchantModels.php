<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class merchantModels extends CI_Model
{
    var $column_order = array(null, 'merchant_name','shared_key', 'date_format', 'no_tlp', 'email', 'owner_name', 'owner_location');
    var $column_search = array('merchant_name','shared_key', 'date_format', 'no_tlp', 'email', 'owner_name', 'owner_location');
    var $order = array('merchant_name' => 'asc');

	public function get_all_merchant()
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
        $this->db->select('*');
        $this->db->from('merchant');
        $this->db->limit($_POST['length'], $_POST['start']);
        return $this->db->get();
	}

    public function get_merchant_all() 
    {
        $this->db->select('*');
        $this->db->from('merchant');
        return $this->db->get();
    }

	public function count_all()
	{
		$this->db->select('*');
		$this->db->from('merchant');
		return $this->db->count_all_results();
	}


	public function count_filtered()
	{
		$this->db->select('*');
		$this->db->from('merchant');
		$query = $this->db->get();
		
		return $query->num_rows();
	}
}

?>