<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller
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
        $this->load->model('Dashboards');
        $this->load->model('Masters', 'master');

    }

    public function index()
    {
        if ($this->session->userdata('islogin') == TRUE):
            //redirect(base_url('report/transaction'));
            redirect(base_url('welcome/dashboard'));
            //for All
//             $dataPaymentSummary = $this->Dashboards->get_payment(null,null)->result_array();

//             if(count($dataPaymentSummary>0)){
//                 $summaryData = $this->split_array($dataPaymentSummary);
//             }else{
//                 $summaryData = "Data Not Found";
//             }
//             //for Yesterday 00:00:00 until today 08:00
//             $datexx = date_create(date("Y-m-d"));
//             date_sub($datexx, date_interval_create_from_date_string("1 days"));
//             $minDate = date(date_format($datexx, "Y-m-d 00:00:00"));
//             $maxDate = date("Y-m-d 08:00:00");
//             $dataYesterday = $this->Dashboards->get_payment($minDate, $maxDate)->result_array();

//             if(count($dataYesterday)>0){
//                 $dataPaymentYesterday = $this->split_array($dataYesterday);
//             }else{
//                 $dataPaymentYesterday = "Data Not Found";
//             }

//             //for Today 00:00 until now
//             $minDateToday = date("Y-m-d 00:00:00");
//             $maxDateToday = date("Y-m-d H:i:s");
//             $dataToday = $this->Dashboards->get_payment($minDateToday, $maxDateToday)->result_array();


//             if(count($dataToday)>0){
//                 $dataPaymentToday = $this->split_array($dataToday);
//             }else{
//                 $dataPaymentToday = "Data Not Found";
//             }
//             $data = array(
//                 "dataSummary" => $summaryData,
//                 "dataPaymentYesterday" => $dataPaymentYesterday,
//                 "dataPaymentToday"=>$dataPaymentToday
//             );

// //            print_r(json_encode($dataPaymentYesterday));
// //            exit();
//             $this->load->view('main/global_header');
//             $this->load->view('main/global_headbar');
//             $this->load->view('main/global_sidebar');
//             $this->load->view('dashboard/dashboard_content', $data);
//             $this->load->view('main/global_footbar');
//             $this->load->view('dashboard/dashboard_footer', $data);
        else:
            $this->load->view('signin/header');
            $this->load->view('signin/form');
            $this->load->view('signin/footer');
        endif;
    }

    public function split_array($data)
    {
        foreach ($data as $pc) {
            $paymentStatus[] = $pc['description'];
            $paymentStatusDescription[] = $pc['ppn'];
            $paymentStatusCounter[] = $pc['transactions'];
        }
        $splitData = array(
            "paymentStatus" => json_encode($paymentStatus),
            "paymentStatusDescription" => json_encode($paymentStatusDescription),
            "paymentStatusCounter" => json_encode($paymentStatusCounter),
        );
        return $splitData;
    }

    public function split_array2($data)
    {
        foreach ($data as $pc) {
            $paymentStatus[] = $pc['description'];
            $paymentStatusDescription[] = $pc['ppn'];
            $paymentStatusCounter[] = $pc['transactions'];
            $fillcolor[] = $this->randomColor();
        }
        $splitData = array(
            "paymentStatus" => $paymentStatus,
            "paymentStatusDescription" => $paymentStatusDescription,
            "paymentStatusCounter" => $paymentStatusCounter,
            "fillcolor" => $fillcolor,
        );
        return $splitData;
    }

    // public function test_server()
    // {
    //     print_r($_SERVER);
    // }

    public function randomColor(){
        $chars = 'ABCDEF0123456789';
        $color = '#';
        for ( $i = 0; $i < 6; $i++ ) {
            $color .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $color;
    }

    public function dashboard(){
        $userLevel = $_SESSION['level'];
        if ($this->session->userdata('islogin') == TRUE):
            $merchants  = $this->master->merchant_id();
            if($_SESSION['level']<'3'){
                $merchantId = '0';
                $branchId   = '0';
            }else if ($_SESSION == '3') {
                $merchantId =$_SESSION['merchantid'];
                $branchId   = $_SESSION['branchid'];
            } else {
                $merchantId =$_SESSION['merchantid'];
                $branchId   = $_SESSION['branchid'];
            }
            
            //$merchantid=$_SESSION['merchantid'];

             //for All
            // $minDateToday = date("Y-m-01 00:00:00");
            // $maxDateToday = date("Y-m-d H:i:s");
            // $dataPurchaseSummary = $this->Dashboards->get_purchase($minDateToday,$maxDateToday,$merchantid)->result_array();

            // if(count($dataPurchaseSummary>0)){
            //     $summaryData = $this->split_array($dataPurchaseSummary);
            //     //$summaryData2 = $this->split_array2($dataPurchaseSummary);
            // }else{
            //     $summaryData = "Data Not Found";
            // }

            // for($i=0;$i<count($summaryData2['paymentStatus']);$i++){
            //     $count = 100/count($summaryData2['paymentStatus']);
            //     $dataPoints[$i]['label']= $summaryData2['paymentStatus'][$i];
            //     $dataPoints[$i]['y']= $count;
            // }

            
            $data = [   "merchantId"    => $merchantId,
                        "branchId"      => $branchId,
                        "merchants"     => $merchants,
                        "userLevel"     => $userLevel
                    ];

            // "dataPoints" => $dataPoints,
            //"dataSummary" => $summaryData

            $this->load->view('main/global_header');
            $this->load->view('main/global_headbar');
            $this->load->view('main/global_sidebar');
            $this->load->view('dashboard/dashboard_content', $data);
            $this->load->view('main/global_footbar');
            $this->load->view('dashboard/dashboard_footer', $data);
        else:
            redirect(base_url('signin'));
        endif;
    }

    public function refreshData(){
        
            $branchid = '0';
            $level = $_SESSION['level'];
             
            if($level < '3' || $level == '6'){
                if(isset($_REQUEST['merchantid']) && $_REQUEST['merchantid']!="" && $_REQUEST['merchantid']!="ALL"){
                    $merchantid = $_REQUEST['merchantid'];
                }else{
                    $merchantid='0';
                }
            }else{
                $merchantid=$_SESSION['merchantid'];
            }

            if($level == '5'){
                $branchid = $_SESSION['branchid'];
            }
            //$merchantid=$_SESSION['merchantid'];

             //for All
            $minDateToday = date("Y-m-01 00:00:00");
            $maxDateToday = date("Y-m-d H:i:s");
            
            if ($level == 5 ) {
                $dateRange = explode(' - ', $_REQUEST['dateRange']);

                if (count($dateRange) > 1) {
                    $startDate  = date('Y-m-d H:i:s', strtotime($dateRange[0]));
                    $endDate    = date('Y-m-d H:i:s', strtotime($dateRange[1]. "+ 1 days"));
                    
                    $monthStart = date('m', strtotime($dateRange[0]));
                    $monthEnd   = date('m', strtotime($dateRange[1]));

                    if ($monthStart != $monthEnd) {
                        $startDate = date("Y-m-01", strtotime($endDate));
                    }

                } else {
                    $startDate = $minDateToday;
                    $endDate   = $maxDateToday;
                }
                    
                $dataPurchaseSummary = $this->Dashboards->get_purchase_branch($startDate,$endDate,$merchantid,$branchid);
            } else {

                $dataPurchaseSummary = $this->Dashboards->get_purchase($minDateToday,$maxDateToday,$merchantid,$branchid)->result_array();
            }            

            if(count($dataPurchaseSummary>0)){
                $summaryData = $this->split_array2($dataPurchaseSummary);
            }else{
                $summaryData = "Data Not Found";
            }

            for($i=0;$i<count($summaryData['paymentStatus']);$i++){
                //$count = 100/count($summaryData['paymentStatus']);
                $count = (int)$summaryData['paymentStatusDescription'][$i];
                $dataPoints[$i]['label']= $summaryData['paymentStatus'][$i];
                $dataPoints[$i]['y']= $count;
            }
            // $data = array(
            //     "dataSummary" => $summaryData,
            // );
            
            $data['summaryData']=$summaryData;
            $data['dataPoints']=$dataPoints;

            echo json_encode($data);
    }
}
