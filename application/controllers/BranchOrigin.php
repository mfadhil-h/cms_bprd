<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Branch extends CI_Controller {

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
		$this->load->model('Masters');
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
    }

    public function _mb_output($output = null)
    {
        $data['namabiller'] = $this->Masters->getBillerName();
        $data['merchantname'] = $this->Masters->get_merchant();
        $this->load->view('main/global_gcrud_header',$output);
        $this->load->view('main/global_headbar');
        $this->load->view('main/global_sidebar');
        $this->load->view('merchant/global_gcrud_content',$data);
        $this->load->view('main/global_footbar');
        $this->load->view('merchant/global_gcrud_footer',$output);
    }

    public function index()
    {
        try{
            $crud = new Grocery_CRUD();
			
//          $crud->set_theme('datatables');
            $crud->set_table('branch');
            $crud->set_subject('Branch');
            $crud->display_as('merchant_id','Merchant Id');
            $crud->display_as('branch_id','Branch Id');
            $crud->display_as('branch_name','Branch Name');
            $crud->display_as('npwp','NPWP');
            $crud->display_as('nopd','NOPD');
            $crud->display_as('location','Location');
			
			//$crud->unique_fields('nopd');
			//$crud->required_fields('merchant_name','shared_key');
			
            if ($this->session->userdata('level') > 2) {
                $crud->where('merchant_id', $this->session->userdata('merchantid'));
                $crud->columns('branch_name','npwp','nopd','location');
            }else{
                // $crud->set_relation('merchant_id','merchant','merchant_id');
                $crud->display_as('merchant_id','Merchant Id');

                $crud->set_relation('merchant_id','merchant','merchant_id');
                $crud->display_as('merchant_name','Merchant Name');
                
                $crud->required_fields('merchant_id','branch_id','branch_name','npwp','nopd','location');
                $crud->columns('merchant_id','branch_id','branch_name','npwp','nopd','location');
            }
            $crud->order_by('merchant_id','asc');
			$crud->unset_fields('branch_id','created','modified');  

		    if($this->session->userdata('level') < 2){
                $crud->callback_after_insert(array($this, 'audit_trail_after_insert'));
            }else{
                $crud->unset_delete();
                $crud->unset_add();
                $crud->unset_edit();
                $crud->unset_read();
            }
            $crud->unset_export();
            $crud->unset_print();
            
            $output = $crud->render();

            $this->_gc_output($output);

        }catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }

    public function audit_trail_after_insert($post_array, $primary_key)
    {           
        $query = $this->db->get_where('branch',array('id'=>$primary_key));
        $data = $query->row_array();
        $merchant_id = $data['merchant_id'];

        $this->db->select_max('branch_id');
        $query = $this->db->get_where('branch',array('merchant_id'=>$merchant_id));
        $data = $query->row_array();
        $branch_id = $data['branch_id'];

        $created_data['branch_id'] = $branch_id + 1;
        $created_data['created'] = date('Y-m-d H:i:s');
        
        $idname     = 'id';
        $tablename  = 'branch';
        
        $this->db->where($idname,$primary_key);
        $this->db->update($tablename,$created_data);

        return true;
    }
}
