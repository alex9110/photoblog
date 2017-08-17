$(function(){
	var status = true; //переменная для управлением авто подрузкой фото
	var target = $('#loadMore');
	var toTop = $('#to_up');
	$(window).on('scroll', function(){
		if (target.length > 0) {
			var targetPos = target.offset().top;
			var winHeight = $(window).height();
			var scrollToElem = targetPos - winHeight;
		    var winScrollTop = $(this).scrollTop() + winHeight;
		    if(winScrollTop > scrollToElem){
		      //сработает когда пользователь доскроллит к элементу с классом .elem
		        if (status) {
       	     	   // console.log(status);
       	     	   addContent(status);
       	     	   status = false;
       	        }
		    } 
		}
		if(toTop.length > 0){onOf(toTop);}
	});
	//поднружает фото на страницу
	$('#loadMore div').click(function add(evt) {
		addContent(true);
	});
	function onOf(toTop){
		var pos = toTop.offset().top;
		if (pos > $(window).height() ) {
			toTop.addClass('block');
		}else{
			toTop.removeClass('block');
		}
	}
	function addContent(st){
		if (st === true) {
			status = false;
			$('#loadMore .more').css({'display':'none'});
			$('#loadMore span').css({'display':'inline-block'});
			$('#loadMore .error').html('');
			//текущее количество рядов на странице
			 var rowsNumber = $('.gallery ul').length;
			 var currentWork = $('.gallery ul:first-child').attr('class'); //узнать клас он же имя текущей таблицы
			$.ajax({
			    url: '/php/includes/main.php?more='+currentWork+'&row='+rowsNumber+'',
			    type: 'GET',
			    dataType: 'json',
			    success: function( data, textStatus, jqXHR ){
			        // Если все ОК
			        if( typeof data.error === 'undefined' ){
			        	  var cont = data['content'];
			        	  if (!cont == false) {
			        	  	$('.gallery').append(cont);
			        	  	$('#loadMore span').css({'display':'none'});
			        	  	$('#loadMore .more').css({'display':'inline-block'});
			        	  	status = true;
			        	  }else
			        	  {	
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
	}
});