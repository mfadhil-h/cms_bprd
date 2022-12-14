<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class branch extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();

        $data = ['class' => 'branch'];
        $this->load->model('kecamatanModels', 'kec');
        $this->load->model('branchModels', 'branch');
        $this->load->model('merchantModels', 'merchant');
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
        $previlage = $this->master->module_access($_SESSION['up_id'], 'mod_branch')->row();
        
        $data = ['rights' => $previlage->ma_previlage];

        $this->load->view('branch/index', $data);
        $this->load->view('main/global_footbar');
    }

    public function get_data()
    {
        $subanId = null;
        if ($_SESSION['level'] == 3) {
            $subanId = $_SESSION['suban_id'];
        }

        $branchs    = $this->branch->getBranch($subanId)->result();
        $previlage  = $this->master->module_access($_SESSION['up_id'], 'mod_branch')->row();
        $row = [];
        $data = [];
       
        foreach ($branchs as  $rowBranch) {
            $row = [];
            $row[] = $rowBranch->branch_name;
            $row[] = $rowBranch->merchant_name;
            $row[] = $rowBranch->npwp;
            $row[] = $rowBranch->nopd;
            $row[] = $rowBranch->bt_desc;
            $row[] = $rowBranch->pic;
            $row[] = $rowBranch->location;
            $row[] = $rowBranch->kec_name;
            $row[] = $rowBranch->pos_code;
            $row[] = $rowBranch->no_tlp;

            if ($previlage->ma_previlage == 3) {
                $row[] = '
                <a data-id="'.$rowBranch->id.'" href="'.base_url('branch/edit/'.$rowBranch->id).'" class="edit-control ext-light mr-3 font-16" data-toggle="tooltip" title="Edit Data"><i class="fa fa-pencil"></i></a>';
            }
            
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->branch->count_all($subanId),
            "recordsFiltered" => $this->branch->count_filtered($subanId),
            "data" => $data,
        );

        echo json_encode($output);
        exit();
    }

    public function create()
    {   
        $subanId = null;
        if ($_SESSION['level'] == 6) {
            $subanId = $_SESSION['suban_id'];
        }

        $kecamatan  = $this->kec->getKec($subanId);
        $brancType  = $this->branch->getBranchType();
        $merchant   = $this->merchant->get_merchant_all()->result_array();

        $data       = [
            'merchants'     => $merchant,
            'kecamatans'    => $kecamatan,
            'branchsType'   => $brancType
        ];

        $result = $this->load->view('branch/create', $data, true);
        echo json_encode($result,true);
        exit();
    }

    public function store()
    {
        foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }
        
        $this->db->select_max('branch_id');
        $this->db->where('merchant_id', $merchant_id);
        $branchCount = $this->db->get('branch')->row()->branch_id;
        $branch_id = $branchCount + 1;

        $data = [
            'merchant_id'       => $merchant_id,
            'branch_id'         => $branch_id,
            'kec_id'            => $kec_id,
            'bt_id'             => $bt_id,
            'branch_name'       => $branch_name,
            'npwp'              => $npwp,
            'nopd'              => $nopd,
            'location'          => $location,
            'pos_code'          => $pos_code,
            'pic'               => $pic,
            'no_tlp'            => $no_tlp,
            'rekening_number'   => $rekening_number,
            'created'           => date('Y-m-d H:i:s')
        ];

        
        $this->db->insert('branch',$data);

        redirect('branch/index');
    }

    public function edit()
    {
        $subanId = null;
        if ($_SESSION['level'] == 6) {
            $subanId = $_SESSION['suban_id'];
        }
        
        $row        = $this->db->get_where('branch',array('id'=>$_REQUEST['id']))->result_array();
        $kecamatan  = $this->kec->getKec($subanId);
        $brancType  = $this->branch->getBranchType();
        $merchant   = $this->merchant->get_merchant_all()->result_array();

       

        $data  = [
                'row'           => $row[0],
                'merchants'     => $merchant,
                'kecamatans'    => $kecamatan,
                'branchsType'   => $brancType
            ];

        $result = $this->load->view('branch/edit', $data, true);

        echo json_encode($result,true);
        exit();
    }

    public function save()
    {
        foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }  

        $data = [
            'kec_id'            => $kec_id,
            'bt_id'             => $bt_id,
            'branch_name'       => $branch_name,
            'npwp'              => $npwp,
            'nopd'              => $nopd,
            'location'          => $location,
            'pos_code'          => $pos_code,
            'pic'               => $pic,
            'no_tlp'            => $no_tlp,
            'rekening_number'   => $rekening_number,
            'modified'          => date('Y-m-d H:i:s')
        ];
            
        $this->db->where('id', $id);
        $this->db->update('branch', $data);

        redirect('branch/index');
    }

    public function delete($req)
    {
        $array      = explode("-",$req);
        $merchantId = $array[0];
        $branchId   = $array[1];

        $condition = [
            'merchant_id'   => $merchantId,
            'branch_id'     => $branchId
        ];

        $row = $this->db->get_where('header',$condition)->result_array();

        if (count($row) > 0) {
            redirect('branch/index','refresh');
        } else {
            $this->db->where('id', $array[2]);
            $this->db->delete('branch');

            redirect('branch/index');
        }            
    }

    public function before_saving() {
        foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }


        if (count($_REQUEST) > 1) {
            $this->db->select('*');
            $this->db->from('branch');
            $this->db->where('branch_name', $_REQUEST['branch_name']);
            $this->db->where_not_in('id', $_REQUEST['id']);
            $query = $this->db->get();
        } else {
            $query = $this->db->get_where('branch', array('branch_name' => $_REQUEST['branch_name']));
        }

        if ($query->num_rows() > 0){
            $result = [
                'res' => false,
                'message' => 'Nama otlet sudah tersedia di database'
                ];
        } else {
            $result = [
                'res' => true,
                'message' => 'Data berhasil disimpan!'
            ];
        }

        echo json_encode($result, true);
        exit();
    }
}
?>