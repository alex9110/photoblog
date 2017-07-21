<?php 
	session_start();
	if ( isset($_SESSION['user']) ) {
		//очистим сесию
		$_SESSION = [];
	}
	header('Location: ../public/index.php');
	exit;
 ?>