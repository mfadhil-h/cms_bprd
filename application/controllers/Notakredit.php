<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class notakredit extends CI_Controller
{
    public function __construct()
        {
            parent::__construct();
            $this->load->library('pdf');
            $data = ['class' => 'notakredit'];

            $this->load->model('Nota_Kredit', 'nk');
             $this->load->model('Masters', 'master');
            
            $this->load->view('main/header', $data);
            $this->load->view('main/footer');
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
            if($_SESSION['level'] == "5"){
                $data['branch'] = $this->master->branch_id($_SESSION['merchantid'], 'ALL');
            }else if($_SESSION['level'] == "6"){
                $data['branch'] = $this->master->branch_id($_SESSION['merchantid'],$_SESSION['branchid']);
            }
        }
        
        $class = ['class' => 'notakredit'];
            $this->load->view('main/global_headbar');
            $this->load->view('main/global_sidebar', $access);
            $this->load->view('report/notakredit');
            $this->load->view('main/global_footbar');
            $this->load->view('main/footer', $class);
        }
        
    public function load_data(){
        $postData = $this->input->post();
        $startdate = $postData['start_date'].' 00:00:00';
        $enddate   = $postData['start_date'].' 23:59:59';
        //2020-08-01

        $data['kredit'] = $this->nk->getTotalTaxByBranchType($startdate, $enddate)->result();
        $arr = $this->nk->getTotalTax($startdate, $enddate)->row();
        $data['maxtotal']=$arr->total;
        $data['terbilang'] = $this->terbilang(round($arr->total)).' RUPIAH';
       // var_dump($arr->total);
        //exit();
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

        $awal = date('d-m-Y', strtotime($postData['start_date']));
        $exp = explode("-", $awal);
        $tanggal = $exp[0].' '.$monthDesc[$exp[1]].' '.$exp[2];
        //01-01-0000
        $awal2 = date('d-m-Y');
        $exp2 = explode("-", $awal2);
        $tanggal2= $exp2[0].' '.$monthDesc[$exp2[1]].' '.$exp2[2];

        $data['startdate'] = $tanggal;
        $data['now'] =$tanggal2;

        $class = ['class' => 'note'];
        $this->load->view('report/report_nota', $data);
         
        $this->load->view('main/footer', $class);
        
    }

    public function terbilang( $num ,$dec=4){

        $stext = array(
            "NOL",
            "SATU",
            "DUA",
            "TIGA",
            "EMPAT",
            "LIMA",
            "ENAM",
            "TUJUH",
            "DELAPAN",
            "SEMBILAN",
            "SEPULUH",
            "SEBELAS"
        );
        $say  = array(
            "RIBU",
            "JUTA",
            "MILYAR",
            "TRILIUN",
            "BILIUN", // remember limitation of float
            "--apaan---" ///setelah biliun namanya apa?
        );
        $w = "";

        if ($num <0 ) {
            $w  = "Minus ";
            //make positive
            $num *= -1;
        }

        $snum = number_format($num,$dec,",",".");
        // die($snum);
        $strnum =  explode(".",substr($snum,0,strrpos($snum,",")));
        //parse decimalnya
        $koma = substr($snum,strrpos($snum,",")+1);

        $isone = substr($num,0,1)  ==1;
        if (count($strnum)==1) {
            $num = $strnum[0];
            switch (strlen($num)) {
                case 1:
                case 2:
                    if (!isset($stext[$strnum[0]])){
                        if($num<19){
                            $w .=$stext[substr($num,1)]." BELAS";
                        }else{
                            $w .= $stext[substr($num,0,1)]." PULUH ".
                                (intval(substr($num,1))==0 ? "" : $stext[substr($num,1)]);
                        }
                    }else{
                        $w .= $stext[$strnum[0]];
                    }
                    break;
                case 3:
                    $w .=  ($isone ? "SERATUS" : $this->terbilang(substr($num,0,1)) .
                        " RATUS").
                        " ".(intval(substr($num,1))==0 ? "" : $this->terbilang(substr($num,1)));
                    break;
                case 4:
                    $w .=  ($isone ? "SERIBU" : terbilang(substr($num,0,1)) .
                        " RIBU").
                        " ".(intval(substr($num,1))==0 ? "" : terbilang(substr($num,1)));
                    break;
                default:
                    break;
            }
        }else{
            $text = $say[count($strnum)-2];
            $w = ($isone && strlen($strnum[0])==1 && count($strnum) <=3? "Satu ".strtolower($text) : $this->terbilang($strnum[0]).' '.$text);
            array_shift($strnum);
            $i =count($strnum)-2;
            foreach ($strnum as $k=>$v) {
                if (intval($v)) {
                    $w.= ' '.$this->terbilang($v).' '.($i >=0 ? $say[$i] : "");
                }
                $i--;
            }
        }
        $w = trim($w);
        if ($dec = intval($koma)) {
            $w .= " Koma ". terbilang($koma);
        }
        return trim($w);
    }
}

?>