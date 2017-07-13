<?php 
	//$value = password_hash($x_data, PASSWORD_BCRYPT);  //хешируем значение перед отравкой браузеру
	
	//$login = mysqli_real_escape_string($connection, $login);  		//экранируем данные только те которые участвуют в запросе к базе
	$data = $_POST;
	if ( isset($data['submit']) ) {
		$errors = array();

		$login = trim($data['login']);
		$pas = trim($data['pas']);

		if (strlen($login) < 1 || strlen($login) > 20) {
			$errors[] = 'Неверный логин';
		}
		if (strlen($pas) < 4 || strlen($pas) > 20) {
			$errors[] = 'Неверный пароль';
		}
		if (empty($errors)) {
			// наш хеш будет состоять с логина сконкатенированным с паролем
			//$result = password_verify($login.$pas);
			$result = true;
			//если все ок сохраним данные для текущей сесии
			if ($result === true) {
				session_start();
				$_SESSION['user'] = 'admin';
				header('Location: index_ad.php');
				exit;
			}	
		}
	}
	if ( !empty($_COOKIE[session_name()]) ) {
		session_start();
		if ( isset($_SESSION['user']) ) {
			if ($_SESSION['user'] === 'admin') {
				header('Location: admin.php');
				exit;
			}
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
	<div class="form">
		<form action="login.php" method="post">
			<label for="login">Username</label>
			<input id="login" type="text" name="login" placeholder="Enter username" value="<?php echo @$data['login']?>"><br>
			<label for="password">Password</label>
			<input id="password" type="password" name="pas" placeholder="Enter password" value="<?php echo @$data['pas']?>"><br>
			<input id="submit" type="submit" name="submit" value="Log in">
		</form>
	</div>

	
</body>
</html>
