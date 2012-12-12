<?php

include "mysql.php";
include "crashes.php";
include "alphaID.php";

$f = fopen("last_access", "w");
fputs($f, "access on ".date("d/M/Y G:i:s")."\n");
fclose($f);

ob_start();

if (!isset($_GET['key'])) {
	echo "no Key";
	die();
}

// Check _POST
if (count($_POST) == 0) {
	echo "empty post";
    log_to_file("Empty _POST query");
   	die();
}

foreach($_POST as $k => $v) {
    if (array_search(strtolower($k), $values) === FALSE) {
       	continue;
    }

    $object[strtolower($k)] = mysql_real_escape_string($v);
}

// Add custom data
$object['appid'] = $_GET['key'];
$object['added_date'] = time();
$object['issue_id'] = issue_id($object['stack_trace'], $object['package_name']);

$sql = "SELECT `status` FROM `crashes` WHERE `issue_id` = '" . $object['issue_id'] . "'";
$res = mysql_query($sql);
$status = mysql_result($res, 0);

if ($status == 0) {
  $object['status'] = STATE_NEW;

} else {
  $object['status'] = $status;
}


// Save to DB
$sql = create_mysql_insert($object);
$success = mysql_query($sql);

if ($success != TRUE) {
    log_to_file("Unable to save record: ".mysql_error());
    log_to_file("Query was: ".$sql);
}

// Close MySQL
mysql_close($mysql);

$f = fopen("log", "w+");
fputs($f, "Output of ".date("d/M/Y G:i:s").":\n".ob_get_clean());
fclose($f);

echo "What are you doing here?";

?>
