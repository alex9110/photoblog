<?php 
	require_once("../includes/functions.php"); 
	if ( login_test() ) {
	}else{redirects();}
	require_once("../includes/main.php"); 
	if ($title == null) {
		$title = "document";
	}
	if ($whom == null) {
		$whom = 0;
	}
	$active[$whom] ='class="active"';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title><?php echo $title; ?></title>
	<link rel="shortcut icon" href="../../img/camera.png" type="image/png">
	<link rel="stylesheet" href="../../libs/icons/fontello/css/flickr.css">
	<link rel="stylesheet" href="../../css/main.css">
	<link rel="stylesheet" href="../../css/admin.css">
	<link rel="stylesheet" href="../../css/portfolio.css">
	<link rel="stylesheet" href="../../css/portfolio_form.css">
	<link rel="stylesheet" href="../../css/price.css">
	<link rel="stylesheet" href="../../css/profile.css">
	<link rel="stylesheet" href="../../css/photo_form.css">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">	
</head>
<body>
	<div class="wrapper">
	<div class="admin"<p>admin</p></div>
		<header>
			<div class="header_box">
				<div class="logo"><a href="index_ad.php"><h2>Helena Nazarenko</h2></a></div>
				<div class="social">
					<ul>						
						<?php 
							$data = get_contacts('social');
							for ($i=0; $i < count($data) ; $i++) { 
								$name = $data[$i]['name'];
								$url = $data[$i]['value'];
								echo '<li><a href="'.$url.'" target="_blank" ><i class="icon-'.$name.'"></i></a></li>';
							}
						 ?>
					</ul>
				</div>
				<nav>
					<ul>
						<li <?php echo @$active[0]; ?> ><a href="index_ad.php">Главная</a></li>
						<li <?php echo @$active[1]; ?> ><a href="portfolio_ad.php">Портфолио</a></li>
						<li <?php echo @$active[2]; ?> ><a href="price_ad.php">Услуги и цены</a></li>
						<li <?php echo @$active[3]; ?> ><a href="profile_ad.php">Профайл</a></li>
						<li <?php echo @$active[4]; ?> ><a href="contacts.php">Контакты</a></li>
						<li><a href="exit.php">Выход</a></li>
					</ul>
				</nav>
			</div>
		</header>