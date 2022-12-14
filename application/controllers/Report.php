<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '512M');

class Report extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/index.php/welcome
     *    - or -
     *        http://example.com/index.php/welcome/index
     *    - or -
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

        $this->load->library('pdf');
        $this->load->model('Masters', 'master');

        if (!$this->session->userdata('islogin')) {
            redirect(base_url('signin/'));
        }

        $this->header_field_mapper = array(
        	'merchant_name' => 'MERCHANT NAME',
        	'branch_name' => 'BRANCH NAME',
        	'npwp' => 'NPWP',
        	'nopd' => 'NOPD',
            'bill_no' => 'BILL NO',
            'bill_date' => 'DATE',
            'total_amount' => 'TOTAL AMOUNT',
            'service' => 'SERVICE',
            'ppn' => 'PPN',
            'total_trx_amount' => 'TOTAL TRX AMOUNT',
            'payment_type' => 'PAYMENT TYPE'
        );

        $this->detail_field_mapper = array(
        	'merchant_name' => 'MERCHANT NAME',
        	'branch_name' => 'BRANCH NAME',
            'bill_no' => 'BILL NO',
            'bill_date' => 'DATE',
            'item_name' => 'ITEM NAME',
            'item_type' => 'ITEM TYPE',
            'item_price' => 'ITEM PRICE',
            'quantity' => 'QUANTITY',
            'item_amount' => 'ITEM AMOUNT'

        );

        // $this->db->select('merchant_name,branch_name,npwp,nopd,invoice_no,ppn,Paid,month,year');
        // //$this->db->order_by('bill_date');   

        // $result = $this->db->get('payment_success3');

        // if ($result->num_rows() > 0) {
        //     $list_data = $result->result_array();
        //     //print_r($list_data); die;
        //     //get list fields
        //     foreach ($list_data[0] as $key => $value) {
        //         $fields[] = $this->payment_field_mapper[$key];

        $this->payment_field_mapper = array(
            'merchant_name' => 'MERCHANT NAME',
            'branch_name' => 'BRANCH NAME',
            'npwp' => 'NPWP',
            'nopd' => 'NOPD',
            'invoice_no' => 'INVOICE NO',
            'ppn' => 'PPN',
            'Paid' => 'PAID',
            'year' => 'YEAR',
            'month' => 'MONTH'

        );
    }

    public function index()
    {
        $this->load->view('welcome_message');

    }

    public function transaction()
    {
        if($_SESSION['level'] == "3"){
            $merchant_id = $this->master->npwp($_SESSION['npwp']);
            $data['merchants'] = $this->master->get_merchant_by_merchantid($merchant_id);
            $data['branch'] = $this->master->branch_id($merchant_id[0], 'ALL');
        }else{
            $data['merchants'] = $this->master->merchant_id();
            if($_SESSION['level'] == "4"){
                $data['branch'] = $this->master->branch_id($_SESSION['merchantid'], 'ALL');
            }else if($_SESSION['level'] == "5"){
                $data['branch'] = $this->master->branch_id($_SESSION['merchantid'],$_SESSION['branchid']);
            }
        }

       // print_r($data['merchants']);exit();
        //$data['merchants'] = $this->master->merchant();
        $this->load->view('report/header');
        $this->load->view('main/global_headbar');
        $this->load->view('main/global_sidebar');
        $this->load->view('report/transaction', $data);
        $this->load->view('main/global_footbar');
        $this->load->view('report/footer');
    }
    
    public function transaction_data()
    {
        ini_set('memory_limit', '512M');
        $this->load->library('Datatablessp');

        $table = 'transaction hr';

        // Table's primary key
        $primaryKey = 'hr.bill_no';

        // Array of database columns which should be read and sent back to DataTables.
        // The db parameter represents the column name in the database, while the dt
        // parameter represents the DataTables column identifier. In this case simple
        // indexes

        $columns = array(
            array('db' => 'hr.merchant_name', 'dt' => 0),
            array('db' => 'hr.branch_name', 'dt' => 1),
            array('db' => 'hr.npwp', 'dt' => 2),
            array('db' => 'hr.nopd', 'dt' => 3),
            array('db' => 'hr.bill_no', 'dt' => 4),
            array('db' => 'hr.bill_date', 'dt' => 5),
            array('db' => 'hr.total_amount', 'dt' => 6),
            array('db' => 'hr.service', 'dt' => 7),
            array('db' => 'hr.ppn', 'dt' => 8),
            array('db' => 'hr.total_trx_amount', 'dt' => 9),
            array('db' => 'hr.payment_type', 'dt' => 10)
        );

        $additional = "";
        // $additional = array('<a href="'.base_url('ticket/edit_form/{primaryKey}').'" class="btn btn-success btn-xs" title="Edit Staff" data-target="#edit"><i class="fa fa-pencil"></i></a>&nbsp;<a href="'.base_url('ticket/delete/{primaryKey}').'" class="btn btn-danger btn-xs" title="Delete Staff" onclick="return confirm(\'Are you sure want to delete this data?\')"><i class="fa fa-trash"></i></a>');

        // SQL server connection information
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );


        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * If you just want to use the basic configuration for DataTables with PHP
         * server-side, there is no need to edit below this line.
         */
        $result = $this->datatablessp->simple($_GET, $sql_details, $table, $primaryKey, $columns, $additional);
        
        foreach ($result['data'] as $row) {
            // $row[18] = null;
            // $row[19] = null;
            //$row[30] = null;
            $data[] = $row;
        }
        $result['data'] = $data;
        echo json_encode($result);
        // ( $request, $conn, $table, $primaryKey, $columns, 'staff_id=3', $whereAll=null )

        // $condition = "";
        // echo json_encode(
        //     $this->datatablessp->complex( $_GET, $sql_details, $table, $primaryKey, $columns, $condition, $condition, $additional )
        // );
    }

    public function transaction_data_search()
    {
        ini_set('memory_limit', '512M');
        $this->load->library('Datatablessp');

        foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }

        $table = 'transaction hr';

        // Table's primary key
        $primaryKey = 'hr.bill_no';

        // Array of database columns which should be read and sent back to DataTables.
        // The db parameter represents the column name in the database, while the dt
        // parameter represents the DataTables column identifier. In this case simple
        // indexes

        $columns = array(
            array('db' => 'hr.merchant_name', 'dt' => 0),
            array('db' => 'hr.branch_name', 'dt' => 1),
            array('db' => 'hr.npwp', 'dt' => 2),
            array('db' => 'hr.nopd', 'dt' => 3),
            array('db' => 'hr.bill_no', 'dt' => 4),
            array('db' => 'hr.bill_date', 'dt' => 5,
                'formatter' => function($d, $row) {
                    return date('d-m-Y H:i:s', strtotime($d));
                }
            ),
            array('db' => 'hr.total_amount', 'dt' => 6, 
                'formatter' => function($d, $row) {
                    return number_format($d);
                }),
            array('db' => 'hr.service', 'dt' => 7,
                'formatter' => function($d, $row) {
                    $d = (int)$d;
                    return $d;  
                }
            ),
            array('db' => 'hr.ppn', 'dt' => 8, 
                'formatter' => function($d, $row) {
                    $d = (int)$d;
                    return number_format($d);
                }
            ),
            array('db' => 'hr.total_trx_amount', 'dt' => 9, 
                'formatter' => function( $d, $row ) {
                    $d = (int)$d;
                    return number_format($d);
                }
            ),
            array('db' => 'hr.payment_type', 'dt' => 10)
        );

        $additional = "";
        // $additional = array('<a href="'.base_url('ticket/edit_form/{primaryKey}').'" class="btn btn-success btn-xs" title="Edit Staff" data-target="#edit"><i class="fa fa-pencil"></i></a>&nbsp;<a href="'.base_url('ticket/delete/{primaryKey}').'" class="btn btn-danger btn-xs" title="Delete Staff" onclick="return confirm(\'Are you sure want to delete this data?\')"><i class="fa fa-trash"></i></a>');

        // SQL server connection information
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );


        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * If you just want to use the basic configuration for DataTables with PHP
         * server-side, there is no need to edit below this line.
         */
        //$filter[] = "(transactions.merchantid= '" . $_SESSION['merchantid'] . "')";
        if (!empty($start_date)) {
            $swap_date = explode("-", $start_date);
            $start_date = $swap_date[2] . '-' . $swap_date[1] . '-' . $swap_date[0];
            if (!empty($end_date)) {
                $swap_date = explode("-", $end_date);
                $end_date = $swap_date[2] . '-' . $swap_date[1] . '-' . $swap_date[0];
                $filter[] = "(hr.bill_date between '" . $start_date . " 00:00:00' AND '" . $end_date . " 23:59:59')";
            } else {
                //$filter[] = "(hr.bill_date between '" . $start_date . " 00:00:01' AND '" . date('Y-m-d H:i:s', strtotime('+2 day')) . "')"; by mahes
                $filter[] = "(hr.bill_date between '" . $start_date . " 00:00:00' AND '" . date('Y-m-d H:i:s') . "')";
            }
        } elseif (!empty($end_date)) {
            $swap_date = explode("-", $end_date);
            $end_date = $swap_date[2] . '-' . $swap_date[1] . '-' . $swap_date[0];
            $filter[] = "(hr.bill_date <= '" . $end_date . " 23:59:59')";
        }

        //rawdata
        if (!empty($bill_no)) {
            //unset($filter);
            $filter[] = "(hr.bill_no = '" . $bill_no . "')";
        }


        //merchant
        if($_SESSION['level']<4 || $_SESSION['level'] == 6){
            if ((!empty($merchant_id)) && (($merchant_id) != 'ALL')) {
                //get merchant ID
                $filter[] = '(hr.merchant_id="' . $merchant_id . '")';

                //branch
                if ((!empty($branch_id)) && (($branch_id) != 'ALL')) {
                    $filter[] = '(hr.branch_id="' . $branch_id . '")';
                }
            }
        }else{
            $filter[] = '(hr.merchant_id="' . $_SESSION['merchantid'] . '")';

            //branch
            if ((!empty($branch_id)) && (($branch_id) != 'ALL')) {
                $filter[] = '(hr.branch_id="' . $branch_id . '")';
            }
        }

         /*elseif (('ALL' == $merchantid) && ('sadmin' != $this->session->userdata('username'))) {
            $allowed_merchant = $this->users->get_allowed_merchant($this->session->userdata('users_id'));
            $filter[] = '(merchantid IN ('.implode(',', $allowed_merchant).'))';
        }*/


        $condition = implode(' AND ', $filter);
        //print_r($condition); die;
        $result = $this->datatablessp->complex($_POST, $sql_details, $table, $primaryKey, $columns, $condition, $condition, $additional);

        if ($hide_rawdata === 'true') {
            if (!empty($result['data'])) {
                foreach ($result['data'] as $row) {
                    // $row[18] = null;
                    // $row[19] = null;
                    // $row[30] = null;
                    $data[] = $row;
                }
                $result['data'] = $data;
            }
        }

        echo json_encode($result);

    }

    public function pdf_template ($title, $htmlReport, $fileName, $pageOrintattion)
    {
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $font_size = $pdf->pixelsToUnits('20');
        $pdf->setPrintFooter(false);
        $pdf->setPrintHeader(false);
        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
        $pdf->AddPage($pageOrintattion);
        $pdf->Write(0, $title, "", 0, "L", true, 2, false, false, 0);
        $pdf->SetFont('', '', $font_size , '', 'default', true);
        $html = $htmlReport;

        $pdf->writeHTML($html);
        $pdf->Output($fileName.'.pdf', 'I');
    }

    public function transaction_report_pdf()
    {
        ini_set('memory_limit', '-1');
        foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }
        $summaryAmount      = 0;
        $summaryServices    = 0;
        $summaryTrx         = 0;
        $summaryPpn         = 0;

        if (!empty($start_date)) {
            $swap_date = explode("-", $start_date);
            $start_date = $swap_date[2] . '-' . $swap_date[1] . '-' . $swap_date[0];
            if (!empty($end_date)) {
                $swap_date = explode("-", $end_date);
                $end_date = $swap_date[2] . '-' . $swap_date[1] . '-' . $swap_date[0];
                $filter[] = "(bill_date between '" . $start_date . " 00:00:00' AND '" . $end_date . " 23:59:59')";
            } else {
                $filter[] = "(bill_date between '" . $start_date . " 00:00:00' AND '" . date('Y-m-d H:i:s') . "')";
            }
        } elseif (!empty($end_date)) {
            $swap_date = explode("-", $end_date);
            $end_date = $swap_date[2] . '-' . $swap_date[1] . '-' . $swap_date[0];
            $filter[] = "(bill_date <= '" . $end_date . " 23:59:59')";
        }

        if (!empty($bill_no)) {
            $filter[] = "(bill_no = '" . $bill_no . "')";
        }

        if ($_SESSION['level']<4 || $_SESSION['level'] == 6 ){
            if ((!empty($merchant_id)) && (($merchant_id) != 'ALL')) {
                $filter[] = '(merchant_id="' . $merchant_id . '")';
                
                if ((!empty($branch_id)) && (($branch_id) != 'ALL')) {
                    $filter[] = '(branch_id="' . $branch_id . '")';
                }
            }
        } else {
            $filter[]       = '(merchant_id="' . $_SESSION['merchantid'] . '")';
            $merchant_id     = $_SESSION['merchantid'];

            if ((!empty($branch_id)) && (($branch_id) != 'ALL')) {
                $filter[] = '(branch_id="' . $branch_id . '")';
            }
        }

        $this->db->select('merchant_name,branch_name,npwp,nopd,bill_no,bill_date,total_amount,service,ppn,total_trx_amount,payment_type');
        $this->db->order_by('bill_date');   
        if (isset($filter)) {
            $condition = implode(' AND ', $filter);
            $this->db->where($condition);
        }
        $result = $this->db->get('transaction');
        $data   = $result->result_array();

       	$headerMerchantName = 'ALL';
       	$headerBranchName 	= 'ALL';
       	if ($merchant_id != 'ALL') {
       		$param 				= ['merchant_id '=> $merchant_id];
       		$merchantName 		= $this->master->get_merchant($param);
       		$headerMerchantName = $merchantName[0]['merchant_name']; 

       	}

       	if ($branch_id != 'ALL') {
       		$brancName 			= $this->master->branch_id($merchant_id, $branch_id);
       		$headerBranchName 	= $brancName[0]['branch_name'];
       	}
        
        foreach ($data as  $value) {
            $summaryAmount      += (float)$value['total_amount'];
            $summaryTrx         += (float)$value['total_trx_amount'];
            $summaryServices    += (float)$value['service']; 
            $summaryPpn         += (float)$value['ppn'];
        }

        $title      = 'Transaction Report';
        $filesName  =  'Transaction Report Tanggal '. date("d/M/Y");
        $html = '
                <table class="header">
                    <thead>
                    	<tr>
                            <th><b></b></th>
                            <th><b></b></th>
                            <th><b></b></th>
                            <th><b></b></th>
                        </tr>
                        <tr>
                            <th><b>Merchant name</b></th>
                            <th><b>:</b></th>
                            <th><b>'.$headerMerchantName.'</b></th>
                            <th><b></b></th>
                        </tr>
                        <tr>
                        	<th><b>Branch Name</b></th>
                        	<th><b>:</b></th>
                        	<th><b>'.$headerBranchName.'</b></th>
                        	<th><b></b></th>
                        </tr>
                        <tr>
                        	<th><b>Date Range</b></th>
                        	<th><b>:</b></th>
                        	<th><b>'.date('d M Y', strtotime($start_date)).' - '.date('d M Y', strtotime($end_date)).'</b></th>
                        	<th><b></b></th>
                        </tr>
                        <tr>
                        	<th></th>
                        </tr>
                    </thead>
                </table>
                <table border="1" cellspacing="1" cellpadding="1">
                    <thead>
                        <tr>
                            <th align="center"> <b>Merchant Name</b> </th>
                            <th align="center"> <b>Branch Name</b> </th>
                            <th align="center"> <b>NPWP</b> </th>
                            <th align="center"> <b>NOPD</b> </th>
                            <th align="center"> <b>Bill - No</b> </th>
                            <th align="center"> <b>Date</b> </th>
                            <th align="center"> <b>Total Amount</b> </th>
                            <th align="center"> <b>Service</b> </th>
                            <th align="center"> <b>Ppn</b> </th>
                            <th align="center"> <b>Total Trx Amount</b> </th>
                            <th align="center"> <b>Payment Type</b> </th>
                        </tr>
                    <thead>
                    <tbody>';
                foreach ($data as $row) { 
                	$service    = (float)$row['service'];
                    $ppn        = (float)$row['ppn'];
                    $trxAmount  = (float)$row['total_trx_amount'];
                    $amount     = (float)$row['total_amount'];

                    $html .=
                    '<tr>
                        <td>'.$row['merchant_name'].'</td>
                        <td>'.$row['branch_name'].'</td>
                        <td>'.$row['npwp'].'</td>
                        <td>'.$row['nopd'].'</td>
                        <td>'.$row['bill_no'].'</td>
                        <td>'.date('d/m/Y H:i:s', strtotime($row['bill_date'])).'</td>
                        <td align="right">'.number_format($amount).'</td>
                        <td align="right">'.number_format($service).'</td>
                        <td align="right">'.number_format($ppn).'</td>
                        <td align="right">'.number_format($trxAmount).'</td>
                        <td>'.$row['payment_type'].'</td>
                    </tr>';
                }
        $html .= '  </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="6">Total</th>
                            <th align="right">'.number_format($summaryAmount).'</th>
                            <th align="right">'.number_format($summaryServices).'</th>
                            <th align="right">'.number_format($summaryPpn).'</th>
                            <th align="right">'.number_format($summaryTrx).'</th>
                            <th></th>
                        </tr>
                    </tfoot>
                  </table>';
        $this->pdf_template($title, $html, $filesName, 'L');       
    }

    public function transaction_report_xlsx($type = "xlsx")
    {
        //error_reporting(E_ALL);
        // ini_set('display_errors', TRUE);
        // ini_set('display_startup_errors', TRUE);
        //load librarynya terlebih dahulu
        //print_r($_REQUEST);
        ini_set('memory_limit', '512M');

        foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }
        //$filter[] = "(merchantid= '" . $_SESSION['merchantid'] . "')";
        if (!empty($start_date)) {
            $swap_date = explode("-", $start_date);
            $start_date = $swap_date[2] . '-' . $swap_date[1] . '-' . $swap_date[0];
            if (!empty($end_date)) {
                $swap_date = explode("-", $end_date);
                $end_date = $swap_date[2] . '-' . $swap_date[1] . '-' . $swap_date[0];
                $filter[] = "(bill_date between '" . $start_date . " 00:00:00' AND '" . $end_date . " 23:59:59')";
            } else {
                $filter[] = "(bill_date between '" . $start_date . " 00:00:00' AND '" . date('Y-m-d H:i:s') . "')";
            }
        } elseif (!empty($end_date)) {
            $swap_date = explode("-", $end_date);
            $end_date = $swap_date[2] . '-' . $swap_date[1] . '-' . $swap_date[0];
            $filter[] = "(bill_date <= '" . $end_date . " 23:59:59')";
        }

        //rawdata
        if (!empty($bill_no)) {
            //unset($filter);
            $filter[] = "(bill_no = '" . $bill_no . "')";
        }

        //merchant
        if($_SESSION['level']<4 || $_SESSION['level'] == 6){
            if ((!empty($merchant_id)) && (($merchant_id) != 'ALL')) {
                //get merchant ID
                $filter[] = '(merchant_id="' . $merchant_id . '")';
                
                //branch
                if ((!empty($branch_id)) && (($branch_id) != 'ALL')) {
                    $filter[] = '(branch_id="' . $branch_id . '")';
                }
            }
        }else{
            $filter[] = '(merchant_id="' . $_SESSION['merchantid'] . '")';

            //branch
            if ((!empty($branch_id)) && (($branch_id) != 'ALL')) {
                $filter[] = '(branch_id="' . $branch_id . '")';
            }
        }


        if (isset($filter)) {
            $condition = implode(' AND ', $filter);
            $this->db->where($condition);
        }
        // print_r($filter); die;
        $this->db->select('merchant_name,branch_name,npwp,nopd,bill_no,bill_date,total_amount,service,ppn,total_trx_amount,payment_type');
        $this->db->order_by('bill_date');	

        $result = $this->db->get('transaction');

        if ($result->num_rows() > 0) {
            $list_data = $result->result_array();
            //print_r($list_data); die;
            //get list fields
            foreach ($list_data[0] as $key => $value) {
                $fields[] = $this->header_field_mapper[$key];
            }
        } else {
            echo json_encode(array('message' => 'Data tidak ada! Silakan lakukan pencarian dengan data yang lain.'));
            exit();
        }

        // exit();

        $this->load->library("PHPExcel");

        //membuat objek PHPExcel
        $objPHPExcel = new PHPExcel();

        //set Sheet yang akan diolah
        $objPHPExcel->setActiveSheetIndex(0);

        // Set Header
        $letter = "A";
        for ($i = 0; $i < count($fields); $i++) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($letter . '1', $fields[$i]);
            $letter++;
        }

        // Set Data
        $col = "2";
        for ($i = 0; $i < count($list_data); $i++) {
            $row = "A";
            foreach ($list_data[$i] as $key => $value) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($row . $col, $value);
                $row++;
            }
            $col++;
        }

        //set title pada sheet (me rename nama sheet)
        $objPHPExcel->getActiveSheet()->setTitle('Report Transaction');
        //sesuaikan headernya
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        if ($type == 'xlsx') {
            $filename = 'Report Transaction - ' . date('YmdHi') . '.xlsx';
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            //ubah nama file saat diunduh
            header('Content-Disposition: attachment;filename="' . $filename . '');

            //mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        } else if ($type == 'csv') {

            $filename = 'Report Transaction - ' . date('YmdHi') . '.csv';
            header('Content-Type: text/csv');
            //ubah nama file saat diunduh
            header('Content-Disposition: attachment;filename="' . $filename . '');

            //mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');

        }

        //unduh file
        // $objWriter->save("php://output");

        $objWriter->save(FCPATH . 'res/report/' . $filename);

        echo json_encode(array('message' => 'File laporan berhasil dibuat! Silakan download <strong><a href="' . str_replace('index.php/', '', base_url('res/report/' . $filename)) . '"><img src="' . str_replace('index.php/', '', base_url('res/download.png')) . '" /> disini </a></strong>'));
    }

    public function detail()
    {

        $this->load->model('Masters', 'master');

        $this->load->view('report/header');
        $this->load->view('main/global_headbar');
        $this->load->view('main/global_sidebar');
        if($_SESSION['level'] == "3"){
            $merchant_id = $this->master->npwp($_SESSION['npwp']);
            $data['merchants'] = $this->master->get_merchant_by_merchantid($merchant_id);
            $data['branch'] = $this->master->branch_id($merchant_id[0], 'ALL');
        }else{
            $data['merchants'] = $this->master->merchant_id();
            if($_SESSION['level']=="4"){
                $data['branch'] = $this->master->branch_id($_SESSION['merchantid'], 'ALL');
            }else if($_SESSION['level']=="5"){
                $data['branch'] = $this->master->branch_id($_SESSION['merchantid'],$_SESSION['branchid']);
            }
        }
        $this->load->view('report/detail', $data);
        $this->load->view('main/global_footbar');
        $this->load->view('report/footer');
    }

    public function detail_data()
    {
        ini_set('memory_limit', '512M');
        $this->load->library('Datatablessp');


        $table = 'transaction_detail dl';

        // Table's primary key
        $primaryKey = 'dl.bill_no';

        // Array of database columns which should be read and sent back to DataTables.
        // The db parameter represents the column name in the database, while the dt
        // parameter represents the DataTables column identifier. In this case simple
        // indexes

        $columns = array(
        	array('db' => 'dl.merchant_name', 'dt' => 0),
        	array('db' => 'dl.branch_name', 'dt' => 1),
            array('db' => 'dl.bill_no', 'dt' => 2),
            array('db' => 'dl.bill_date', 'dt' => 3),
            array('db' => 'dl.item_name', 'dt' => 4),
            array('db' => 'dl.item_type', 'dt' => 5),
            array('db' => 'dl.item_price', 'dt' => 6),
            array('db' => 'dl.quantity', 'dt' => 7),
            array('db' => 'dl.item_amount', 'dt' => 8)
        );

        $additional = "";
        // $additional = array('<a href="'.base_url('ticket/edit_form/{primaryKey}').'" class="btn btn-success btn-xs" title="Edit Staff" data-target="#edit"><i class="fa fa-pencil"></i></a>&nbsp;<a href="'.base_url('ticket/delete/{primaryKey}').'" class="btn btn-danger btn-xs" title="Delete Staff" onclick="return confirm(\'Are you sure want to delete this data?\')"><i class="fa fa-trash"></i></a>');

        // SQL server connection information
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );


        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * If you just want to use the basic configuration for DataTables with PHP
         * server-side, there is no need to edit below this line.
         */

        $result = $this->datatablessp->simple($_GET, $sql_details, $table, $primaryKey, $columns, $additional);

        foreach ($result['data'] as $row) {
            // $row[18] = null;
            // $row[19] = null;
            //$row[30] = null;
            $data[] = $row;
        }
        $result['data'] = $data;

        echo json_encode($result);
        // ( $request, $conn, $table, $primaryKey, $columns, 'staff_id=3', $whereAll=null )

        // $condition = "";
        // echo json_encode(
        //     $this->datatablessp->complex( $_GET, $sql_details, $table, $primaryKey, $columns, $condition, $condition, $additional )
        // );
    }

    public function detail_data_search()
    {
        ini_set('memory_limit', '512M');
        $this->load->library('Datatablessp');

        foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }

        $table = 'transaction_detail dl';


        // Table's primary key
        $primaryKey = 'dl.bill_no';

        // Array of database columns which should be read and sent back to DataTables.
        // The db parameter represents the column name in the database, while the dt
        // parameter represents the DataTables column identifier. In this case simple
        // indexes

        $columns = array(
            array('db' => 'dl.merchant_name', 'dt' => 0),
        	array('db' => 'dl.branch_name', 'dt' => 1),
            array('db' => 'dl.bill_no', 'dt' => 2),
            array('db' => 'dl.bill_date', 'dt' => 3,
                'formatter' => function($d, $row) {
                    return date('d-m-Y H:i:s', strtotime($d));
                }
            ),
            array('db' => 'dl.item_name', 'dt' => 4),
            array('db' => 'dl.item_type', 'dt' => 5),
            array('db' => 'dl.item_price', 'dt' => 6,
                'formatter' => function( $d, $row ) {
                return number_format($d);
                }
            ),
            array('db' => 'dl.quantity', 'dt' => 7,
                'formatter' => function( $d, $row ) {
                return number_format($d);
                }
            ),
            array('db' => 'dl.item_amount', 'dt' => 8,
                'formatter' => function( $d, $row ) {
                return number_format($d);
                }
            )
        );

        $additional = "";
        // $additional = array('<a href="'.base_url('ticket/edit_form/{primaryKey}').'" class="btn btn-success btn-xs" title="Edit Staff" data-target="#edit"><i class="fa fa-pencil"></i></a>&nbsp;<a href="'.base_url('ticket/delete/{primaryKey}').'" class="btn btn-danger btn-xs" title="Delete Staff" onclick="return confirm(\'Are you sure want to delete this data?\')"><i class="fa fa-trash"></i></a>');

        // SQL server connection information
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );


        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * If you just want to use the basic configuration for DataTables with PHP
         * server-side, there is no need to edit below this line.
         */

        //$filter[] = "(members.merchantid= '" . $_SESSION['merchantid'] . "')";
        if (!empty($start_date)) {
            $swap_date = explode("-", $start_date);
            $start_date = $swap_date[2] . '-' . $swap_date[1] . '-' . $swap_date[0];
            if (!empty($end_date)) {
                $swap_date = explode("-", $end_date);
                $end_date = $swap_date[2] . '-' . $swap_date[1] . '-' . $swap_date[0];
                $filter[] = "(dl.bill_date between '" . $start_date . " 00:00:00' AND '" . $end_date . " 23:59:59')";
            } else {
                $filter[] = "(dl.bill_date between '" . $start_date . " 00:00:00' AND '" . date('Y-m-d H:i:s') . "')";
            }
        } elseif (!empty($end_date)) {
            $swap_date = explode("-", $end_date);
            $end_date = $swap_date[2] . '-' . $swap_date[1] . '-' . $swap_date[0];
            $filter[] = "(dl.bill_date <= '" . $end_date . " 23:59:59')";
        }

        //rawdata
        if (!empty($bill_no)) {
            //unset($filter);
            $filter[] = "(dl.bill_no = '" . $bill_no . "')";
        }

        //merchant
        if($_SESSION['level']<4 || $_SESSION['level'] == 6){
            if ((!empty($merchant_id)) && (($merchant_id) != 'ALL')) {
                //get merchant ID
                $filter[] = '(dl.merchant_id="' . $merchant_id . '")';
            }
        }else{
            $filter[] = '(dl.merchant_id="' . $_SESSION['merchantid'] . '")';
        }

        //branch
        if ((!empty($branch_id)) && (($branch_id) != 'ALL')) {
            $filter[] = '(dl.branch_id="' . $branch_id . '")';
        }

        $condition = implode(' AND ', $filter);
        //print_r($condition); die;
        $result = $this->datatablessp->complex($_POST, $sql_details, $table, $primaryKey, $columns, $condition, $condition, $additional);
        if ($hide_rawdata === 'true') {
            if (!empty($result['data'])) {
                foreach ($result['data'] as $row) {
                    // $row[18] = null;
                    // $row[19] = null;
                    // $row[30] = null;
                    $data[] = $row;
                }
                $result['data'] = $data;
            }
        }
        echo json_encode($result);

    }

    public function detail_report_pdf()
    {
        ini_set('memory_limit', '512M');

        
        foreach ($_REQUEST as $key => $value) { 
            $$key = $value;
        }

       if (!empty($start_date)) {
            $swap_date = explode("-", $start_date);
            $start_date = $swap_date[2] . '-' . $swap_date[1] . '-' . $swap_date[0];
            if (!empty($end_date)) {
                $swap_date = explode("-", $end_date);
                $end_date = $swap_date[2] . '-' . $swap_date[1] . '-' . $swap_date[0];
                $filter[] = "(bill_date between '" . $start_date . " 00:00:00' AND '" . $end_date . " 23:59:59')";
            } else {
                $filter[] = "(bill_date between '" . $start_date . " 00:00:00' AND '" . date('Y-m-d H:i:s') . "')";
            }
        } elseif (!empty($end_date)) {
            $swap_date = explode("-", $end_date);
            $end_date = $swap_date[2] . '-' . $swap_date[1] . '-' . $swap_date[0];
            $filter[] = "(bill_date <= '" . $end_date . " 23:59:59')";
        }

         if (!empty($bill_no)) {
            $filter[] = "(bill_no = '" . $bill_no . "')";
        }

        if($_SESSION['level']<4 || $_SESSION['level'] == 6 ){
            if ((!empty($merchant_id)) && (($merchant_id) != 'ALL')) {
                $filter[] = '(merchant_id="' . $merchant_id . '")';
            }
        }else{
            $filter[]       = '(merchant_id="' . $_SESSION['merchantid'] . '")';
            $merchant_id    = $_SESSION['merchantid'];
        }

        if ((!empty($branch_id)) && (($branch_id) != 'ALL')) {
            $filter[] = '(branch_id="' . $branch_id . '")';
        }

        if (isset($filter)) {
            $condition = implode(' AND ', $filter);
            $this->db->where($condition);
        }
       
        $this->db->select('merchant_name,branch_name,bill_no,bill_date,item_name,item_type,item_price,quantity,item_amount');
        $this->db->order_by('bill_date');

        $data = $this->db->get('transaction_detail')->result_array();

        $headerMerchantName = 'ALL';
       	$headerBranchName 	= 'ALL';
       	if ($merchant_id != 'ALL') {
       		$param 				= ['merchant_id '=> $merchant_id];
       		$merchantName 		= $this->master->get_merchant($param);
       		$headerMerchantName = $merchantName[0]['merchant_name']; 

       	}

       	if ($branch_id != 'ALL') {
       		$brancName 			= $this->master->branch_id($merchant_id, $branch_id);
       		$headerBranchName 	= $brancName[0]['branch_name'];
       	}

        $totItem    = 0;
        $totQty     = 0;
        $totAmount  = 0;

        $title ='Report Detail';
        $html = '<table class="header">
                    <thead>
                    	<tr>
                            <th><b></b></th>
                            <th><b></b></th>
                            <th><b></b></th>
                            <th><b></b></th>
                        </tr>
                        <tr>
                            <th><b>Merchant name</b></th>
                            <th><b>:</b></th>
                            <th><b>'.$headerMerchantName.'</b></th>
                            <th><b></b></th>
                        </tr>
                        <tr>
                        	<th><b>Branch Name</b></th>
                        	<th><b>:</b></th>
                        	<th><b>'.$headerBranchName.'</b></th>
                        	<th><b></b></th>
                        </tr>
                        <tr>
                        	<th><b>Date Range</b></th>
                        	<th><b>:</b></th>
                        	<th><b>'.date('d M Y', strtotime($start_date)).' - '.date('d M Y', strtotime($end_date)).'</b></th>
                        	<th><b></b></th>
                        </tr>
                        <tr>
                        	<th></th>
                        </tr>
                    </thead>
                </table>
                <table border="1" cellspacing="1" cellpadding="3">
                    <thead>
                        <tr>
                            <th align="Center"> # </th>
                            <th align="center">Merchant Name</th>
                            <th align="center">Branch Name</th>
                            <th align="center">Bill No</th>
                            <th align="center">Date</th>
                            <th align="center">Item Name</th>
                            <th align="center">Item Type</th>
                            <th align="center">Item Price</th>
                            <th align="center">Quantity</th>
                            <th align="center">Item Amount</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($data as $count => $row) {
            $totItem    += (float)$row['item_price'];
            $totQty     += (float)$row['quantity'];
            $totAmount  += (float)$row['item_amount'];
            $html .= 
                '   <tr>
                        <td align="center">'.++$count.'</td>
                        <td>'.$row['merchant_name'].'</td>
                        <td>'.$row['branch_name'].'</td>
                        <td>'.$row['bill_no'].'</td>
                        <td>'.date('d/m/Y H:i:s', strtotime($row['bill_date'])).'</td>
                        <td>'.$row['item_name'].'</td>
                        <td>'.$row['item_type'].'</td>
                        <td align="right">'.number_format($row['item_price']).'</td>
                        <td align="center">'.number_format($row['quantity']).'</td>
                        <td align="right">'.number_format($row['item_amount']).'</td>
                    </tr>'; 
        }
        $html .= '  </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="7">Total</th>
                            <th align="right">'.number_format($totItem).'</th>
                            <th align="right">'.number_format($totQty).'</th>
                            <th align="right">'.number_format($totAmount).'</th>
                        </tr>
                    </tfoot>
                    </table>';
        $filesName = 'Detail Report_'.date('d/m/Y');

        $this->pdf_template($title, $html, $filesName, 'L');

    }

    public function detail_report_xlsx($type = "xlsx")
    {
        //error_reporting(E_ALL);
        // ini_set('display_errors', TRUE);
        // ini_set('display_startup_errors', TRUE);
        //load librarynya terlebih dahulu
        //print_r($_REQUEST);
        ini_set('memory_limit', '512M');

        foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }
        //$filter[] = "(merchantid= '" . $_SESSION['merchantid'] . "')";
        if (!empty($start_date)) {
            $swap_date = explode("-", $start_date);
            $start_date = $swap_date[2] . '-' . $swap_date[1] . '-' . $swap_date[0];
            if (!empty($end_date)) {
                $swap_date = explode("-", $end_date);
                $end_date = $swap_date[2] . '-' . $swap_date[1] . '-' . $swap_date[0];
                $filter[] = "(bill_date between '" . $start_date . " 00:00:00' AND '" . $end_date . " 23:59:59')";
            } else {
                $filter[] = "(bill_date between '" . $start_date . " 00:00:00' AND '" . date('Y-m-d H:i:s') . "')";
            }
        } elseif (!empty($end_date)) {
            $swap_date = explode("-", $end_date);
            $end_date = $swap_date[2] . '-' . $swap_date[1] . '-' . $swap_date[0];
            $filter[] = "(bill_date <= '" . $end_date . " 23:59:59')";
        }

        //rawdata
        if (!empty($bill_no)) {
            //unset($filter);
            $filter[] = "(bill_no = '" . $bill_no . "')";
        }

	    //merchant
        if($_SESSION['level']<4 || $_SESSION['level'] == 6 ){
            if ((!empty($merchant_id)) && (($merchant_id) != 'ALL')) {
                //get merchant ID
                $filter[] = '(merchant_id="' . $merchant_id . '")';
            }
        }else{
            $filter[] = '(merchant_id="' . $_SESSION['merchantid'] . '")';
        }

        //branch
        if ((!empty($branch_id)) && (($branch_id) != 'ALL')) {
            $filter[] = '(branch_id="' . $branch_id . '")';
        }

        if (isset($filter)) {
            $condition = implode(' AND ', $filter);
            $this->db->where($condition);
        }
        // print_r($filter); die;
        $this->db->select('merchant_name,branch_name,bill_no,bill_date,item_name,item_type,item_price,quantity,item_amount');
		$this->db->order_by('bill_date');	

        $result = $this->db->get('transaction_detail');

        if ($result->num_rows() > 0) {
            $list_data = $result->result_array();
            // print_r($list_data); die;
            //get list fields
            foreach ($list_data[0] as $key => $value) {
                $fields[] = $this->detail_field_mapper[$key];
            }
        } else {
            echo json_encode(array('message' => 'Data tidak ada! Silakan lakukan pencarian dengan data yang lain.'));
            exit();
        }

        // exit();

        $this->load->library("PHPExcel");

        //membuat objek PHPExcel
        $objPHPExcel = new PHPExcel();

        //set Sheet yang akan diolah
        $objPHPExcel->setActiveSheetIndex(0);

        // Set Header
        $letter = "A";
        for ($i = 0; $i < count($fields); $i++) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($letter . '1', $fields[$i]);
            $letter++;
        }

        // Set Data
        $col = "2";
        for ($i = 0; $i < count($list_data); $i++) {
            $row = "A";
            foreach ($list_data[$i] as $key => $value) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($row . $col, $value);
                $row++;
            }
            $col++;
        }

        //set title pada sheet (me rename nama sheet)
        $objPHPExcel->getActiveSheet()->setTitle('Report Detail');
        //sesuaikan headernya
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        if ($type == 'xlsx') {
            $filename = 'Report Detail - ' . date('YmdHi') . '.xlsx';
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            //ubah nama file saat diunduh
            header('Content-Disposition: attachment;filename="' . $filename . '');

            //mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        } else if ($type == 'csv') {

            $filename = 'Report Detail - ' . date('YmdHi') . '.csv';
            header('Content-Type: text/csv');
            //ubah nama file saat diunduh
            header('Content-Disposition: attachment;filename="' . $filename . '');

            //mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');

        }

        //unduh file
        // $objWriter->save("php://output");
        $objWriter->save(FCPATH . 'res/report/' . $filename);

        echo json_encode(array('message' => 'File laporan berhasil dibuat! Silakan download <strong><a href="' . str_replace('index.php/', '', base_url('res/report/' . $filename)) . '"><img src="' . str_replace('index.php/', '', base_url('res\\download.png')) . '" /> disini </a></strong>'));

    }

    public function branch(){
    	$this->load->model('Masters', 'master');
        
        $subanId = null;
        if ($_SESSION['level'] == 6) {
            $subanId = $_SESSION['suban_id'];
        }

    	foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }

    	$branch = $this->master->branch_id($merchant_id,'ALL', $subanId);

    	echo json_encode($branch,true);
    }

        public function payment()
    {
        $this->load->model('Masters', 'master');
        if($_SESSION['level'] == "3"){
            $merchant_id = $this->master->npwp($_SESSION['npwp']);
            $data['merchants'] = $this->master->get_merchant_by_merchantid($merchant_id);
            $data['branch'] = $this->master->branch_id($merchant_id[0], 'ALL');
        }else{
            $data['merchants'] = $this->master->merchant_id();
            if($_SESSION['level']=="4"){
                $data['branch'] = $this->master->branch_id($_SESSION['merchantid'], 'ALL');
            }else if($_SESSION['level']=="5"){
                $data['branch'] = $this->master->branch_id($_SESSION['merchantid'],$_SESSION['branchid']);
            }
        }
        // print_r($data['merchants']);exit();
        //$data['merchants'] = $this->master->merchant();
        $this->load->view('report/header');
        $this->load->view('main/global_headbar');
        $this->load->view('main/global_sidebar');
        $this->load->view('report/payment', $data);
        $this->load->view('main/global_footbar');
        $this->load->view('report/footer');
    }

    public function payment_data()
    {
        ini_set('memory_limit', '512M');
        $this->load->library('Datatablessp');

        $table = 'payment_success3 ps';

        // Table's primary key
        $primaryKey = 'ps.invoice_no';

        // Array of database columns which should be read and sent back to DataTables.
        // The db parameter represents the column name in the database, while the dt
        // parameter represents the DataTables column identifier. In this case simple
        // indexes

        $columns = array(
            array('db' => 'ps.merchant_name', 'dt' => 0),
            array('db' => 'ps.branch_name', 'dt' => 1),
            array('db' => 'ps.npwp', 'dt' => 2),
            array('db' => 'ps.nopd', 'dt' => 3),
            array('db' => 'ps.invoice_no', 'dt' => 4),
            array('db' => 'ps.ppn', 'dt' => 5),
            array('db' => 'ps.assessment', 'dt' => 6),
            array('db' => 'ps.paid', 'dt' => 7),
            array('db' => 'ps.note', 'dt' => 8),
            array('db' => 'ps.payment_channel', 'dt' => 9),
            array('db' => 'ps.year', 'dt' => 10),
            array('db' => 'ps.month', 'dt' => 11),
            array('db' => 'ps.paid_date', 'dt' => 12)
        );

        $additional = "";
        // $additional = array('<a href="'.base_url('ticket/edit_form/{primaryKey}').'" class="btn btn-success btn-xs" title="Edit Staff" data-target="#edit"><i class="fa fa-pencil"></i></a>&nbsp;<a href="'.base_url('ticket/delete/{primaryKey}').'" class="btn btn-danger btn-xs" title="Delete Staff" onclick="return confirm(\'Are you sure want to delete this data?\')"><i class="fa fa-trash"></i></a>');

        // SQL server connection information
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );


        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * If you just want to use the basic configuration for DataTables with PHP
         * server-side, there is no need to edit below this line.
         */
        $result = $this->datatablessp->simple($_GET, $sql_details, $table, $primaryKey, $columns, $additional);
        
        foreach ($result['data'] as $row) {
            // $row[18] = null;
            // $row[19] = null;
            //$row[30] = null;
            $data[] = $row;
        }
        $result['data'] = $data;
        echo json_encode($result);
        // ( $request, $conn, $table, $primaryKey, $columns, 'staff_id=3', $whereAll=null )

        // $condition = "";
        // echo json_encode(
        //     $this->datatablessp->complex( $_GET, $sql_details, $table, $primaryKey, $columns, $condition, $condition, $additional )
        // );
    }

    public function payment_data_search()
    {
        ini_set('memory_limit', '512M');
        $this->load->library('Datatablessp');

        foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }

        $table = 'payment_success3 ps';

        // Table's primary key
        $primaryKey = 'ps.invoice_no';

        // Array of database columns which should be read and sent back to DataTables.
        // The db parameter represents the column name in the database, while the dt
        // parameter represents the DataTables column identifier. In this case simple
        // indexes

        $columns = array(
            array('db' => 'ps.merchant_name', 'dt' => 0),
            array('db' => 'ps.branch_name', 'dt' => 1),
            array('db' => 'ps.npwp', 'dt' => 2),
            array('db' => 'ps.nopd', 'dt' => 3),
            array('db' => 'ps.invoice_no', 'dt' => 4),
            array('db' => 'ps.ppn', 'dt' => 5),
            array('db' => 'ps.assessment', 'dt' => 6),
            array('db' => 'ps.paid', 'dt' => 7),
            array('db' => 'ps.note', 'dt' => 8),
            array('db' => 'ps.payment_channel', 'dt' => 9),
            array('db' => 'ps.year', 'dt' => 10),
            array('db' => 'ps.month', 'dt' => 11),
            array('db' => 'ps.paid_date', 'dt' => 12)
        );

        $additional = "";
        // $additional = array('<a href="'.base_url('ticket/edit_form/{primaryKey}').'" class="btn btn-success btn-xs" title="Edit Staff" data-target="#edit"><i class="fa fa-pencil"></i></a>&nbsp;<a href="'.base_url('ticket/delete/{primaryKey}').'" class="btn btn-danger btn-xs" title="Delete Staff" onclick="return confirm(\'Are you sure want to delete this data?\')"><i class="fa fa-trash"></i></a>');

        // SQL server connection information
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );


        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * If you just want to use the basic configuration for DataTables with PHP
         * server-side, there is no need to edit below this line.
         */
        //$filter[] = "(transactions.merchantid= '" . $_SESSION['merchantid'] . "')";
        if($year!='ALL'){
            $filter[] = "(ps.year = '".$year."')";
        }
        if($month!='ALL'){
            $filter[] = "(ps.month = '".$month."')";
        }
        
        // if (!empty($start_date)) {
        //     $swap_date = explode("-", $start_date);
        //     $start_date = $swap_date[2] . '-' . $swap_date[1] . '-' . $swap_date[0];
        //     if (!empty($end_date)) {
        //         $swap_date = explode("-", $end_date);
        //         $end_date = $swap_date[2] . '-' . $swap_date[1] . '-' . $swap_date[0];
        //         $filter[] = "(ps.bill_date between '" . $start_date . " 00:00:00' AND '" . $end_date . " 23:59:59')";
        //     } else {
        //         //$filter[] = "(hr.bill_date between '" . $start_date . " 00:00:01' AND '" . date('Y-m-d H:i:s', strtotime('+2 day')) . "')"; by mahes
        //         $filter[] = "(ps.bill_date between '" . $start_date . " 00:00:00' AND '" . date('Y-m-d H:i:s') . "')";
        //     }
        // } elseif (!empty($end_date)) {
        //     $swap_date = explode("-", $end_date);
        //     $end_date = $swap_date[2] . '-' . $swap_date[1] . '-' . $swap_date[0];
        //     $filter[] = "(ps.bill_date <= '" . $end_date . " 23:59:59')";
        // }

        //rawdata
        if (!empty($invoice_no)) {
            //unset($filter);
            $filter[] = "(ps.invoice_no = '" . $invoice_no . "')";
        }


        //merchant
        if($_SESSION['level']<4 || $_SESSION['level'] == 6 ){
            if ((!empty($merchant_id)) && (($merchant_id) != 'ALL')) {
                //get merchant ID
                $filter[] = '(ps.merchant_id="' . $merchant_id . '")';

                //branch
                if ((!empty($branch_id)) && (($branch_id) != 'ALL')) {
                    $filter[] = '(ps.branch_id="' . $branch_id . '")';
                }
            }
        }else{
            $filter[] = '(ps.merchant_id="' . $_SESSION['merchantid'] . '")';

            //branch
            if ((!empty($branch_id)) && (($branch_id) != 'ALL')) {
                $filter[] = '(ps.branch_id="' . $branch_id . '")';
            }
        }

         /*elseif (('ALL' == $merchantid) && ('sadmin' != $this->session->userdata('username'))) {
            $allowed_merchant = $this->users->get_allowed_merchant($this->session->userdata('users_id'));
            $filter[] = '(merchantid IN ('.implode(',', $allowed_merchant).'))';
        }*/

        $condition = '';
        if (!empty($filter)) {
            $condition = implode(' AND ', $filter);
        }
        //print_r($condition); die;
        $result = $this->datatablessp->complex($_POST, $sql_details, $table, $primaryKey, $columns, $condition, $condition, $additional);
        if ($hide_rawdata === 'true') {
            if (!empty($result['data'])) {
                foreach ($result['data'] as $row) {
                    $row[13] = $row[12];
                    $row[12] = $row[11];
                    $row[11] = $row[10];
                    $row[10] = '<a target="_blank" href="'.str_replace('index.php/','',base_url("report/payment_receipt/".$row[4])).'"><img src="'.str_replace('index.php/','',base_url('res/download.png')).'" /></a>';

                    $data[] = $row;
                }
                $result['data'] = $data;
            }
        }

        echo json_encode($result);

    }

    public function payment_receipt($invoice_no = ""){
        $query = $this->db->query('SELECT pr.order_id,pr.month,pr.year,m.merchant_name,b.branch_name,b.npwp,b.nopd,b.location,
    ps.totalpayment,ps.notiftime FROM paymentrequest pr JOIN merchant m ON m.merchant_id = pr.merchant_id JOIN branch b ON b.branch_id = pr.branch_id AND b.merchant_id = pr.merchant_id JOIN paymentstatus ps on pr.order_id = ps.orderid WHERE pr.order_id = '.$invoice_no.';');
        $data = $query->row_array();
        $data['terbilang'] = $this->terbilang($data['totalpayment'])." RUPIAH";
        $this->load->view('report/receipt',$data);
    }

    public function terbilang( $num ,$dec=4){
        $stext = array(
            "NOL",
            "SATU",
            "DUA",
            "TIGA",
            "EMPAT",
            "LIMA",
            "ENAM",
            "TUJUH",
            "DELAPAN",
            "SEMBILAN",
            "SEPULUH",
            "SEBELAS"
        );
        $say  = array(
            "RIBU",
            "JUTA",
            "MILYAR",
            "TRILIUN",
            "BILIUN", // remember limitation of float
            "--apaan---" ///setelah biliun namanya apa?
        );
        $w = "";

        if ($num <0 ) {
            $w  = "Minus ";
            //make positive
            $num *= -1;
        }

        $snum = number_format($num,$dec,",",".");
        // die($snum);
        $strnum =  explode(".",substr($snum,0,strrpos($snum,",")));
        //parse decimalnya
        $koma = substr($snum,strrpos($snum,",")+1);

        $isone = substr($num,0,1)  ==1;
        if (count($strnum)==1) {
            $num = $strnum[0];
            switch (strlen($num)) {
                case 1:
                case 2:
                    if (!isset($stext[$strnum[0]])){
                        if($num<19){
                            $w .=$stext[substr($num,1)]." BELAS";
                        }else{
                            $w .= $stext[substr($num,0,1)]." PULUH ".
                                (intval(substr($num,1))==0 ? "" : $stext[substr($num,1)]);
                        }
                    }else{
                        $w .= $stext[$strnum[0]];
                    }
                    break;
                case 3:
                    $w .=  ($isone ? "SERATUS" : $this->terbilang(substr($num,0,1)) .
                        " RATUS").
                        " ".(intval(substr($num,1))==0 ? "" : $this->terbilang(substr($num,1)));
                    break;
                case 4:
                    $w .=  ($isone ? "SERIBU" : terbilang(substr($num,0,1)) .
                        " RIBU").
                        " ".(intval(substr($num,1))==0 ? "" : terbilang(substr($num,1)));
                    break;
                default:
                    break;
            }
        }else{
            $text = $say[count($strnum)-2];
            $w = ($isone && strlen($strnum[0])==1 && count($strnum) <=3? "Se".strtolower($text) : $this->terbilang($strnum[0]).' '.$text);
            array_shift($strnum);
            $i =count($strnum)-2;
            foreach ($strnum as $k=>$v) {
                if (intval($v)) {
                    $w.= ' '.$this->terbilang($v).' '.($i >=0 ? $say[$i] : "");
                }
                $i--;
            }
        }
        $w = trim($w);
        if ($dec = intval($koma)) {
            $w .= " Koma ". terbilang($koma);
        }
        return trim($w);
    }

    public function payment_report_pdf()
    {
        ini_set('memory_limit', '512M');

        foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }

        if(!empty($year) && $year!="ALL"){
            $filter[] = "(year = '".$year."')";
        }
        
        if(!empty($month) && $month!="ALL"){
            $filter[] = "(month = '".$month."')";
        }

        if (!empty($invoice_no)) {
            $filter[] = "(invoice_no = '" . $invoice_no . "')";
        }

        if($_SESSION['level']<4 || $_SESSION['level'] == 6){
            if ((!empty($merchant_id)) && (($merchant_id) != 'ALL')) {
                //get merchant ID
                $filter[] = '(merchant_id="' . $merchant_id . '")';
                
                //branch
                if ((!empty($branch_id)) && (($branch_id) != 'ALL')) {
                    $filter[] = '(branch_id="' . $branch_id . '")';
                }
            }
        }else{
            $filter[] = '(merchant_id="' . $_SESSION['merchantid'] . '")';
            $merchant_id    = $_SESSION['merchant_id'];
            //branch
            if ((!empty($branch_id)) && (($branch_id) != 'ALL')) {
                $filter[] = '(branch_id="' . $branch_id . '")';
            }
        }


        if (isset($filter)) {
            $condition = implode(' AND ', $filter);
            $this->db->where($condition);
        }

        $this->db->select('merchant_name,branch_name,npwp,nopd,invoice_no,ppn,assessment,paid,note,payment_channel,month,year,paid_date');

        $data = $this->db->get('payment_success3')->result_array();

        $headerMerchantName = 'ALL';
       	$headerBranchName 	= 'ALL';
       	if ($merchant_id != 'ALL') {
       		$param 				= ['merchant_id '=> $merchant_id];
       		$merchantName 		= $this->master->get_merchant($param);
       		$headerMerchantName = $merchantName[0]['merchant_name']; 

       	}

       	if ($branch_id != 'ALL') {
       		$brancName 			= $this->master->branch_id($merchant_id, $branch_id);
       		$headerBranchName 	= $brancName[0]['branch_name'];
       	}

        $title ='Payment Report';
        $html = '<table class="header">
                    <thead>
                    	<tr>
                            <th><b></b></th>
                            <th><b></b></th>
                            <th><b></b></th>
                            <th><b></b></th>
                        </tr>
                        <tr>
                            <th><b>Merchant name</b></th>
                            <th><b>:</b></th>
                            <th><b>'.$headerMerchantName.'</b></th>
                            <th><b></b></th>
                        </tr>
                        <tr>
                        	<th><b>Branch Name</b></th>
                        	<th><b>:</b></th>
                        	<th><b>'.$headerBranchName.'</b></th>
                        	<th><b></b></th>
                        </tr>
                        <tr>
                        	<th></th>
                        </tr>
                    </thead>
                </table>
                <table border="1" cellspacing="2" cellpadding="1">
                    <tr>
                        <th align="Center">#</th>
                        <th align="center">Merchant Name</th>
                        <th align="center">Branch Name</th>
                        <th align="center">NPWP</th>
                        <th align="center">NOPD</th>
                        <th align="center">Invoice NO</th>
                        <th align="center">PPN</th>
                        <th align="center">Assessment</th>
                        <th align="center">PAID</th>
                        <th align="center">Note</th>
                        <th align="center">Payment Channel</th>
                        <th align="center">Year</th>
                        <th align="center">Month</th>
                        <th align="center">Paid Date</th>
                    </tr>';
        foreach ($data as $count => $row) {
        $html .= '
                    <tr>
                        <td>'.++$count.'</td>
                        <td>'.$row['merchant_name'].'</td>
                        <td>'.$row['branch_name'].'</td>
                        <td>'.$row['npwp'].'</td>
                        <td>'.$row['nopd'].'</td>
                        <td>'.$row['invoice_no'].'</td>
                        <td>'.$row['ppn'].'</td>
                        <td>'.$row['assessment'].'</td>
                        <td>'.$row['paid'].'</td>
                        <td>'.$row['note'].'</td>
                        <td>'.$row['payment_channel'].'</td>
                        <td>'.$row['month'].'</td>
                        <td>'.$row['year'].'</td>
                        <td>'.$row['paid_date'].'</td>
                    </tr>';
        }
        $html .= '</table>';
        $filesName = 'Detail Report_'.date('d/m/Y');

        $this->pdf_template($title, $html, $filesName);
    }

    public function payment_report_xlsx($type = "xlsx")
    {
        //error_reporting(E_ALL);
        // ini_set('display_errors', TRUE);
        // ini_set('display_startup_errors', TRUE);
        //load librarynya terlebih dahulu
        //print_r($_REQUEST);
        ini_set('memory_limit', '512M');

        foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }
        //$filter[] = "(merchantid= '" . $_SESSION['merchantid'] . "')";

        if(!empty($year) && $year!="ALL"){
            $filter[] = "(year = '".$year."')";
        }
        
        if(!empty($month) && $month!="ALL"){
            $filter[] = "(month = '".$month."')";
        }

        // if (!empty($start_date)) {
        //     $swap_date = explode("-", $start_date);
        //     $start_date = $swap_date[2] . '-' . $swap_date[1] . '-' . $swap_date[0];
        //     if (!empty($end_date)) {
        //         $swap_date = explode("-", $end_date);
        //         $end_date = $swap_date[2] . '-' . $swap_date[1] . '-' . $swap_date[0];
        //         $filter[] = "(bill_date between '" . $start_date . " 00:00:00' AND '" . $end_date . " 23:59:59')";
        //     } else {
        //         $filter[] = "(bill_date between '" . $start_date . " 00:00:00' AND '" . date('Y-m-d H:i:s') . "')";
        //     }
        // } elseif (!empty($end_date)) {
        //     $swap_date = explode("-", $end_date);
        //     $end_date = $swap_date[2] . '-' . $swap_date[1] . '-' . $swap_date[0];
        //     $filter[] = "(bill_date <= '" . $end_date . " 23:59:59')";
        // }

        //rawdata
        if (!empty($invoice_no)) {
            //unset($filter);
            $filter[] = "(invoice_no = '" . $invoice_no . "')";
        }

        //merchant
        if($_SESSION['level']<4 || $_SESSION['level'] == 6){
            if ((!empty($merchant_id)) && (($merchant_id) != 'ALL')) {
                //get merchant ID
                $filter[] = '(merchant_id="' . $merchant_id . '")';
                
                //branch
                if ((!empty($branch_id)) && (($branch_id) != 'ALL')) {
                    $filter[] = '(branch_id="' . $branch_id . '")';
                }
            }
        }else{
            $filter[] = '(merchant_id="' . $_SESSION['merchantid'] . '")';

            //branch
            if ((!empty($branch_id)) && (($branch_id) != 'ALL')) {
                $filter[] = '(branch_id="' . $branch_id . '")';
            }
        }


        if (isset($filter)) {
            $condition = implode(' AND ', $filter);
            $this->db->where($condition);
        }
        // print_r($filter); die;
        $this->db->select('merchant_name,branch_name,npwp,nopd,invoice_no,ppn,assessment,paid,note,payment_channel,month,year,paid_date');
        //$this->db->order_by('bill_date');   

        $result = $this->db->get('payment_success3');

        if ($result->num_rows() > 0) {
            $list_data = $result->result_array();
            //print_r($list_data); die;
            //get list fields
            foreach ($list_data[0] as $key => $value) {
                $fields[] = $this->payment_field_mapper[$key];
            }
        } else {
            echo json_encode(array('message' => 'Data tidak ada! Silakan lakukan pencarian dengan data yang lain.'));
            exit();
        }

        // exit();

        $this->load->library("PHPExcel");

        //membuat objek PHPExcel
        $objPHPExcel = new PHPExcel();

        //set Sheet yang akan diolah
        $objPHPExcel->setActiveSheetIndex(0);

        // Set Header
        $letter = "A";
        for ($i = 0; $i < count($fields); $i++) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($letter . '1', $fields[$i]);
            $letter++;
        }

        // Set Data
        $col = "2";
        for ($i = 0; $i < count($list_data); $i++) {
            $row = "A";
            foreach ($list_data[$i] as $key => $value) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($row . $col, $value);
                $row++;
            }
            $col++;
        }

        //set title pada sheet (me rename nama sheet)
        $objPHPExcel->getActiveSheet()->setTitle('Report Payment');
        //sesuaikan headernya
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        if ($type == 'xlsx') {
            $filename = 'Report Payment - ' . date('YmdHi') . '.xlsx';
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            //ubah nama file saat diunduh
            header('Content-Disposition: attachment;filename="' . $filename . '');

            //mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        } else if ($type == 'csv') {

            $filename = 'Report Payment - ' . date('YmdHi') . '.csv';
            header('Content-Type: text/csv');
            //ubah nama file saat diunduh
            header('Content-Disposition: attachment;filename="' . $filename . '');

            //mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');

        }

        //unduh file
        // $objWriter->save("php://output");

        $objWriter->save(FCPATH . 'res/report/' . $filename);

        echo json_encode(array('message' => 'File laporan berhasil dibuat! Silakan download <strong><a href="' . str_replace('index.php/', '', base_url('res/report/' . $filename)) . '"><img src="' . str_replace('index.php/', '', base_url('res/download.png')) . '" /> disini </a></strong>'));
    }

    public function monitoring(){
        $this->load->model('Masters', 'master');

        if($_SESSION['level'] == "3"){
            $merchant_id = $this->master->npwp($_SESSION['npwp']);
            $data['merchants'] = $this->master->get_merchant_by_merchantid($merchant_id);
            $data['branch'] = $this->master->branch_id($merchant_id[0], 'ALL');
        }else{
            $data['merchants'] = $this->master->merchant_id();
            if($_SESSION['level']=="4"){
                $data['branch'] = $this->master->branch_id($_SESSION['merchantid'], 'ALL');
            }else if($_SESSION['level']=="5"){
                $data['branch'] = $this->master->branch_id($_SESSION['merchantid'],$_SESSION['branchid']);
            }
        }

        $this->load->view('report/header');
        $this->load->view('main/global_headbar');
        $this->load->view('main/global_sidebar');
        $this->load->view('report/monitoring', $data);
        $this->load->view('main/global_footbar');
        $this->load->view('report/footer');
    }

    public function monitoring_data_search(){
        ini_set('memory_limit', '512M');
        $this->load->library('Datatablessp');

        foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }

        $table = "merchant m JOIN branch b ON m.merchant_id = b.merchant_id LEFT JOIN header h ON (h.merchant_id = b.merchant_id AND h.branch_id = b.branch_id";

        $primaryKey = 'm.merchant_id';

        $columns = array(
            array('db' => 'm.merchant_name AS merchant_name', 'dt' => 0),
            array('db' => 'b.branch_name AS branch_name', 'dt' => 1),
            array('db' => 'COUNT(h.bill_date) AS total_transaction', 'dt' => 2)
        );

        $additional = "";

        // SQL server connection information
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );

        $filter = array();
        $filter[] = "(1 = 1)";

        $filter_date = array();
        if (!empty($start_date)) {
            $swap_date = explode("-", $start_date);
            $start_date = $swap_date[2] . '-' . $swap_date[1] . '-' . $swap_date[0];
            if (!empty($end_date)) {
                $swap_date = explode("-", $end_date);
                $end_date = $swap_date[2] . '-' . $swap_date[1] . '-' . $swap_date[0];
                $filter_date[] = "(h.bill_date between '" . $start_date . " 00:00:00' AND '" . $end_date . " 23:59:59')";
            } else {
                //$filter_date[] = "(hr.bill_date between '" . $start_date . " 00:00:01' AND '" . date('Y-m-d H:i:s', strtotime('+2 day')) . "')"; by mahes
                $filter_date[] = "(h.bill_date between '" . $start_date . " 00:00:00' AND '" . date('Y-m-d H:i:s') . "')";
            }
        } elseif (!empty($end_date)) {
            $swap_date = explode("-", $end_date);
            $end_date = $swap_date[2] . '-' . $swap_date[1] . '-' . $swap_date[0];
            $filter_date[] = "(h.bill_date <= '" . $end_date . " 23:59:59')";
        }

        //merchant
        if($_SESSION['level']<4 || $_SESSION['level'] == 6 ){
            if ((!empty($merchant_id)) && (($merchant_id) != 'ALL')) {
                //get merchant ID
                $filter[] = '(m.merchant_id="' . $merchant_id . '")';

                //branch
                if ((!empty($branch_id)) && (($branch_id) != 'ALL')) {
                    $filter[] = '(b.branch_id="' . $branch_id . '")';
                }
            }
        }else{
            $filter[] = '(m.merchant_id="' . $_SESSION['merchantid'] . '")';

            //branch
            if ((!empty($branch_id)) && (($branch_id) != 'ALL')) {
                $filter[] = '(b.branch_id="' . $branch_id . '")';
            }
        }


        $condition = implode(' AND ', $filter);
        //print_r($condition); die;
        $table = $table.' AND '.implode(' AND ', $filter_date).')'."WHERE ".$condition." GROUP BY b.merchant_id,b.branch_id";
        $condition = '';
        if($empty_only=='true'){
            $table = $table.' HAVING COUNT(h.bill_date)=0';
        }
        // echo $table;exit();
        $result = $this->datatablessp->complex($_POST, $sql_details, $table, $primaryKey, $columns, $condition, $condition, $additional);
            if (!empty($result['data'])) {
                foreach ($result['data'] as $row) {
                    // $row[18] = null;
                    // $row[19] = null;
                    // $row[30] = null;
                    $data[] = $row;
                }
                $result['data'] = $data;
            }

        echo json_encode($result);
    }

}
