<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '512M');

/**
 * 
 */
class ReportPayment extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->library('pdf');
        $this->load->model('Report_payment'); 
        $this->load->model('Masters', 'master');

        if (!$this->session->userdata('islogin')) {
            redirect(base_url('signin/'));
        }


         $this->header_field_mapper = array(
            'merchant_name' => 'Wajob Pajak',
            'branch_name'   => 'Outlet',
            'npwp'          => 'NPWP',
            'nopd'          => 'NOPD',
            'kode_bayar'    => 'Kode Bayar',
            'payment_date'  => 'Tanggal Pembayaran',
            'total_payment' => 'Total Pembayaran Pajak',
            'periode'       => 'Periode'

        );
    }

    public function index()
    {
        $access = [
            'accessModule' => $this->master->user_access($_SESSION['up_id'])
        ];
        $this->load->model('Masters', 'master');
        $class = ['class' => 'reportpayment'];

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
        $this->load->view('report/payment', $data);
        $this->load->view('main/global_footbar');
        $this->load->view('main/footer', $class);
    }

    public function print_report($year, $month, $merchant_id = null, $branch_id = null, $suban_id, $invoice_no=null)
    {

        if ($_SESSION['level'] == '3') {
            $suban_id = $_SESSION['subanId'];
        }

        if ($_SESSION['level'] == "5"){
            $merchant_id = $_SESSION['merchantid'];
        } else if ($_SESSION['level'] == "6") {
            $merchant_id = $_SESSION['merchantid'];
            $branch_id = $_SESSION['branchid'];
        }
        
        $class = ['class' => 'reportpayment'];
        $data  = $this->Report_payment->get_data($year, $month, $merchant_id, $branch_id, $suban_id, $invoice_no)->result_array();

        $result = [
            'fetch' => $data
        ];

        $this->load->view('main/header');
        $this->load->view('main/footer', $class);
        $this->load->view('report/payment_report', $result);
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


        if ($_SESSION['level'] == '3') {
            $suban_id = $_SESSION['suban_id'];
        }

        $dataPayment = $this->Report_payment->get_data_table($month, $year, $merchant_id, $branch_id, $suban_id, $invoice_no)->result();
        
        $data = [];
        $row =[];
        
      
        foreach ($dataPayment as $key => $value) {
            $row = [];
            $row[] = $value->merchant_name;
            $row[] = $value->branch_name;
            $row[] = $value->npwp;
            $row[] = $value->nopd;
            $row[] = $value->kode_bayar;
            $row[] = number_format($value->total_payment);
            $row[] = $value->periode;
            $row[] = date('d F Y', strtotime($value->payment_date));
            $data[] = $row;
        }

        $output = [
            'draw' => $_POST['draw'],
            "recordsTotal" => $this->Report_payment->count_all($month, $year, $merchant_id, $branch_id, $suban_id, $invoice_no),
            "recordsFiltered" => $this->Report_payment->count_filtered($month, $year, $merchant_id, $branch_id, $suban_id, $invoice_no),
            "data" => $data,
        ];

        echo json_encode($output,true);
        exit();
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
    public function excel_export($type = 'xlsx')
    {
        foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }
        if ($_SESSION['level'] > 4 ) {
             $merchant_id = $_SESSION['merchantid'];
        }

        if ($_SESSION['level'] == '3') {
            $suban_id = $_SESSION['subanId'];
        }

        $result  = $this->Report_payment->get_data($month, $year, $merchant_id, $branch_id, $suban_id, $invoice_no)->result_array();

       
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

        $objPHPExcel->getActiveSheet()->setTitle('Report Payment');

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


}

?>