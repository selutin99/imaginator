<?php
	if ($_COOKIE['user']) {
		setcookie('user', '', strtotime('-30 days'), '/');
		unset($_COOKIE['user']);
	}
	session_unset();
	exit(header('location: index.php'));
?>