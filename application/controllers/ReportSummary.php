<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '512M');

/**
 * 
 */
class ReportSummary extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
        $this->load->library('pdf');
        $this->load->model('Report_summary', 'report_summary'); 
        $this->load->model('Masters', 'master');

        if (!$this->session->userdata('islogin')) {
            redirect(base_url('signin/'));
        }


        $this->header_field_mapper = array(
            'date_transaction'   => 'Tanggal',
            'merchant_name' => 'Wajib Pajak',
            'branch_name' => 'Outlet',
            'daily_tax' => 'PPN',
            'daily_transaction' => 'Total Transaksi'
        );
	}

	public function index()
	{
        $class = ['class' => 'reportsummary'];
        $access = [
            'accessModule' => $this->master->user_access($_SESSION['up_id'])
        ];

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
        
        $this->load->view('main/header');
        $this->load->view('main/global_headbar');
        $this->load->view('main/global_sidebar', $access);
        $this->load->view('report/summary', $data);
        $this->load->view('main/global_footbar');
        $this->load->view('main/footer', $class);
	}

    public function getData()
    {
        $dataMonth = [  '1' => 'January',
                        '2' => 'February',
                        '3' => 'March',
                        '4' => 'April',
                        '5' => 'May',
                        '6' => 'June',
                        '7' => 'July',
                        '8' => 'Agust',
                        '9' => 'September',
                        '10'=> 'October',
                        '11'=> 'November',
                        '12'=> 'December' ];

        foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }

        if ($_SESSION['level'] == 3) {
            $suban_id = $_SESSION['suban_id'];
        }

        if ($_SESSION['level'] == "5"){
            $merchant_id = $_SESSION['merchantid'];
        } else if ($_SESSION['level'] == "6") {
            $merchant_id = $_SESSION['merchantid'];
            $branch_id = $_SESSION['branchid'];
        }

        
        $data  = $this->report_summary->get_data($month, $year, $merchant_id, $branch_id, $suban_id)->result_array();

        $totalTransaction = 0;
        $totalTax = 0;

        foreach ($data as $rowData) {
            $totalTransaction += $rowData['daily_transaction'];
            $totalTax += $rowData['daily_tax'];
        }

        $result = [
            'totalTransaction' => number_format($totalTransaction),
            'totalTax'         => number_format($totalTax),
            'year'             => $year,
            'month'            => $dataMonth[$month]
        ];

        echo json_encode($result,true);
    }

	public function excel($type = 'xlsx')
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
        } else if($_SESSION['level'] > 3) {
            $suban_id = 'ALL';
        }

        $result  = $this->report_summary->get_data($month, $year, $merchant_id, $branch_id, $suban_id)->result_array();

        if (count($result) > 0) {
            $list_data = $result;
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

        $objPHPExcel->getActiveSheet()->setTitle('Report Summary');

        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        if ($type == 'xlsx') {
            $filename = 'Report Summary - ' . date('YmdHi') . '.xlsx';
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        } else if ($type == 'csv') {
            $filename = 'Report Summary - ' . date('YmdHi') . '.csv';
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment;filename="' . $filename . '');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
        }

        $objWriter->save(FCPATH . 'res/report/' . $filename);

        echo json_encode(array('message' => 'File laporan berhasil dibuat! Silakan download <strong><a href="' . str_replace('index.php/', '', base_url('res/report/' . $filename)) . '"><img src="' . str_replace('index.php/', '', base_url('res/download.png')) . '" /> disini </a></strong>'));
	}

	public function data_search()
	{
        $dataMonth = [  '1' => 'January',
                        '2' => 'February',
                        '3' => 'March',
                        '4' => 'April',
                        '5' => 'May',
                        '6' => 'June',
                        '7' => 'July',
                        '8' => 'Agust',
                        '9' => 'September',
                        '10'=> 'October',
                        '11'=> 'November',
                        '12'=> 'December' ];

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

        $row    = [];
        $data   = [];
        $dataSummary = $this->report_summary->get_data_table($month, $year, $merchant_id, $branch_id, $suban_id)->result();

        foreach ($dataSummary as $key => $value) {
            $row = [];
            $row[] = $value->date_transaction;
            $row[] = $value->merchant_name;
            $row[] = $value->branch_name;
            $row[] = number_format($value->daily_tax);
            $row[] = $value->daily_transaction;
            $data[] = $row;
        }

        $output = [
            'draw' => $_POST['draw'],
            "recordsTotal" => $this->report_summary->count_all($month, $year, $merchant_id, $branch_id, $suban_id),
            "recordsFiltered" => $this->report_summary->count_filtered($month, $year, $merchant_id, $branch_id, $suban_id),
            "data" => $data,
        ];

        echo json_encode($output,true);
        exit();
	}

    public function print_report($month, $year, $merchant_id = null, $branch_id = null, $suban_id)
    {

        $class = ['class' => 'reportsummary'];
        
        if ($_SESSION['level'] == "5"){
            $merchant_id = $_SESSION['merchantid'];
        } else if ($_SESSION['level'] == "6") {
            $merchant_id = $_SESSION['merchantid'];
            $branch_id = $_SESSION['branchid'];
        }

        if ($_SESSION['level'] == 3) {
            $suban_id = $_SESSION['suban_id'];
        } else if($_SESSION['level'] > 3) {
            $suban_id = 'ALL';
        }

        $data  = $this->report_summary->get_data($month, $year, $merchant_id, $branch_id, $suban_id)->result_array();
        
        $result = [
            'fetch' => $data
        ];

        $this->load->view('main/header', $class);
        $this->load->view('main/footer');
        $this->load->view('report/summary_report', $result);
    }
}

?>
