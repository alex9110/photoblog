<?php
	function config(){	//настройки
		$data = array(
			'dbhost'=>"localhost",			//хост
			'dbuser'=>"root",				//логин к базе
			'dbpass'=>"",					//пароль к базе
			'dbname'=>"photoblog",			//имя базы
			//'dbname'=>"test22",			//имя базы
			'main'=>"main",					//имя таблицы админа
			'index'=>'index_photo',			//имя таблицы для фоток индексной страницы
			'tmp'=>'temporarily',			//имя таблицы для временного хранения
			'portfolio'=>'portfolio',		//имя таблицы с данными обо всех альбомах
			'price'=>'price',				//имя таблицы для странички услуги и цены
			'extra_service'=>'extra_service',  //имя таблицы дополнительные услуги
			'profile'=>'profile',				//имя таблицы странички профаил
			'contacts'=>'contacts',				//имя таблицы с контактными данными
			'img_folder'=>'../../all_photos/photo/',				//папка с фотками
			'аlbum_covers'=>'../../all_photos/covers/',		//папка для хранения обложок альбовом
			'price_image'=>'../../all_photos/price/',		//папка для хранения фоток услуг и цен
			'avatar'=>'../../all_photos/avatar/'			//папка для хранения авы
		);
		return($data);
	}
?>