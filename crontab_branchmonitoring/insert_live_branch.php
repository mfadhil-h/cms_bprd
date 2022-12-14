<?php

$mysqli = new mysqli("103.252.51.172:3306", "fast", "fast123", "bprd");


if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$mysqli->query("insert into livebranch (merchant_id, branch_id, date_live) 
				select merchant_id, branch_id, created from header 
				WHERE (merchant_id, branch_id) NOT IN(SELECT merchant_id, branch_id FROM livebranch)
				GROUP BY merchant_id, branch_id");

?>
