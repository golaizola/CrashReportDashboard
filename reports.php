<?php

include "checklogin.php";
include "html.php";
include "mysql.php";
include "crashes.php";
include "alphaID.php";

// Search form
echo '<form method="get" action="reports.php">'."\n";
echo 'Filter by phone_model: <input type="text" name="q" value="'.$_GET[q].'" /> <input type="submit" value="Search" />'."\n";
echo "</form>\n";

session_start();

if (!isset($_GET['app'])) {
	echo "An error occurred! Back to <a href=\"index.php\">Dashboard</a>";
	exit;

} else if (isset($_GET['app'])) {
	$sql = "SELECT `id` FROM `user` WHERE `username` = '" . $_SESSION["username"] . "'";
	$res = mysql_query($sql);
	$userid = mysql_result($res, 0);

	$sql = "SELECT `userid` FROM `app` WHERE `appid` = '" . $_GET['app'] . "'";
	$res = mysql_query($sql);
	$useridForApp = mysql_result($res, 0);

	if ($userid != $useridForApp) {
		echo "Not your Application!";
		exit;
	}
}

echo '<center><a href="?app=' . $_GET[app] . '&status='.STATE_NEW.'">New reports</a> | <a href="?app=' . $_GET[app] . '&status='.STATE_FIXED.'">Fixed reports</a> | <a href="?app=' . $_GET[app] . '&status='.STATE_INVALID.'">Invalid reports</a></center>'."\n";

if (!isset($_GET[status])) {
	$status = STATE_NEW;

} else {
	$status = $_GET[status];
}

if ($_GET[status] == STATE_NEW) {
	display_versions($_GET[app]);
}
display_crashes($status, $_GET[app]);
mysql_close();

?></body>
</html>
