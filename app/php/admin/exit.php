<?php 
	session_start();
	if ( isset($_SESSION['user']) ) {
		//очистим сесию
		$_SESSION = [];
	}
	header('Location:/index.php');
	exit;
 ?>