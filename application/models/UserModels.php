<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class userModels extends CI_Model
{
    

	public function get_data($id = null)
	{
       $this->db->select('
            user.id, 
            user.up_id,
            userprevilage.up_name,
            userprevilage.up_level,
            user.username,
            user.suban_id,
            user.merchant_id,
            user.branch_id');
       $this->db->from('user');
       $this->db->join('userprevilage', 'user.up_id = userprevilage.up_id');
       if ($id != null) {
            $this->db->where('user.id', $id);
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