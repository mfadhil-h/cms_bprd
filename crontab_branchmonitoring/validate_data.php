<?php

$mysqli = new mysqli("103.252.51.172:3306", "fast", "fast123", "bprd");


if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$firstDate = 1;
$dateToday =  date('d');
$monthToday= date('m');
$yearToday = date('Y');

$intDate = intval($dateToday);

for ($i=$firstDate; $i < $dateToday ; $i++) {
	
	if ($i < 10) {
	 	$i = '0'.$i;
	} 
	$mysqli->query("insert into branchmonitoring (date, merchant_id, branch_id, COUNT) select date_format(header.`bill_date`, '%Y-%m-%d'), header.merchant_id , header.branch_id, COUNT(bill_no)
		from header
		WHERE DAY(bill_date) = ".$i." 
		AND MONTH(bill_date) = ".$monthToday." 
		AND YEAR(bill_date) = ".$yearToday." 
		and not exists(select date, branchmonitoring.merchant_id, branchmonitoring.branch_id from branchmonitoring 
		where date = '".$yearToday."-".$monthToday."-".$i."' and header.`branch_id` = branchmonitoring.`branch_id` 
		and header.`merchant_id` = branchmonitoring.`merchant_id`)
		GROUP BY header.merchant_id, header.branch_id;");
}

?>