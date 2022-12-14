<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '512M');

/**
 * 
 */
class reportDataMonitoring extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->library('datatables');
        $this->load->model('Report_data_monitoring'); 
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
        
        $class = ['class' => 'reportdatamonitoring'];
        $access = [
            'accessModule' => $this->master->user_access($_SESSION['up_id'])
        ];

        $this->load->view('main/header');
        $this->load->view('main/global_headbar');
        $this->load->view('main/global_sidebar', $access);
        $this->load->view('report/data_monitoring', $data);
        $this->load->view('main/global_footbar');
        $this->load->view('main/footer', $class);
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

        $start_date = $start_date.' 00:00:00';
        $end_date = $end_date.' 23:59:59';

        $firstDay   = date('d', strtotime($start_date));
        $endDay     = date('d', strtotime($end_date));

        $dataMonitoring =  $this->Report_data_monitoring->get_data_table($start_date, $end_date, $merchant_id, $branch_id, $suban_id, $empty_data)->result();
        
        

        $data   = [];
        $row    = [];
        $drawData = [];
        $status = [];

        foreach ($dataMonitoring as $rowDetail) {
            $row    = [];
            $row[]  = $rowDetail->merchant_name;
            $row[]  = $rowDetail->branch_name;

            for ($i=intval($firstDay); $i <= intval($endDay) ; $i++) {
                $row[] = $rowDetail->{'day_'.$i};
            }
            $data[] = $row;
        }

        foreach ($data as $key => $value) {
            $status = [];
            foreach ($value as $index => $row) {
                if ($index > 1) {
                    $status[$row] = $row;
                }
            }

            if (array_key_exists('0', $status) == true) {
                $drawData[] = $value;
            }
            
        }

         $output = [
            'draw' => $_POST['draw'],
            "recordsTotal" => $this->Report_data_monitoring->count_all($start_date, $end_date, $merchant_id, $branch_id, $suban_id, $empty_data),
            "recordsFiltered" => $this->Report_data_monitoring->count_filtered($start_date, $end_date, $merchant_id, $branch_id, $suban_id, $empty_data),
            "data" => $drawData,
        ];
        echo json_encode($output,true);
        exit();
    }

}

?>