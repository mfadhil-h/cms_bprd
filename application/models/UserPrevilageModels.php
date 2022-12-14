<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class userPrevilageModels extends CI_Model
{
    

	public function get_data($up_id = null)
	{
       $this->db->select('*');
       $this->db->from('userprevilage');
       if (!empty($up_id)) {
            $this->db->where('up_id = '.$up_id);
       }
       $query = $this->db->get();
       return $query;
	}

      public function get_module_access($up_id)
      {
            $this->db->select('module.`mod_id`, module.`mod_code`, module.`mod_name`, ma_id, up_id, ma_previlage, ma_approver');
            $this->db->from('module');
            $this->db->join('moduleaccess', 'module.mod_id = moduleaccess.mod_id');
            $this->db->where('up_id = '.$up_id);
            $query = $this->db->get();

            return $query;
      }
}

?>