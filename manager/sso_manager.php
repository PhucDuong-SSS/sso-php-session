<?php
session_start();
$this_page = "http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
if(isset($_GET['s'])){
	header("location:".$GLOBALS['this_page']);
}
// if logout
if(isset($_GET['o'])){
	if(isset($_GET['u'])){
		$_SESSION['url'] = array_diff($_SESSION['url'],array($_GET['u']));
	}
	sso_logout();
}
//check is login redirect to url login
function is_login($url='')
{
	if (isset($_GET['u'])) {
		if (!empty($_SESSION)) {
			sso_login($_GET['u']);
		}
	} else if (!empty($_SESSION)) {
		if (!empty($url) && !isset($_GET['o'])) {
			header("location:" . $url);
		} else {
			if (!empty($_SESSION['url'])) {
				$url = end($_SESSION['url']);
				if ($url != '' && $url != $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME']) {
					sso_login($url);
				}
			}
		}
	}
}
// Adding session url from get
	function sso_login($url = '')
	{
		if (!isset($_GET['o'])) {
			$url = isset($_GET['u']) ? $_GET['u'] : $url;
			$host_login = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
			$host_web = "http://" . parse_url($url, PHP_URL_HOST);
			if (isset($_SESSION['url'])) {
				if (!in_array($url, $_SESSION['url'])) {
					if ($host_login != $host_web) {
						array_push($_SESSION['url'], $url);
					} else if ($host_login == $host_web) {
						if (!in_array($host_login, $_SESSION['url'])) {
							array_push($_SESSION['url'], "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME']);
						}
					}
				}
			} else {
				if ($host_login == $host_web) {
					array_push($_SESSION['url'], "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME']);
				} else {
					$_SESSION['url'] = array($url);
				}
			}
			$_SESSION['url'] = array_diff($_SESSION['url'], array(''));
			$json = json_encode($_SESSION);
			// send session to other page with encrypted using base64 encode
			header("location:" . $url . "?s=" . base64_encode($json));
		}
	}

// Logout system base on url session
	function sso_logout()
	{
		if (!empty($_SESSION['url'])) {
			if (count($_SESSION['url']) > 0) {
				$url = end($_SESSION['url']);
				//$_SESSION['url'] = array_diff($_SESSION['url'],array($url));
				header("location:" . $url . "?o=l&u=" . $GLOBALS['this_page']);
			}
		} else {
			session_destroy();
			header("location:" . $GLOBALS['this_page']);
		}
		echo "Please Wait...";
	}
//print_r($_SESSION);


?>
