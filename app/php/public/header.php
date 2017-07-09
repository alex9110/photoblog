<?php 
	require_once("../includes/functions.php"); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="../../libs/icons/fontello/css/flickr.css">
	<link rel="stylesheet" href="../../css/main.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
</head>
<body>
	<div class="wrapper">
		<header>
			<div class="header_box">
				<div class="logo"><a href="../admin/admin.php"><h2>Helena Nazarenko</h2></a></div>
				<nav>
					<ul>
						<li><a href="index.php">Главная</a></li>
						<li><a href="portfolio.php">Портфолио</a></li>
						<li><a href="price.php">Услуги и цены</a></li>
						<li><a href="profile.php">Профайл</a></li>
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