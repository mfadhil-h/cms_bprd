<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	/**
	 * 
	 */
	class payment_autodebet extends CI_Controller
	{
		public $url_kode_bayar 		= 'http://103.252.50.157:3180/createva';
		public $url_ballance 		= 'http://103.252.51.147:3315/api/getbalance';
		public $url_inq 			= 'http://103.252.51.147:3315/api/getinhouseinquiry';
		public $url_dopayment 		= 'http://103.252.51.147:3315/api/dopayment';
		public $url_paymentstatus 	= 'http://103.252.51.147:3315/api/getpaymentstatus';
		
		public function __construct()
		{
			parent::__construct();

			$data = ['class' => 'payment_autodebet'];

			$this->load->model('payments');
			$this->load->model('mpayment_autodebet');
			$this->load->model('notes');
        	$this->load->model('Masters', 'master');
			
			

        	$this->load->view('main/header', $data);
	        $this->load->view('main/footer');
		}

		public function index()
		{
			$access = [
            	'accessModule' => $this->master->user_access($_SESSION['up_id'])
        	];

			$previlage = $this->master->module_access($_SESSION['up_id'], 'mod_summary')->row();
        
        	$data ['rights'] = $previlage->ma_previlage;

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

	       	$this->load->view('main/global_headbar');
	        $this->load->view('main/global_sidebar', $access);
	        $this->load->view('payment/index', $data);
	        $this->load->view('main/global_footbar');	
		}

		public function get_kode_bayar()
		{
			$pa_id = $_REQUEST['pa_id'];
			$data_history = [
				'pa_id' => $pa_id,
				'created_at' => date('Y-m-d : H:i:s'),
				'created_by' => $_SESSION['username'],
				'payment_status' => 2
			];

			$detail_payment = $this->mpayment_autodebet->get_detail($pa_id)->row();
			
			$kode_pajak = $this->master->get_kode_pajak($detail_payment->merchant_id, $detail_payment->branch_id)->row();

			$periode = explode('/', $detail_payment->periode);

			$data_kode_bayar = [
	             "JENISPAJAK"       => $kode_pajak->bt_kode_pajak,
	             "TGLPERMOHONAN"    => date('m/d/Y'),
	             "USERID"           => "0",
	             "CARABAYARID"      => 7,
	             "KODE"             => "BNI",
	             "PAJAKUSERID"      => "0",
	             "NILAI"            => $detail_payment->total_payment,
	             "THNPAJAK"         => $periode[1],
	             "MASAPAJAK"        => $periode[0],
	             "TANGGAL"          => date('m/d/Y'),
	             "POKOK"            => $detail_payment->total_payment,
	             "BUNGA"            => 0,
	             "DENDA"            => 0,
	             "SANKSI"           => 0,
	             "NOPD"             => $kode_pajak->nopd,
	             "NPWPD"            => $kode_pajak->npwp,
	             "NO_SKPD"          => ""
	        ];

	        $res_kode_bayar = $this->api('get_kode_bayar', 'response_kode_bayar', $this->url_kode_bayar, json_encode($data_kode_bayar));

	        $response_json_kode_bayar = json_decode($res_kode_bayar, true);

	        $resJson = [
	        	'res' => false,
	        	'message' => 'Gagal mendapatkan kode bayar'
	        ];


	        if (isset($response_json_kode_bayar['KODEBAYAR'])) {
	            $kodeBayar = $response_json_kode_bayar['KODEBAYAR'];

	            $data_history['kode_bayar'] = $kodeBayar;

	            $res_ballance = $this->ballance_payment($detail_payment->merchant_id, $detail_payment->branch_id);

	            $data_history['balance'] = $res_ballance['response_all'];

	            if ($res_ballance['response_code'] != '0001') {
	            	$resJson = [
		        		'res' 		=> false,
		        		'message' 	=> 'gagal Ballance'
		       		];

		       		$this->db->insert('paymentautodebethistory', $data_history);
		       		echo json_encode($resJson, true);
					exit();
	            }

	            
	            $res_houseinq = $this->get_house_inq($detail_payment->merchant_id, $detail_payment->branch_id);

	            $data_history['inquiry'] = $res_houseinq['response_all'];

	            if ($res_houseinq['response_code'] != '0001') {
	            	$resJson = [
		        		'res' 		=> false,
		        		'message' 	=> 'gagal Inquiry'
		       		];

		       		$this->db->insert('paymentautodebethistory', $data_history);
		       		echo json_encode($resJson, true);
					exit();
	            }

	            $res_dopayment = $this->do_payment($detail_payment->merchant_id, $detail_payment->branch_id, $detail_payment->total_payment);

	            $data_history['do_payment'] = $res_dopayment['response_all'];
	            if ($res_dopayment['response_code'] == '0001') {
	            	$cust_ref = $res_dopayment['customer_reference'];
	            } else {
	            	$resJson = [
		        		'res' 		=> false,
		        		'message' 	=> 'gagal Do Payment'
		       		];
		       		$this->db->insert('paymentautodebethistory', $data_history);
		       		echo json_encode($resJson, true);
					exit();
	            }

	            $res_get_paymentstatus = $this->get_payment_status($cust_ref);
	            $data_history['get_paymentstatus'] = $res_get_paymentstatus['response_all'];

	            if ($res_get_paymentstatus['response_code'] != '0001') {
	            	$resJson = [
		        		'res' 		=> false,
		        		'message' 	=> 'gagal get payment status'
		       		];
		       		$this->db->insert('paymentautodebethistory', $data_history);
		       		echo json_encode($resJson, true);
					exit();
	            }

	            $data_history['payment_status'] = 1;
	          	

	            $this->db->insert('paymentautodebethistory', $data_history);
	            $this->db->where('pa_id', $pa_id);
	            $this->db->update('paymentautodebet', ['flag'=>'2', 'kode_bayar' => $kodeBayar]);

	            $resJson = [
	        		'res' 		=> true,
	        		'message' 	=> 'Pembayaran berhasil silahkan refresh halaman ini'
	       		];
	        }

	       	echo json_encode($resJson, true);
			exit();
		}

		public function get_payment_status($customerReference)
		{
			$data_paymentstatus = [
            	 "customerReferenceNumber"       => $customerReference
            ];

	        $res_paymentstatus = $this->api('get_payment_status', 'response_get_payment_status', $this->url_paymentstatus, json_encode($data_paymentstatus));

	        $response_json_paymentstatus = json_decode($res_paymentstatus, true);

	        $response_code = $response_json_paymentstatus['getPaymentStatusResponse']['parameters']['responseCode'];
	        $response_message = $response_json_paymentstatus['getPaymentStatusResponse']['parameters']['responseMessage'];

	        $response = [
	        	'response_code' => $response_code,
	        	'response_message' => $response_message,
	        	'response_all'	=> $res_paymentstatus
	        ];

	        return $response;
		}

		public function do_payment($merchant_id, $branch_id, $amount_pajak)
		{
			$branch = $this->db->get_where('branch', ['merchant_id' => $merchant_id, 'branch_id' => $branch_id])->row();

			$data_payment = [
				"paymentMethod"				=> "0",
				'debitAccountNo' 			=> $branch->rekening_number ,
				'creditAccountNo'			=> '115471119',
				'valueAmount'				=> floatval($amount_pajak),
				'chargingModelId'			=> 'OUR',
				'remark'					=> '',
				'beneficiaryEmailAddress'	=> '',
				'beneficiaryName'			=> '',
				'beneficiaryAddress1'		=> '',
				'beneficiaryAddress2'		=> '',
				'destinationBankCode'		=> ''
			];


			$res_dopayment = $this->api('do_payment', 'response_do_payment', $this->url_dopayment, json_encode($data_payment));


			$res_json_dopayment = json_decode($res_dopayment);

			$response_code = $res_json_dopayment->doPaymentResponse->parameters->responseCode;
	        $response_message = $res_json_dopayment->doPaymentResponse->parameters->responseMessage;

	        $response = [
	        	'response_code' => $response_code,
	        	'response_message' => $response_message,
	        	'response_all'	=> $res_dopayment
	        ];

	        if ($response_code == '0001') {
	        	$response['customer_reference'] = $res_json_dopayment->doPaymentResponse->parameters->customerReference;
	        }

	        return $response;
		}

		public function get_house_inq($merchant_id, $branch_id)
		{
			$branch = $this->db->get_where('branch', ['merchant_id' => $merchant_id, 'branch_id' => $branch_id])->row();

			$data_houseinq = [
            	 "accountNo"       => $branch->rekening_number
            ];

	        $res_inq = $this->api('get_house_inquiry', 'response_get_house_inquiry', $this->url_inq, json_encode($data_houseinq));

	        $response_json_houseinq = json_decode($res_inq, true);

	        $response_code = $response_json_houseinq['getInHouseInquiryResponse']['parameters']['responseCode'];
	        $response_message = $response_json_houseinq['getInHouseInquiryResponse']['parameters']['responseMessage'];

	        $response = [
	        	'response_code' => $response_code,
	        	'response_message' => $response_message,
	        	'response_all'	=> $res_inq
	        ];

	        return $response;
		}

		public function ballance_payment($merchant_id, $branch_id)
		{
			$branch = $this->db->get_where('branch', ['merchant_id' => $merchant_id, 'branch_id' => $branch_id])->row();

			$data_ballance = [
            	 "accountNo"       => $branch->rekening_number
            ];

	        $res_ballance = $this->api('ballance_bni', 'response_ballance', $this->url_ballance, json_encode($data_ballance));

	        $response_json_ballance = json_decode($res_ballance, true);

	        $response_code = $response_json_ballance['getBalanceResponse']['parameters']['responseCode'];
	        $response_message = $response_json_ballance['getBalanceResponse']['parameters']['responseMessage'];

	        $response = [
	        	'response_code' => $response_code,
	        	'response_message' => $response_message,
	        	'response_all'	=> $res_ballance
	        ];

	        return $response;
		}

		public function api($req, $res, $url, $post = '')
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

	        $this->logging($req ,$url.' ',$post ,'');
	        $this->logging($res ,$url.'',$output ,'');
	        return $output;
	    }

	    public function logging($type,$type_data,$data , $id){

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
	        fwrite($file,"\n[".date('Y-m-d H:i:s')."][".$type."][".$id."]".$type_data.":".$data);
	        fclose($file);

	    }

		public function cek_reknumber()
		{
			foreach ($_REQUEST as $key => $value) {
				$$key = $value;
			}

			$branch = $this->db->get_where('branch', ['merchant_id' => $merchant_id, 'branch_id' => $branch_id])->row();

			$result = [
				'res' 		=> true,
				'message'	=> 'Rekening number sudah ditambahkan'
			];

			if (empty($branch->rekening_number) || $branch->rekening_number == '') {
				$result = [
				'res' 		=> false,
				'message'	=> 'Nomor rekening tidak tersedia'
				];
			}

			echo json_encode($result, true);
			exit();
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

	        if ($_SESSION['level'] == 3) {
	            $suban_id = $_SESSION['suban_id'];
	        }
	        

	        $periode = ($month < 10 ? '0'.$month : $month).'/'.$year;
			
	        $branchs = $this->master->branch_id($merchant_id, $branch_id);
	        
			if ($branch_id == 'ALL') {
				foreach ($branchs as $key => $branch) {

					$val_branchid = $branch['branch_id'];
					$countValidation = $this->mpayment_autodebet->count_all($periode, $merchant_id, $val_branchid);
					
					if ($countValidation < 1) {
						$statusInsert = $this->mpayment_autodebet->insert_autodebet($year, $month, $merchant_id, $val_branchid);
					}
				}	
			} else {
				$countValidation = $this->mpayment_autodebet->count_all($periode, $merchant_id, $branch_id);

				if ($countValidation < 1) {
					$statusInsert = $this->mpayment_autodebet->insert_autodebet($year, $month, $merchant_id, $branch_id);
				}
			}

			$dataDetail =  $this->mpayment_autodebet->get_data_table($periode, $merchant_id, $branch_id)->result();
			
			$data   = [];
	        $row    = [];
	        foreach ($dataDetail as $rowDetail) {
	            $row    = [];
	            $row[]  = $rowDetail->merchant_name;
	            $row[]  = $rowDetail->branch_name;
	            $row[]  = $rowDetail->periode;
	            $row[]  = number_format($rowDetail->total_payment);
	            $row[] 	= $rowDetail->flag;
	            $row[] 	= $rowDetail->pa_id;
	            $row[] 	= $rowDetail->merchant_id;
	            $row[] 	= $rowDetail->branch_id;	          	
	            $data[] = $row;
	        }
	        
	        $output = [
	            'draw' => $_POST['draw'],
	            "recordsTotal" => $this->mpayment_autodebet->count_all($periode, $merchant_id, $branch_id),
	            "recordsFiltered" => $this->mpayment_autodebet->count_filtered($periode, $merchant_id, $branch_id),
	            "data" => $data,
	        ];

	        echo json_encode($output,true);
	        exit();
		}

		public function self_assessment()
		{
			foreach ($_REQUEST as $key => $value) {
				$$key = $value;
			}

			$pa = $this->mpayment_autodebet->get_detail($pa_id)->row();

			$periode 	= explode("/", $pa->periode);
			$month 		= $periode[0];
			$year 		= $periode[1];
			$monthNow 	= date('d');
			$yearNow 	= date('Y');

			$param = [
				'h.merchant_id' 	=> $merchant_id, 
				'h.branch_id' 		=> $branch_id 
			];

			$noteData = $this->db->get_where('noteadjustment', array('month' => intval($month), 'year' => $year, 'merchant_id' => $merchant_id, 'branch_id' => $branch_id));



			/*if ($year != $yearNow || ($year == $yearNow && $monthNow - $month > 1) ) {
				$table = 'bprdwarehouse.headerunder2019';
				if ($year >= 2019) {
					$table ='bprdwarehouse.header'.$year.$month;
				}

				$noteData = $this->notes->get_data_warehouse($param, $table);						
		
			} else {
				$noteData = $this->db->get_where('noteadjustment', array('month' => intval($month), 'year' => $year, 'merchant_id' => $merchant_id, 'branch_id' => $branch_id));
			}*/
		
			$data_note = $noteData->result_array();
			$data = [
	            'month'         => $month,
	            'year'          => $year,
	            'merchant_id'   => $merchant_id,
	            'branch_id'     => $branch_id
	        ];
			if ($noteData->num_rows() <= 0) {
	            $data['type'] = 'create';
	            $data['data_note'] = [];
	            $data['bill_no'] = [];
	        } else {
	            $data['type'] = 'edit';
	            $data['data_note'] = $data_note;
	            $data['bill_no'] = '';
	        }

	       	$data['payment'] = $pa;

	        $result = $this->load->view('payment/self_assessment', $data, true);
	        echo json_encode($result,true);
	        exit();
			
		}

		public function selfassessment_store()
		{
			foreach ($_REQUEST as $key => $value) {
				$$key = $value;
			}

			$yearParam 	= $year_0;
			$monthParam = intval($month_0);

			$monthNow 	= date('m');
	        $yearNow 	= date('Y');
	        $bill_no 	= [];
	        $total_adjustment = 0;
	        $data 		= [];
	        $dataWerehouse = [];

			if ($type == 'edit') {
	            for ($i=0; $i < $count ; $i++) {
	                $adjustment_value 	= ${'adjustment_value_'.$i};
	                $adjustment_value 	= str_replace(".","",$adjustment_value);
	                $ppn 				= str_replace(",","",${'ppn_'.$i});
	                $total_adjustment 	+=  $adjustment_value;
	                $bill_no [] = ${'bill_number_'.$i};
	              	
	              	$merchant_id 	= ${'merchant_id_'.$i};
	                $branch_id  	= ${'branch_id_'.$i};
	                $bill_number 	= ${'bill_number_'.$i};
	                
	                $data = [
	                    'month'             => ${'month_'.$i},
	                    'year'              => ${'year_'.$i},
	                    'merchant_id'       => ${'merchant_id_'.$i},
	                    'branch_id'         => ${'branch_id_'.$i},
	                    'bill_number'       => ${'bill_number_'.$i},
	                    'date_transaction'  => ${'date_transaction_'.$i},
	                    'adjustment_value'  => $adjustment_value,
	                    'ppn_adjustment'	=> ${'ppn_'.$i},
	                    'note'              => ${'note_'.$i} 
	                ];

	                $dataWerehouse = [
	                	'adjustment_value'  => $adjustment_value,
	                    'ppn_adjustment'	=> $ppn,
	                    'note'              => ${'note_'.$i}
	                ];

	                if (${'id_'.$i} == 'data_new') {
	                    $this->db->insert('noteadjustment',$data);
	                } else {
	                    $this->db->WHERE('id', ${'id_'.$i});
	                    $this->db->UPDATE('noteadjustment',$data);
	                }
	            }

	        } else {
	            for ($i=0; $i < $count ; $i++) {
	                $adjustment_value = ${'adjustment_value_'.$i};
	                $adjustment_value = str_replace(".","",$adjustment_value);
	                $bill_no [] = ${'bill_number_'.$i};
	                $ppn = str_replace(",","",${'ppn_'.$i});
	                $total_adjustment +=  $adjustment_value;

	                $merchant_id 	= ${'merchant_id_'.$i};
	                $branch_id  	= ${'branch_id_'.$i};
	                $bill_number 	= ${'bill_number_'.$i};

	                $data = [
	                    'month'             => ${'month_'.$i},
	                    'year'              => ${'year_'.$i},
	                    'merchant_id'       => ${'merchant_id_'.$i},
	                    'branch_id'         => ${'branch_id_'.$i},
	                    'bill_number'       => ${'bill_number_'.$i},
	                    'date_transaction'  => ${'date_transaction_'.$i},
	                    'adjustment_value'  => $adjustment_value,
	                    'ppn_adjustment'	=> $ppn,
	                    'note'              => ${'note_'.$i} 
	                ];

	                $dataWerehouse = [
	                	'adjustment_value'  => $adjustment_value,
	                    'ppn_adjustment'	=> $ppn,
	                    'note'              => ${'note_'.$i}
	                ];

	                $this->db->insert('noteadjustment',$data);
	            }

	        }

           $this->mpayment_autodebet->update_autodebet($merchant_id, $branch_id, $year, intval($month), $bill_no, $total_adjustment, $pa_id);            

            redirect('payment_autodebet/index');
		}

		public function show_detail()
		{
			foreach ($_REQUEST as $key => $value) {
				$$key = $value;
			}

			$pa = $this->mpayment_autodebet->get_detail($pa_id)->row();

			
			$data = [
				'merchant_name' => $pa->merchant_name,
				'branch_name'	=> $pa->branch_name,
				'npwp'			=> $pa->npwp,
				'nopd'			=> $pa->nopd,
				'payment_date' 	=> $pa->payment_date,
				'periode'		=> $pa->periode,
				'kode_bayar'	=> $pa->kode_bayar,
				'total_payment'	=> $pa->total_payment
			];

			$result = $this->load->view('payment/payment_show_detail', $data, true);
	        echo json_encode($result,true);
	        exit();
		}

		public function download_file($pa_id, $merchant_id, $branch_id)
		{
			
			$pa = $this->mpayment_autodebet->get_detail($pa_id)->row();

			$data = ['class' => 'payment_autodebet'];
			$dataPa = [
				'Wajib Pajak'	 		=> $pa->merchant_name,
				'Outlet'				=> $pa->branch_name,
				'NPWP'					=> $pa->npwp,
				'NOPD'					=> $pa->nopd,
				'Tanggal Pembayaran'	=> date('d F Y', strtotime($pa->payment_date)),
				'Periode Pajak'			=> $pa->periode,
				'Kode Bayar'			=> $pa->kode_bayar,
				'Total Bayar'			=> 'Rp. '.number_format($pa->total_payment)
			];

			$fetch = [
				'fetch' => $dataPa
			];


			$this->load->view('main/header', $data);
	        $this->load->view('main/footer');
	        $this->load->view('payment/receipt_payment', $fetch);
		}

		public function history_payment()
		{
			$dataDetail = $this->mpayment_autodebet->history_payment($_REQUEST['pa_id'])->result();

			$fetch = [
				'fetch' => $dataDetail
			];

			$result = $this->load->view('payment/payment_history', $fetch, true);
	        echo json_encode($result,true);
	        exit();
		}
	}
?>