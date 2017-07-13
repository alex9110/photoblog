<?php 
	require_once("../includes/functions.php");
	//проверим залогинен ли
	if ( login_test() ) {
		redirects('index_ad.php');
	}
	//$login = mysqli_real_escape_string($connection, $login);  		//экранируем данные только те которые участвуют в запросе к базе
	$data = $_POST;
	if ( isset($data['submit']) ) {
		if ( login($data) ) {
			session_start();
			$_SESSION['user'] = 'admin';
			header('Location: index_ad.php');
			exit;
		}
	}	
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>login</title>
	<link rel="stylesheet" href="../../css/login_form.css">
</head>
<body>
	<div id="login" class="form">
		<form action="login.php" method="post">
			<label for="login">Username</label>
			<input id="login" type="text" name="login" placeholder="Enter username" value="<?php echo @$data['login']?>"><br>
			<label for="password">Password</label>
			<input id="password" type="password" name="pas" placeholder="Enter password"><br>
			<input id="submit" type="submit" name="submit" value="Log in">
		</form>
		<span id="change" class="сhange" >cменить пароль</span>
	</div>	
	<div id="new_data" class="form form2">
		<form action="login.php" method="post">
			<label for="old_login">Username</label>
			<input id="old_login" type="text" name="login" placeholder="Enter username"><br>

			<label for="old_password">Password</label>
			<input id="old_password" type="password" name="pas" placeholder="Enter password"><br>

			<label for="new_login">New username</label>
			<input id="new_login" type="text" name="new_login" placeholder="Enter new username"><br>

			<label for="new_password">New password</label>
			<input id="new_password" type="password" name="new_pas" placeholder="Enter new password"><br>

			<label for="new_password2">Repeat new password</label>
			<input id="new_password2" type="password" name="new_pas2" placeholder="Repeat new password"><br>

			<input id="save" type="submit" name="save" value="Save">

		</form>
		<span id="no_change" class="сhange">не менять пароль</span>
	</div>
	<script src="../../js/libs.min.js"></script>
	<script>
	//смена форм
	var form1 = $('#login');
	var form2 = $('#new_data');
		$('#change').click(function(evt){
			form1 = $(form1).detach();
			form2.appendTo('body');
		});
		$('#no_change').click(function(evt){
			form2 = $(form2).detach();
			form1.appendTo('body');
		});
		form2 = $('#new_data').detach();
		
	</script>
</body>
</html>
