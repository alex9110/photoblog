<?php 
	require_once("../includes/functions.php");
	require_once("db_start.php");
	//проверим залогинен ли
	if ( login_test() ) {
		redirects('index_ad.php');
	}
	//$login = mysqli_real_escape_string($connection, $login);  		//экранируем данные только те которые участвуют в запросе к базе
	//вход админа
	$data = $_POST;
	if ( isset($data['submit']) ) {
		$login = $data['login'];
		$pas = $data['pas'];
		if ( valid($login, $pas) ) {
			if (login($login, $pas) ) {
				session_start();
				$_SESSION['user'] = 'admin';
				header('Location: index_ad.php');
				exit;
			}	
		}
	}
	//смена логина и пароля
	$result;
	if ( isset($data['save']) ) {
		$login = trim($data['login']);
		$pas = trim($data['pas']);
		$new_login = trim($data['new_login']);
		$new_pas = trim($data['new_pas']);
		$new_pas2 = trim($data['new_pas2']);

		if ( valid($login, $pas) ) {
			if ( login($login, $pas) ) {
				if ( new_log_pas($new_login, $new_pas, $new_pas2) ) {
					$result = '<p style="color:#fff;">успешно изменено</p>';
				}else{
					$result = '<p style="color:red;">пароли не совпадают</p>';
				}
			}else{
				$result = '<p style="color:red;">логин или пароль не верный</p>';
			}
		}else{
			$result = '<p style="color:red;">логин или пароль не верный</p>';
		}	
	}
	//create_db();
	//create_tables();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>login</title>
	<link rel="stylesheet" href="../../css/login_form.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<div id="login" class="form">
	<div class="result"><?php echo $result; ?></div>
		<form action="login.php" method="post">
			<label for="login">Username</label>
			<input required maxlength="10" id="login" type="text" name="login" placeholder="Enter username" value="<?php echo @$data['login']?>"><br>
			<label for="password">Password</label>
			<input required maxlength="20" id="password" type="password" name="pas" placeholder="Enter password"><br>
			<input id="submit" type="submit" name="submit" value="Log in">
		</form>
		<span id="change" class="change" >cменить пароль</span>
	</div>	
	<div id="new_data" class="form form2">
		<form action="login.php" method="post">
			<label for="old_login">Username</label>
			<input required maxlength="10" id="old_login" type="text" name="login" placeholder="Enter username"><br>

			<label for="old_password">Password</label>
			<input required maxlength="20" id="old_password" type="password" name="pas" placeholder="Enter password"><br>

			<label for="new_login">New username</label>
			<input required maxlength="10" id="new_login" type="text" name="new_login" placeholder="Enter new username"><br>

			<label for="new_password">New password</label>
			<input required maxlength="20" id="new_password" type="password" name="new_pas" placeholder="Enter new password"><br>

			<label for="new_password2">Repeat new password</label>
			<input required maxlength="20" id="new_password2" type="password" name="new_pas2" placeholder="Repeat new password"><br>

			<input id="save" type="submit" name="save" value="Save">

		</form>
		<span id="no_change" class="change">отмена</span>
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
