<?php 
	require_once("config.php");   //подключим настройки
//из строки создает список li елементов регулируеться /
		function build_list($text){
			$arr = array();
			$li = '';
				if ($text !="") {
					$arr = array();                               		 // создам массив он мне нужен 
			        $arr = explode("/", $text);               		 //дробим имя на масив регулируемся 
				}
				for ($i=0; $i < count($arr); $i++) { 
					$li .= '<li>'.$arr[$i].'</li>';
				}
				return($li);
		}
	function redirects($url = 'login.php'){
		header('Location: '.$url);
		exit;
	}
//функцыя для подлючения к базе данных если все ок возвращает переменную с текущим подлючением
	function connect_db(){
		$config = config();			//получим настройки для подлючения к базе
		//создаем подключение к базе
		$connection = mysqli_connect($config['dbhost'], $dbuser = $config['dbuser'], $dbpass = $config['dbpass'], $config['dbname']); 
		// проверяем подключение
		if (mysqli_connect_errno()) {							//возвращает либо ошибку либо ноль
			die("DAta basese connection failed: " .
				mysqli_connect_error() .						//ошмбка
				")" .mysqli_connect_errno() . ")"				//номерошибки
			);
		}
		return $connection;
	}
	//установыть новый logi и password
	function new_log_pas($login, $pas, $pas2){
		$config = config();
		$table = $config['main'];
		if ( valid($login, $pas) ) {
			if ($pas2 === $pas) {
				$hash = password_hash($pas, PASSWORD_BCRYPT);  //хешируем значение перед отравкой браузеру
				$connection = connect_db();
				$login = mysqli_real_escape_string($connection, $login);
				$query = "UPDATE {$table} SET name = '$login', password = '$hash' WHERE id = 1"; 
				$result  = mysqli_query($connection, $query);
				//проверяем нет ли ошибок запроса
			 	if (!$result) {
			 		die("database query faled.");
			 	}			
				 //5закрыть соединение
				mysqli_close($connection);
				if ($result === true) {
					return true;
				}
			}
		}
		return false;
	}
//прроверка залогинен ли пользователь
	function login_test(){
	// если у нас есть сессионная кука...
		if ( !empty($_COOKIE[session_name()]) ) {
			if(!isset($_SESSION)){ 
					session_start(); 
				}
			if ( isset($_SESSION['user']) ) {
				if ($_SESSION['user'] === 'admin') {
					
					return true;
				}
			}
		}
		return false;
	}
	//проверим коректность введенных данных
	function valid($login, $pas){
		$result = false;
		$login = trim($login);
		$pas = trim($pas);

		if (strlen($login) < 3 || strlen($login) > 10) {
			return false;
		}
		if (strlen($pas) < 4 || strlen($pas) > 20) {
			return false;
		}
		return true;
	}
	//проверка логина и пароля
	function login($login, $pas){
		$config = config();
		$table = $config['main'];
		$result = false;
		$data = get_data($table);
		$correct_login = $data[0]['name'];
		$hash_pas = $data[0]['password'];
		//если логин верный проверим пароль
		if ($correct_login === $login) {
			$result = password_verify($pas, $hash_pas);
		}
		return $result;
	}
// функцыя вернет двохуровневый массив записей с БД
//все рады если второй параметр не задан или конкретный ряд если зада
	function get_data($table, $column = '*', $where = false){
		$data = array();
		$connection = connect_db(); //подключится к базе
		$query = "SELECT {$column} FROM {$table} ORDER BY id ASC"; 
		//если задан третий параметр формируем запрос с учетом этого параметра
		if ($where) {
			$query = "SELECT {$column} FROM {$table} {$where} ORDER BY id ASC";
		}
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
	// получть контакты, в качестве парам названия категории контактов
	//вернет только те в который есть значения value
	function get_contacts($category){
		$config = config();
		$table = $config['contacts'];
		$data = get_data($table);
		$arr = array();
		$info = array();
		for ($i=0; $i < count($data); $i++) { 
			// $name = $data[$i]['name'];
			if ($data[$i]['value'] != "" && $data[$i]['category']==$category) {
				 $info['name'] = $data[$i]['name'];
				 $info['value'] = $data[$i]['value'];
				 $arr[] = $info;
			}	
		}
		return $arr;
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
			return '<ul class="temporarily"><li class="message">Не сохраненный фоторяд!!! Вы можите добавить ещё фото в данный ряд или сохранить его в таком виде.</li>'.$content.'</ul>';	
		}else{
			return '<ul class="temporarily"><li class="message">Временный фоторяд не обнаружен, чтобы создать новый фоторяд выберите фото и загрузите</li></ul>';
		}				
	}
	//функцыя вернет строку все фотки в виде кждый ряд список ul, параметры имя таблицы с которой нужно взять фтки
	
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
	//показать все контакты
	function show_all_contacts(){
			$config = config();
			$table = $config['contacts'];
			$data = get_data($table);
			$li = '';
			for ($i=0; $i < count($data); $i++) { 
				$name = $data[$i]['name'];
				$value = $data[$i]['value'];
				$li .= '<li class="contacts"><p>'.$name.'</p><input name="'.$name.'" type="text" value="'.$value.'" class="cont_input"></li>';
			}
			return $li;
	}

/*функцыя вернет строку все фотки в виде кждый ряд список ul, параметры 1 имя таблицы с которой нужно взять фтки? не обезятельные параметры, 2 с какого ряда начать брать фотки 3 сколько рядов взять	есл начального ряда не существует фернет false, если ряд есть но ету нужного количества рядов вернется то количество которое осталось, ВНИМАНИЯ если указан параметр 2 то обезательным становиться и третий параметр, иначе все будет работать будто указан только первый параметр,если парам 3 =0 функцыя вернет все оставшися рады, какже функцыя позволяет плучить последний ряд в фото для этого достаточно в качестве второго параметра передать 'last'*/
	function show_photo_r($table_name, $from=false, $how=false){
		$config = config();		//подтяним фаил с настройками
		$data = get_data($table_name);
		$path = $config['img_folder'].'example.jpg'; //путь к стандартной каотинке
		$content = ""; 
		$ul = '<ul class="'.$table_name.'">';
		$li = "";
		$max = 0;
		//зададим клас чтобы всекда знать какой именно альбом мы показываем
		$content ='<ul id="demo" class="'.$table_name.'"><li class="gallery-box" style="width:44%">'.
			 		  '<div class="heigth" style="padding-top:66.666%"></div>'.
			 	 	  '<div class="gallery-box__image" style="background-image: url('.$path.')"></div>'.
		 		  '</li><p style="margin-top:50px; ">Привет, в этом альбоме пока что нет фото, но это ненадолго)</p></ul>';
		if (count($data) < 1) {
			return $content;	 //если альбом пустой вернем стандартное значение			
		}
		if ($from === false || $how === false) { //если один из елементов не указан
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
			if ($from === 'last') { //если нужен последний ряд
				//узнать номер последнего ряд
				$last = count($row)-1;
			 	$first = $row[$last]['index']; //номер первого фото которое нужно отдать
			 	$how = 0;
			 }else{ 
			 	@$first = $row[$from]['index']; //номер первого фото которое нужно отдать
			 	
			 }
			// если указали ряд которого нет
			if ($first === null) {
				return false;
			}
			if ($how == 0) {
				$to = count($data);
			}else{
				@$to = $row[$from+$how-1]['index']+$row[$from+$how-1]['maunt'];	//номер елемента до которого выдаем не включительно
				//если запросили слишком бльшой порядковый номер которого нет в таблице
				if ($to == null) {
					$to = count($data);
				}
			}
			
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
		 		$ul .= '<span class="delete"></span></ul>';
		 		$ul .= '<ul class="'.$table_name.'">'.$li;
		 		$max = 0;
		 	}else{
		 		$ul .= $li;
		 	} 	
		 	$max += $width +1;		//если сумарная ширина фоток с марджинами будет блиска к 100% нужно запихнуть li в ul
		}
			return $ul.'<span class="delete"></span></ul>';				
	}
	function show_woks(){
		$config = config();
		$table = $config['portfolio'];
		$path = $config['аlbum_covers'];

		$folder = $config['аlbum_covers'];
		$content = '<div class="rubric_box">'.
						'<div class="adapt_box">'.
							'<div class="heigth"></div>'.
							'<div class="image_box" style="background-image: url('.$path.'example.jpg)"></div>'.
						'</div>'.
						'<div class="designation">'.
							'<h3>Привет</h3>'.
							'<p>Пока что у тебя нет ни одной работы, но ты можешь добавить их прямо сейчас</p>'.
						'</div>'.
					'</div>';
		$data = get_data($table); 	//получим все днные с базы
		//если массив пустой значит работ нет
		if (count($data) < 1) {
			return $content;
		}
		$content ="";
		for ($i=0; $i < count($data); $i++) { 
			$path = $folder.$data[$i]["title_photo"];		
			$titles = $data[$i]["job_titles"];
			$desc = $data[$i]["job_description"];  
			$table = $data[$i]["table_photo"];	//таблица с фотками данного альбома

			$content .= '<div class="rubric_box"><span class="delete '.$table.'"></span>'.
							'<a href="gallery.php?current='.$table.'"></a>'.
							'<div class="adapt_box">'.
								'<div class="heigth"></div>'.
								'<div class="image_box" style="background-image: url('.$path.')"></div>'.
							'</div>'.
							'<div class="designation">'.
								'<h3>'.$titles.'</h3>'.
								'<p>'.$desc.'</p>'.
							'</div>'.
						'</div>';
		}
		return $content;
	}
	function show_prices(){
		$config = config();
		$table_name = $config['price'];
		$data = get_data($table_name);
		$image_folder =  $config['price_image'];

		$service_name = "";
		$image_name = "";
		$li = "";
		$content = "";
		
		$contact_content = "";
		$phones= get_contacts('phone');
		//получим наши номера телефонов
		for ($i=0; $i < count($phones) ; $i++) { 
			$value = $phones[$i]['value'];
			$contact_content .= '<div class="tel">'.$value.'<i class="icon-phone"></i></div>';
		}
		//если таблица пуста дадим стандартное значение
		if (count($data)<1) {
			$content =  '<div class="service">'.
							'<p class="service_name">названия услуги</p>'.
							'<div class="photo" style="background-image:url('.$image_folder.'example.jpg)"></div>'.
								'<div class="desc">'.
									'<p class="cost">"СТОИМОСТЬ" <br><span>12 000 ₽</span></p>'.
									'<ul>
									<li>- первый элемент списка,</li>
									<li>- второй элемент списка,</li>
									<li>- третий элемент списка,</li>
									<li>- какой-то элемент списка,</li>
									<li>-  последний элемент в данном списке выделяется жирным шрифтом, пример ниже,</li>
									<li>- детальней за телефонами.</li>
									</ul>'.
								'</div>'.
							'<div class="phones">'.$contact_content.'</div>'.
						'</div>';
		}
		for ($i=0; $i < count($data); $i++) { 
			$id = 'i'.$data[$i]['id'];
			$service_name = $data[$i]['service_name'];
			$cost = $data[$i]['cost'];
			$image_name = $data[$i]['image_name'];
			$li = build_list($data[$i]['description']);		
			$content .= '<div class="service"><span class="delete '.$id.'"></span>'.
							'<p class="service_name">'.$service_name.'</p>'.
							'<div class="photo" style="background-image:url('.$image_folder.$image_name.')"></div>'.
								'<div class="desc">'.
									'<p class="cost">"СТОИМОСТЬ" <br><span>'.$cost.'</span></p>'.
									'<ul>'.$li.'</ul>'.
								'</div>'.
							'<div class="phones">'.$contact_content.'</div>'.
						'</div>';
		}
		return $content;
	}
// выведет все с таблицы дополнительных услуг
	function show_extra_service(){
		$config = config();
		$table_name = $config['extra_service'];
		$data = get_data($table_name);
		$content = '<div class="extra_service">'.
						'<h2>Дополнительные услуги</h2>'.
						'<ul>'.
							'<li>-Фотокнига из искусственной кожи в фотобоксе размер 20х20 от 8.000 тысяч рублей;</li>'.
							'<li>- Фотокнига премиум класса в кожаном переплете 30х30 от 12.000 тысяч рублей;</li>'.
							'<li>-Авторская, художественная ретушь 1 фото - 250 рублей;</li>'.
							'<li>- Передача всех исходных файлов в формате jpg 2.000 тысячи рублей;</li>'.
							'<li>- Печать фотохолста от 3.000 тысячи рублей;</li>'.
						'</ul>'.
					'</div>';
		if (count($data)>0) {
			$content = "";
		}
		for ($i=0; $i < count($data); $i++) { 
			$service_name = $data[$i]['service_name'];
			$li = build_list($data[$i]['description']);	
		
		 $content .= '<div class="extra_service">'.
						'<h2>'.$service_name.'</h2>'.
						'<ul>'.$li.'</ul>'.
					'</div>';
		}
		return $content;
	}
	//сформирует контент для страницы профаил
	function show_profile(){
		$content = '<div class="avatar_box"><img src="../../all_photos/avatar/avatar.jpg" class="avatar"></div>'.
				'<p class="desk" ><span>Lorem ipsum</span> <br>sit amet, consectetur adipisicing elit. Odit cum eos ex, nihil explicabo maiores totam officia repellendus tenetur magni officiis maxime eum est debitis quos commodi quis aut itaque sed aspernatur, incidunt saepe. Aperiam ea rerum, nihil quae soluta nemo. Hic eaque eligendi, expedita aliquam, reiciendis minima, reprehenderit, illo molestiae dolore explicabo eum numquam? Cum laborum quasi id soluta perspiciatis adipisci, ipsam tenetur cumque incidunt iusto culpa, illum aspernatur similique beatae repudiandae modi quos explicabo laboriosam, tempore nesciunt deleniti eos consequuntur ex placeat. Dignissimos excepturi animi voluptas doloremque eum natus debitis porro beatae, earum nobis, molestiae nemo suscipit. Repellendus?</p>';

		$config = config();
		$table = $config['profile'];
		$data = get_data($table);
		if (count($data) > 0) {
			$content = '<div class="avatar_box"><img src="'.$config['avatar'].$data[0]['photo_name'].'"class="avatar"></div>'.
						'<p class="desk" ><span>'.$data[0]['article_title'].'</span><br>'.$data[0]['article_text'].'</p>';
		}

		 return $content;
	}
//функцыя для изменения контактов
	function set_contacts(){
	  $arr = $_POST;
	  $config = config();
	  $table = $config['contacts'];
	  reset($arr);
	  $i =1;
	  $connection = connect_db(); //подключится к базе
	  while (list($key, $val) = each($arr)) {
	    $query = "UPDATE {$table} SET name = '$key', value = '$val' WHERE id = '$i'";
	    $result  = mysqli_query($connection, $query);
	    $i++; 
	    //проверяем нет ли ошибок запроса
	    if (!$result) {
	      die("database query faled.");
	    }     
	  }
	  return true;
	  //5закрыть соединение
	  mysqli_close($connection);
	}
	//соранения фото для галерей с записю во временную таблицу
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
		    $content = show_normal_size_photo( $config['tmp'] );
		    $data = $error ? array('error' => 'Ошибка загрузки файлов.') : array('photo' => $content);

		    return $data;
	}
	//обычное сохранения фото принимает папку в которую нужно сохранить
	function save_title_photo($uploaddir=false){
		
		if (!$uploaddir) {		//если забыли указать папку выходим из 
			return;
		}
		$config = config();		//подтяним фаил с настройками
		$data = array();		 //для ответа

		    $error = false;
		    
		    // Создадим папку если её нет
		    if( ! is_dir( $uploaddir ) ) mkdir( $uploaddir, 0777 );
		 	$file = 0;
		    // переместим файлы из временной директории в указанную
		    foreach( $_FILES as $file ){
		    	//$count ++;
		    	 $new_name = rename_photo($file['name']);		//получим новое имя для фото
		        if( move_uploaded_file( $file['tmp_name'], $uploaddir . $new_name ) ){
		        }
		        else{
		            $error = true;
		        }     
		    }
		  $data = $error ? array('error' => 'Ошибка загрузки файлов.') : array('status' => "фото сохранено", 'photo_name'=>$new_name);
		    return $data;
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
	//функцыя новой базы данных
	function create_db($db_name){
	    $config = config();     //получим настройки для подлючения
	    // соединение с сервером базы данных
	    $connection = mysqli_connect($config['dbhost'], $dbuser = $config['dbuser'], $dbpass = $config['dbpass']); 
	    // проверяем подключение
	    if (mysqli_connect_errno()) {             //возвращает либо ошибку либо ноль
	      die("DAta basese connection failed: " .
	        mysqli_connect_error() .            //ошмбка
	        ")" .mysqli_connect_errno() . ")"       //номерошибки
	      );
	    }
		//создадим новую базу данных
		$query = "CREATE DATABASE {$db_name}";
		$result  = mysqli_query($connection, $query);
		//проверяем нет ли ошибок запроса
	 	if (!$result) {
	 		die("database query faled.");
	 	}else{
	 		return true;
	 	}
		 //5закрыть соединение
		mysqli_close($connection);
		return false;
	}
	function create_tables(){
		$connection = connect_db();
		$data = receive_requests();
		for ($i=0; $i < count($data); $i++) { 
			$query = $data[$i]; 
			$result  = mysqli_query($connection, $query);
			if (!$result) {
				die("database query faled.");
			}
		}
		mysqli_close($connection);
	}
	//изменения данных страницы профаил, удаление старых данных тоесть фотки
	function change_profile($photo_name, $title, $article){
	    $config = config();
	    $table_name = $config['profile'];
	    $arr = get_data($table_name);
	    $connection = connect_db();
	   // проверим не наличия записи в нашей таблице 
	    if ( count($arr) > 0 ) {
    		//если запись значит есть фото значит его нужно снести
    		$old_photo_name = $arr[0]['photo_name'];
    		$path = $config['avatar'].$old_photo_name;
	        $query = "UPDATE {$table_name} SET photo_name = '$photo_name', article_title = '$title', article_text = '$article'"; 
	        unlink($path);
	    }else{
	        $query = "INSERT INTO {$table_name} (id, photo_name, article_title, article_text) VALUES (NULL, '$photo_name', '$title', '$article')"; 
	    }
	   
	    $result  = mysqli_query($connection, $query);
	    //проверяем нет ли ошибок запроса
	    if (!$result) {
	      die("database query faled.");
	    }
	     //5закрыть соединение
	    mysqli_close($connection);
	    return true;
	  }
 //создания и соранения альбома 
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
		 $query = "CREATE TABLE {$new_table} ( id INT(11) NOT NULL AUTO_INCREMENT, name VARCHAR(100) NOT NULL, width DOUBLE NOT NULL, height DOUBLE NOT NULL, PRIMARY KEY (id) )"; 
		
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
	//создать предложения в услуги и цены
	function create_offer($photo_name, $offer_name, $cost, $desc){
		   $config = config();
		   $table = $config['price'];
		   $path = $config['price_image'];
		   $connection = connect_db(); //подключится к базе
		   $query = "INSERT INTO {$table} (id, service_name, image_name, cost, description) VALUES (NULL, '$offer_name', '$photo_name', '$cost', '$desc')"; 
		   $result  = mysqli_query($connection, $query);
		   //проверяем нет ли ошибок запроса
		   if (!$result) {
		     die("database query faled.");
		     return false;
		   }
		  
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

	//изменить доп услуги
	function change_extra_services($text){
	  $config = config();
	  $table_name = $config['extra_service'];
	  $connection = connect_db();
	  $arr = get_data($table_name);	
	  //если записи есть
	  if ( count($arr) > 0 ) {
	  	$query = "UPDATE {$table_name} SET service_name = 'Дополнительные услуги', description = '$text'";
	  }else{
      $query = "INSERT INTO {$table_name} (id, service_name, description) VALUES (NULL, 'Дополнительные услуги', '$text')"; 
      }
	   
	  $result  = mysqli_query($connection, $query);
	  //проверяем нет ли ошибок запроса
	  if (!$result) {
	    die("database query faled.");
	  }
	   //5закрыть соединение
	  mysqli_close($connection);
	  return true;
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

	//удалть фото принимает путь и таблицу с которой нужно удалить запись об этой фотке
	function remove_photo($path, $table, $where=false){

		$arr = array();                               		// создам массив он мне нужен 
        $arr = explode("/", $path);               		 //дробим путь на масив регулируемся /
        $name = end($arr);                   			 //берём последний елемент массива теперь имеем имя 
		 $del = unlink( $path );
		 if ($del === true) {
			$connection = connect_db();
			$query = "DELETE FROM {$table} WHERE name = '$name'";
			if ($where) {
				$query = "DELETE FROM {$table} {$where}";
			
			}
			
			$result  = mysqli_query($connection, $query);
			//проверяем нет ли ошибок запроса
		 	if (!$result) {
		 		die("database query faled.");
		 	}
			mysqli_close($connection);
			return true;
		 }
		 return false;
	}
//удалит запись с таблицы портфолио, а также таблицу которая пренадлежит текущему альбому 
//принимает имя таблицы текущего альбома
	function remuve_album($table){
    $config = config();
    $table_name = $config['portfolio'];   //общая таблица всех альбомов       
    $where = "WHERE table_photo = '$table'";
    $arr = get_data($table_name, 'title_photo',  $where);
    $photo_name = $arr[0]['title_photo'];  //имя фото на обложки альбома
    $path = $config['аlbum_covers'].$photo_name;

    if ( remove_photo($path, $table_name, $where) ) {
      $connection = connect_db(); //подключится к базе
    // удалить таблицу альбома 
      $query = "DROP TABLE {$table};";
      $result  = mysqli_query($connection, $query);
       if (!$result) {
        die("database query faled.");
      } 
     //5закрыть соединение
      mysqli_close($connection);
      return true;
    }
     return false;
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
		$width_start = round($width_start, 5, PHP_ROUND_HALF_ODD); //округлить до 4 знаков и в меньшую сторону
		//выровнять все блоки по $max_height с сохранением пропорцый для этого увеличим ширину у низких блоков
		//узнать во сколько раз необходимо увеличить ширину 
		$totalWidth = 0;    //сумарная ширина выровняных блоков
		$i = 0;
		while (  $i < $amount ) {
		    $сoeff = $max_height/$new_photo[$i]['prop']; //узнаем в сколько раз самый большой блок высше текущего
		    $сoeff = round($сoeff, 5, PHP_ROUND_HALF_ODD); //округлить до 4 знаков и в меньшую сторону
		    // узнать новую ширину текущего блока
		    // новая ширина блока необходимая для выравнивания его же по высоте с самым высоким
		    // $width[] = $сoeff*$width_start;
		     $width[] = round($сoeff*$width_start, 5, PHP_ROUND_HALF_ODD); //округлить до 4 знаков и в меньшую сторону
		    //узнать сумарную ширину всех блоков в процентах после того как они выровнены по высоте
		    $totalWidth += $width[$i];
		    $i++;
		}
		//узнать в сколько раз ширина родительского блока меньше чем сумма ширин всех блоков, перед этим минус все маржини
		$mainKof = ( 100-$margin*($amount*2) )/$totalWidth;
		$mainKof = round($mainKof, 5, PHP_ROUND_HALF_ODD); 

		//умножить ширину каждого блока на получившийся коэфицыент чтобы узнать необходимую правильную ширину для фотки
		$i = 0;
		while( $i < $amount ){
		   // $width[$i] = $width[$i] * $mainKof;
			//теперь ширина ряда точно не перелетит за 100%
		    $width[$i] = round($width[$i] * $mainKof, 5, PHP_ROUND_HALF_ODD) - 0.001; 
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