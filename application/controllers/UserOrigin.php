<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

    public function __construct()
    {
        parent::__construct();
 
        if(!$this->session->userdata('islogin'))
        {
            redirect(base_url('signin/'));
        }

    }

    public function _gc_output($output = null)
    {

		$this->load->view('main/global_gcrud_header',$output);
		$this->load->view('main/global_headbar');
		$this->load->view('main/global_sidebar');
		$this->load->view('main/global_gcrud_content',$output);
		$this->load->view('main/global_footbar');
		$this->load->view('main/global_gcrud_footer',$output);
//		print_r($output);
//		exit();
    }

	public function index()
	{
		try{
			$crud = new grocery_CRUD();

			//$crud->set_theme('datatables');
			$crud->set_table('user');
			$crud->set_subject('User');

      // $crud->set_primary_key('merchant_id', 'user');
      // $crud->set_primary_key('branch_id', 'user');

			// $crud->required_fields('username','password');
      $crud->field_type('password','password');
			// $crud->unique_fields('username');

			if($_SESSION['level']=='2'){
				$username = 'sadmin';
				$crud->where('username <>',$username);
			}
			if($_SESSION['level']=='1'){
				$crud->field_type('level','dropdown', array('1' => 'Super Admin', '2' => 'Admin', '3' => 'NPWP', '4' => 'Merchant', '5' => 'Branch', '6' => 'Suban'));
			}else{
				$crud->field_type('level','dropdown', array('2' => 'Admin', '3' => 'NPWP', '4' => 'Merchant', '5' => 'Branch', '6' => 'Suban'));
			}
            $crud->set_relation('merchant_id', 'merchant', 'merchant_name');
            $crud->display_as('merchant_id','Merchant Name');
            
            $crud->display_as('branch_id','Branch Id');

            $crud->set_relation('suban_id', 'suban', 'suban_name');
            $crud->display_as('suban_id', 'Suku Badan Pajak');

            $crud->order_by('level');
            
            $crud->callback_before_insert(array($this, 'change_password'));
            $crud->callback_before_update(array($this, 'check_change_password'));
            
            $crud->callback_after_insert(array($this, 'audit_trail_after_insert'));
//            $crud->callback_after_update(array($this, 'audit_trail_after_update'));
//            $crud->callback_after_delete(array($this, 'audit_trail_after_delete'));
			
            $crud->unset_fields('created');
            $crud->unset_export();
            $crud->unset_print();
			$output = $crud->render();

			$this->_gc_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

    public function change_password($post_array,$primary_key)
    {
        $post_array['password'] = md5($post_array['password']);
        return $post_array;
    }
    public function check_change_password($post_array,$primary_key)
    {
        $c_q = $this->db->get_where('user',array('id'=>$primary_key,'password'=>$post_array['password']));
        if($c_q->num_rows()>0)
        {
            unset($post_array['password']);
        }else{
            $post_array['password'] = md5($post_array['password']);
        }
        return $post_array;
    }

   public function audit_trail_after_insert($post_array, $primary_key)
   {
   	$created_data['created'] = date('Y-m-d H:i:s');
   	$this->db->where('id',$primary_key);
   	$this->db->update('user',$created_data);
       //audit trail
       // $new_audit = array(
       //     'id_users' => '1',
       //     'url' => $_SERVER['REQUEST_URI'],
       //     'query_type' => 'insert',
       //     'query_data' => json_encode($post_array),
       // );
       // $this->db->insert('audittrail', $new_audit);

       return true;
   }
//
//    public function audit_trail_after_update($post_array, $primary_key)
//    {
//        //audit trail
//        $new_audit = array(
//            'id_users' => '1',
//            'url' => $_SERVER['REQUEST_URI'],
//            'query_type' => 'update',
//            'query_data' => json_encode($post_array),
//        );
//        $this->db->insert('audittrail', $new_audit);
//    }
//
//    public function audit_trail_after_delete($primary_key)
//    {
//        //audit trail
//        $new_audit = array(
//            'id_users' => '1',
//            'url' => $_SERVER['REQUEST_URI'],
//            'query_type' => 'delete',
//            'query_data' => json_encode(array('id' => $primary_key)),
//        );
//        $this->db->insert('audittrail', $new_audit);
//    }
   public function load_branch($merchantid) {
        $sql = "SELECT * FROM branch WHERE merchant_id = '".$merchantid."'";
        $query = $this->db->query($sql);
            $data = array();
            foreach ($query->result() as $value) {
                $data[] = array('value'=>$value->branch_id,'property'=>$value->branch_name);
            }
        echo(json_encode($data,true));
    }
}
