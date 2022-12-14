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
        $this->load->model('branchModels');
    }

    public function index()
    {
        if ($this->session->userdata('islogin') == TRUE):
            redirect(base_url('welcome/dashboard'));
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

    public function split_array2($data, $type)
    {
        if ($type == 'kecamatan') {
            foreach ($data as $pc) {
                $paymentStatus[] = $pc['description'];
                $paymentStatusDescription[] = $pc['transactions'];
                $paymentStatusCounter[] = $pc['ppn'];
                $fillcolor[] = $this->randomColor();
            }
        } else if($type == 'monitoring_branch') {
            foreach ($data as $pc) {
                $paymentStatus[] = $pc['description'];
                $paymentStatusDescription[] = $pc['transactions'];
                $paymentStatusCounter[] = $pc['total_transactions'];
                $fillcolor[] = $this->randomColor();
            }
        } else {
            foreach ($data as $pc) {
                $paymentStatus[] = $pc['description'];
                $paymentStatusDescription[] = $pc['ppn'];
                $paymentStatusCounter[] = $pc['transactions'];
                $fillcolor[] = $this->randomColor();
            }
        }
        
        $splitData = array(
            "paymentStatus" => $paymentStatus,
            "paymentStatusDescription" => $paymentStatusDescription,
            "paymentStatusCounter" => $paymentStatusCounter,
            "fillcolor" => $fillcolor,
        );
        return $splitData;

    }

    public function randomColor(){
        $chars = 'ABCDEF0123456789';
        $color = '#';
        for ( $i = 0; $i < 6; $i++ ) {
            $color .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $color;
    }

   public function get_data_header() {
        $userLevel = $_SESSION['level'];
        $class = ['class' => 'dashboard'];
        $minDateToday = date("Y-m-01 00:00:00");
        $maxDateToday = date("Y-m-d H:i:s");
        $taxTotal = 0;

        $merchants  = $this->master->merchant_id();
        if($_SESSION['level']<'4'){
            $merchantId = '0';
            $branchId   = '0';
        }else if ($_SESSION['level'] == '4') {
            $merchantId =$_SESSION['merchantid'];
            $branchId   = $_SESSION['branchid'];
        } else {
            $merchantId =$_SESSION['merchantid'];
            $branchId   = $_SESSION['branchid'];
        }
        $dataSuban = [];
        $idSuban    = [];
        $taxSuban = $this->Dashboards->get_tax_persuban($minDateToday, $maxDateToday);

        foreach ($taxSuban as $key => $value) {
            array_push($idSuban, $value['suban_id']);
        }

        
        $suban = $this->Dashboards->subanNotin($idSuban)->result_array();
        
        foreach ($suban as $key => $valueSuban) {
            array_push($taxSuban, ['suban_name' => $valueSuban['suban_name'], 'suban_id' => $valueSuban['suban_id'], 'ppn' => '0', 'transactions' => '0']);
        }

        foreach ($taxSuban as $rowSuban) {
            $taxTotal += $rowSuban['ppn'];    
        }

        $data = [   "merchantId"    => $merchantId,
                    "branchId"      => $branchId,
                    "merchants"     => $merchants,
                    "userLevel"     => $userLevel,
                    "subanData"     => $taxSuban,
                    "totalTax"      => $taxTotal
                ];
        echo json_encode($data);
        exit();
   }

    public function dashboard(){

        $class = ['class' => 'dashboard'];
        if ($this->session->userdata('islogin') == TRUE):
            $userLevel = $_SESSION['level'];

            $access = [
                'accessModule' => $this->master->user_access($_SESSION['up_id'])
            ];

            $data= ["userLevel"     => $userLevel ];
            $this->load->view('main/global_header');
            $this->load->view('main/global_headbar');
            $this->load->view('main/global_sidebar',$access);
            $this->load->view('dashboard/dashboard_content', $data);
            $this->load->view('main/global_footbar');
            $this->load->view('main/footer', $class);
        else:
            redirect(base_url('signin'));
        endif;
    }

    public function chartKecamatanMerchant () {
        $minDateToday = date("Y-m-01 00:00:00");
        $maxDateToday = date("Y-m-d H:i:s");
        $suban_id = $_REQUEST['suban_id'];

        if ($_REQUEST['type'] == 'kecamatan') {
            $dataPurchaseSummary = $this->Dashboards->get_purchase_kecamatan($minDateToday,$maxDateToday, $suban_id)->result_array();
        } else {
            $dataPurchaseSummary = $this->Dashboards->get_purchase_merchant($minDateToday,$maxDateToday, $suban_id)->result_array();
        }
        if(count($dataPurchaseSummary>0)){
            if ($_REQUEST['type'] == 'kecamatan') {
                $summaryData = $this->split_array2($dataPurchaseSummary, 'kecamatan');
            } else {
                $summaryData = $this->split_array2($dataPurchaseSummary, 'merchant');
            }
            
        }else{
            $summaryData = "Data Not Found";
        }

        for($i=0;$i<count($summaryData['paymentStatus']);$i++){

            $count = (int)$summaryData['paymentStatusDescription'][$i];
            $dataPoints[$i]['label']= $summaryData['paymentStatus'][$i];
            $dataPoints[$i]['y']= $count;
        }
        
        $data['summaryData']=$summaryData;
        $data['dataPoints']=$dataPoints;

        echo json_encode($data);
    }

    public function refreshData(){
        
            $branchid = $_SESSION['branchid'];
            $level = $_SESSION['level'];
            
            $subanId = null;
            if ($_SESSION['level'] == 3) {
                $subanId = $_SESSION['suban_id'];
            }
            

            $onlineBranch = $this->Dashboards->branch_online($subanId);
            $allBranch = $this->branchModels->count_all($subanId);

            
            $offlineBranch = $allBranch - $onlineBranch;

            if($level < '4'){
                if(isset($_REQUEST['merchantid']) && $_REQUEST['merchantid']!="" && $_REQUEST['merchantid']!="ALL"){
                    $merchantid = $_REQUEST['merchantid'];
                }else{
                    $merchantid = $_SESSION['merchantid'];
                }
            }else{
                $merchantid=$_SESSION['merchantid'];
            }

            if($level == '6'){
                $branchid = $_SESSION['branchid'];
            }

            $minDateToday = date("Y-m-01 00:00:00");
            $maxDateToday = date("Y-m-d H:i:s");
            
            if ($level == 6 ) {
                $dateRange = explode(' - ', $_REQUEST['dateRange']);
            
                if (count($dateRange) > 1) {
                    $startDate  = date('Y-m-d H:i:s', strtotime($dateRange[0]));
                    $endDate    = date('Y-m-d H:i:s', strtotime($dateRange[1]));
                    
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
            } elseif ($level <= 3) {
                $dataPurchaseSummary = $this->Dashboards->branch_monitoring($subanId)->result_array();
            } else {
                $dataPurchaseSummary = $this->Dashboards->get_purchase($minDateToday,$maxDateToday,$merchantid,$branchid)->result_array();
            }          

            if(count($dataPurchaseSummary>0)){
                $summaryData = $this->split_array2($dataPurchaseSummary, 'ALL');
            }else{
                $summaryData = "Data Not Found";
            }

            for($i=0;$i<count($summaryData['paymentStatus']);$i++){

                $count = (int)$summaryData['paymentStatusDescription'][$i];
                $dataPoints[$i]['label']= $summaryData['paymentStatus'][$i];
                $dataPoints[$i]['y']= $count;
            }
            
            $data['summaryData']    = $summaryData;
            $data['dataPoints']     = $dataPoints;
            $data['onlineBranch']   = $onlineBranch;
            $data['offlineBranch']  = $offlineBranch;

            echo json_encode($data);
    }
}
