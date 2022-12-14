<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '512M');

/**
 * 
 */
class ReportSspdSptpd extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
        $this->load->library('pdf');
        $this->load->model('sspdSptpd', 'ss'); 
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
        $class = ['class' => 'reportsspdsptpd'];
        
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
        $this->load->view('report/sspd_sptpd', $data);
        $this->load->view('main/global_footbar');
        $this->load->view('main/footer', $class);
	}

	public function get_data()
	{
        foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }
        $month = ($month < 10 ? '0'.$month : $month);
               
        $periode = 'B'.$year.$month;
        

        if ($_SESSION['level'] == "5"){
            $merchant_id = $_SESSION['merchantid'];
        } else if ($_SESSION['level'] == "6") {
            $merchant_id = $_SESSION['merchantid'];
            $branch_id = $_SESSION['branchid'];
        }


        $row    = [];
        $data   = [];
        $dataReport = $this->ss->get_data_table($periode, $merchant_id, $branch_id)->result();
       
        $monthDesc =  [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];
        

        foreach ($dataReport as $key => $value) {
            $showPeriode = '';
            $yearData = substr($value->periode,1, 4);
            $monthData = substr($value->periode,5, 2);
            $monthparam = (int)$monthData;
            $row = [];
            $row[] = $value->merchant_name;
            $row[] = $value->branch_name;
            $row[] = $value->npwp;
            $row[] = $value->nopd;
            $row[] = $monthDesc[$monthData].' '.$yearData;
            $row[] = ' 
                    <div class="dropdown">
                          <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="ti-more-alt"></i></a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">            
                                <li>
                                    <a data-month="'.$monthData.'"
                                        data-year="'.$yearData.'"
                                        data-nopd="'.$value->nopd.'" 
                                        data-npwp="'.$value->npwp.'"  
                                        data-merchant-id ="'.$value->merchant_id.'" 
                                        data-branch-id ="'.$value->branch_id.'" 
                                        target="_blank"
                                        href ="'.base_url('sspd/report/'.$monthparam.'/'.$yearData.'/'.$value->merchant_id.'/'.$value->branch_id).' "
                                        class="SSPD-control ext-light mr-3 font-10 text-left" data-toggle="tooltip" title="Download SSPD"><i class="fa fa-file-pdf-o"></i>SSPD
                                    </a>
                                </li>
                                <li>
                                    <a data-month="'.$monthData.'"
                                        data-year="'.$yearData.'"
                                        data-nopd="'.$value->nopd.'" 
                                        data-npwp="'.$value->npwp.'"  
                                        data-merchant-id ="'.$value->merchant_id.'" 
                                        data-branch-id ="'.$value->branch_id.'"
                                        target="_blank"
                                        href ="'.base_url('sptpd/report/'.$monthparam.'/'.$yearData.'/'.$value->merchant_id.'/'.$value->branch_id).' "
                                        class="sptpd-control ext-light mr-3 font-10 text-left" data-toggle="tooltip" title="Download SPTPD"><i class="fa fa-file-pdf-o"></i>SPTPD
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a data-month="'.$monthData.'"
                                        data-year="'.$yearData.'"
                                        data-nopd="'.$value->nopd.'" 
                                        data-npwp="'.$value->npwp.'"  
                                        data-merchant-id ="'.$value->merchant_id.'" 
                                        data-branch-id ="'.$value->branch_id.'" 
                                        target="_blank"
                                        href ="'.base_url('note/showReport/'.$value->merchant_id.'/'.$value->branch_id.'/'.$yearData.'/'.$monthparam).' "
                                        class="SSPD-control ext-light mr-3 font-10 text-left" data-toggle="tooltip" title="Download Self Asestment"><i class="fa fa-file-pdf-o"></i>Self Asestment
                                    </a>
                                </li>
                                <li>
                                    <a data-month="'.$monthData.'"
                                        data-year="'.$yearData.'"
                                        data-nopd="'.$value->nopd.'" 
                                        data-npwp="'.$value->npwp.'"  
                                        data-merchant-id ="'.$value->merchant_id.'" 
                                        data-branch-id ="'.$value->branch_id.'"
                                        target="_blank"
                                        href ="'.base_url('note/detailpajak/'.$value->merchant_id.'/'.$value->branch_id.'/'.$yearData.'/'.$monthparam).' " 
                                        class="SSPD-control ext-light mr-3 font-10 text-left" data-toggle="tooltip" title="Download Detail Pajak"><i class="fa fa-file-pdf-o"></i>Detail Pajak
                                    </a>
                                </li>
                          </ul>
                    </div>';
            $data[] = $row;
        }

        $output = [
            'draw' => $_POST['draw'],
            "recordsTotal" => $this->ss->count_all($periode, $merchant_id, $branch_id),
            "recordsFiltered" => $this->ss->count_filtered($periode, $merchant_id, $branch_id),
            "data" => $data,
        ];

        echo json_encode($output,true);
        exit();
	}
}

?>