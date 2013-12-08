<?php
	include "config.php";

if (!file_exists($_SERVER[DOCUMENT_ROOT]."/{$app_path}/config.php")) {
	echo '<p class="error">Project setup is not complete.<br />-&gt; <a href="install.php">Go to installation</a>?</p>';
}
