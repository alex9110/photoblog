<?php
 require_once("header_ad.php");
 require_once("../includes/functions.php"); 
 require_once("../includes/config.php"); 
  ?>
	<link rel="stylesheet" href="../../css/profile.css">
	<link rel="stylesheet" href="../../css/form2.css">
	<link rel="stylesheet" href="../../css/form5.css">
	<div class="content">
	<form id="save_form">
			<div id="desc">
				<div id="fileName"><p>выберите своё фото </p></div>
				<div id="fileUpload">
					<label><input class="none" type="file" accept="image/*" id="avatar" onchange="getFileName ();" ><span>Выбрать</span></label>
				</div>
				<input placeholder="Заголовок" maxlength="50" type="text" class="input" id="title"/> 
				<div></div>
				<textarea cols="70" rows="7" placeholder="Статья" maxlength="700" class="input text" id="article"></textarea>
			</div>	
			<input type="button" name="submit" value="сохранить" id="save_profile" class="save button" />
			<div id="preview"></div>
			<script>// скрипт для формы сохранения закладок
				function getFileName () { //покажем имя выбраного файла
					var file = document.getElementById ('avatar').value;
					 document.getElementById('fileName').innerHTML ='файл: '+file;
				}
				function handleFileSelect(evt) {                 //запускаем функцию обработки события в нее передается объект события
       				var files = evt.target.files;                // возьмемем наш фаил точнее масив 
        			var file = files[0];
        			var reader = new FileReader();               //создадим экземпляр объекта FileReader()
        			reader.readAsDataURL(file);                  //читаем фаил с с помощю данного метода
        			reader.onload = (function(event) {           //когда читаемтение файла завершено вызываем функцию для отображения картинки и передаем в нее обьект этого событие
	        			var image = event.target.result;
	        			var prew = document.getElementById('preview');
	        			prew.style.backgroundImage = "url("+image+")";
    				});
					}
					// вешаем обработчик на елемент с id files
					document.getElementById('avatar').addEventListener('change', handleFileSelect, false);
			</script>
		</form>
		<div class="about_me">
			<?php echo( show_profile() );?>
		</div>
		<div class="contact">
			<p>Заказать фотосессию</p><br>
			<?php 
				$data = get_contacts('phone');
				for ($i=0; $i < count($data) ; $i++) { 
					$value = $data[$i]['value'];
					echo '<p class="tel">'.$value.'<i class="icon-phone"></i></p>';
				}
			 ?>
		</div>
		<div class="social2">
			<?php 
				$data = get_contacts('mail');
				echo '<div class="mail"><p>'.$data[0]['value'].'</p></div>';
				$data = get_contacts('social');
				for ($i=0; $i < count($data) ; $i++) { 
					$name = $data[$i]['name'];
					$value = $data[$i]['value'];
					echo'<span class="'.$name.'"><a href="'.$value.'" target="_blank"><i class="icon-'.$name.'"></i></a></span>';
				}
			 ?>
		</div>
	</div>
<?php require_once("footer_ad.php"); ?>