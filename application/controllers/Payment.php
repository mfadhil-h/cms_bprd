<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '512M');

class Payment extends CI_Controller
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

    public $server_pg='http://103.252.50.157:8282';
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('islogin')) {
            redirect(base_url('signin/'));
        }

        $this->load->model('payments');
        $this->load->model('Masters', 'master');

        $this->payment_field_mapper = array(
          'merchant_name' => 'MERCHANT NAME',
          'branch_name' => 'BRANCH NAME',
          'bill_date' => 'DATE',
          'total_trx_amount' => 'TOTAL TRX AMOUNT'
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
            if($_SESSION['level']=="5"){
                $data['branch'] = $this->master->branch_id($_SESSION['merchantid'], 'ALL');
            }else if($_SESSION['level']=="6"){
                $data['branch'] = $this->master->branch_id($_SESSION['merchantid'],$_SESSION['branchid']);
            }
        }
        
        $class = ['class' => 'payment'];

        $previlage = $this->master->module_access($_SESSION['up_id'], 'mod_summary')->row();
        
        $data ['rights'] = $previlage->ma_previlage;
        
       // var_dump($data); exit();
        $this->load->view('main/header');
        $this->load->view('main/global_headbar');
        $this->load->view('main/global_sidebar', $access);
        $this->load->view('payment/payment', $data);
        $this->load->view('main/global_footbar');
        $this->load->view('main/footer', $class);
    }

    public function get_data_payment()
    {
        foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }
        
        if ($_SESSION['level'] > 4 ) {
          $merchant_id = $_SESSION['merchantid'];
          if (!empty($_SESSION['branchid'])) {
            $branch_id = $_SESSION['branchid'];
          }
        }

        $query = $this->payments->getPayment($merchant_id, $branch_id, $month, $year);
        $data = $query->result_array();
        
        echo json_encode($data,true);
    }
    
    public function payment_data_search()
    {
        ini_set('memory_limit', '512M');
        $this->load->library('Datatablessp');

        foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }

        $table = 'payment pt';

        // Table's primary key
        $primaryKey = 'pt.bill_date';

        $columns = array(
            array('db' => 'pt.merchant_name', 'dt' => 0),
            array('db' => 'pt.branch_name', 'dt' => 1),
            array('db' => 'pt.bill_date', 'dt' => 2),
            array('db' => 'pt.tax', 'dt' => 3)
        );

        $additional = "";

        // SQL server connection information
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );

        $filter[] = "(YEAR(pt.bill_date) = '".$year."')";
        $filter[] = "(MONTH(pt.bill_date) = '".$month."')";

        if($_SESSION['level']<4){
            if ((!empty($merchant_id)) && (($merchant_id) != 'ALL')) {
                //get merchant ID
                $filter[] = '(pt.merchant_id="' . $merchant_id . '")';

                //branch
                if ((!empty($branch_id)) && (($branch_id) != 'ALL')) {
                    $filter[] = '(pt.branch_id="' . $branch_id . '")';
                }
            }
        }else{
            $filter[] = '(pt.merchant_id="' . $_SESSION['merchantid'] . '")';

            //branch
            if ((!empty($branch_id)) && (($branch_id) != 'ALL')) {
                $filter[] = '(pt.branch_id="' . $branch_id . '")';
            }
        }

        $condition = implode(' AND ', $filter);

        $result = $this->datatablessp->complex($_POST, $sql_details, $table, $primaryKey, $columns, $condition, $condition, $additional);
            if (!empty($result['data'])) {
                foreach ($result['data'] as $row) {
                    $data[] = $row;
                }
                $result['data'] = $data;
            }

        echo json_encode($result);

    }


    function hitapi($data,$url){
        $post_fields = json_encode($data);

        $headers = array(
            "Content-type: application/json",
            "Content-length: " . strlen($post_fields)
        );

        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_VERBOSE, TRUE);

        $res = curl_exec($ch); 

        curl_close($ch);
        return $res;
    }
    
    public function show_detail_waiting_payment()
    {
      foreach ($_REQUEST as $key => $value) {
        $$key = $value;
      }

      $data = ['fetch' => $this->payments->show_detail($order_id)->result_array()];

      $result = $this->load->view('payment/waiting_payment_detail', $data, true);

      echo json_encode($result,true);
    }


    public function taxreport()
    {
      $access = [
            'accessModule' => $this->master->user_access($_SESSION['up_id'])
      ];

      $class = ['class' => 'taxreport'];

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


      $this->load->view('main/header');
      $this->load->view('main/global_headbar');
      $this->load->view('main/global_sidebar', $access);
      $this->load->view('payment/tax_report', $data);
      $this->load->view('main/global_footbar');
      $this->load->view('main/footer', $class);
    }

    public function isosptpd() {
      foreach ($_REQUEST as $key => $value) {
        $$key = $value;
      }

      if ($month < 10) {
          $month = '0'.$month;
      }

      $url_sptpd = 'http://103.252.50.157:3180/post/sptpd';
      $validation = $this->db->get_where('document', ['merchant_id' => $merchant_id, 'branch_id' => $branch_id, 'periode' => 'B'.$year.$month])->num_rows();

      if ($validation > 0) {
        $result = [
          'res'     => false,
          'message' => 'Data Pajak Sudah Dilaporkan'
        ];

      } else {
        $transaction = $this->payments->getPayment($merchant_id, $branch_id, $month, $year)->row();

        $omsetTotal = $transaction->dpp;
        $service = $transaction->service_charge;
        $omset = $transaction->total_amount;

      
        $detail = [
          [
            "KODEFASILITAS" => "05.07",
            "OMSET"         => $service 
          ],
          [
            "KODEFASILITAS" => "05.01",
            "OMSET"         => $omset
          ]
        ];

        $data = [
          [
            "KODEOBJEK"     => $nopd,
            "PERIODE"       => 'B'.$year.$month,
            "TANGGAL_LAPOR" => date('m/d/Y'),
            "OMSET_TOTAL"   => $omsetTotal,
            "SOURCE"        => "7",
            "DETAIL"        => $detail
          ]
        ];

        $dataInsert =  [
          'merchant_id'   => $merchant_id,
          'branch_id'     => $branch_id,
          'nopd'          => $nopd,
          'periode'       => 'B'.$year.$month,
          'tanggal_lapor' => date('Y-m-d'),
          'omset_total'   => $omsetTotal, 
          'source'        => '7',
          'detail'        => json_encode($detail),
          'status'        => '0',
          'created_at'    => date('Y-m-d H:i:s'),
          'created_by'    => $_SESSION['username']
        ];

        $this->db->insert('document',$dataInsert);
        
        $headers = array(
          "Content-Type: application/json"
        );

        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL,$url_sptpd);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_VERBOSE, TRUE);

        $output = curl_exec($ch); 
        curl_close($ch);

        $this->logging('hit_sptpd',json_encode($data), $output);

        $validationKodeTerima = $this->db->get_where('document', ['merchant_id' => $merchant_id, 'branch_id' => $branch_id, 'periode' => 'B'.$year.$month])->row();

        if ($validationKodeTerima->kodeterima == NULL || empty($validationKodeTerima->kodeterima) || $validationKodeTerima->kodeterima == '') {
          $result = [
            'res'     => false,
            'message' => 'Pajak '.$nopd.' Periode '.$month.'/'.$year.' Gagal Dilaporkan'
          ]; 
        } else {
          
          $result = [
            'res'     => true,
            'message' => 'Pajak '.$nopd.' Periode '.$month.'/'.$year.' Berhasil Dilaporkan'
          ];
        }
      }
      

      echo json_encode($result, true);
      exit();
    }

    public function getreporttax()
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
            $suban_id = $_SESSION['subanId'];
        }

        $dataPayment = $this->payments->get_data_table_tax_report($year, $month, $merchant_id, $branch_id)->result();
       
        $data = [];
        $row =[];
        
        foreach ($dataPayment as $key => $value) {
            $row = [];
            $row[] = $value->merchant_name;
            $row[] = $value->branch_name;
            $row[] = $value->year;
            $row[] = $value->month;
            $row[] = $value->kode_bayar;
            $row[] = $value->va_number;
            $row[] = '
                <a  data-month="'.$value->month.'"
                    data-year="'.$value->year.'"
                    data-nopd="'.$value->nopd.'" 
                    data-order-id="'.$value->order_id.'" 
                    data-kode-bayar="'.$value->kode_bayar.'" 
                    data-merchant-id ="'.$value->merchant_id.'" 
                    data-branch-id ="'.$value->branch_id.'" 
                    class="taxreport-control ext-light mr-3 font-16 text-center" data-toggle="tooltip" title="Lapor Pajak"><i class="fa fa-archive"></i></a>';
            $data[] = $row;
        }

        $output = [
          'draw' => $_POST['draw'],
          "recordsTotal" => $this->payments->count_all_tax_report($year, $month, $merchant_id, $branch_id),
          "recordsFiltered" => $this->payments->count_filtered_tax_report($year, $month, $merchant_id, $branch_id),
          "data" => $data,
        ];

        echo json_encode($output, true);
        exit();

    }
    
    public function waitingpayment()
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
          if($_SESSION['level']=="5"){
              $data['branch'] = $this->master->branch_id($_SESSION['merchantid'], 'ALL');
          }else if($_SESSION['level']=="6"){
              $data['branch'] = $this->master->branch_id($_SESSION['merchantid'],$_SESSION['branchid']);
          }
      }

      $merchantId   = 'ALL';
      $branchId     = 'ALL';
      $monthData    = 'ALL';
      $yearData     = 'ALL';

      if (count($_REQUEST) == 0) {
          if ($_SESSION['level'] >= 4 ) {
            $merchantId = $_SESSION['merchantid'];
            if (!empty($_SESSION['branchid'])) {
              $branchid = $_SESSION['branchid'];
            }
          }

          $dataWaitingPayment = $this->payments->waiting_payment($merchantId, $branchId, $monthData, $yearData)->result_array();
          $class = ['class' => 'waitingpayment'];

          $data['fetch'] = $dataWaitingPayment;

          
          $this->load->view('main/header');
          $this->load->view('main/global_headbar');
          $this->load->view('main/global_sidebar', $access);
          $this->load->view('payment/waiting_payment', $data);
          $this->load->view('main/global_footbar');
          $this->load->view('main/footer', $class);
      } else {
        foreach ($_REQUEST as $key => $value) {
          $$key = $value;
        }
        if ($_SESSION['level'] > 4 ) {
          $merchant_id = $_SESSION['merchantid'];
          if (!empty($_SESSION['branchid'])) {
            $branch_id = $_SESSION['branchid'];
          }
        }
        
        $dataWaitingPayment = $this->payments->waiting_payment($merchant_id, $branch_id, $month, $year)->result_array();
        
        echo json_encode($dataWaitingPayment,true);
      
      }
    }

    public function detail()
    {
        $access = [
            'accessModule' => $this->master->user_access($_SESSION['up_id'])
        ];
        foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }

        if($_SESSION['level'] >= '4'){
          $merchant_id = $_SESSION['merchantid'];
        }

        $query = $this->payments->getPayment($merchant_id, $branch_id, $month, $year);
        
        if($query->num_rows()>0){
            $data = $query->result_array();
            
            $amount = $data[0]['tax'];
            if(count($data)>1){            
                for($i=1;$i<count($data);$i++){
                    $amount = $amount + $data[$i]['tax'];
                }
            }
            $amount = round($amount);
            
            if(!isset($merchant_id)){
              $merchant_id=$_SESSION['merchantid'];
            }
            $pass['merchant_id'] = $merchant_id;
            $pass['branch_id'] = $branch_id;
            $pass['year'] = $year;
            $pass['month'] = $month;

            $branchName = $this->master->branch_id($merchant_id, $branch_id);

            $pass['branch_name'] = $branchName[0]['branch_name'];
            $pass['nopd'] = $branchName[0]['nopd'];

            $query_npwp = $this->db->get_where('branch',array('merchant_id'=>$merchant_id));
            $result_npwp = $query_npwp->row_array();
            $pass['npwp'] = $result_npwp['npwp'];

            $pass['total']=$amount;
            $pass['merchantid']=$merchant_id;
            $pass['branchid']=$branch_id;

            $class = ['class' => 'payment'];

            if ($branch_id == 'ALL') {
              $conditionCekPayment =[
                'merchant_id' => $merchant_id,
                'year' => $year,
                'month' => $month
              ];
            } else {
              $conditionCekPayment =[
                'merchant_id' => $merchant_id,
                'branch_id' => $branch_id,
                'year' => $year,
                'month' => $month
              ];
            }
            
            $dataValidate = [];
            $dataPayment = [];
            foreach ($data as $row) {
                $conditionPayment =[
                  'merchant_id' => $row['merchant_id'],
                  'branch_id' => $row['branch_id'],
                  'year' => $year,
                  'month' => $month
                ];
                $paymentValdiate =  $this->db->get_where('paymentrequest', $conditionPayment)->num_rows();
                if ($paymentValdiate > 0) {
                  $row['status'] = 'true'; 
                } else {
                  $row['status'] = 'false';
                }

                array_push($dataPayment, $row);
                 
            }

            $pass['detailBranch'] =  $dataPayment;

            $cekPayment = $this->db->get_where('paymentrequest', $conditionCekPayment)->num_rows();
            if ($cekPayment == 0) {
              $pass ['statusPayment'] = 'true';
            } else {
              $pass ['statusPayment'] = 'false';
            }

            $this->load->view('main/header');
            $this->load->view('main/global_headbar');
            $this->load->view('main/global_sidebar', $access);
            $this->load->view('payment/detail',$pass);
            $this->load->view('main/global_footbar');
            $this->load->view('main/footer', $class);

        }else{
            echo '<!DOCTYPE html><html><head><script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script></head><body><script type="text/javascript" language="javascript">swal({icon: "error", title: "Transaction is not found",closeOnClickOutside: false}).then(function() {window.location="'.site_url().'";});</script></body></html>';
        }

    }

    public function checkout(){
      foreach ($_REQUEST as $key => $value) {
            $$key = $value;
      }

      $access = [
            'accessModule' => $this->master->user_access($_SESSION['up_id'])
        ];

      $url = $this->server_pg.'/checkout';
      $productname = 'BPRD';
      $productcode = 'BPRD';
      $amount = str_replace('.','',$tax);
      $orderid = date("Y").date("m").date("d").rand(1000000000000000,9999999999999999);
      $merchantid_PG = '23';
      $sharedkey = '654321';//$this->getkey($merchantid);

      $cproductcode=array();
      $cproductname=array();
      $cadminfee=array();
      $csubsnum=array();
      $csubsname=array();
      $ctrxamount=array();

      array_push($cproductcode,$productcode);
      array_push($cproductname,"BPRD");
      array_push($cadminfee,"0");
      array_push($csubsnum,"08123456789");
      array_push($csubsname,"My Name");
      array_push($ctrxamount,$amount);

      $ORDER_DETAILS=array();
      for($i=0;$i<count($cproductcode);$i++){
      $ORDER_DETAILS[$i]['product_code']=$cproductcode[$i];
      $ORDER_DETAILS[$i]['product_name']=$cproductname[$i];
      $ORDER_DETAILS[$i]['admin_fee']=$cadminfee[$i];
      $ORDER_DETAILS[$i]['subscriber_number']=$csubsnum[$i];
      $ORDER_DETAILS[$i]['subscriber_name']=$csubsname[$i];
      $ORDER_DETAILS[$i]['trx_amount']=$ctrxamount[$i];
      }

      $data['merchant_id'] = $merchantid_PG;
      $data['order_id'] = $orderid;
      $data['total_trx_amount'] = $amount;
      $data['checksumhash'] = sha1($data['merchant_id'].$sharedkey.$data['order_id']);
      $data['product_code'] = $productcode;
      $data['mobile_number'] = "6";
      $data['email'] = "7";
      $data['currency'] = "IDR";
      $data['order_details'] = $ORDER_DETAILS;

      $arr=$this->hitapi($data,$url);
      $arr=json_decode($arr, true);

      if(isset($note)){
            $pass['note']=$note;
        }else{
            $pass['note']="";
        }
      $pass['npwp']=$npwp;
      $pass['amount']=$amount;
      $pass['orderid'] = $orderid;
      $pass['merchantid']=$merchantid_PG;
      $pass['total']=$data['total_trx_amount'];
      $pass['productname']=$productname;
      $pass['productcode']=$productcode;
      $pass['arr']=$arr;

      $query['merchant_id'] = $merchantid;
      $query['branch_id'] = $branchid;

      $query['month'] = $month_pay;
      $query['year'] = $year_pay;
      $query['order_id'] = $orderid;
      $query['flag'] = '0';

      $class = ['class' => 'payment'];
      $this->db->insert('paymentrequest',$query);
      $this->load->view('main/header');
      $this->load->view('main/global_headbar');
      $this->load->view('main/global_sidebar', $access);
      $this->load->view('payment/checkout',$pass);
      $this->load->view('main/global_footbar');
      $this->load->view('main/footer', $class);
    }

    public function pay(){
      $total_bayar=str_replace('.','',$_POST['total_bayar']);
      $jumlah=str_replace('.','',$_POST['jumlah']);
      $productname = 'BPRD';
      $productcode = 'BPRD';

      $url=$this->server_pg."/payment";
      $cproductcode=array();
      $cproductname=array();
      $cadminfee=array();
      $csubsnum=array();
      $csubsname=array();
      $ctrxamount=array();

      array_push($cproductcode,$productcode);
      array_push($cproductname,$productname);
      array_push($cadminfee,"0");
      array_push($csubsnum,"08123456789");
      array_push($csubsname,"My Name");
      array_push($ctrxamount,$total_bayar);

      $ORDER_DETAILS=array();
      for($i=0;$i<count($cproductcode);$i++){
      $ORDER_DETAILS[$i]['product_code']=$cproductcode[$i];
      $ORDER_DETAILS[$i]['product_name']=$cproductname[$i];
      $ORDER_DETAILS[$i]['admin_fee']=$cadminfee[$i];
      $ORDER_DETAILS[$i]['subscriber_number']=$csubsnum[$i];
      $ORDER_DETAILS[$i]['subscriber_name']=$csubsname[$i];
      $ORDER_DETAILS[$i]['trx_amount']=$ctrxamount[$i];
      }
       
      $data['merchant_id'] = $_POST['merchantid'];
      $data['order_id'] = $_POST['id'];
      $data['total_trx_amount'] = $jumlah;
      $data['payment_amount'] = $total_bayar;

      $data['payment_channel_id'] = substr($_POST['pgid'],2);
      $data['payment_channel_mdr'] = (int)$total_bayar - (int)$jumlah;
      $data['checksumhash'] = "124124312512124";
      $data['product_code'] = $_POST['productcode'];
      $data['checkout_id'] = "1241251251245";
      $data['order_details'] = $ORDER_DETAILS;
      $query_checking = $this->db->GET_WHERE('paymentstatus',array('merchantid'=>$_POST['merchantid'],'orderid'=>$data['order_id'], 'productcode'=>$data['product_code'], 'totalpayment'=>$total_bayar,'paymentchannel'=>$data['payment_channel_id']));
            if($query_checking->num_rows()==0){
                $query['orderid'] = $data['order_id'];
                $query['productcode'] = $data['product_code'];

                $query['price'] = $jumlah;
                $query['totalpayment'] = $total_bayar;
                $query['note'] = $_POST['note'];
                $query['paymentchannel'] = $data['payment_channel_id'];
                $query['created'] = date("Y-m-d H:i:s");
                $query['merchantid'] = $_POST['merchantid'];
                $this->db->INSERT('paymentstatus',$query);
            }   

      $result = $this->hitapi($data,$url);
      if($result == 'Invalid OrderId'){
        redirect('/');
      }else{
        echo $result; 
      }
        
    }

    public function result(){
        $TRX_ID=$_GET['TRX_ID'];
        $PAYMENT_CODE=$_GET['PAYMENT_CODE'];
        $AMOUNT=$_GET['AMOUNT'];
        $PAYMENT_STATUS=$_GET['PAYMENT_STATUS'];
        $PAYMENT_STATUS_DESC=$_GET['PAYMENT_STATUS_DESC'];
        $PAYMENT_CHANNEL=$_GET['PAYMENT_CHANNEL'];
        $ORDER_ID=$_GET['ORDER_ID'];

        $data['paymentcode']=$PAYMENT_CODE; 
        $data['orderid']=$ORDER_ID; 
        $data['paymentchannelname']=$PAYMENT_CHANNEL;
        $data['totalpayment']=$AMOUNT;
        $data['realstatus']=$PAYMENT_STATUS_DESC;
        $data['merchantid']='23';
        $data['amount']=$AMOUNT;

        $query_status=$this->db->GET_WHERE('paymentstatus',array('orderid'=>$ORDER_ID));
            if($query_status->num_rows()!=0){  
                $getdata=$query_status->row_array();
                $status=$getdata['redirstatusdesc'];
            }else{
                $status = '';
            }

        if($status==NULL||$status==""){
            $query['redirstatuscode'] = $PAYMENT_STATUS;
            $query['redirstatusdesc'] = $PAYMENT_STATUS_DESC;
            $query['paymentchannelname'] = $PAYMENT_CHANNEL;
            $query['paymentcode'] = $PAYMENT_CODE;
            $query['redirtime'] = date('Y-m-d H:i:s');
            $this->db->WHERE('orderid',$ORDER_ID);
            $this->db->UPDATE('paymentstatus',$query);
        }

        $access = [
            'accessModule' => $this->master->user_access($_SESSION['up_id'])
        ];
        $class = ['class' => 'payment'];
        $this->load->view('main/header');
        $this->load->view('main/global_headbar');
        $this->load->view('main/global_sidebar', $access);
        $this->load->view('payment/redir',$data);
        $this->load->view('main/global_footbar');
        $this->load->view('main/footer', $class);
    }

    public function PaidChecker(){
        foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }

        if(!isset($merchant_id)){
            $merchant_id = $_SESSION['merchantid'];
        }
        
        $month_db = "";
        $year_db = "";

        $paid['status'] = 'false';

        if($branch_id == 'ALL'){
             $query = $this->db->query('SELECT paymentrequest.* FROM paymentstatus,paymentrequest WHERE paymentrequest.order_id = paymentstatus.orderid AND paymentrequest.merchant_id = '.$merchant_id.' AND paymentstatus.notifstatusdesc="Success"');
        }else{
             $query = $this->db->query('SELECT paymentrequest.* FROM paymentstatus,paymentrequest WHERE paymentrequest.order_id = paymentstatus.orderid AND paymentrequest.merchant_id = '.$merchant_id.' AND (paymentrequest.branch_id = 0 OR paymentrequest.branch_id = '.$branch_id.') AND paymentstatus.notifstatusdesc="Success"');
        }
        
        $data = $query->result_array();

        for($i=0;$i<$query->num_rows();$i++){
            $month_db = $data[$i]['month'];
            $year_db = $data[$i]['year'];

            if ($month == $month_db && $year = $year_db){
                $paid['status']='true';
                break;
            }
        }

        

        echo json_encode($paid,true);
    }

    function logging($type, $dataRequest, $dataResponse){

        $path=APPPATH."logs/log.log";
        
        if(file_exists($path)){
            $filesize = filesize($path); // bytes
            //$filesize = round($filesize / 1024, 2); // kilobytes with two digits
            $filesize = round($filesize / 1024 / 1024, 1); // megabytes with 1 digit
            if($filesize>=2){
                $newpath=str_replace('.log','_'.date('Ymd').'.log',$path);
                rename($path,$newpath);
            }
        }

        $file = fopen($path,"a");
        fwrite($file,"\n[".date('Y-m-d H:i:s')."][".$type."][".$dataRequest."]".'Response'.":".$dataResponse);
        fclose($file);

    }
}
