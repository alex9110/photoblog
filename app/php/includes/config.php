<?php

	function config(){	//настройки
		$data = array(
			'dbhost'=>"localhost",			//хост
			'dbuser'=>"root",				//логин к базе
			'dbpass'=>"",					//пароль к базе
			'dbname'=>"photoblog",			//имя базы
			'index'=>'index_photo',			//имя таблицы для фоток индексной страницы
			'tmp'=>'temporarily',			//имя таблицы для временного хранения
			'portfolio'=>'portfolio',		//имя таблицы с данными обо всех альбомах
			'img_folder'=>"../../albums/photo/",				//папка с фотками
			'аlbum_covers'=>'../../albums/covers/'		//папка для хранения обложок альбовом
		);
		return($data);
	}
?>