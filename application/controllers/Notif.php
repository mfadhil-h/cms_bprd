<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '512M');

class notif extends CI_Controller
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

    public function index()
    {
        if(isset($_GET['ORDER_ID'])){
            $data['trxid'] = $_GET['TRX_ID'];
            $data['paymentcode'] = $_GET['PAYMENT_CODE'];
            $data['notiftime'] = date("Y-m-d H:i:s");
            $data['notifstatuscode'] = $_GET['PAYMENT_STATUS'];
            $data['notifstatusdesc'] = $_GET['PAYMENT_STATUS_DESC'];
            $data['paymentchannelname'] = $_GET['PAYMENT_CHANNEL'];
            $ORDER_ID = $_GET['ORDER_ID'];

            $this->db->WHERE('orderid',$ORDER_ID);
            $this->db->UPDATE('paymentstatus',$data);

            if($_GET['PAYMENT_STATUS'] == '5001' && $_GET['PAYMENT_STATUS_DESC']== 'Success'){
                $this->updateOrderId($_GET['ORDER_ID']);
            }
        }else{
            show_404();
        }
    }

    public function updateOrderId($orderid){
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

            $monthNow = date('m');
            $table = 'header';
            if($year < 2019) {
                $table ='headerunder2019';
            }else if ($year != date('Y')) {
                $table = 'header'.$year.($month < 10 ? '0'.$month : $month );
            } else if ($year == date('Y') && $monthNow - $month > 1 ) {
                $table = 'header'.$year.($month < 10 ? '0'.$month : $month );
            }
            
            $query_header = "";
            if($branch_id == "0") {
                 $query_header = "SELECT bill_no FROM ".table." WHERE ((merchant_id = ".$merchant_id.") OR (branch_id = ".$branch_id.")) AND MONTH(bill_date) = ".$month." AND YEAR(bill_date) = ".$year;
            }else {
                 $query_header = "SELECT bill_no FROM ".table." WHERE (merchant_id = ".$merchant_id.") AND (branch_id = ".$branch_id.") AND MONTH(bill_date) = ".$month." AND YEAR(bill_date) = ".$year;
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
        }
    }
}