<?php
require 'sso_client.php';
sso_login('http://localhost:8888/manager/login.php');


if(isset($_SESSION['username'])){
	echo "welcome login";
	print_r($_SESSION);
}

?>
<a href="http://localhost:8888/manager/login.php?o=l">Logout</a>
