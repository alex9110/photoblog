<?php require_once("header_ad.php"); ?>
	<link rel="stylesheet" href="../../css/portfolio.css">
	<link rel="stylesheet" href="../../css/form2.css">
	<div class="content">
		<form id="save_form">
			<div id="desc">
				<div id="fileName"><p>выберите фото обложку альбома </p></div>
				<div id="fileUpload">
					<label><input class="none" name="takeImg" type="file" accept="image/*" id="album_cover" onchange="getFileName ();" ><span>Выбрать</span></label>
				</div>
				<input placeholder="названия альбома" maxlength="50" type="text" class="input" id="album_name"/> 
				<div></div>
				<input placeholder="краткое описание альбома" maxlength="100" type="text" class="input" id="album_desc"/> 
			</div>	
			<input type="button" name="submit" value="сохранить" id="save_album" class="save button" />
			<div id="preview"></div>
			<script>// скрипт для формы сохранения закладок
				function getFileName () { //покажем имя выбраного файла
					var file = document.getElementById ('album_cover').value;
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
					document.getElementById('album_cover').addEventListener('change', handleFileSelect, false);
			</script>
		</form>
	
		<?php  echo( show_woks() );?>
	</div>
<?php require_once("footer_ad.php"); ?>