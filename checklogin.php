<?php

// initiate session!
session_start();

if (isset($_SESSION["username"])) {
	if (isset($_COOKIE["username"]) && isset($_COOKIE["password"])) {
		if(_check_db($_COOKIE["username"], $_COOKIE["password"])) {
			$_SESSION["username"] = $_COOKIE["username"];
        } else {
        	notLoggedIn();
        }
	}

} else {
	if (isset($_COOKIE["username"]) && isset($_COOKIE["password"])) {
		if(_check_db($_COOKIE["username"], $_COOKIE["password"])) {
			$_SESSION["username"] = $_COOKIE["username"];
        } else {
        	notLoggedIn();
        }
	} else {
		notLoggedIn();
	}
}



function notLoggedIn() {
	echo "Not logged in, please login first! Click here to <a href=\"login.php\">Login</a>";
	exit;
}

function _check_db($username, $password) {
	include "config.php";

    $con = mysql_connect($mysql_server, $mysql_user , $mysql_password) or die("Server can't be reached or is down!"); 
    mysql_select_db($mysql_db) or die ("Can't select database!");
    $sql = "SELECT `username`, `password`, `activated` FROM `user` WHERE `username` = '" . strtolower($username) . "' LIMIT 1";
    $result = mysql_query($sql);
    $row = mysql_fetch_object($result);
 
    //general return
    if(is_object($row) && $row->password == $password && $row->activated == 1)
        return true;
    else
        return false;
}

?>