<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class Report_payment extends CI_Model
{
	var $column_order = array(
		'm.merchant_name',
  		'b.branch_name',
  		'b.npwp',
		'b.nopd',
		'pa.periode',
  		'pa.total_payment',
  		'pa.kode_bayar',
  		'pa.payment_date'
	);
    var $column_search = array(
    	'm.merchant_name',
  		'b.branch_name',
  		'b.npwp',
		'b.nopd',
		'pa.periode',
  		'pa.total_payment',
  		'pa.kode_bayar',
  		'pa.payment_date');

    var $order = array('merchant_name' => 'asc');

    public function query($month, $year, $merchantId, $branchId, $suban_id, $kode_bayar, $type)
    {
				
    	$this->db->select('
			  		m.merchant_name  AS merchant_name,
			  		b.branch_name      AS branch_name,
			  		b.npwp             AS npwp,
					b.nopd             AS nopd,
					pa.periode         		AS periode,
			  		pa.total_payment   		AS total_payment,
			  		pa.kode_bayar 			AS kode_bayar,
			  		pa.payment_date 		AS payment_date
			');
		$this->db->from('paymentautodebet as pa');
		$this->db->join('merchant as m', 'm.merchant_id = pa.merchant_id');
		$this->db->join('branch as b', 'b.merchant_id = pa.merchant_id AND b.branch_id = pa.branch_id');
		$this->db->join('kecamatan as kec', 'kec.kec_id = b.kec_id');
		$this->db->where('pa.periode', ($month < 10 ? '0'.$month : $month ).'/'.$year);
		$this->db->where('pa.flag', '2');
		
		if ($merchantId != 'ALL') {
			$this->db->where('pa.merchant_id = '.$merchantId);
		
		}
		if ($branchId != 'ALL') {
			$this->db->where('pa.branch_id = '.$branchId);
		
		}

		if ($suban_id != 'ALL') {
			$this->db->where('kec.suban_id = '.$suban_id);
		}		

		if($kode_bayar != '' || !empty($kode_bayar)) {
			$this->db->where('pa.kode_bayar', $kode_bayar);
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

    public function get_data_table($month, $year, $merchantId, $branchId, $suban_id, $kode_bayar)
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

    	$data = $this->query($month, $year, $merchantId, $branchId, $suban_id, $kode_bayar, 'dataTable');
    	return $data;
    }

    public function count_all($month, $year, $merchantId, $branchId, $suban_id, $kode_bayar)
    {
    	$data = $this->query($month, $year, $merchantId, $branchId, $suban_id, $kode_bayar, 'countAll');
    	return $data;
    }

    public function count_filtered($month, $year, $merchantId, $branchId, $suban_id, $kode_bayar)
    {
    	$data = $this->query($month, $year, $merchantId, $branchId, $suban_id, $kode_bayar, 'countFiltered');
    	return $data->num_rows();
    }

	public function get_data($month, $year, $merchantId, $branchId, $suban_id, $kode_bayar)
	{
		$data = $this->query($month, $year, $merchantId, $branchId, $suban_id, $kode_bayar, 'getData');
    	return $data;
	}
}

?>