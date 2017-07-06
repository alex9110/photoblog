$(function(){

//отправка фоток 
	// Переменная куда будут располагаться данные файлов 
	var files;
	// Получим данные файлов и добавим их в переменную 
	$('input.upload_photo').change(function(){
	    files = this.files;
	});
	// Вешаем функцию ан событие click и отправляем AJAX запрос с данными файлов
	 
	$('#upload_photo').click(function( event ){
	    // Создадим данные формы и добавим в них данные файлов из files
	    var data = new FormData();
	    $.each( files, function( key, value ){
	        data.append( key, value );
	    });
	    // Отправляем запрос
	    $.ajax({
	        url: '../includes/main.php?uploadfiles',
	        type: 'POST',
	        data: data,
	        cache: false,
	        dataType: 'json',
	        processData: false, // Не обрабатываем файлы (Don't process the files)
	        contentType: false, // Так jQuery скажет серверу что это строковой запрос
	        success: function( data, textStatus, jqXHR ){
	            // Если все ОК
	            if( typeof data.error === 'undefined' ){
	                // если Файлы успешно загружены
	                var photo = data.photo;
	                $('.temporarily').html(photo);
	                $(".message").html("добавлены новые фото можите сохранить изменения или добавить еще фотки в этот ряд");
	            }
	            else{
	                console.log('ОШИБКИ ОТВЕТА сервера: ' + data.error );
	            }
	        },
	        error: function( jqXHR, textStatus, errorThrown ){
	            console.log('ОШИБКИ AJAX запроса: ' + textStatus );
	        }
	    });
	 
	});
//отправка данных для нового фотоальбома
	$('#album_cover').change(function(){
	    files = this.files;
	});
	$('#save').click(function( event ){
		console.log("clik");
		var name = $('#album_name').val();
		var desc = $('#album_desc').val();
	  
	    // Создадим данные формы и добавим в них данные файлов из files
	    var data = new FormData();
	    $.each( files, function( key, value ){
	        data.append( key, value );
	    });
	    // Отправляем запрос
	    $.ajax({
	        url: '../includes/main.php?album_name='+name+'&desc='+desc+'',
	        type: 'POST',
	        data: data,
	        cache: false,
	        dataType: 'json',
	        processData: false, // Не обрабатываем файлы (Don't process the files)
	        contentType: false, // Так jQuery скажет серверу что это строковой запрос
	        success: function( data, textStatus, jqXHR ){
	            // Если все ОК
	            if( typeof data.error === 'undefined' ){
	                // если Файлы успешно загружены
	                var album = data.album;
	                 console.log(album);
	                 $('#answer').append(album);
	                location.reload();
	                
	            }
	            else{
	                console.log('ОШИБКИ ОТВЕТА сервера: ' + data.error );
	            }
	        },
	        error: function( jqXHR, textStatus, errorThrown ){
	            console.log('ОШИБКИ AJAX запроса: ' + textStatus );
	        }
	    });
	 
	});
	//var data = "save_row";
	$('#save_row').click(function( event ){
		var currentWork = $('#photo_wall').attr("class");
		$( ".gallery" ).load( '../includes/main.php?save_row='+currentWork+'', function() {
		  console.log( "Load was performed." );
		   $('.temporarily').html("Ряд с фотками сохранен можите выбрать еще");
		});
		// $.ajax({
		// 	  type: "POST",
		// 	  url: "../includes/main.php?save_row",
		// 	  data: data,
		// 	  dataType: 'json',
		// 	  success: function(data){
		// 	  	console.log(data);
		// 	  },
		// 	  error: function(textStatus){
		//             console.log('ОШИБКИ AJAX запроса: ' + textStatus );
		//       }
		// });
	});

	console.log("ds");
});