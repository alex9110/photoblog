<?php require_once("header_ad.php"); ?>
	<link rel="stylesheet" href="../../css/price_form.css">
	<form id="save_form">
		<div id="desc">
			<div id="fileName"><p>Выбери изображения </p></div>
			<div id="fileUpload" class="button">
				<label><input class="none" name="takeImg" type="file" accept="image/*" id="offer_image" onchange="getFileName ();" ><span>Выбрать</span></label>
			</div>
			<input placeholder="Названия услуги" maxlength="50" type="text" class="portfolio_input" id="offer_name"/> 
			<input placeholder="стоимость" maxlength="30" type="text" class="portfolio_input" id="cost"/> 
			<div></div> 
			<textarea cols="70" rows="7" placeholder="Описания услуги. ВНИМАНИЕ, для обозначения нового элемента списка, необходимо в начале каждого следующего елемента, кроме самого первого ставить знак слеш / " maxlength="700" class="portfolio_input text" id="offer_desc"></textarea>
			<input type="button" name="submit" value="сохранить" id="save_offer" class="save button" />	
		</div>	
		
		<div id="preview"></div>
		<script>// скрипт для формы сохранения закладок
			function getFileName () { //покажем имя выбраного файла
				var file = document.getElementById ('offer_image').value;
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
				document.getElementById('offer_image').addEventListener('change', handleFileSelect, false);
		</script>
	</form>
	<div class="content">
		<div class="service_box">
			<?php 
				echo(show_prices());
			 ?>	
		</div>
		<form id="extra_service">
			<textarea id="service_desc"  cols="70" rows="7" type="text" placeholder="Укажите список дополнительных услуг, для коректного отображения списка, елементы списка необходимо разделять значком слеш /"></textarea>
			<input id="service_but" type="button" value="изменить">
		</form>
		<?php echo(show_extra_service());?>
	</div>
<?php require_once("footer_ad.php"); ?>