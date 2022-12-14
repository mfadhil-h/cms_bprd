<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '512M');

class callback extends CI_Controller
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

    #DEV
    public $client_id = '00430';
    public $secret_key = 'a9759b1e029f43eb6bc02f04bfb98543';

    #PROD
    // public $client_id = '29045';
    // public $secret_key = 'c12e05cfe56a784b75779fa1e7913ba2';

    public function index(){
        $random=rand(100000000,999999999);
        include_once "/var/www/html/cms_bprd/application/controllers/BniEnc.php";

        $data = file_get_contents('php://input');
        $this->logging('callback','Request',$data,$random);
        $data_json = json_decode($data, true);

        if (!$data_json) {
            // handling orang iseng
            //echo '{"status":"999","message":"jangan iseng :D"}';
            show_404();
        }
        else {
            if ($data_json['client_id'] === $this->client_id) {
                $data_asli = BniEnc::decrypt(
                    $data_json['data'],
                    $this->client_id,
                    $this->secret_key
                );

                if (!$data_asli) {
                    // handling jika waktu server salah/tdk sesuai atau secret key salah
                    echo '{"status":"999","message":"waktu server tidak sesuai NTP atau secret key salah."}';
                }
                else {
                    // insert data asli ke db
                    /* $data_asli = array(
                        'trx_id' => '', // silakan gunakan parameter berikut sebagai acuan nomor tagihan
                        'virtual_account' => '',
                        'customer_name' => '',
                        'trx_amount' => '',
                        'payment_amount' => '',
                        'cumulative_payment_amount' => '',
                        'payment_ntb' => '',
                        'datetime_payment' => '',
                        'datetime_payment_iso8601' => '',
                    ); */

                    $query['trx_id'] = $data_asli['trx_id'];
                    $query['datetime_payment'] = $data_asli['datetime_payment'];
                    $query['flag'] = '0';
                    $query['full_response'] = json_encode($data_asli,true);

                    $this->db->INSERT('bnicallback',$query);

                    $response = '{"status":"000"}';
                    echo $response;

                    $this->logging('callback','Response',$response,$random);

                    // $query['redirtime'] = date("Y-m-d H:i:s");
                    // $query['notiftime'] = $data_asli['datetime_payment'];
                    // $query['notifstatuscode'] = '000';
                    // $query['notifstatusdesc'] = 'Success';

                    // $this->db->WHERE('trxid',$data_asli['trx_id']);
                    // $this->db->UPDATE('paymentstatus',$query);
                    // $this->db->SELECT('orderid');
                    // $orderid_data = $this->db->GET_WHERE('paymentstatus',array('trxid'=>$data_asli['trx_id']));
                    // $orderid = $orderid_data->row_array()['orderid'];

                    //$this->updateOrderId($orderid);
                }
            }
        }
    }

    public function cron_callback(){
        $query_callback = $this->db->get_where('bnicallback',array('flag'=>'0'));
        if($query_callback->num_rows()>0){
            $data_callback = $query_callback->row_array();

            $trx_id = $data_callback['trx_id'];
            $datetime_payment = $data_callback['datetime_payment'];

            $data_asli = json_decode($data_callback['full_response'],true);
            $query['redirtime'] = date("Y-m-d H:i:s");
            $query['notiftime'] = $data_asli['datetime_payment'];
            $query['notifstatuscode'] = '000';
            $query['notifstatusdesc'] = 'Success';

            $this->db->WHERE('trxid',$data_asli['trx_id']);
            $this->db->UPDATE('paymentstatus',$query);
            $this->db->SELECT('orderid');
            $orderid_data = $this->db->GET_WHERE('paymentstatus',array('trxid'=>$data_asli['trx_id']));
            $orderid = $orderid_data->row_array()['orderid'];

            $this->updateOrderId($orderid);

            $this->db->WHERE(array('trx_id'=>$trx_id,'datetime_payment'=>$datetime_payment));
            $this->db->UPDATE('bnicallback',array('flag'=>'1'));
        }
    }

    // public function test(){
    //     $pass['orderid'] = '201910131662392177619040';
    //     $this->load->view('callback/test', $pass);
    // }


    // public function encrypt(){
    //     include_once "/var/www/html/cms_bprd/application/controllers/BniEnc.php";

    //     // FROM BNI
    //     $url = 'https://apibeta.bni-ecollection.com/';

    //     $orderid = mt_rand();

    //     $data_asli = array(
    //         'trx_id' => '698996905',
    //         'virtual_account' => '9880043055568619',
    //         'customer_name' => 'Mr. X',
    //         'trx_amount' => '100000',
    //         'payment_amount' => '100000',
    //         'cumulative_payment_amount' => '100000',
    //         'payment_ntb' => '233171',
    //         'datetime_payment' => '2016-03-01 14:00:00"',
    //         'datetime_payment_iso8601' => '2016-03-01T14:00:00+07:00'
    //     );

    //     //print_r(json_encode($data_asli,true));exit();
    //     $hashed_string = BniEnc::encrypt(
    //         $data_asli,
    //         $this->client_id,
    //         $this->secret_key
    //     );

    //     echo $hashed_string;
    // }

    public function updateOrderId($orderid){
        if($orderid!=''){
            $query = $this->db->get_where('paymentrequest',array('order_id'=>$orderid));
            $merchant_id = '';
            $branch_id = '';
            $month = '';
            $year = '';

            if($query->num_rows()>0){
                $data = $query->row_array();
                $merchant_id = $data['merchant_id'];
                $branch_id = $data['branch_id'];
                $month = $data['month'];
                $year = $data['year'];

                $query_header = "";

                $monthNow = date('m');
                $table = 'header';
                if($year < 2019) {
                    $table ='headerunder2019';
                }else if ($year != date('Y')) {
                    $table = 'header'.$year.($month < 10 ? '0'.$month : $month );
                } else if ($year == date('Y') && $monthNow - $month > 1 ) {
                    $table = 'header'.$year.($month < 10 ? '0'.$month : $month );
                }

                if($branch_id == "0") {
                     $query_header = "SELECT bill_no FROM ".$table." WHERE ((merchant_id = ".$merchant_id.") OR (branch_id = ".$branch_id.")) AND MONTH(bill_date) = ".$month." AND YEAR(bill_date) = ".$year;
                }else {
                     $query_header = "SELECT bill_no FROM ".$table." WHERE (merchant_id = ".$merchant_id.") AND (branch_id = ".$branch_id.") AND MONTH(bill_date) = ".$month." AND YEAR(bill_date) = ".$year;
                }
                $query= $this->db->query($query_header);
                if($query->num_rows()>0){
                    $data=$query->result_array();
                    for($i=0;$i<count($data);$i++){
                        $billnumber=$data[$i]['bill_no'];

                        $this->db->WHERE('bill_no',$billnumber);
                        $this->db->UPDATE('bprddata',array('order_id'=>$orderid));
                    }
                }
                echo 'success';
            }

        }
    }

    function logging($type,$type_data,$data,$id){

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
        fwrite($file,"\n[".date('Y-m-d H:i:s')."][".$type."][".$id."]".$type_data.":".$data);
        fclose($file);

    }
}