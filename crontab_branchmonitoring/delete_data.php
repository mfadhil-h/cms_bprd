<?php

$mysqli = new mysqli("103.252.51.172:3306", "fast", "fast123", "bprd");


if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}


if (!$mysqli->query("CALL sp_delete_branchmonitoring()")) {
    echo "CALL failed: (" . $mysqli->errno . ") " . $mysqli->error;
}

?>