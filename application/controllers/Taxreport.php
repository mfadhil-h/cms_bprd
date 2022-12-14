<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	/**
	 * 
	 */
	class taxreport extends CI_Controller
	{
		
		public function __construct()
		{
			parent::__construct();

			$data = ['class' => 'taxreport'];

			$this->load->model('payments');
			$this->load->model('mpayment_autodebet');
			$this->load->model('mtax_report');
        	$this->load->model('Masters', 'master');
			
			$access = [
            	'accessModule' => $this->master->user_access($_SESSION['up_id'])
        	];

        	$this->load->view('main/header', $data);
	        $this->load->view('main/global_headbar');
	        $this->load->view('main/global_sidebar', $access);
	        $this->load->view('main/footer');
		}

		public function index()
		{
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

			$this->load->view('payment/tax_report', $data);
	        $this->load->view('main/global_footbar');	
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

	        $periode = ($month < 10 ? '0'.$month : $month).'/'.$year;
	        $dataPayment = $this->mtax_report->get_data_table($merchant_id, $branch_id, $periode)->result();

	        $data 	= [];
	        $row 	= [];
        
	        foreach ($dataPayment as $key => $value) {
	            $row = [];
	            $row[] = $value->merchant_name;
	            $row[] = $value->branch_name;
	            $row[] = $value->periode;
	            $row[] = $value->kode_bayar;
	            $row[] = date('d M Y', strtotime($value->payment_date));
	            $row[] = 'Rp. '.number_format($value->total_payment);
	            $row[] = '
	                <a  data-periode="'.$value->periode.'"
	                    data-nopd="'.$value->nopd.'"
	                    data-npwp="'.$value->npwp.'" 
	                    data-pa-id="'.$value->pa_id.'" 
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

		public function isosptpd()
		{
			$pa_id = $_REQUEST['pa_id'];


			$detail_payment = $this->mpayment_autodebet->get_detail($pa_id)->row();
			

			$merchant_id 	= $detail_payment->merchant_id;
			$branch_id		= $detail_payment->branch_id;
			$periode 		= explode('/', $detail_payment->periode);
			$month 			= $periode[0];
			$year  			= $periode[1]; 
			$nopd   		= $detail_payment->nopd;

			$url_sptpd 		= 'http://103.252.51.147:3180/post/sptpd';
      		$validation 	= $this->db->get_where('document', ['pa_id' => $pa_id])->num_rows();
			
			if ($validation > 0) {
				$result = [
		        	'res'     => false,
		        	'message' => 'Data Pajak Sudah Dilaporkan'
		        ];

			} else {
				$transaction = $this->mpayment_autodebet->get_data($year, intval($month), $merchant_id, $branch_id)->row();
				
		        $omsetTotal = $transaction->dpp;
		        $service 	= $transaction->service_charge;
		        $omset 		= $transaction->total_amount;

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
		          	'pa_id'			=> $pa_id,
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

		        echo json_encode($result, true);
     			exit();
			}
		}

		function logging($type, $dataRequest, $dataResponse){

	        $path=APPPATH."logs/log.log";
	        
	        if(file_exists($path)){
	            $filesize = filesize($path); 
	            $filesize = round($filesize / 1024 / 1024, 1);
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

?>