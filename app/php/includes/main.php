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
    $data = array();
	$title = $_GET['album_name'];
    $desc = $_GET['desc'];
   
    $data = save_title_photo();
    //если ошибок нет
    if (!$data['error']) {
    	$result = сreate_album($data['photo_name'], $title, $desc);
    	if ($result == false) {
    		$data['error'] = 'не удалось создать альбом'; 
    	}
    }
 	echo json_encode($data);
}
 
 ?>