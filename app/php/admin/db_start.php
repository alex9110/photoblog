<?php 
	function receive_requests(){
		$data = array();
		$data[0] = "CREATE TABLE contacts ( id INT(11) NOT NULL AUTO_INCREMENT , category VARCHAR(100) NOT NULL , name VARCHAR(100) NOT NULL , value VARCHAR(100) NOT NULL , PRIMARY KEY (id)) ENGINE = InnoDB";
		$data[1] = "CREATE TABLE extra_service ( id INT(11) NOT NULL AUTO_INCREMENT , service_name VARCHAR(100) NOT NULL , description TEXT NOT NULL , PRIMARY KEY (id)) ENGINE = InnoDB";
		$data[2] = "CREATE TABLE index_photo ( id INT(11) NOT NULL AUTO_INCREMENT , name VARCHAR(100) NOT NULL , width DOUBLE NOT NULL , height DOUBLE NOT NULL , PRIMARY KEY (id)) ENGINE = InnoDB";
		$data[3] = "CREATE TABLE main ( id INT(11) NOT NULL AUTO_INCREMENT , name VARCHAR(100) NOT NULL , password VARCHAR(200) NOT NULL , PRIMARY KEY (id)) ENGINE = InnoDB";
		$data[4]= "CREATE TABLE portfolio ( id INT(11) NOT NULL AUTO_INCREMENT , title_photo VARCHAR(100) NOT NULL , job_titles VARCHAR(100) NOT NULL , job_description VARCHAR(200) NOT NULL , table_photo VARCHAR(100) NOT NULL , PRIMARY KEY (id)) ENGINE = InnoDB";
		$data[5] = "CREATE TABLE price ( id INT(11) NOT NULL AUTO_INCREMENT , service_name VARCHAR(100) NOT NULL , image_name VARCHAR(100) NOT NULL , cost VARCHAR(100) NOT NULL , description TEXT NOT NULL , PRIMARY KEY (id)) ENGINE = InnoDB";
		$data[6]= "CREATE TABLE profile ( id INT(11) NOT NULL AUTO_INCREMENT , photo_name VARCHAR(100) NOT NULL , article_title VARCHAR(100) NOT NULL , article_text TEXT NOT NULL , PRIMARY KEY (id)) ENGINE = InnoDB";
		$data[7] = "CREATE TABLE temporarily ( id INT(11) NOT NULL AUTO_INCREMENT , name VARCHAR(100) NOT NULL , PRIMARY KEY (id)) ENGINE = InnoDB";
		$hash = password_hash('1111', PASSWORD_BCRYPT);  //хешируем значение перед 
		$data[8] = "INSERT INTO contacts (id, category, name, value) VALUES (NULL, 'social', 'vkontakte', 'https://vk.com'), (NULL, 'social', 'facebook', 'https://www.facebook.com'), (NULL, 'social', 'twitter', 'https://twitter.com'), (NULL, 'social', 'gplus', ''), (NULL, 'social', 'youtube', ''), (NULL, 'social', 'inkedin', ''), (NULL, 'social', 'odnoklassniki', ''), (NULL, 'social', 'instagram', 'https://www.instagram.com'), (NULL, 'social', 'flickr', ''), (NULL, 'phone', 'phone_1', '8-777-445-30-69'), (NULL, 'phone', 'phone_2', ' 8-777-445-30-69'), (NULL, 'mail', 'mail', 'some_mail@gmail.com')";
		$data[9] = "INSERT INTO main (id, name, password) VALUES (NULL, 'admin', '$hash')";
		return $data;
	}
?>