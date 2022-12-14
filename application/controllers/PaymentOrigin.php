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

        $this->payment_field_mapper = array(
          'merchant_name' => 'MERCHANT NAME',
          'branch_name' => 'BRANCH NAME',
          'bill_date' => 'DATE',
          'total_trx_amount' => 'TOTAL TRX AMOUNT'
        );
    }

    public function index()
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
        $this->load->view('payment/header');
        $this->load->view('main/global_headbar');
        $this->load->view('main/global_sidebar');
        $this->load->view('payment/payment', $data);
        $this->load->view('main/global_footbar');
        $this->load->view('payment/footer');
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


        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * If you just want to use the basic configuration for DataTables with PHP
         * server-side, there is no need to edit below this line.
         */

        $filter[] = "(YEAR(pt.bill_date) = '".$year."')";
        $filter[] = "(MONTH(pt.bill_date) = '".$month."')";
        // if (!empty($start_date)) {
        //     $swap_date = explode("-", $start_date);
        //     $start_date = $swap_date[2] . '-' . $swap_date[1] . '-' . $swap_date[0];
        //     if (!empty($end_date)) {
        //         $swap_date = explode("-", $end_date);
        //         $end_date = $swap_date[2] . '-' . $swap_date[1] . '-' . $swap_date[0];
        //         $filter[] = "(pt.bill_date between '" . $start_date . " 00:00:00' AND '" . $end_date . " 23:59:59')";
        //     } else {
        //         //$filter[] = "(pt.bill_date between '" . $start_date . " 00:00:01' AND '" . date('Y-m-d H:i:s', strtotime('+2 day')) . "')"; by mahes
        //         $filter[] = "(pt.bill_date between '" . $start_date . " 00:00:00' AND '" . date('Y-m-d H:i:s') . "')";
        //     }
        // } elseif (!empty($end_date)) {
        //     $swap_date = explode("-", $end_date);
        //     $end_date = $swap_date[2] . '-' . $swap_date[1] . '-' . $swap_date[0];
        //     $filter[] = "(pt.bill_date <= '" . $end_date . " 23:59:59')";
        // }


        //merchant
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
        //print_r($condition); die;
        $result = $this->datatablessp->complex($_POST, $sql_details, $table, $primaryKey, $columns, $condition, $condition, $additional);
        //if ($hide_rawdata === 'true') {
            if (!empty($result['data'])) {
                foreach ($result['data'] as $row) {
                    // $row[18] = null;
                    // $row[19] = null;
                    // $row[30] = null;
                    $data[] = $row;
                }
                $result['data'] = $data;
            }
        //}

        echo json_encode($result);

    }


    function hitapi($data,$url){
        $post_fields = json_encode($data);
        
        //echo "Request : ";
        //print_r($post_fields);

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
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        $res = curl_exec($ch); 

        //echo "\nResponse : ";
        //echo $res;

        //curl_close($ch);

        //$this->logging($type,$post_fields,$res);
        curl_close($ch);
        return $res;
    }

     public function detail()
    {
        foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }

       // if (!empty($start_date)) {
       //      $swap_date = explode("-", $start_date);
       //      $start_date = $swap_date[2] . '-' . $swap_date[1] . '-' . $swap_date[0];
       //      if (!empty($end_date)) {
       //          $swap_date = explode("-", $end_date);
       //          $end_date = $swap_date[2] . '-' . $swap_date[1] . '-' . $swap_date[0];
       //          $filter[] = "(bill_date between '" . $start_date . " 00:00:00' AND '" . $end_date . " 23:59:59')";
       //      } else {
       //          $filter[] = "(bill_date between '" . $start_date . " 00:00:00' AND '" . date('Y-m-d H:i:s') . "')";
       //      }
       //  } elseif (!empty($end_date)) {
       //      $swap_date = explode("-", $end_date);
       //      $end_date = $swap_date[2] . '-' . $swap_date[1] . '-' . $swap_date[0];
       //      $filter[] = "(bill_date <= '" . $end_date . " 23:59:59')";
       //  }

        $filter[] = "(YEAR(bill_date) = '".$year."')";
        $filter[] = "(MONTH(bill_date) = '".$month."')";

        //merchant
        if($_SESSION['level']=="1" || $_SESSION['level']=="2"){
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

        $condition = implode(' AND ', $filter);

        $query = $this->db->query('SELECT * FROM payment WHERE '.$condition);
        
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
            //Range by date
            // $pass['start_date'] = $start_date;
            // $pass['end_date'] = $end_date;
            
            //Range by month
            $pass['year'] = $year;
            $pass['month'] = $month;

            $query_npwp = $this->db->get_where('branch',array('merchant_id'=>$_SESSION['merchantid']));
            $result_npwp = $query_npwp->row_array();
            $pass['npwp'] = $result_npwp['npwp'];

            $pass['total']=$amount;
            $pass['merchantid']=$merchant_id;
            $pass['branchid']=$branch_id;
            //$this->checkout($amount,$pass);

            $this->load->view('payment/header');
            $this->load->view('main/global_headbar');
            $this->load->view('main/global_sidebar');
            $this->load->view('payment/detail',$pass);
            $this->load->view('main/global_footbar');
            $this->load->view('payment/footer');

        }else{
            echo '<!DOCTYPE html><html><head><script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script></head><body><script type="text/javascript" language="javascript">swal({icon: "error", title: "Transaction is not found",closeOnClickOutside: false}).then(function() {window.location="'.site_url().'";});</script></body></html>';
        }

    }

    public function checkout(){
      foreach ($_REQUEST as $key => $value) {
            $$key = $value;
      }

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
      //print_r($data);exit();
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
      // $query['start_date'] = $checkout['start_date'];
      // $query['end_date'] = $checkout['end_date'];
      $query['month'] = $month_pay;
      $query['year'] = $year_pay;
      $query['order_id'] = $orderid;
      $query['flag'] = '0';
      $this->db->insert('paymentrequest',$query);
      $this->load->view('payment/header');
      $this->load->view('main/global_headbar');
      $this->load->view('main/global_sidebar');
      $this->load->view('payment/checkout',$pass);
      $this->load->view('main/global_footbar');
      $this->load->view('payment/footer');
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
      //array_push($ctrxamount,$_POST['amount']);
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

      // $data['total_trx_amount'] = $_POST['tagihan'];
      // $data['payment_amount'] = $_POST['total'];
      $data['total_trx_amount'] = $jumlah;
      $data['payment_amount'] = $total_bayar;

      $data['payment_channel_id'] = substr($_POST['pgid'],2);
      $data['payment_channel_mdr'] = (int)$total_bayar - (int)$jumlah;
      $data['checksumhash'] = "124124312512124";
      $data['product_code'] = $_POST['productcode'];
      $data['checkout_id'] = "1241251251245";
      $data['order_details'] = $ORDER_DETAILS;

      // $query_checking = $this->db->GET_WHERE('paymentstatus',array('merchantid'=>$_POST['merchantid'],'orderid'=>$data['order_id'], 'productcode'=>$data['product_code'], 'totalpayment'=>$_POST['total'],'paymentchannel'=>$data['payment_channel_id']));
      $query_checking = $this->db->GET_WHERE('paymentstatus',array('merchantid'=>$_POST['merchantid'],'orderid'=>$data['order_id'], 'productcode'=>$data['product_code'], 'totalpayment'=>$total_bayar,'paymentchannel'=>$data['payment_channel_id']));
            if($query_checking->num_rows()==0){
                $query['orderid'] = $data['order_id'];
                $query['productcode'] = $data['product_code'];

                // $query['price'] = $_POST['amount'];
                // $query['totalpayment'] = $_POST['total'];
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

        $this->load->view('payment/header');
        $this->load->view('main/global_headbar');
        $this->load->view('main/global_sidebar');
        $this->load->view('payment/redir',$data);
        $this->load->view('main/global_footbar');
        $this->load->view('payment/footer');
    }

    // public function PaidChecker(){ by Date
    //     foreach ($_REQUEST as $key => $value) {
    //         $$key = $value;
    //     }

    //     if(!isset($merchant_id)){
    //         $merchant_id = $_SESSION['merchantid'];
    //     }

    //     $Date_Start = date('Y-m-d', strtotime($start_date));
    //     $Date_End = date('Y-m-d', strtotime($end_date));
        
    //     $start_date_db = "";
    //     $end_date_db = "";

    //     $paid['status'] = 'false';

    //     if($branch_id == 'ALL'){
    //          $query = $this->db->query('SELECT paymentrequest.* FROM paymentstatus,paymentrequest WHERE paymentrequest.order_id = paymentstatus.orderid AND paymentrequest.merchant_id = '.$merchant_id.' AND paymentstatus.notifstatusdesc="Success"');
    //     }else{
    //          $query = $this->db->query('SELECT paymentrequest.* FROM paymentstatus,paymentrequest WHERE paymentrequest.order_id = paymentstatus.orderid AND paymentrequest.merchant_id = '.$merchant_id.' AND (paymentrequest.branch_id = 0 OR paymentrequest.branch_id = '.$branch_id.') AND paymentstatus.notifstatusdesc="Success"');
    //     }
       
    //     $data = $query->result_array();

    //     for($i=0;$i<$query->num_rows();$i++){
    //         $start_date_db = explode(" ",$data[$i]['start_date'])[0];
    //         $end_date_db = explode(" ",$data[$i]['end_date'])[0];

    //         $Date_Start_DB = date('Y-m-d', strtotime($start_date_db));
    //         $Date_End_DB = date('Y-m-d', strtotime($end_date_db));

    //         if ((($Date_Start >= $start_date_db) && ($Date_Start <= $end_date_db)) 
    //          || (($Date_End >= $start_date_db) && ($Date_End <= $end_date_db))){
    //             $paid['status']='true';
    //             break;
    //         }
    //     }

    //     echo json_encode($paid,true);
    // }

    //By Month
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
}
