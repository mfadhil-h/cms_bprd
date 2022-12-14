<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class subans extends CI_Model
{
	public function getSuban($subanId = null)
	{
		if ($subanId != null || !empty($subanId)) {
			$query = $this->db->get_where('suban', array('suban_id' => $subanId));		
		} else {
			$query = $this->db->get('suban');
		}

		return $query->result_array();
	}

	public function subanName()
	{
		$this->db->select('suban_id, suban_name');
		$query = $this->db->get('suban');
		return $query->result_array();
	}
}

?>