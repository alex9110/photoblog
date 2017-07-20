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
		$('#upload_photo').css({'display': 'none'});
		$('.loader').css({'display': 'inline-block'});
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
	                $(".message").html("Загружены новые фото, можите сохранить данный фоторяд или добавить в него ещё фото.");
	           		//почистим форму
	           		$(".upload_photo").val("");
	           		$('.loader').css({'display': 'none'});
	           		$('#upload_photo').css({'display': 'inline-block'})
	            }
	            else{
	                console.log('ОШИБКИ ОТВЕТА сервера: ' + data.error );
	                alert('ОШИБКИ ОТВЕТА сервера: ' + data.error );
	                $('.loader').css({'display': 'none'});
	           		$('#upload_photo').css({'display': 'inline-block'});
	            }
	        },
	        error: function( jqXHR, textStatus, errorThrown ){
	            console.log('ОШИБКИ AJAX запроса: ' + textStatus );
	             alert('ОШИБКИ ОТВЕТА сервера: ' + data.error );
	             $('.loader').css({'display': 'none'});
	             $('#upload_photo').css({'display': 'inline-block'});
	        }
	    });
	 
	});
//загрузить все фоторяды
	$('#loadMore div').click(function add(evt) {
		addNewContent(0, 0, 'html');
	});
//сохранить ряд и показать после сохранения
	$('#save_row').click(function( event ){
	 	var li = $('.temporarily li:not(.message)');
		if (li.length < 1) {		//если во временном ряде пусто выходим ис функцыи
			alert('Сначала загрузите фото');
			//console.log(li);
			return;
		}
		var currentWork = $('.gallery ul:first-child').attr('class'); //узнать клас он же имя текущей таблицы
		//в случае успеха добавить данный ряд в div с класом gallery
		$.ajax({
		    url: '../includes/main.php?save_row='+currentWork+'',
		    type: 'GET',
		   	dataType: 'json',
		    success: function( data, textStatus, jqXHR ){
		        // Если ряд сохранен подгрузим его 
		        if(data.result){
		        	addNewContent('last', 0);
		          	  //почистим форму
      			    $(".upload_photo").val("");
      			     //выведем сообщение
      			    $('.temporarily').html("Фоторяд сохранен можите выбрать еще.");
		        }
		        else{
		            alert('Сохранение не удалось');
		            location.reload();
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
		$('.loader2').css({'display': 'inline-block'});
		$('.button').css({'z-index': '-1'});

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
	                alert('ОШИБКИ ОТВЕТА сервера: ' + data.error);
	                location.reload();
	            }
	        },
	        error: function( jqXHR, textStatus, errorThrown ){
	            console.log('ОШИБКИ AJAX запроса: ' + textStatus );
	            alert('ОШИБКИ AJAX запроса: ' + textStatus );
	            location.reload();
	        }
	    });
	 
	});
	//отправка данных для нового предложения в услуги и цены
		$('#offer_image').change(function(){
		    files = this.files;
		});
		$('#save_offer').click(function( event ){
			$('.loader2').css({'display': 'inline-block'});
			$('.button').css({'z-index': '-1'});
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
		                alert('ОШИБКИ ОТВЕТА сервера: ' + data.error);
		                location.reload();
		            }
		        },
		        error: function( jqXHR, textStatus, errorThrown ){
		            console.log('ОШИБКИ AJAX запроса: ' + textStatus );
		            alert('ОШИБКИ AJAX запроса: ' + textStatus );
		            location.reload();
		        }
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
		$('.loader2').css({'display': 'inline-block'});
		$('.button').css({'z-index': '-1'});
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
	                //var data = data.status;
	                // console.log(data);
	               	location.reload();
	                
	            }
	            else{
	                console.log('ОШИБКИ ОТВЕТА сервера: ' + data.error );
	                alert('ОШИБКИ ОТВЕТА сервера: ' + data.error);
	                location.reload();
	            }
	        },
	        error: function( jqXHR, textStatus, errorThrown ){
	            console.log('ОШИБКИ AJAX запроса: ' + textStatus );
	            alert('ОШИБКИ AJAX запроса: ' + textStatus );
	            location.reload();
	        }
	    });
	});
//смена информацыи контакты
	$(".but").click(function(evt){
	var value = $(".cont_input");
	var val;
	var name;
	var data = {};
	for (var i = 0; i < value.length; i++) {
		 name = $(value[i]).attr('name');
		 val = $(value[i]).val();
		 val = $.trim(val);
		 data[name] = val;	
	}
	    $.ajax({
	        url: '../includes/main.php?contacts_change',
	        type: 'POST',
	        data: data,
	       	dataType: 'json',
	        success: function( data, textStatus, jqXHR ){
	            // Если все ОК
	            if( typeof data.error === 'undefined' ){
	                // если Файлы успешно загружены
	              	var status = data.status;
	              	 console.log(status);
	              	 console.log(data);
	              	 alert('Данные сохранены');
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
	//удаление ряда фоток вешаем обратчик на родительский элемент, в инном 
	//случае клик по только подгруженых с помощю аякса элементах не даст результата 
	$('.gallery ').on('click', 'span', function(evt){
		evt.stopPropagation();
		var table_name = $('.gallery ul:first-child').attr('class');	//узнаем имя таблицы с данними об текущих фотках
		var element = evt.currentTarget;	//возьмем элемент от которого пришло событие
		var parent = $(element).closest("ul");  //узнаем его первого ul одителя 
		var elements = $(parent).find('.gallery-box__image'); //получим нужные нам элементы
		var path = new Array; //масив для хранения путей к фоткам
		var data = new Object;
		for (var i = 0; i < elements.length; i++) {
			path[i] = $(elements[i]).css('background-image');
		}
		data.table = table_name;
		data.path = path;
		// console.log(data);
		$.ajax({
		    url: '../includes/main.php?remove_rov',
		    type: 'POST',
		    data: data,
		   	dataType: 'json',
		    success: function( data, textStatus, jqXHR ){
		        // Если все ОК
		        if( typeof data.error === 'undefined' ){
		            // если Файлы успешно загружены
		          	var status = data.status;
		          	 if (status) {
		          	 	var sibl = $(parent).siblings();  //посмотрим есть в ul сиблинги тоесть другие ряды ul
		          	 	//нельзя удалять все и отавлять страницу в таком состоянии иначе программа не будет знать класса и 
		          	 	//соответственно таблицы в которую следует добавить информацыю
		          	 	 if (sibl.length > 0) {
		          	 		$(parent).remove();
		          	 	 }else{
		          	 	 	location.reload();
		          		  }
		          	 }
		        }
		        else{
		            console.log('ОШИБКИ ОТВЕТА сервера: ' + data.error );
		        }
		    },
		    error: function( jqXHR, textStatus, errorThrown ){
		        console.log('ОШИБКИ AJAX запроса: ' + textStatus );
		    }
		});	
	})	
//удаление обложки альбома
	$('#albums ').on('click', 'span.delete', function(evt){
		evt.stopPropagation();
		//evt.currentTarget
		var elem_class = $(evt.currentTarget).attr('class');
		//последний клас елемента он же названия таблицы
		var arr = elem_class.split(' '); //покрышим строку на мпссив регулируясь пробелом
		var table_name = arr[arr.length - 1 ];
		var data = new Object;
		data.table = table_name;
		// console.log(data);
		$.ajax({
		    url: '../includes/main.php?remove_album',
		    type: 'POST',
		    data: data,
		   	dataType: 'json',
		    success: function( data, textStatus, jqXHR ){
		        // Если все ОК
		        if( typeof data.error === 'undefined' ){
		            // альбом удален
		            if (data.status) {
		            	location.reload();
		            }
		          	// console.log(data);  
		        }
		        else{
		        	alert(data.error);
		        }
		    },
		    error: function( jqXHR, textStatus, errorThrown ){
		        console.log('ОШИБКИ AJAX запроса: ' + textStatus );
		    }
		});	
	});
	//удаления услуги из цены и услуги
	$('.service ').on('click', 'span.delete', function(evt){
		evt.stopPropagation();
		var elem_class = $(evt.currentTarget).attr('class');
		//последний клас елемента он же id pзаписи данного предложения
		var arr = elem_class.split(' '); //покрышим строку на мпссив регулируясь пробелом
		var id = arr[arr.length - 1 ];
		//console.log(id);
		var data = new Object;
		data.id = id;
		$.ajax({
		    url: '../includes/main.php?remove_offer',
		    type: 'POST',
		    data: data,
		   	dataType: 'json',
		    success: function( data, textStatus, jqXHR ){
		        // Если все ОК
		        if( typeof data.error === 'undefined' ){
		            // альбом удален
		            if (data.status) {
		            	location.reload();
		            	//console.log(data.status);  
		            }
		          	 //console.log(data);  
		        }
		        else{
		        	alert(data.error);
		        }
		    },
		    error: function( jqXHR, textStatus, errorThrown ){
		        console.log('ОШИБКИ AJAX запроса: ' + textStatus );
		    }
		});	
		
	});
//подгрузка фото /////////////////////////////////////////////////////////////////
//по умочанию подгружает все оставшися фото ряды на страницу, но в параметрах можно указать с какого ряда начать и сколько рядов подгрузить, а также каким методом добавить
	
	function addNewContent(rowsNumber, how, append){
		if (how === undefined) {
			how = 0; //все оставшися ряды
		}
		
		$('#loadMore .more').css({'display':'none'});
		$('#loadMore span').css({'display':'inline-block'});
		$('#loadMore .error').html('');
		//текущее количество рядов на странице
		if (rowsNumber === undefined) {
			var rowsNumber = $('.gallery ul').length;
		}
		
		 var currentWork = $('.gallery ul:first-child').attr('class'); //узнать клас он же имя текущей таблицы
		$.ajax({
		    url: '../includes/main.php?more='+currentWork+'&row='+rowsNumber+'&how='+how+'',
		    type: 'GET',
		    dataType: 'json',
		    success: function( data, textStatus, jqXHR ){
		        // Если все ОК
		        if( typeof data.error === 'undefined' ){
		        	  var cont = data['content'];
		        	  if (!cont == false) {
		        	  	if (append === 'html') {
		        	  		$('.gallery').html(cont);
		        	  		$('#loadMore .more').html('В этом альбоме больше нет фото.');
		        	  		$('#loadMore div').css({'cursor':'default'});
		        	  	}else{
		        	  		$('.gallery').append(cont);
		        	  	}
		        	  	$('#loadMore span').css({'display':'none'});
		        	  	$('#loadMore .more').css({'display':'inline-block'});
		        	  }else{
		        	  	$('#loadMore span').css({'display':'none'});
		        	  	$('#loadMore .more').css({'display':'inline-block'});
		        	  	$('#loadMore .more').html('В этом альбоме больше нет фото.');
		        	  	$('#loadMore div').css({'cursor':'default'});
		        	  }
		        }
		        else{
		            console.log('ОШИБКИ ОТВЕТА сервера: ' + data.error );
		            $('#loadMore span').css({'display':'none'});
		            $('#loadMore .error').html('упс, что-то пошло не так :(<br>Попробовать еще?');
		        }
		    },
		    error: function( jqXHR, textStatus, errorThrown ){
		        console.log('ОШИБКИ AJAX запроса: ' + textStatus );
		        $('#loadMore span').css({'display':'none'});
		        $('#loadMore .error').html('упс, что то пошло не так :(<br>Попробовать еще?');
		    }
		});
	}
////////////////////////////////////////////////////////////////////////////////
});