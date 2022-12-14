<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Masters extends CI_Model {
	
	public function merchantid()
    {
        $this->db->select_max('merchant_id');
        $result = $this->db->get('merchant');

        return $result->row(); 
    }
	

    public function get_kode_pajak($merchant_id, $branch_id)
    {
        $this->db->select('bt_kode_pajak, branch.nopd, branch.npwp');
        $this->db->from('branchtype');
        $this->db->join('branch', 'branchtype.bt_id = branch.bt_id');
        $this->db->where('branch.branch_id', $branch_id);
        $this->db->where('branch.merchant_id', $merchant_id);
        $query = $this->db->get();
        
        return $query;
    }

    public function login($username, $password)
    {
        $this->db->select('
            user.`id` as id, 
            user.`up_id as up_id`, 
            user.`username` as username, 
            user.`password` as password,
            userprevilage.`up_level` as up_level,
            user.`suban_id` as suban_id,
            user.`merchant_id` as merchant_id,
            user.`branch_id` as branch_id'
        );
        $this->db->from('user');
        $this->db->join('userprevilage', 'user.up_id = userprevilage.up_id');
        $this->db->where('user.username', $username);
        $this->db->where('user.password', $password);
        $query = $this->db->get();

        return $query;
    }

    public function user_access($up_id)
    {
        $this->db->select('ma_id, module.mod_id, up_id, ma_previlage, module.`mod_code`');
        $this->db->from('moduleaccess');
        $this->db->join('module', 'module.mod_id = moduleaccess.mod_id');
        $this->db->where('up_id', $up_id);
        $query = $this->db->get()->result();

        $data =  [];
        foreach ($query as $value) {
            $data[$value->mod_code] = $value->ma_previlage;
        }

        return $data;
    }

    public function module_access($up_id, $mod_code)
    {
        $this->db->select('ma_previlage');
        $this->db->from('moduleaccess');
        $this->db->join('module', 'module.mod_id = moduleaccess.mod_id');
        $this->db->where('up_id', $up_id);
        $this->db->where('module.mod_code', $mod_code);
        $query = $this->db->get();    
        
        return $query;
    }

	public function billermappingid()
    {
        $this->db->select_max('id');
        $result = $this->db->get('billerstatusmapping');

        return $result->row(); 
    }

    public function billerproductid()
    {
        $this->db->select_max('id');
        $result = $this->db->get('merchantbillerproduct');

        return $result->row(); 
    }

    public function jatisproductid()
    {
        $this->db->select_max('id');
        $result = $this->db->get('jatisproduct');

        return $result->row(); 
    }

    public function getBillerName()
    {
        $result = $this->db->get('biller');
        return $result->result_array(); 
    }

    public function openclose_product($data)
    {
        $this->db->set('status', $data['status']);
        $this->db->where('biller_product_code', $data['billercode']);
        $this->db->update('merchantbillerproduct');
		
        $sql = "SELECT * FROM merchantbillerproduct WHERE biller_product_code = '".$data['billercode']."' ";
        $q = $this->db->query($sql);
        $q->result_array();

        $val = $q->result_array;

    }

    public function get_billers_name()
    {
        $this->db->select('biller_name');
        $result = $this->db->get('biller');

        return $result->result_array(); 
    }
    
    public function get_productcodeid($id)
    {
        $this->db->where('id', $id);
        $q = $this->db->get('billerproduct');
        return $q->row();
    }

    public function get_merchant($where=array())
    {
        $this->db->select('merchant_id,merchant_name');
        if(!empty($where))
        {
            $this->db->where($where);
        }
        $result = $this->db->get('merchant');

        return $result->result_array();
    }

    public function get_suban()
    {
        $this->db->select('suban_id, suban_name');
        $this->db->from('suban');
        $query = $this->db->get();

        return $query;
    }
	
    public function merchant($where=array())
    {
        $this->db->select('merchant_name');
        if(!empty($where))
        {
            $this->db->where($where);
        }
        $result = $this->db->get('merchant');

        return $result->result_array();
    }

    public function biller($where=array())
    {
        $this->db->select('biller_name');
        if(!empty($where))
        {
            $this->db->where($where);
        }
        $result = $this->db->get('biller');

        return $result->result_array();
    }

    public function payment_gateway($where=array())
    {
        $this->db->select('PaymentGatewayName');
        if(!empty($where))
        {
            $this->db->where($where);
        }
        $result = $this->db->get('paymentgateway');

        return $result->result_array();
    }

    public function biller_product($where=array())
    {
        $this->db->select('biller_product_name');
        if(!empty($where))
        {
            $this->db->where($where);
        }
        $result = $this->db->get('billerproduct');

        return $result->result_array();
    }

    public function jatis_product($where=array())
    {
        $this->db->select('jatis_product_name');
        if(!empty($where))
        {
            $this->db->where($where);
        }
        $result = $this->db->get('jatisproduct');

        return $result->result_array();
    }

    public function merchant_owner($where=array())
    {
        $this->db->select('ARMName');
        if(!empty($where))
        {
            $this->db->where($where);
        }
        $result = $this->db->get('arm');

        return $result->result_array();
    }

    public function payment_status_transaction()
    {
        $this->db->select('paymentstatus');
        $this->db->group_by('paymentstatus');
        $result = $this->db->get('v_report_transaction');
        return $result->result_array();
    }

    public function biller_status_transaction()
    {
        $this->db->select('billerstatus');
        $this->db->group_by('billerstatus');
        $result = $this->db->get('v_report_transaction');
        return $result->result_array();
    }

    public function payment_status_finance()
    {
        $result[] = array('statuspg'=>'Success');
        $result[] = array('statuspg'=>'Pending');
        $result[] = array('statuspg'=>'Failed');
        return $result;
    }

    public function biller_status_finance()
    {
        $result[] = array('statusbiller'=>'Success');
        $result[] = array('statusbiller'=>'Pending');
        $result[] = array('statusbiller'=>'Failed');
        return $result;
    }

    public function merchant_id(){
        $query=$this->db->get('merchant');
        $data = $query->result_array();
        $merchant = array();

        for($i=0;$i<$query->num_rows();$i++){
            $merchantid = $data[$i]['merchant_id'];
            $merchantname = $data[$i]['merchant_name'];
            //$branchid = $this->branch_id($merchantid);

            $merchant[$i]['merchant_id'] = $merchantid;
            $merchant[$i]['merchant_name'] = $merchantname;
            //$merchant[$i]['branch_id'] = $branchid;
        }
        return $merchant;
    }

    public function branch_id($merchant_id,$branch_id, $subanId = null){
        if ($subanId != null || !empty($subanId)) {
            $this->db->select('branch.branch_id, branch.branch_name, branch.nopd');
            $this->db->from('branch');
            $this->db->join('kecamatan', 'branch.kec_id = kecamatan.kec_id');
            $this->db->join('suban', 'kecamatan.suban_id = suban.suban_id');
            $this->db->where('branch.merchant_id ='.$merchant_id.' and suban.suban_id = '.$subanId);
            $query = $this->db->get();
        } else {
            if($branch_id == 'ALL' || $branch_id == 'All'){
                $query=$this->db->get_where('branch',array('merchant_id'=>$merchant_id));
            }else{
                $query=$this->db->get_where('branch',array('merchant_id'=>$merchant_id, 'branch_id'=>$branch_id));
            }
        }
        

        $data = $query->result_array();

        $branch=array();

        for($i=0;$i<$query->num_rows();$i++){
            $branch[$i]['branch_id'] = $data[$i]['branch_id'];
            $branch[$i]['branch_name'] = $data[$i]['branch_name'];
            $branch[$i]['nopd'] = $data[$i]['nopd'];
        }
        
        return $branch;
    }

    public function npwp($npwp){   
        $this->db->where('npwp',$npwp);
        $this->db->group_by('merchant_id');
        $query = $this->db->get('branch');
        $data = $query->result_array();

        for($i=0;$i<$query->num_rows();$i++){
            $merchantid = $data[$i]['merchant_id'];
            $merchant[] = $merchantid;
        }
        return $merchant;
    }

    public function get_merchant_by_merchantid($merchantid)
    {
        $this->db->select('merchant_id,merchant_name');
        $this->db->where_in('merchant_id',$merchantid);
        $result = $this->db->get('merchant');

        return $result->result_array();
    }
}
