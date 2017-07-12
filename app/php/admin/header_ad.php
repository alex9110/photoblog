<?php 
	require_once("../includes/functions.php"); 
	if ( login_test() ) {
	}else{
		redirects();
	}
	require_once("../includes/config.php"); 
	require_once("../includes/main.php"); 
//если все ок продолжаем строить страницу если нет переадресовуем на страницу входа
	
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="../../libs/icons/fontello/css/flickr.css">
	<link rel="stylesheet" href="../../css/main.css">
	<link rel="stylesheet" href="../../css/admin.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
</head>
<body>
	<div class="wrapper">
	<div class="admin" style="height: 20px; background-color: #000; text-align: center; color: #fff"><p>admin</p></div>
		<header>
			<div class="header_box">
				<div class="logo"><a href="index_ad.php"><h2>Helena Nazarenko</h2></a></div>
				<nav>
					<ul>
						<li><a href="index_ad.php">Главная</a></li>
						<li><a href="portfolio_ad.php">Портфолио</a></li>
						<li><a href="price_ad.php">Услуги и цены</a></li>
						<li><a href="profile_ad.php">Профайл</a></li>
						<li><a href="exit.php">Выход</a></li>
					</ul>
				</nav>
				<div class="social">
					<ul>						
						<?php 
							$data = get_contacts('social');
							for ($i=0; $i < count($data) ; $i++) { 
								$name = $data[$i]['name'];
								$url = $data[$i]['value'];
								echo '<li class="instagram"><a href="'.$url.'" target="_blank" ><i class="icon-'.$name.'"></i></a></li>';
							}
						 ?>
					</ul>
				</div>
			</div>
		</header>