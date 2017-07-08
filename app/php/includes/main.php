 <?php 
 require_once("functions.php");
require_once("config.php");


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
function change_profile($photo_name, $title, $article){
    $config = config();
    $table_name = $config['profile'];
    $arr = get_data($table_name);
    $connection = connect_db();
   // проверим не наличия записи в нашей таблице 
    if ( count($arr) > 0 ) {
      $query = "UPDATE {$table_name} SET photo_name = '$photo_name', article_title = '$title', article_text = '$article'"; 
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

 ?>