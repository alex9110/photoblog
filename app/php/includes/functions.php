<?php 
	require_once("config.php");   //подключим настройки
//получим масив с настройками
//функцыя для подлючения к базе данных если все ок возвращает переменную с текущим подлючением
	function connect_db(){
		$config = config();			//получим настройки для подлючения к базе
		//создаем подключение к базе
		$connection = mysqli_connect($config['dbhost'], $dbuser = $config['dbuser'], $dbpass = $config['dbpass'], $config['dbname']); 
		return $connection;
		// проверяем подключение
		if (mysqli_connect_errno()) {							//возвращает либо ошибку либо ноль
			die("DAta basese connection failed: " .
				mysqli_connect_error() .						//ошмбка
				")" .mysqli_connect_errno() . ")"				//номерошибки
			);
		}
	}
// функцыя вернет двохуровневый массив записей с БД
	function get_data($table){
		$connection = connect_db(); //подключится к базе
		$query = "SELECT * FROM {$table}"; 
		$result  = mysqli_query($connection, $query);
		//проверяем нет ли ошибок запроса
	 	if (!$result) {
	 		die("database query faled.");
	 	}
	 	while ($row = mysqli_fetch_assoc($result)) { 						//пока есть что присвоить работаем 	
		 		$data[] = $row;											//пихаем масывы в масив для ответа 	
		}
		 // шаг 4. отпустьть возвращенные данные
		mysqli_free_result($result);			
		 //5закрыть соединение
		mysqli_close($connection);
		return $data;
	}

	//функцыя вернет строку все фотки в виде не нумерованого списка ul, параметры имя таблицы с которой нужно взять фтки
	// но в данном случае фото будут необхдимого размера даже если он не указан б базе
	// но путь фоткам ПОКА Что только во временной директории
	function show_normal_size_photo($table_name){
		$config = config();			//подтяним фаил с настройками
		$content = "";
		$li = "";
		$data = get_data($table_name);
		//масив для хранения путей к фоткам
		$path = array();
		for ($i=0; $i < count($data); $i++) { 		//пройдем по масиву по елементам первого уровня 		
		 	$path[] = $config['img_folder'].$data[$i]["name"];
		}
		//если масив не пустой
		if ( 0 < count($path)) {
			$properties = set_size($path);

			for ($i=0; $i < count($properties); $i++) { 		//пройдем по масиву по елементам первого уровня 
			  	$path = $properties[$i]["path"];		
			  	$width = $properties[$i]["width"];
			  	$height = $properties[$i]["height"];  

			  	$li = '<li class="gallery-box" style="width:'.$width.'%">'.
			 	 		  '<div class="heigth" style="padding-top:'.$height.'%"></div>'.
			 	 	 	  '<div class="gallery-box__image" style="background-image: url('.$path.')"></div>'.
			  		  '</li>';
			  	$content .= $li;
			}
			return '<ul class="temporarily">'.$content.'<li class = "message">не сохраненный ряд фоток можите добавить ещё фото в ряд или сохранить его в таком виде</li></ul>';	
		}else{
			return '<ul class="temporarily"><li class="message">вы пока что не выбрали ни одного фото чтобы создать новый ряд с фотками выберите фото и загрузите</li></ul>';
		}				
	}
	//функцыя вернет строку все фотки в виде не нумерованого списка ul, параметры имя таблицы с которой нужно взять фтки
	
	function show_photo($table_name){
		$config = config();		//подтяним фаил с настройками
		$data = get_data($table_name);
		$path = $config['img_folder'].'example.jpg'; //путь к стандартной каотинке
		$content = "";
		$ul = '<ul id="photo_wall" class="'.$table_name.'">';
		$li = "";
		$max = 0;
		$content ='<ul id="photo_wall" class="'.$table_name.'"><li class="gallery-box" style="width:44%">'.
			 		  '<div class="heigth" style="padding-top:66.666%"></div>'.
			 	 	  '<div class="gallery-box__image" style="background-image: url('.$path.')"></div>'.
		 		  '</li><p style="margin-top:50px;">Привет, здесь пока что нет фото, но это ненадолго)</p></ul>';
		if (count($data) < 1) {
			return $content;	 //если альбом пучтой вернем стандартное значение
		}
		for ($i=0; $i < count($data); $i++) { 		//пройдем по масиву по елементам первого уровня 
		 	$path = $config['img_folder'].$data[$i]["name"];		
		 	$width = $data[$i]["width"];
		 	$height = $data[$i]["height"];  
	 	
		 	$li = '<li class="gallery-box" style="width:'.$width.'%">'.
			 		  '<div class="heigth" style="padding-top:'.$height.'%"></div>'.
			 	 	  '<div class="gallery-box__image" style="background-image: url('.$path.')"></div>'.
		 		  '</li>';
		 	
		 	if ($max > 95) {
		 		$ul .= "</ul>";
		 		$ul .= "<ul>".$li;
		 		$max = 0;
		 	}else{
		 		$ul .= $li;
		 	} 	
		 	$max += $width +1;		//если сумарная ширина фоток с марджинами будет блиска к 100% нужно запихнуть li в ul
		}
			return $ul.'</ul>';				
	}

//функцыя вернет строку все фотки в виде не нумерованого списка ul, параметры 1имя таблицы с которой нужно взять фтки
//не обезятельные параметры, 2с какого ряда начать брать фотки 3сколько рядов взять	
	function show_photo_r($table_name, $from=false, $how=false){
		$config = config();		//подтяним фаил с настройками
		$data = get_data($table_name);
		$path = $config['img_folder'].'example.jpg'; //путь к стандартной каотинке
		$content = ""; 
		$ul = '<ul id="photo_wall" class="'.$table_name.'">';
		$li = "";
		$max = 0;
		//зададим клас чтобы всекда знать какой именно альбом мы показываем
		$content ='<ul id="photo_wall" class="'.$table_name.'"><li class="gallery-box" style="width:44%">'.
			 		  '<div class="heigth" style="padding-top:66.666%"></div>'.
			 	 	  '<div class="gallery-box__image" style="background-image: url('.$path.')"></div>'.
		 		  '</li><p style="margin-top:50px;">Привет, в этом альбоме пока что нет фото, но это ненадоло)</p></ul>';
		if (count($data) < 1) {
			return $content;	 //если альбом пучтой вернем стандартное значение			
		}
		if (!$how || !$how) { //если один из елементов не указан
			$to = count($data);
			$first = 0;
		}else{
			/////////////////////////////////////////////////////////
			$row = array();
			$info = array();
			$amount = 0;		//количество фоток в данном ряду
		for ($i=0; $i < count($data); $i++){
			$width = $data[$i]["width"];
			$max += $width +1;
			$amount +=1;		//количество фоток в данном ряду

			if ($max > 95) {
				$info['maunt'] = $amount; //количество фоток в данном ряду
				$info['index'] = $i+1-$amount;		//общий порядковый номер первого фото в данном ряду отчет с нуля
				$row[] = $info;
				$max = 0;
				$amount =0;
			}		
		}
		//нужно узнать с какого по счету элемента начинаеться запрашиваемый ряд 
		//и какой елемент последний для выдачи
		$first = $row[$from]['index']; //номер первого фото которое нужно отдать
		$to = $row[$from+$how-1]['index']+$row[$from+$how-1]['maunt'];	//номер елемента до которого выдаем не включительно
		// return $last;
////////////////////////////////////////////////////////////////
		}	
		for ($i=$first; $i < $to; $i++) { 		//пройдем по масиву по елементам первого уровня 
		 	$path = $config['img_folder'].$data[$i]["name"];		
		 	$width = $data[$i]["width"];
		 	$height = $data[$i]["height"];  
	 	
		 	$li = '<li class="gallery-box" style="width:'.$width.'%">'.
			 		  '<div class="heigth" style="padding-top:'.$height.'%"></div>'.
			 	 	  '<div class="gallery-box__image" style="background-image: url('.$path.')"></div>'.
		 		  '</li>';
		 	
		 	if ($max > 95) {
		 		$ul .= "</ul>";
		 		$ul .= "<ul>".$li;
		 		$max = 0;
		 	}else{
		 		$ul .= $li;
		 	} 	
		 	$max += $width +1;		//если сумарная ширина фоток с марджинами будет блиска к 100% нужно запихнуть li в ul
		}
			return $ul.'</ul>';				
	}
	function show_woks(){
		$config = config();
		$table = $config['portfolio'];
		$path = $config['аlbum_covers'];

		$folder = $config['аlbum_covers'];
		$content = '<div class="rubric_box">'.
						'<img src="'.$path.'example.jpg" class="rubric">'.
						'<div class="designation">'.
							'<h3>Привет</h3>'.
							'<p>Пока что у тебя нет ни одной работы, но ты можешь добавить их прямо сейчас</p>'.
						'</div>'.
					'</div>';
		$data = get_data($table); 	//получим все днные с базы
		//если массив пустой значит работ нет
		if (count($data) < 1) {
			//echo $content;
			return $content;
		}
		$content ="";
		for ($i=0; $i < count($data); $i++) { 
			$path = $folder.$data[$i]["title_photo"];		
			$titles = $data[$i]["job_titles"];
			$desc = $data[$i]["job_description"];  
			$table = $data[$i]["table_photo"];	//таблица с фотками данного альбома

			$content .= '<div class="rubric_box">'.
							'<a href="gallery.php?current='.$table.'"></a>'.
							'<img src="'.$path.'" class="rubric">'.
							'<div class="designation">'.
								'<h3>'.$titles.'</h3>'.
								'<p>'.$desc.'</p>'.
							'</div>'.
						'</div>';
		}
		return $content;
	}
	//соранения фото 
	function save_photo(){
		$config = config();		//подтяним фаил с настройками
		$data = array(); //для ответа
		$new_photo = array();   //масив для хранения имен и инфы о новых файлах

		    $error = false;
		    $uploaddir = $config['img_folder']; // . - текущая папка где находится submit.php
		    // Создадим папку если её нет
		    if( ! is_dir( $uploaddir ) ) mkdir( $uploaddir, 0777 );
		 
		    // переместим файлы из временной директории в указанную
		    foreach( $_FILES as $file ){
		    	 $new_name = rename_photo($file['name']);		//получим новое имя для фото
		        if( move_uploaded_file( $file['tmp_name'], $uploaddir . $new_name ) ){
		        	 // если фотка сохранилась запишем данные во временную таблицу
		        	save_info_t($new_name);
		           // если фотка сохранилась запишем пут к ней
		            $new_photo[] = $uploaddir.$new_name;
		        }
		        else{
		            $error = true;
		        }
		    }
		    // $properties = set_size($new_photo); 
		    $content = show_normal_size_photo( $config['tmp'] );
		    $data = $error ? array('error' => 'Ошибка загрузки файлов.') : array('photo' => $content);

		    return $data;
	}
	 //создания и соранения альбома 
	function save_title_photo(){
		$config = config();		//подтяним фаил с настройками
		$data = array();		 //для ответа
		//$new_photo = array();   //масив для хранения имен и инфы о новых файлах

		    $error = false;
		    $uploaddir = $config['аlbum_covers']; 
		    // Создадим папку если её нет
		    if( ! is_dir( $uploaddir ) ) mkdir( $uploaddir, 0777 );
		 
		    // переместим файлы из временной директории в указанную
		    foreach( $_FILES as $file ){
		    	 $new_name = rename_photo($file['name']);		//получим новое имя для фото
		        if( move_uploaded_file( $file['tmp_name'], $uploaddir . $new_name ) ){
		        	 // если фотка сохранилась сохраним данные в таблицу для портфолио и создадим таблицу в БД для нового альбома

		        	
		           // если фотка сохранилась запишем пут к ней
		           // $new_photo[] = $uploaddir.$new_name;
		        }
		        else{
		            $error = true;
		        }     
		    }
		  $data = $error ? array('error' => 'Ошибка загрузки файлов.') : array('album' => "альбом создан", 'photo_name'=>$new_name);
		    return $data;
	}

	function сreate_album($photo, $title, $desc){
		$config = config();
		$table = $config['portfolio'];
		$data = get_data($table);
		 $max_id = 0;
		//узнаем максимальній id
		 for ($i=0; $i < count($data); $i++) { 
		 	$id = $data[$i]['id'];
		 	$max_id = ($max_id <= $id)? $id : $max_id;
		 	
		 }
		 $max_id += 1;
		 $new_table = 'work_'.$max_id;
		 $connection = connect_db(); //подключится к базе
		 //создадим таблицу для альбома
		 $query = "CREATE TABLE {$new_table} ( id INT(11) NOT NULL AUTO_INCREMENT ,  name VARCHAR(100) NOT NULL , width DOUBLE NOT NULL , height DOUBLE NOT NULL , PRIMARY KEY (id)) ENGINE = InnoDB"; 
		
		 $result  = mysqli_query($connection, $query);
		 //проверяем нет ли ошибок запроса
	 	if (!$result) {
	 		die("database query faled.");
	 		return false;
	 	}
	 	//запишем данные об альбоме в таблицу портфолио
	 	$query = "INSERT INTO  {$table} (id, title_photo, job_titles, job_description, table_photo) VALUES (NULL, '$photo', '$title', '$desc', '$new_table')";
	 	$result  = mysqli_query($connection, $query);
	 	if (!$result) {
	 		die("database query faled.");
	 		return false;
	 	}
		//  // шаг 4. отпустьть возвращенные данные			
		  //5закрыть соединение
		mysqli_close($connection);
		return true;
	}
	//переместить записи о фотках из временной таблицы в нужную
	// парам имя таблицы куда перемещать
	function move_photo($table){
		$config = config();			//подтяним фаил с настройками
		$data = get_data($config['tmp']);
		//масив для хранения путей к фоткам
		$path = array();
		for ($i=0; $i < count($data); $i++) { 		//пройдем по масиву по елементам первого уровня 		
		 	$path[] = $config['img_folder'].$data[$i]["name"];
		}
		$param = array();
		$element = array();
		//если масив не пустой
		if ( 0 < count($path)) {
			$properties = set_size($path);
			$arr = array();                               		// создам массив он мне нужен 
			for ($i=0; $i < count($properties); $i++) { 		//пройдем по масиву по елементам первого уровня 
				$path = $properties[$i]["path"];	
		        $arr = explode("/", $path);               		 //дробим путь на масив регулируемся /
		       
		        $element['name'] = end($arr);                   			 //берём последний елемент массива теперь имеем имя
			  	$element['width'] = $properties[$i]["width"];
			  	$element['height'] = $properties[$i]["height"];  
			  	$param[] = $element;
			}
			$connection = connect_db();
			for ($i=0; $i < count($param); $i++) {
				$name = $param[$i]['name'];
				$width = $param[$i]['width'];
				$height = $param[$i]['height'];
				//формируем запрос
				$query = "INSERT INTO {$table} (id, name, width, height) VALUES (NULL, '$name', '$width', '$height')";
				//делаем запрос
				$result  = mysqli_query($connection, $query);

				if (!$result) {
			 		die("database query faled.");
			 	}	
			}
			mysqli_close($connection);
			remove_info();
			return true;	
		}else{
			return "вы не загрузили ни одной фотки выберите и загрузите фото";
		}
	}
//записывет инфу о фотках в таблицу БД для временного хранения 
	function save_info_t($photo_name){
		$config = config();

		$connection = connect_db();

		//формируем запрос
		$query = "INSERT INTO {$config['tmp']} (id, name) VALUES (NULL, '$photo_name')";
		//делаем запрос
		$result  = mysqli_query($connection, $query);

		if (!$result) {
	 		die("database query faled.");
	 	}
		
		mysqli_close($connection);
	}

//перейменования фоток
	function rename_photo($old_name){
		$config = config();
		if ($old_name !="") {
			//узнаем расширение файла, картинки
			$arr = array();                               		 // создам массив он мне нужен 
	        $arr = explode(".", $old_name);               		 //дробим имя на масив регулируемся точкой
	        $file_extension = ".".end($arr);                    //берём последний елемент массива лепим точку теперь имеем разширение файла
		}
		$random_name = uniqid('img_');		//генерируем случайное имя
		$new_name = $random_name.$file_extension;
		//если фаил с таким именем уже есть добавим к имени 'x2'
		$exist = file_exists($new_name);
		if ($exist) {
			$rand = rand(0, 100);
			$new_name = 'x'.$rand.$new_name;
			$exist = file_exists($new_name); //проверим еще раз
		}
		if ($exist) {
			$rand = rand(0, 100);
			$new_name = 'x2'.$rand.$new_name;
		}

		return $new_name;
	}
	//удалит все записи во временной таблице
	function remove_info(){
			$config = config();
			$table = $config['tmp'];
		 
			$connection = connect_db();
			$query = "DELETE FROM {$table}";
			$result  = mysqli_query($connection, $query);
			//проверяем нет ли ошибок запроса
		 	if (!$result) {
		 		die("database query faled.");
		 	}
			mysqli_close($connection);
	}
	//удалть фото принимает путь и таблицу с которой нужно удалить заись об этой фотке
	function remove_photo($path, $table){
			$arr = array();                               		// создам массив он мне нужен 
	        $arr = explode("/", $path);               		 //дробим путь на масив регулируемся /
	        $name = end($arr);                   			 //берём последний елемент массива теперь имеем имя
	       
		 $del = unlink ( $path );
		 if ($del == true) {
			$connection = connect_db();
			$query = "DELETE FROM {$table} WHERE name = '$name'";
			$result  = mysqli_query($connection, $query);
			//проверяем нет ли ошибок запроса
		 	if (!$result) {
		 		die("database query faled.");
		 	}
			mysqli_close($connection);
		 }
	}
	//функцыя для задания размеров фоткам таким образом чтобы все были выровняны по высоте и вмещались в один ряд
	//парамеры масив с путями к фоткам
	//вернет 2уровневый массив с первый уровень елемент в торой путь и свойства нужная ширина и высота
	function set_size($new_photo){
		$properties =array();    	//масив для ответа
		$info = array();       		//хранения инфы о новых файлах внутри $new_photo
		$margin = 0.5;          	//марджин блоков с фотками
		$width = array();   		//храить новые ширины каждого изображения
		$amount = count($new_photo);  //количесво элементов

		$i = 0;
		while ( $i < $amount ) {
			$path = $new_photo[$i];
			//функцыя getimagesize() вернет массив с размерами фала
            // узнать реальные пропорцыи делим высоту на ширину 
            $image_size = getimagesize($path);
            //если по каким то причинам размеры не получены установим стандартные
            if ( ($image_size[1]||$image_size[0]) == null){
            	$image_size[1] = 3;
            	$image_size[0] = 4;
            }
			$info['prop'] = ($image_size[1]/$image_size[0])*100;
			$info['path'] = $path; //путь к файлу пока что относительно submit.php
	        $new_photo[$i] = $info;

			$i++;
		}
		//нужно узнать какое фото самое высокое, если оно не одно. (судим по пропорцыям)
		$max_height = $new_photo[0]['prop']; //допустим оно самое большое
		if ( $amount > 1) {
		    $i = 1;
		    while ( $i < $amount ) {
		        //ищем самый высокий
		        $max_height = ($max_height<$new_photo[$i]['prop']) ? $new_photo[$i]['prop'] : $max_height;
		        $i++;
		    }
		}
		$width_start = 100/$amount - $margin * 2;  //начальная ширина фоток, в процентах без марджина
		//выровнять все блоки по $max_height с сохранением пропорцый для этого увеличим ширину у низких блоков
		//узнать во сколько раз необходимо увеличить ширину 
		$totalWidth = 0;    //сумарная ширина выровняных блоков
		$i = 0;
		while (  $i < $amount ) {
		    $сoeff = $max_height/$new_photo[$i]['prop']; //узнаем в сколько раз самый большой блок высше текущего
		    // узнать новую ширину текущего блока
		    // новая ширина блока необходимая для выравнивания его же по высоте с самым высоким
		    $width[] = $сoeff*$width_start;
		    //узнать сумарную ширину всех блоков в процентах после того как они выровнены по высоте
		    $totalWidth += $width[$i];
		    $i++;
		}
		//узнать в сколько раз ширина родительского блока меньше чем сумма ширин всех блоков, перед этим минус все маржини
		$mainKof = ( 100-$margin*($amount*2) )/$totalWidth;
		//умножить ширину каждого блока на получившийся коэфицыент чтобы узнать необходимую правильную ширину для фотки
		$i = 0;
		while( $i < $amount ){
		    $width[$i] = $width[$i] * $mainKof;
		    //формируем ответ
		 	$info['height'] =  $new_photo[$i]['prop'];
		 	$info['width'] = $width[$i];
		 	$info['path'] =  $new_photo[$i]['path'];
		 	$properties[] = $info;		 	
		    $i++;
		}
		return $properties;
	}
 ?>