<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class sspd extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();

		$data = ['class' => 'sspd'];

		$this->load->model('subans', 'suban');
		$this->load->model('branchModels', 'branch');
		$this->load->model('payments');
		$this->load->model('kecamatanModels', 'kec');

		$this->load->library("session");

		$this->load->view('main/header', $data);
        $this->load->view('main/footer');
	}

	public function report($month, $year, $merchantId, $branchId)
	{	
		$query = $this->payments->getPayment($merchantId, $branchId, $month, $year);
		$datapayment = $query->result();
		
		if ($month < 10) {
			$month = '0'.$month;
		}

		$dataDoc = $this->db->get_where('document', ['merchant_id' => $merchantId, 'branch_id' => $branchId, 'periode' => 'B'.$year.$month])->row();

		foreach ($datapayment[0] as $key => $value) {
			$data [$key] = $value;
		}

		$dataKecamatan = $this->kec->getKecByBranch($merchantId, $branchId);
		$data['kecamatan_name'] = $dataKecamatan['kec_name'];
        $dataMerchant = $this->db->get_where('merchant', ['merchant_id' => $merchantId])->row();
		
        $dataBranch = $this->branch->getBranchByid($branchId, $merchantId);
		$data['month'] = $month;
		$data['year'] = $year;
		$data['npwp'] = $dataBranch['npwp'];
		$data['nopd'] = $dataBranch['nopd'];
		$data['alamat']= $dataBranch['location'];
		$data['merchant'] = $dataMerchant;
		$data['ntpd'] = $dataDoc->ntpd;
		$amount = floatval($data['tax']);
		$data['terbilang'] = $this->terbilang(round($amount)).' RUPIAH';
        
		$dataResult = [
			'fetch' => $data
		];
		
		$this->load->view('report/sspd', $data);
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