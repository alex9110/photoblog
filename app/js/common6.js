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
	$('#save_album').click(function( event ){
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
	                var album = data.status;
	                 console.log(album);
	                // $('#answer').append(album);
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
	//отправка данных для нового предложения в услуги и цены
		$('#offer_image').change(function(){
		    files = this.files;
		});
		$('#save_offer').click(function( event ){
			var offer_name = $('#offer_name').val();
			var cost = $('#cost').val();
			var desc = $('#offer_desc').val();
		    // Создадим данные формы и добавим в них данные файлов из files
		    var data = new FormData();
		    $.each( files, function( key, value ){
		        data.append( key, value );
		    });
		    // console.log(offer_name);
		    // Отправляем запрос
			    $.ajax({
		        url: '../includes/main.php?offer_name='+offer_name+'&cost='+cost+'&desc='+desc+'',
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
		              	var status = data.status;
		              	 console.log(status);
		              	 //$('#answer').append(status);
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
	$('#save_row').click(function( event ){
		var currentWork = $('#photo_wall').attr("class");
		$( ".gallery" ).load( '../includes/main.php?save_row='+currentWork+'', function() {
		  console.log( "Load was performed." );
		   $('.temporarily').html("Ряд с фотками сохранен можите выбрать еще");
		});
	});

	//отправка изменения в категории доп услуги
	$("#service_but").click(function(event){
		var data = $("#service_desc").val();
	    $.ajax({
	        url: '../includes/main.php?extra_service',
	        type: 'POST',
	        data: {data:data},
	       	dataType: 'json',
	        success: function( data, textStatus, jqXHR ){
	            // Если все ОК
	            if( typeof data.error === 'undefined' ){
	                // если Файлы успешно загружены
	              	var status = data.status;
	              	 console.log(status);
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
	//отправка данных для измениения информацыи в профаил
		$('#avatar').change(function(){
		    files = this.files;
		});
		$('#save_profile').click(function( event ){
			console.log("clik");
			var title = $('#title').val();
			var article = $('#article').val();
		  
		    // Создадим данные формы и добавим в них данные файлов из files
		    var data = new FormData();
		    $.each( files, function( key, value ){
		        data.append( key, value );
		    });
		    // Отправляем запрос
		    $.ajax({
		        url: '../includes/main.php?profile&title='+title+'&article='+article+'',
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
		                var data = data.status;
		                 console.log(data);
		                // $('#answer').append(album);
		               // location.reload();
		                
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

	console.log("ds");
});