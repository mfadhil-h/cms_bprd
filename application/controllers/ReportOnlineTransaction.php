<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '512M');

/**
 * 
 */
class ReportOnlineTransaction extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
        $this->load->library('pdf');
        $this->load->library('datatables');
        $this->load->model('Report_online_transaction', 'rot'); 
        $this->load->model('Masters', 'master');

        if (!$this->session->userdata('islogin')) {
            redirect(base_url('signin/'));
        }


        $this->header_field_mapper = array(
            'merchant_name' => 'Wajib Pajak',
            'branch_name' => 'Outlet',
            'npwp' => 'NPWP',
            'nopd' => 'NOPD',
            'bill_no' => 'No Bill',
            'bill_date' => 'Tanggal',
            'total_amount' => 'Total Amount',
            'service' => 'Service Charge',
            'ppn' => 'PPN',
            'total_trx_amount' => 'Total Trx Amount',
            'payment_type' => 'Jenis Pembayaran'
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
        
        $data['subans'] = $this->master->get_suban()->result();
        $class = ['class' => 'reportonlinetransaction'];

        $this->load->view('main/header');
        $this->load->view('main/global_headbar');
        $this->load->view('main/global_sidebar', $access);
        $this->load->view('report/onlineTransaction', $data);
        $this->load->view('main/global_footbar');
        $this->load->view('main/footer', $class);
	}

    public function print_report($start_date, $end_date, $merchant_id = null, $branch_id = null, $suban_id = 'ALL', $bill_no=null) 
    {
        $class = ['class' => 'reportonlinetransaction'];

        $start_date = $start_date.' 00:00:00';
        $end_date = $end_date.' 23:59:59';

        if ($_SESSION['level'] == "5"){
            $merchant_id = $_SESSION['merchantid'];
        } else if ($_SESSION['level'] == "6") {
            $merchant_id = $_SESSION['merchantid'];
            $branch_id = $_SESSION['branchid'];
        }

        if ($_SESSION['level'] == 3) {
            $suban_id = $_SESSION['suban_id'];
        }
        
        $data =  $this->rot->get_data($start_date, $end_date, $merchant_id, $branch_id, $suban_id, $bill_no)->result_array();

        $result = [
            'fetch' => $data
        ];

        $this->load->view('main/header', $class);
        $this->load->view('main/footer');
        $this->load->view('report/online_transaction_report', $result);
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

        $start_date = $start_date.' 00:00:00';
        $end_date = $end_date.' 23:59:59';

        if ($_SESSION['level'] == 3) {
            $suban_id = $_SESSION['suban_id'];
        }

        $dataTransaction =  $this->rot->get_data_tables($start_date, $end_date, $merchant_id, $branch_id, $suban_id, $bill_no)->result();

        $row    = [];
        $data   = [];
        foreach ($dataTransaction as $key => $rowData) {
            $row = [];
            $row[]  = $rowData->merchant_name;
            $row[]  = $rowData->branch_name;
            $row[]  = $rowData->npwp;
            $row[]  = $rowData->nopd;
            $row[]  = $rowData->bill_no;
            $row[]  = $rowData->bill_date;
            $row[]  = number_format($rowData->total_amount);
            if ($rowData->service == null) {
                $row[]  = number_format(0);
            } else {
                $row[]  = number_format($rowData->service);
            }

            $row[]  = number_format($rowData->ppn);
            $row[]  = number_format($rowData->total_trx_amount);
            $row[]  = $rowData->payment_type;
            $data[] = $row; 
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->rot->count_all($start_date, $end_date, $merchant_id, $branch_id, $suban_id, $bill_no),
            "recordsFiltered" => $this->rot->count_filtered($start_date, $end_date, $merchant_id, $branch_id, $suban_id, $bill_no),
            "data" => $data,
        );

        echo json_encode($output,true);
        exit();
    }

	 public function excel_export($type = "xlsx")
    {
        foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }

        if ($_SESSION['level'] == 3) {
            $suban_id = $_SESSION['suban_id'];
        }

        $dataMerchantId = $merchant_id;
        $dataBranchId = $branch_id;

        $start_date = $start_date.' 00:00:00';
        $end_date = $end_date.' 23:59:59';

        if($_SESSION['level']<5){
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

        $result = $this->rot->get_data($start_date, $end_date, $dataMerchantId, $dataBranchId, $suban_id, $bill_no);

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
        $objPHPExcel->getActiveSheet()->setTitle('Report Online Transaction');

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