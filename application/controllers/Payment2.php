<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '512M');

class Payment2 extends CI_Controller
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

    public $server_pg='http://103.252.51.147:8282';
    public $prefix = '988';

    #DEV
    public $client_id = '00430';
    public $secret_key = 'a9759b1e029f43eb6bc02f04bfb98543';
    public $url_bni = 'https://apibeta.bni-ecollection.com/';


    public $url_kode_bayar = 'http://103.252.50.157:3180/createva';

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('islogin')) {
            redirect(base_url('signin/'));
        }
         $this->load->model('Masters', 'master');
    }

    public function checkout(){
        foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }

        $access = [
            'accessModule' => $this->master->user_access($_SESSION['up_id'])
        ];

        $arrayPeriod = explode('/', $period);

        $class = ['class' => 'payment'];
        if ($branchid == 'ALL') {
            $detailTax = explode(',', $detail_tax);
            $detailBranch = explode(',', $detail_branch);
        }

        $amount = str_replace('.','',$tax);
        $tagihan = str_replace('.','',$tagihan);
        $orderid = date("Y").date("m").date("d").rand(1000000000000000,9999999999999999);
        $productname = 'BPRD';
        $productcode = 'BPRD';
        $merchantid_PG = '23';
        $total_trx_amount=$amount;

        if(isset($note)){
            $pass['note']=$note;
        }else{
            $pass['note']="";
        }
        $pass['npwp']         =$npwp;
        $pass['amount']       =$amount;
        $pass['orderid']      = $orderid;
        $pass['merchantid']   =$merchantid;
        $pass['total']        =$total_trx_amount;
        $pass['productname']  =$productname;
        $pass['productcode']  =$productcode;
        $pass['tagihan']      = $tagihan;
        $pass['branchid']     = $branchid;

        $pass['month']        = (int)$arrayPeriod[0];
        $pass['year']         = (int)$arrayPeriod[1];

        $query['merchant_id']   = $merchantid;
        $query['branch_id']     = $branchid;
        $query['month']         = $month_pay;
        $query['year']          = $year_pay;
        $query['order_id']      = $orderid;
        $query['flag']          = '0';
        $query['total_ppn']       =$amount;

        if ($branchid == 'ALL') {
            $detailId = $this->db->get_where('merchant', array('merchant_id' => $merchantid))->row_array();
            $name    = $detailId['owner_name'];
            $email   = $detailId['email'];
            $no_tlp  = $detailId['no_tlp'];
        } else {
            $detailId = $this->db->get_where('branch', array('merchant_id' => $merchantid, 'branch_id' => $branchid))->row_array();
            $name    = $detailId['pic'];
            $email   = $detailId['email'];
            $no_tlp  = $detailId['no_tlp'];
        }

        $pass['name']   = $name;
        $pass['email']  = $email;
        $pass['no_tlp'] = $no_tlp;

        $insertQuery = null;
        if ($branchid == 'ALL') {
            foreach($detailBranch as $key => $val) {
                $insertQuery = [];
                $insertQuery['merchant_id']   = $merchantid;
                $insertQuery['branch_id']     = $val;
                $insertQuery['month']         = $month_pay;
                $insertQuery['year']          = $year_pay;
                $insertQuery['order_id']      = $orderid;
                $insertQuery['flag']          = '0';
                $insertQuery['total_ppn']     = $detailTax[$key];

                $this->db->insert('paymentrequest',$insertQuery);
            }
        } else {
             $this->db->insert('paymentrequest',$query);
        }

        $this->load->view('main/header');
        $this->load->view('main/global_headbar');
        $this->load->view('main/global_sidebar', $access);
        $this->load->view('payment/checkout2',$pass);
        $this->load->view('main/global_footbar');
        $this->load->view('main/footer', $class);
    }

    public function result(){
        //createbilling
        foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }
        
        $class = ['class' => 'payment'];

        $access = [
            'accessModule' => $this->master->user_access($_SESSION['up_id'])
        ];

        $kode_pajak = $this->master->get_kode_pajak($merchantid, $branchid)->row();

        $data_kode_bayar = [
            "JENISPAJAK"        => $kode_pajak->bt_kode_pajak,
             "TGLPERMOHONAN"    => date('m/d/Y'),
             "USERID"           => "0",
             "CARABAYARID"      => 7,
             "KODE"             => "BNI",
             "PAJAKUSERID"      => "0",
             "NILAI"            => $tagihan,
             "THNPAJAK"         => $yearperiod,
             "MASAPAJAK"        => ($monthperiod < 10 ? '0'.$monthperiod : $monthperiod),
             "TANGGAL"          => date('m/d/Y'),
             "POKOK"            => $tagihan,
             "BUNGA"            => 0,
             "DENDA"            => 0,
             "SANKSI"           => 0,
             "NOPD"             => $kode_pajak->nopd,
             "NPWPD"            => $kode_pajak->npwp,
             "NO_SKPD"          => ""
        ];

        $res_kode_bayar = $this->get_kode_bayar('get_kode_bayar', $this->url_kode_bayar, json_encode($data_kode_bayar));


        $response_json_kode_bayar = json_decode($res_kode_bayar, true);

        if (isset($response_json_kode_bayar['KODEBAYAR'])) {
            $kodeBayar = $response_json_kode_bayar['KODEBAYAR'];

            $this->db->where('order_id', $id);
            $this->db->update('paymentrequest', ['kode_bayar' => $kodeBayar]);
        } else {
            $this->db->where('order_id', $id);
            $this->db->delete('paymentrequest');

            redirect('payment');
        }


        $no_va = $this->generateva();
        $billing_number = $this->generatebillingnumber();

        include_once "/var/www/html/cms_bprd/application/controllers/BniEnc.php";

        // FROM BNI
        $url = $this->url_bni;

        $orderid = mt_rand();

        $query = $this->db->get_where('branch',array('merchant_id'=>$_SESSION['merchantid'],'branch_id'=>$_SESSION['branchid']));
        $data = $query->row_array();
        $branch_name = $data['branch_name'];
        $npwp = $data['npwp'];
        $nopd = $data['nopd'];

        $data_asli = array(
            'client_id' => $this->client_id,
            'trx_id' => $orderid, // fill with Billing ID
            'trx_amount' => (int)$amount,
            'billing_type' => 'c',
            'datetime_expired' => date('c', time() + 2 * 3600), // billing will be expired in 2 hours
            'virtual_account' => $no_va, //9880043000000003
            'customer_name' => $nama,
            'customer_email' => $email,
            'customer_phone' => $nohp,
            'description' => 'Payment of transaction '.$orderid,
            'type' => 'createbilling' ,

            'billing_number' => $billing_number,
            'addl_label_1' => null,
            'addl_label_2' => 'ID OP',
            'addl_label_3' => '',
            'addl_value_1' => '',
            'addl_value_2' => null,
            'addl_value_3' => '',
            'addl_label_1_en' => null,
            'addl_label_2_en' => 'ID OP',
            'addl_label_3_en' => '',
            'addl_value_1_en' => '',
            'addl_value_2_en' => null,
            'addl_value_3_en' => ''

        );



        $hashed_string = BniEnc::encrypt(
            $data_asli,
            $this->client_id,
            $this->secret_key
        );

        $data = array(
            'prefix' => $this->prefix,
            'client_id' => $this->client_id,
            'data' => $hashed_string,
        );

        $response = $this->get_content('createbilling',$url, json_encode($data));
        $response_json = json_decode($response, true);

        if ($response_json['status'] !== '000') {

            $this->load->view('main/header');
            $this->load->view('main/global_headbar');
            $this->load->view('main/global_sidebar', $access);
            $this->load->view('payment/result',$response_json);
            $this->load->view('main/global_footbar');
            $this->load->view('main/footer', $class);

            $this->db->where('order_id', $id);
            $this->db->delete('paymentrequest');

        } else {
            $data_response = BniEnc::decrypt($response_json['data'], $this->client_id, $this->secret_key);

            $query_checking = $this->db->GET_WHERE('paymentstatus',array('merchantid'=>$merchantid,'orderid'=>$id, 'productcode'=>'BPRD', 'totalpayment'=>$amount,'paymentchannel'=>'11'));
            if($query_checking->num_rows()==0){
                $query2 = array();
                $query2['trxid'] = $data_response['trx_id'];
                $query2['orderid'] = $id;
                $query2['productcode'] = 'BPRD';
                $query2['note'] = $note;
                $query2['price'] = $amount;
                $query2['totalpayment'] = $amount;
                $query2['paymentchannel'] = '11';
                $query2['paymentchannelname'] = 'BNI';
                $query2['created'] = date("Y-m-d H:i:s");
                $query2['merchantid'] = $merchantid;
                $this->db->INSERT('paymentstatus',$query2);
            }
            $query2 = array();
            $query2['va_number'] = $no_va;
            $query2['billing_id'] = $data_response['trx_id'] ;
            $query2['name'] = $nama;
            $query2['phone_no'] = $nohp;
            $query2['email'] = $email;
            $query2['order_id'] = $id;
            $query2['user_name'] = $_SESSION['username'];

            $this->db->INSERT('bnihistory',$query2);

            $data_response['status'] = '000';
            $data_response['trx_amount'] = $amount;
            $data_response['billing_number'] = $billing_number;
            $data_response['kode_bayar'] = $kodeBayar;

            $this->load->view('main/header');
            $this->load->view('main/global_headbar');
            $this->load->view('main/global_sidebar', $access);
            $this->load->view('payment/result',$data_response);
            $this->load->view('main/global_footbar');
            $this->load->view('main/footer', $class);
            //$this->inquirybilling($data_response['trx_id'],$merchantid,$id,$amount, $no_va, $nama, $email, $nohp);
        }
    }

    function generateva(){
        $va = '';
        $va=$this->prefix.$this->client_id.date("m").date("d").rand(1000,9999);
        return $va;
    }

    function generatebillingnumber(){
        $billingnumber = '';
        $billingnumber='4'.$this->client_id.date("m").date("d").rand(10000000,99999999);
        return $billingnumber;
    }

    public function bni_history()
    {
        ini_set('memory_limit', '512M');
        $this->load->library('Datatablessp');

        foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }

        $table = 'bnihistory hr';


        $primaryKey = 'hr.va_number';

        $columns = array(
            array('db' => 'hr.va_number', 'dt' => 0),
            array('db' => 'hr.billing_id', 'dt' => 1),
            array('db' => 'hr.name', 'dt' => 2),
            array('db' => 'hr.phone_no', 'dt' => 3),
            array('db' => 'hr.email', 'dt' => 4),
            array('db' => 'hr.order_id', 'dt' => 5),
            array('db' => 'hr.date_created', 'dt' => 6)
        );

        $additional = "";

        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );

        $filter[] = "(hr.user_name = '" .$_SESSION['username']. "')";


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

    public function checkbilling(){
        $access = [
            'accessModule' => $this->master->user_access($_SESSION['up_id'])
        ];
        $class = ['class' => 'payment'];

        $this->load->view('main/header');
        $this->load->view('main/global_headbar');
        $this->load->view('main/global_sidebar', $access);
        $this->load->view('payment/check');
        $this->load->view('main/global_footbar');
        $this->load->view('main/footer', $class);
    }

    public function inquirybilling(){
        $access = [
            'accessModule' => $this->master->user_access($_SESSION['up_id'])
        ];

        $class = ['class' => 'payment'];
        foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }

        include_once "/var/www/public_html/cms_bprd/application/controllers/BniEnc.php";

        $url = $this->url_bni;

        $data_asli = array(
            'client_id' => $this->client_id,
            'trx_id' => $trx_id,
            'type' => 'inquirybillingvamenu'
        );

        $hashed_string = BniEnc::encrypt(
            $data_asli,
            $this->client_id,
            $this->secret_key
        );

        $data = array(
            'prefix' => $this->prefix,
            'client_id' => $this->client_id,
            'data' => $hashed_string,
        );

        $response = $this->get_content('inquirybilling',$url, json_encode($data));
        $response_json = json_decode($response, true);

        if ($response_json['status'] !== '000') {
            $this->load->view('main/header');
            $this->load->view('main/global_headbar');
            $this->load->view('main/global_sidebar', $access);
            $this->load->view('payment/result',$response_json);
            $this->load->view('main/global_footbar');
            $this->load->view('main/footer', $class);
        }
        else {
            $data_response = BniEnc::decrypt($response_json['data'], $this->client_id, $this->secret_key);

            $data_response['status'] = '000';
            $this->load->view('main/header');
            $this->load->view('main/global_headbar');
            $this->load->view('main/global_sidebar', $access);
            $this->load->view('payment/result_detail',$data_response);
            $this->load->view('main/global_footbar');
            $this->load->view('main/footer', $class);
        }
    }

    public function tes3(){
        echo date('c', time() + 2 * 3600);exit();
        include_once "/var/www/html/cms_bprd/application/controllers/BniEnc.php";
        $response_json['data'] = 'Th4UF1QeHhgeGxZpB1pdDkpJRwkiCRkdTEkjRhEhFB02DwpdBlZbXEtXRkhOSlsKUloGIgkZJh5RQRdSEhwQFE0aIR9PDGU';
         $data_response = BniEnc::decrypt($response_json['data'], $this->client_id, $this->secret_key);
         print_r(json_encode($data_response,true));
    }

    public function updatebilling(){

        foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }

        $access = [
            'accessModule' => $this->master->user_access($_SESSION['up_id'])
        ];

        $class = ['class' => 'payment'];

        $no_va = $this->generateva();

        include_once "/var/www/public_html/cms_bprd/application/controllers/BniEnc.php";

        // FROM BNI
        $url = $this->url_bni;

        $data_asli = array(
            'client_id' => $this->client_id,
            'trx_id' => $trx_id,
            'trx_amount' => $trx_amount,
            'datetime_expired' => $datetime_expired,
            'customer_name' => $customer_name,
            'customer_email' => $customer_email,
            'customer_phone' => $customer_phone,
            'description' => $description,
            'type' => 'updatebilling',

            'billing_number' => $billing_number,
            'addl_label_1' => $addl_label_1,
            'addl_label_2' => $addl_label_2,
            'addl_label_3' => $addl_label_3,
            'addl_value_1' => $addl_value_1,
            'addl_value_2' => $addl_value_2,
            'addl_value_3' => $addl_value_3,
            'addl_label_1_en' => $addl_label_1_en,
            'addl_label_2_en' => $addl_label_2_en,
            'addl_label_3_en' => $addl_label_3_en,
            'addl_value_1_en' => $addl_value_1_en,
            'addl_value_2_en' => $addl_value_2_en,
            'addl_value_3_en' => $addl_value_3_en,
        );

        //print_r(json_encode($data_asli,true));exit();
        $hashed_string = BniEnc::encrypt(
            $data_asli,
            $this->client_id,
            $this->secret_key
        );

        $data = array(
            'prefix' => $this->prefix,
            'client_id' => $this->client_id,
            'data' => $hashed_string,
        );

        $response = $this->get_content('updatebilling',$url, json_encode($data));
        $response_json = json_decode($response, true);

        if ($response_json['status'] !== '000') {
            // handling jika gagal
            // echo $response_json['message'];
            $this->load->view('main/header');
            $this->load->view('main/global_headbar');
            $this->load->view('main/global_sidebar', $access);
            $this->load->view('payment/result',$response_json);
            $this->load->view('main/global_footbar');
            $this->load->view('main/footer', $class);
        }
        else {
            $data_response = BniEnc::decrypt($response_json['data'], $this->client_id, $this->secret_key);

            $query['name'] = $customer_name;
            $query['phone_no'] = $customer_phone;
            $query['email'] = $customer_email;

            $this->db->WHERE('va_number',$virtual_account);
            $this->db->WHERE('billing_id',$trx_id);
            $this->db->UPDATE('bnihistory',$query);

            $data_response['status'] = '000';
            $data_response['trx_amount'] = $trx_amount;
            $data_response['billing_number'] = $billing_number;
            $this->load->view('main/header');
            $this->load->view('main/global_headbar');
            $this->load->view('main/global_sidebar', $access);
            $this->load->view('payment/result',$data_response);
            $this->load->view('main/global_footbar');
            $this->load->view('main/footer', $class);
        }
    }

    function get_content($type, $url, $post = '') {
        $random=rand(100000000,999999999);
        $this->logging($type,'Request',$post,$random);
        $usecookie = __DIR__ . "/cookie.txt";
        $header[] = 'Content-Type: application/json';
        $header[] = "Accept-Encoding: gzip, deflate";
        $header[] = "Cache-Control: max-age=0";
        $header[] = "Connection: keep-alive";
        $header[] = "Accept-Language: en-US,en;q=0.8,id;q=0.6";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        // curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_ENCODING, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);

        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36");

        if ($post)
        {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $rs = curl_exec($ch);

        if(empty($rs)){

            curl_close($ch);
            return false;
        }
        curl_close($ch);

        $this->logging($type,'Response',$rs,$random);
        return $rs;
    }

    public function get_kode_bayar($type, $url, $post = '')
    {
        $headers = array(
          "Content-Type: application/json"
        );


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_VERBOSE, TRUE);

        $output = curl_exec($ch);
        curl_close($ch);

        $this->logging('Request Kode Bayar ',$url.' ',$post ,'');
        $this->logging('Response Kode Bayar ',$url.'',$output ,'');
        return $output;
    }

    function logging($type,$type_data,$data , $id){

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
