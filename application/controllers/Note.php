<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class note extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('notes');
        $this->load->model('Masters', 'master');
    }

    public function index()
    {
        $subanId = null;
        if ($_SESSION['level'] == 6) {
            $subanId = $_SESSION['suban_id'];
        }

        $fetch = $this->branch->getBranch($subanId);

        $data = ['fetch' => $fetch];

        $this->load->view('branch/index', $data);
        $this->load->view('main/global_footbar');
    }

    public function getBillNo()
    {
        foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }
        $query = $this->notes->getBillNo($merchant_id, $branch_id, $date);
        
        $data   = $query->result_array();
        $result = [];
        foreach ($data as $index => $row) {
            $result[$index] = $row['bill_no'];
        }

        echo json_encode($result,true);

    }

    public function get_tax_value()
    {
        foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }

        $tax = $this->notes->get_tax_value($bill_no, $month, $year)->row();

        $result['tax'] = number_format($tax->ppn_dpp);
        echo json_encode($result,true);
    }

    public function create($month, $year, $merchant_id, $branch_id)
    {        
        $access = [
            'accessModule' => $this->master->user_access($_SESSION['up_id'])
        ];

        $data = [
            'month'         => $month,
            'year'          => $year,
            'merchant_id'   => $merchant_id,
            'branch_id'     => $branch_id
        ];

        $dataMonth = $month;
        $query = $this->db->get_where('noteadjustment', array('month' => $month, 'year' => $year, 'merchant_id' => $merchant_id, 'branch_id' => $branch_id));
        $dataNote = $query->result_array();
        if ($month < 10) {
            $dataMonth = '0'.$month;
        }
        $dateParam = $year.'-'.'11'.'-13';

        $queryBillNo = $this->notes->getBillNo($merchant_id, $branch_id, $dateParam)->result_array();

        if ($query->num_rows() <= 0) {
            $data['type']       = 'create';
            $data['data_note']  = [];
            $data['bill_no']    = [];
        } else {
            $data['type']       = 'edit';
            $data['data_note']  = $dataNote;
            $data['bill_no']    = $queryBillNo;
        }

        $class = ['class' => 'note'];
        
        $this->load->view('payment/header');
        $this->load->view('main/global_headbar');
        $this->load->view('main/global_sidebar', $access);
        $this->load->view('payment/note', $data);
        $this->load->view('main/global_footbar');
        $this->load->view('payment/footer', $class);
    }

    public function store()
    {
        foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }

        if ($type == 'edit') {
            $data= [];
            for ($i=0; $i < $count ; $i++) {
                $adjustment_value = ${'adjustment_value_'.$i};
                $adjustment_value = str_replace(".","",$adjustment_value);
                $data = [
                    'month'             => ${'month_'.$i},
                    'year'              => ${'year_'.$i},
                    'merchant_id'       => ${'merchant_id_'.$i},
                    'branch_id'         => ${'branch_id_'.$i},
                    'bill_number'       => ${'bill_number_'.$i},
                    'date_transaction'  => ${'date_transaction_'.$i},
                    'adjustment_value'  => $adjustment_value,
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
            $data = [];
            for ($i=0; $i < $count ; $i++) {
                $adjustment_value = ${'adjustment_value_'.$i};
                $adjustment_value = str_replace(".","",$adjustment_value);
                $data = [
                    'month'             => ${'month_'.$i},
                    'year'              => ${'year_'.$i},
                    'merchant_id'       => ${'merchant_id_'.$i},
                    'branch_id'         => ${'branch_id_'.$i},
                    'bill_number'       => ${'bill_number_'.$i},
                    'date_transaction'  => ${'date_transaction_'.$i},
                    'adjustment_value'  => $adjustment_value,
                    'note'              => ${'note_'.$i} 
                ];
                $this->db->insert('noteadjustment',$data);
            }
        }

       $this->showReport($merchant_id_0, $branch_id_0, $year_0, $month_0);
    }

    public function showReport ($merchant_id, $branch_id, $year, $month)
    {
        $class = ['class' => 'note'];

        $queryNote      = $this->db->get_where('noteadjustment', array('month' => $month, 'year' => $year, 'merchant_id' => $merchant_id, 'branch_id' => $branch_id));
        $queryMerchant  = $this->db->get_where('merchant', array('merchant_id' => $merchant_id));
        $queryBranch    = $this->db->get_where('branch', array('merchant_id' => $merchant_id, 'branch_id' => $branch_id));

        $data = [
            'dataNote'       => $queryNote->result_array(),
            'dataMerchant'   => $queryMerchant->row_array(),
            'dataBranch'     => $queryBranch->row_array()
        ];



        $this->load->view('main/header', $class);
        $this->load->view('main/footer');
        $this->load->view('report/note', $data);
    }

    public function detailpajak($merchant_id, $branch_id, $year, $month)
    {
        $class = ['class' => 'note'];

        $row    = [];
        $fetch  = [];
        $notes  = [];
        $queryNote      = $this->db->get_where('noteadjustment', array('month' => $month, 'year' => $year, 'merchant_id' => $merchant_id, 'branch_id' => $branch_id))->result();
        $queryMerchant  = $this->db->get_where('merchant', array('merchant_id' => $merchant_id))->row();
        $queryBranch    = $this->db->get_where('branch', array('merchant_id' => $merchant_id, 'branch_id' => $branch_id))->row();

        foreach ($queryNote as $index => $rowNote) {
            $notes[$rowNote->bill_number] = [$rowNote->adjustment_value, $rowNote->date_transaction];
        }

       // var_dump(); exit();

        $dataHeader = $this->notes->get_data_transaction($merchant_id, $branch_id, $year, $month)->result();
        
        foreach ($dataHeader as $key => $value) {
            $row    = [];
            $row[]  = $value->merchant_name;
            $row[]  = $value->branch_name;
            $row[]  = $value->bill_no;
            $row[]  = date('d F Y', strtotime($value->bill_date));
            $row[]  = number_format($value->ppn);
            if (array_key_exists($value->bill_no,$notes) == false) {
                $row[]  = '-';
            } else {
                $row[]  = number_format($notes[$value->bill_no][0]);
                unset($notes[$value->bill_no]);
                
            }
                      
            $fetch[] = $row;
        }

        foreach ($notes as $index => $val) {
            $row    = [];
            $row[]  = $queryMerchant->merchant_name;
            $row[]  = $queryBranch->branch_name;
            $row[]  = $index;
            $row[]  = date('d F Y', strtotime($val[1]));
            $row[]  = '-'; 
            $row[]  = number_format($val[0]);
           
            $fetch [] = $row;
        }

        $data = [
            'fetch' => $fetch
        ];

        $this->load->view('main/header', $class);
        $this->load->view('main/footer');
        $this->load->view('report/detail_pajak', $data);
    }

    public function delete()
    {
        foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }

        $monthNow   = date('m');
        $yearNow    = date('Y');

        if ($yearNow != $year || ($year == $yearNow && $monthNow - intval($month) > 1)) {
            $this->db->where([
                'merchant_id' => $merchant_id,
                'branch_id'   => $branch_id
            ]);
            
            $this->db->update('bprdwarehouse'.$year.$month, ['note' => NULL, 'adjustment_value' => NULL, 'ppn_adjustment' => NULL]);
        } else {
            $this->db->where('id', $id);
            $this->db->delete('noteadjustment');
        }

        $data = ['status' => 'succcess'];
        
        echo json_encode($data,true);
    }
}
?>