 <?php 
 require_once("functions.php");

//смена контактов
if( isset($_GET['contacts_change']) ) { 
  $data = array();
  $data['status'] = "ok";
  if ( set_contacts() ) {
     echo json_encode($data);
   } 
}
 //если гетом пришли данные с ключом uploadfiles сохранить эти фотки
if( isset( $_GET['uploadfiles'] ) ){
    // Здесь можно сделать все проверки передаваемых файлов и вывести ошибки если нужно
    $data = save_photo();
    //ответим на запрос
    echo json_encode($data);
}
//если гетом пришли данные с ключом new_album yнужно создать нвый альбом
if( isset( $_GET['album_name'] ) ){
  $config = config();
    $data = array();
    $data['desc'] = "Виберите фото";
	$title = $_GET['album_name'];
    $desc = $_GET['desc'];
   $uploaddir = $config['аlbum_covers']; 
    if ( count($_FILES) > 0) {
      $data = save_title_photo($uploaddir);
      //если ошибок нет
      if (!$data['error']) {
      	$result = сreate_album($data['photo_name'], $title, $desc);
        //если создание не удалось запишим ошибку
      	if ($result == false) {
      		$data['error'] = 'не удалось создать альбом'; 
      	}
      }
    }
 	echo json_encode($data);
}
//сохранить ряд с фотками
if( isset( $_GET['save_row'] ) ){
    //прилетело имя таблицы с которой выведены текущие фотки, значит в неё мы их и сохраним
    $table_name =   $_GET['save_row'];
   $result = move_photo($table_name);
   if ($result === true) {
    //если всьо ок построим контент и отддим
    $content = show_photo_r($table_name);
   // $result = "успех";
       echo ($content);
   }else{
    echo ($result);
    }
} 
//сохранение новой услуги
if( isset( $_GET['offer_name'] ) ){
   $config = config();
   $data = array();
    $offer_name = $_GET['offer_name'];
    $cost = $_GET['cost'];
    $desc = $_GET['desc'];
    $data['desc'] = "Виберите фото";
    if ( count($_FILES) > 0) {
        $data = save_title_photo($config['price_image']);
        
        if (!$data['error']) {
          $result = create_offer($data['photo_name'], $offer_name, $cost, $desc);
          if ($result == false) {
            $data['error'] = 'не удалось создать предложения'; 
          }
        }
    }
      echo json_encode($data);
} 
//изменения дополнительных услуг
if( isset($_GET['extra_service']) ){
    $data = array();
    $text = $_POST['data'];
    if (change_extra_services($text) == true) {
      $data['status'] = true;
    }else{
      $data['error'] = true;
    }
    echo json_encode($data);
}

//изменить инфу в профаил
if( isset( $_GET['profile'] ) ){
    $config = config();
    $data = array();
    $data['status'] = "Виберите фото";
    $title = $_GET['title'];
    $article = $_GET['article'];
    $uploaddir = $config['avatar']; 
    if ( count($_FILES) > 0) {
      $data = save_title_photo($uploaddir);
      //если ошибок нет
      if (!$data['error']) {
        $result = change_profile($data['photo_name'], $title, $article);
        //если создание не удалось запишим ошибку
        if ($result == false) {
          $data['error'] = 'не удалось создать альбом'; 
        }
      }
    }
  echo json_encode($data);
}

//удаления ряда соток
  if( isset($_GET['remove_rov']) ) { 
    $post = $_POST;
    $not_ready_path = $post['path'];
    $ready_path = array();
    $table = $post['table'];    //имя таблицы с которой нужно удалить инфу
    for ($i=0; $i < count($not_ready_path); $i++) {     //вытямин путя к фоткам
      $text = $not_ready_path[$i];
      // регулярное выражение возьмом все сиволы после all_photos//photo/ и до конца но кроме симвлов ")
     if ( preg_match('~all_photos/photo/(.*[^")])~', $text, $result) ) {
        $ready_path[] = $result[0];
      }
    }
    for ($i=0; $i < count($ready_path); $i++) { 
      $full_path = '../../'.$ready_path[$i];
      if ( remove_photo($full_path, $table) ) {
           $data['status'] = 'true';
      }else{ $data['status'] = 'false';}
    }
//не забыть зделать предворительные проверки в функцыи удаляющей фотки и данные и научить удалять даже когда фото уже было удалено и данные
    echo json_encode($data);  
}
//удаления альбома
  if( isset($_GET['remove_album']) ) { 
   $table_name = $_POST['table'];
   //проверим нет ли в альбрме фоток
   $arr = get_data($table_name, 'id');
   if (!count($arr) > 0) {
      $data = array();
      if ( remuve_album($table_name) ) {
         $data['status'] = true;
      }else{
         $data['error'] = 'что пошло не так';
      }
   }else{
     $data['error'] = 'В альбоме обнаружены фото, перед тем как удалить альбом, необходимо удалить все фото в данном альбоме';
   }
    echo json_encode($data);  
}
//удаления альбома
  if( isset($_GET['remove_offer']) ) { 
    $data = array();
    $config = config();
    $table_name = $config['price'];
    $record_id = $_POST['id'];

   //отбросим первый символ что бы получить чистый id записи
    $record_id = substr( $record_id, 1);
    $where = "WHERE id = '$record_id'";
    $arr = get_data($table_name, 'image_name', $where);
    $image_name = $arr[0]['image_name'];
    $path = $config['price_image'].$image_name;
     if ( remove_photo($path, $table_name, $where)) {
        $data['status'] = true;
     }else{
       $data['error'] = 'что пошло не так';
     }
    echo json_encode($data);  
}

?>