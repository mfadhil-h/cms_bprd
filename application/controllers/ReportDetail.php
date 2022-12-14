<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '512M');

/**
 * 
 */
class ReportDetail extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->library('datatables');
        $this->load->model('Report_detail'); 
        $this->load->model('Masters', 'master');

        if (!$this->session->userdata('islogin')) {
            redirect(base_url('signin/'));
        }


        $this->header_field_mapper = array(
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
        $access = [
            'accessModule' => $this->master->user_access($_SESSION['up_id'])
        ];

        if($_SESSION['level'] == "4"){
            $merchant_id = $this->master->npwp($_SESSION['npwp']);
            $data['merchants'] = $this->master->get_merchant_by_merchantid($merchant_id);
            $data['branch'] = $this->master->branch_id($merchant_id[0], 'ALL');
        }else{
            $data['merchants'] = $this->master->merchant_id();
            if($_SESSION['level'] == "5"){
                $data['branch'] = $this->master->branch_id($_SESSION['merchantid'], 'ALL');
            }else if($_SESSION['level'] == "6"){
                $data['branch'] = $this->master->branch_id($_SESSION['merchantid'],$_SESSION['branchid']);
            }
        }

        $dataSuban = $this->master->get_suban()->result();

        $data['subans'] = $dataSuban;
        
        $class = ['class' => 'reportdetail'];

        $this->load->view('main/header');
        $this->load->view('main/global_headbar');
        $this->load->view('main/global_sidebar', $access);
        $this->load->view('report/detail', $data);
        $this->load->view('main/global_footbar');
        $this->load->view('main/footer', $class);
    }

        public function excel($start_date, $end_date, $merchant_id=null, $branch_id=null, $suban_id, $bill_no=null) 
        {
        $class = ['class' => 'reportonlinetransaction'];

        if ($_SESSION['level'] == "5"){
            $merchant_id = $_SESSION['merchantid'];
        } else if ($_SESSION['level'] == "6") {
            $merchant_id = $_SESSION['merchantid'];
            $branch_id = $_SESSION['branchid'];
        }

        if ($_SESSION['level'] == 3) {
            $suban_id = $_SESSION['suban_id'];
        }

        $start_date = $start_date;
        $end_date = $end_date;

        $dayStart = date('d', strtotime($start_date));
        $month = date('m', strtotime($start_date));
        $year = date('Y', strtotime($start_date));

        $dayEnd = date('d', strtotime($end_date));

        $fetch = [];
        for ($i=$dayStart; $i <= $dayEnd ; $i++) { 
            $start = $year.'-'.$month.'-'.$i.' 00:00:00';
            $end = $year.'-'.$month.'-'.$i.' 23:59:59';
            $data = null;
            $data =  $this->Report_detail->get_data($start, $end, $merchant_id, $branch_id, $suban_id, $bill_no)->result_array();
          
            $fetch[] = $data;

        }
        
        $result = [
            'title' => 'Laporan Detail',
            'fetch' => $fetch
        ];

        $this->load->view('report/detail_report_excel', $result);
    }
    
    public function print_report($start_date, $end_date, $merchant_id=null, $branch_id=null, $suban_id, $bill_no=null) 
    {
        $class = ['class' => 'reportonlinetransaction'];

        if ($_SESSION['level'] == "5"){
            $merchant_id = $_SESSION['merchantid'];
        } else if ($_SESSION['level'] == "6") {
            $merchant_id = $_SESSION['merchantid'];
            $branch_id = $_SESSION['branchid'];
        }

        if ($_SESSION['level'] == 3) {
            $suban_id = $_SESSION['suban_id'];
        }

        $start_date = $start_date.' 00:00:00';
        $end_date = $end_date.' 23:59:59';

        $data =  $this->Report_detail->get_data($start_date, $end_date, $merchant_id, $branch_id, $suban_id, $bill_no)->result_array();

        $result = [
            'fetch' => $data
        ];

        $this->load->view('main/header');
        $this->load->view('main/footer', $class);
        $this->load->view('report/detail_report', $result);
    }


    public function get_data()
    {
        foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }

        if ($_SESSION['level'] == "5"){
            $merchant_id = $_SESSION['merchantid'];
        } else if ($_SESSION['level'] == "6") {
            $merchant_id = $_SESSION['merchantid'];
            $branch_id = $_SESSION['branchid'];
        }

        if ($_SESSION['level'] == 3) {
            $suban_id = $_SESSION['suban_id'];
        }

      
        $start_date = $start_date.' 00:00:00';
        $end_date = $end_date.' 23:59:59';

        $dataDetail =  $this->Report_detail->get_data_table($start_date, $end_date, $merchant_id, $branch_id, $suban_id, $bill_no)->result();

        $data   = [];
        $row    = [];
        foreach ($dataDetail as $rowDetail) {
            $row    = [];
            $row[]  = $rowDetail->merchant_name;
            $row[]  = $rowDetail->branch_name;
            $row[]  = $rowDetail->bill_no;
            $row[]  = $rowDetail->bill_date;
            $row[]  = $rowDetail->item_name;
            $row[]  = $rowDetail->item_type;
            $row[]  = number_format($rowDetail->item_price);
            $row[]  = number_format($rowDetail->quantity);
            $row[]  = number_format($rowDetail->item_amount);
            $data[] = $row;
        }

        $output = [
            'draw' => $_POST['draw'],
            "recordsTotal" => $this->Report_detail->count_all($start_date, $end_date, $merchant_id, $branch_id, $suban_id, $bill_no),
            "recordsFiltered" => $this->Report_detail->count_filtered($start_date, $end_date, $merchant_id, $branch_id, $suban_id, $bill_no),
            "data" => $data,
        ];

        echo json_encode($output,true);
        exit();
    }

     public function excel_export($type = "xlsx")
    {
        foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }
        $dataMerchantId = $merchant_id;
        $dataBranchId = $branch_id;

        if ($_SESSION['level'] == 3) {
            $suban_id = $_SESSION['suban_id'];
        }

        if($_SESSION['level'] < 5 ){
            if ((!empty($merchant_id)) && (($merchant_id) != 'ALL')) {
                $dataMerchantId = $merchant_id;    
                if ((!empty($branch_id)) && (($branch_id) != 'ALL')) {
                    $dataBranchId = $dataBranchId;
                }
            }
        }else{
            $filter[] = '(merchant_id="' . $_SESSION['merchantid'] . '")';
            $dataMerchantId = $_SESSION['merchantid']; 
            if ((!empty($branch_id)) && (($branch_id) != 'ALL')) {
                 $dataBranchId =  $branch_id;
            }
        }  

        $start_date = $start_date.' 00:00:00';
        $end_date = $end_date.' 23:59:59';
        $result = $this->Report_detail->get_data($start_date, $end_date, $dataMerchantId, $dataBranchId, $suban_id, $bill_no);
        
        if ($result->num_rows() > 0) {
            $list_data = $result->result_array();
            foreach ($list_data[0] as $key => $value) {
                $fields[] = $this->header_field_mapper[$key];
            }
        } else {
            echo json_encode(array('message' => 'Data tidak ada! Silakan lakukan pencarian dengan data yang lain.'));
            exit();
        }

        $this->load->library("PHPExcel");
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $letter = "A";
        for ($i = 0; $i < count($fields); $i++) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($letter . '1', $fields[$i]);
            $letter++;
        }
        $col = "2";
        for ($i = 0; $i < count($list_data); $i++) {
            $row = "A";
            foreach ($list_data[$i] as $key => $value) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($row . $col, $value);
                $row++;
            }
            $col++;
        }
        $objPHPExcel->getActiveSheet()->setTitle('Report Detail');

        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        if ($type == 'xlsx') {
            $filename = 'Report Transaction - ' . date('YmdHi') . '.xlsx';
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        } else if ($type == 'csv') {

            $filename = 'Report Transaction - ' . date('YmdHi') . '.csv';
            header('Content-Type: text/csv');

            header('Content-Disposition: attachment;filename="' . $filename . '');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');

        }

        $objWriter->save(FCPATH . 'res/report/' . $filename);

        echo json_encode(array('message' => 'File laporan berhasil dibuat! Silakan download <strong><a href="' . str_replace('index.php/', '', base_url('res/report/' . $filename)) . '"><img src="' . str_replace('index.php/', '', base_url('res/download.png')) . '" /> disini </a></strong>'));
    }

}

?>