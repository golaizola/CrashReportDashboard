<?php
	include "html.php";
	include "checklogin.php";
?>

<form action="#" method="post">
Old password:<br />
<input type="password" name="oldpass" /><br /><br />
New password:<br />
<input type="password" name="new_pass" /><br />
Repeat new password:<br />
<input type="password" name="reenter_pass" /><br />
<input type="submit" value="Submit" /><input type="reset" value="Reset" />
</form>


<?php
include "mysql.php";


if(isset($_POST['oldpass']) && isset($_POST['new_pass']) && isset($_POST['reenter_pass'])) {
	session_start();

	$pass = $_POST['oldpass'];
	$newpass = $_POST['new_pass'];
	$valpass = $_POST['reenter_pass'];
	$username = $_SESSION['username'];

	$sql = "SELECT `password` FROM `user` WHERE `username` = '" . strtolower($username) . "' LIMIT 1";
	$result = mysql_query($sql);
	$saved_pw = mysql_result($result, 0);

	// hash old password
	$old_pass_hashed = hash("sha512", $pass);

	if ($newpass != $valpass) {
		echo "Passwords doesn't match";
		exit;

	} else if ($newpass == $valpass) {
		$new_pass_hashed = hash("sha512", $newpass);
	}


	if($old_pass_hashed == $saved_pw) {
		$sql_pass =  "UPDATE `user` SET `password` = '$new_pass_hashed' WHERE `username` = '" . strtolower($username) . "'";
		$result_pass = mysql_query($sql_pass);

		if ($result_pass == true) {
			echo 'password changed';
		} else {
			echo "Error: Couldn't change password!";
			exit;
		}

	} else {
		echo "Old password is wrong!";
		exit;
	}
}
