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
				header('Location: admin.php');
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
</head>
<body>
	<form action="login.php" method="post">
		<input type="text" name="login" value="<?php echo @$data['login']?>"><br>
		<input type="text" name="pas" value="<?php echo @$data['pas']?>"><br>
		<input type="submit" name="submit">
	</form>
</body>
</html>
