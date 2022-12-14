<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '512M');

/**
 * 
 */
class reportbranchlive extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->library('datatables');
        $this->load->model('mreport_live_branch'); 
        $this->load->model('Masters', 'master');

        if (!$this->session->userdata('islogin')) {
            redirect(base_url('signin/'));
        }


        $this->detail_field_mapper = array(
            'merchant_name' => 'Wajib Pajak',
            'branch_name' => 'Outlet',
            'bill_no' => 'Nomor Bill',
            'bill_date' => 'Tanggal',
            'item_name' => 'Nama Item',
            'item_type' => 'Jenis Item',
            'item_price' => 'Harga Item',
            'quantity' => 'Jumlah',
            'item_amount' => 'Harga Item',
        );
    }

    public function index()
    {
        if($_SESSION['level'] == "4"){
            $merchant_id = $this->master->npwp($_SESSION['npwp']);
            $data['merchants'] = $this->master->get_merchant_by_merchantid($merchant_id);
            $data['branch'] = $this->master->branch_id($merchant_id[0], 'ALL');
        }else{
            $data['merchants'] = $this->master->merchant_id();
            if($_SESSION['level']=="5"){
                $data['branch'] = $this->master->branch_id($_SESSION['merchantid'], 'ALL');
            }else if($_SESSION['level']=="6"){
                $data['branch'] = $this->master->branch_id($_SESSION['merchantid'],$_SESSION['branchid']);
            }
        }

       $data['subans'] = $this->master->get_suban()->result();
        
        $class = ['class' => 'reportbranchlive'];
        
        $access = [
            'accessModule' => $this->master->user_access($_SESSION['up_id'])
        ];

        $this->load->view('main/header');
        $this->load->view('main/global_headbar');
        $this->load->view('main/global_sidebar', $access);
        $this->load->view('report/live_branch', $data);
        $this->load->view('main/global_footbar');
        $this->load->view('main/footer', $class);
    }

    public function excel($merchant_id, $branch_id, $year, $month, $suban_id)
    {
    	$dataMonitoring =  $this->mreport_live_branch->get_data($year, $month, $merchant_id, $branch_id, $suban_id)->result();

    	 $result = [
            'title' => 'Laporan Detail',
            'fetch' => $dataMonitoring
        ];

        $this->load->view('report/excel_report_live_branch', $result);
    }
    public function get_data()
    {
        foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }

        if($_SESSION['level'] == "5"){
             $merchant_id = $_SESSION['merchantid'];
        }else if ($_SESSION['level'] == "6") {
            $merchant_id = $_SESSION['merchantid'];
            $branch_id = $_SESSION['branchid'];
        }

        if ($_SESSION['level'] == 3) {
            $suban_id = $_SESSION['suban_id'];
        }

       	
        $dataMonitoring =  $this->mreport_live_branch->get_data_table($year, $month, $merchant_id, $branch_id, $suban_id)->result();
        
        $data   = [];
        $row    = [];
        $drawData = [];
        $status = [];

       foreach ($dataMonitoring as $rowDetail) {
            $row    = [];
            $row[]  = $rowDetail->merchant_name;
            $row[]  = $rowDetail->branch_name;
            $row[]  = $rowDetail->npwp;
            $row[]  = $rowDetail->nopd;
            $row[]  = date('d F Y', strtotime($rowDetail->date_live));	          	
            $data[] = $row;
        }

        $output = [
            'draw' => $_POST['draw'],
            "recordsTotal" => $this->mreport_live_branch->count_all($year, $month, $merchant_id, $branch_id, $suban_id),
            "recordsFiltered" => $this->mreport_live_branch->count_filtered($year, $month, $merchant_id, $branch_id, $suban_id),
            "data" => $data,
        ];
    echo json_encode($output,true);
    exit();
    }
}

?>